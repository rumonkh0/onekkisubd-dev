<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SimulateTwoMonthsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:simulate-two-months';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate 2 months of active e-commerce data (orders, customers, payments, expenses, deposits, stock)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting 2-Month Data Simulation...');

        DB::beginTransaction();

        try {
            // 1. Replenish Product Stocks
            $this->info('1. Replenishing Product Stocks...');
            $stocks = [
                6  => 185,
                9  => 140,
                10 => 95,
                11 => 120,
                29 => 85,
                36 => 210,
                38 => 160,
                41 => 110,
                43 => 175,
            ];
            foreach ($stocks as $pId => $stk) {
                DB::table('products')->where('id', $pId)->update([
                    'stock'      => $stk,
                    'status'     => 1,
                    'updated_at' => Carbon::now(),
                ]);
            }

            // Fix 64 orphan order details pointing to invalid product IDs
            $activeProducts = DB::table('products')->whereIn('id', array_keys($stocks))->get()->keyBy('id');
            $fallbackProduct = $activeProducts->get(6);
            DB::table('order_details')
                ->whereNotIn('product_id', array_keys($stocks))
                ->update([
                    'product_id'   => 6,
                    'product_name' => $fallbackProduct ? $fallbackProduct->name : 'Ranga Gold Tea(দুধ/লাল চা)',
                ]);

            // 2. Distribute 1,088 Orders over 62 Days (2026-07-24 to 2026-09-23)
            $this->info('2. Distributing Orders chronologically over the past 2 months...');
            
            $startDate = Carbon::create(2026, 7, 24, 0, 0, 0);
            $endDate   = Carbon::create(2026, 9, 23, 18, 30, 0); // Today up to current time
            $totalDays = $startDate->diffInDays($endDate->copy()->startOfDay()) + 1; // 62 days

            $allOrders = DB::table('orders')->orderBy('id', 'asc')->get();
            $totalOrdersCount = $allOrders->count(); // 1,088

            // Calculate daily target distribution curve
            // Days 0-7   (July 24 - 31, 8 days): ~8-12 orders/day (weight 1.0)
            // Days 8-38  (August, 31 days):       ~13-18 orders/day (weight 1.6)
            // Days 39-60 (Sep 1 - 22, 22 days):   ~19-25 orders/day (weight 2.3)
            // Day 61     (Sep 23, today):         ~25 orders (weight 2.5)
            $weights = [];
            for ($d = 0; $d < $totalDays; $d++) {
                if ($d < 8) {
                    $weights[$d] = 1.0 + (rand(-15, 15) / 100.0);
                } elseif ($d < 39) {
                    $weights[$d] = 1.6 + (rand(-20, 20) / 100.0);
                } elseif ($d < 61) {
                    $weights[$d] = 2.3 + (rand(-25, 25) / 100.0);
                } else {
                    $weights[$d] = 2.5; // Today
                }
            }

            $totalWeight = array_sum($weights);
            $dailyCounts = [];
            $assignedSoFar = 0;
            for ($d = 0; $d < $totalDays; $d++) {
                if ($d === $totalDays - 1) {
                    $dailyCounts[$d] = $totalOrdersCount - $assignedSoFar;
                } else {
                    $count = (int) round(($weights[$d] / $totalWeight) * $totalOrdersCount);
                    $dailyCounts[$d] = $count;
                    $assignedSoFar += $count;
                }
            }

            // Map orders to days and assign timestamps + statuses
            $orderIndex = 0;
            $customerEarliestDate = [];
            $customerLatestDate = [];

            for ($d = 0; $d < $totalDays; $d++) {
                $currentDayDate = $startDate->copy()->addDays($d);
                $isToday = ($d === $totalDays - 1);
                $isYesterday = ($d === $totalDays - 2);
                $isRecentPast = ($d >= $totalDays - 6 && $d < $totalDays - 2); // 3-6 days ago

                $countToday = $dailyCounts[$d];
                for ($i = 0; $i < $countToday; $i++) {
                    if ($orderIndex >= $totalOrdersCount) break;

                    $order = $allOrders[$orderIndex];

                    // Realistic time distribution within the day
                    if ($isToday) {
                        // Distribute up to 18:30
                        $hour = rand(8, 18);
                        $minute = ($hour === 18) ? rand(0, 30) : rand(0, 59);
                        $second = rand(0, 59);
                    } else {
                        // 10% night (0-7), 25% morning (8-11), 35% afternoon (12-16), 30% evening (17-23)
                        $randSlot = rand(1, 100);
                        if ($randSlot <= 10) {
                            $hour = rand(1, 7);
                        } elseif ($randSlot <= 35) {
                            $hour = rand(8, 11);
                        } elseif ($randSlot <= 70) {
                            $hour = rand(12, 16);
                        } else {
                            $hour = rand(17, 23);
                        }
                        $minute = rand(0, 59);
                        $second = rand(0, 59);
                    }

                    $orderCreatedAt = $currentDayDate->copy()->setTime($hour, $minute, $second);
                    
                    // Assign status based on recency:
                    // 1: Pending, 2: Processing, 3: Pre Order, 4: Cancel, 5: In Courier, 6: Completed, 8: Return
                    if ($isToday) {
                        if ($hour >= 15) {
                            $status = 1; // Pending (last few hours)
                        } elseif ($hour >= 11) {
                            $status = 2; // Processing (middle of the day)
                        } else {
                            $status = 5; // In Courier (dispatched this morning)
                        }
                    } elseif ($isYesterday) {
                        $randStat = rand(1, 100);
                        if ($randStat <= 15) {
                            $status = 2; // Still Processing
                        } elseif ($randStat <= 80) {
                            $status = 5; // In Courier
                        } else {
                            $status = 6; // Quick local delivery completed
                        }
                    } elseif ($isRecentPast) {
                        $randStat = rand(1, 100);
                        if ($randStat <= 35) {
                            $status = 5; // In Courier transit
                        } elseif ($randStat <= 92) {
                            $status = 6; // Completed
                        } elseif ($randStat <= 97) {
                            $status = 4; // Cancel
                        } else {
                            $status = 8; // Return
                        }
                    } else {
                        // Older than 6 days
                        $randStat = rand(1, 100);
                        if ($randStat <= 91) {
                            $status = 6; // Completed
                        } elseif ($randStat <= 96) {
                            $status = 4; // Cancel
                        } else {
                            $status = 8; // Return
                        }
                    }

                    // Calculate updated_at
                    $orderUpdatedAt = $orderCreatedAt->copy();
                    if ($status == 6) {
                        $orderUpdatedAt->addHours(rand(24, 72));
                        if ($orderUpdatedAt->greaterThan($endDate)) {
                            $orderUpdatedAt = $endDate->copy();
                        }
                    } elseif ($status == 5) {
                        $orderUpdatedAt->addHours(rand(4, 24));
                    } elseif ($status == 2) {
                        $orderUpdatedAt->addHours(rand(1, 6));
                    }

                    // Update order
                    DB::table('orders')->where('id', $order->id)->update([
                        'order_status' => $status,
                        'created_at'   => $orderCreatedAt,
                        'updated_at'   => $orderUpdatedAt,
                    ]);

                    // Sync shippings
                    DB::table('shippings')->where('order_id', $order->id)->update([
                        'created_at' => $orderCreatedAt,
                        'updated_at' => $orderUpdatedAt,
                    ]);

                    // Sync order_details
                    DB::table('order_details')->where('order_id', $order->id)->update([
                        'created_at' => $orderCreatedAt,
                        'updated_at' => $orderUpdatedAt,
                    ]);

                    // Sync payments
                    $paymentStatus = in_array($status, [5, 6]) ? 'paid' : (empty($order->bkash_tranxId) ? 'pending' : 'paid');
                    DB::table('payments')->where('order_id', $order->id)->update([
                        'payment_status' => $paymentStatus,
                        'created_at'     => $orderCreatedAt,
                        'updated_at'     => $orderUpdatedAt,
                    ]);

                    // Track customer timestamps
                    $custId = $order->customer_id;
                    if ($custId) {
                        if (!isset($customerEarliestDate[$custId]) || $orderCreatedAt->lessThan($customerEarliestDate[$custId])) {
                            $customerEarliestDate[$custId] = $orderCreatedAt;
                        }
                        if (!isset($customerLatestDate[$custId]) || $orderCreatedAt->greaterThan($customerLatestDate[$custId])) {
                            $customerLatestDate[$custId] = $orderCreatedAt;
                        }
                    }

                    $orderIndex++;
                }
            }

            // 3. Synchronize Customers
            $this->info('3. Synchronizing customer registration and activity dates...');
            $allCustomers = DB::table('customers')->get();
            foreach ($allCustomers as $customer) {
                if (isset($customerEarliestDate[$customer->id])) {
                    $regDate = $customerEarliestDate[$customer->id]->copy()->subMinutes(rand(5, 180));
                    $actDate = $customerLatestDate[$customer->id]->copy();
                } else {
                    // Customer with no orders placed: place between Aug 1 and Sep 20
                    $regDate = Carbon::create(2026, 8, 1)->addDays(rand(0, 50))->addHours(rand(9, 21));
                    $actDate = $regDate->copy();
                }

                DB::table('customers')->where('id', $customer->id)->update([
                    'created_at' => $regDate,
                    'updated_at' => $actDate,
                ]);
            }

            // 4. Populate Realistic Deposits (Aug 1 to Sep 23)
            $this->info('4. Populating realistic Deposits (Courier COD disbursements & Office Sales)...');
            DB::table('deposits')->delete();

            $depositFiles = [
                'public/backEnd/images/deposit/1742552174.8655.jpg',
                'public/backEnd/images/deposit/1742552215.6678.jpg',
                'public/backEnd/images/deposit/1744363366.6212.jpg',
                'public/backEnd/images/deposit/1746895066.4591.jpg',
                'public/backEnd/images/deposit/1747933104.6892.jpg',
            ];

            $depositsData = [];
            // Courier COD disbursements every 2-3 days
            $depDate = Carbon::create(2026, 8, 2);
            $fIdx = 0;
            while ($depDate->lessThanOrEqualTo($endDate)) {
                $codAmount = rand(8500, 24000);
                $depositsData[] = [
                    'title'        => 'Courier Payment - Steadfast / Pathao COD',
                    'amount'       => $codAmount,
                    'deposit_type' => '1', // 1: Courier
                    'payment_type' => '1', // 1: Bank / COD
                    'file'         => $depositFiles[$fIdx % count($depositFiles)],
                    'date'         => $depDate->toDateString(),
                    'status'       => 1,
                    'created_at'   => $depDate->copy()->setTime(14, rand(10, 50)),
                    'updated_at'   => $depDate->copy()->setTime(14, rand(10, 50)),
                ];
                $fIdx++;

                // Office sales once a week
                if (rand(1, 100) <= 40) {
                    $officeAmount = rand(1500, 4800);
                    $depositsData[] = [
                        'title'        => 'Office Direct Sales',
                        'amount'       => $officeAmount,
                        'deposit_type' => '2', // 2: Office Sale
                        'payment_type' => '3', // 3: Cash
                        'file'         => $depositFiles[$fIdx % count($depositFiles)],
                        'date'         => $depDate->toDateString(),
                        'status'       => 1,
                        'created_at'   => $depDate->copy()->setTime(17, rand(10, 40)),
                        'updated_at'   => $depDate->copy()->setTime(17, rand(10, 40)),
                    ];
                    $fIdx++;
                }

                $depDate->addDays(rand(2, 3));
            }
            DB::table('deposits')->insert($depositsData);

            // 5. Populate Realistic Expenses (Aug 1 to Sep 23)
            $this->info('5. Populating realistic Expenses (Ad Boost, Packaging, Courier Delivery, Office)...');
            DB::table('expenses')->delete();

            $expenseFiles = [
                'public/backEnd/images/expense/1746114721.3885.jfif',
                'public/backEnd/images/expense/1746283940.5558.jpg',
                'public/backEnd/images/expense/1746284029.5894.jpg',
                'public/backEnd/images/expense/1746895161.7707.jpg',
                'public/backEnd/images/expense/1747932929.8642.jpg',
            ];

            $expensesData = [];
            $expDate = Carbon::create(2026, 8, 1);
            $eIdx = 0;
            while ($expDate->lessThanOrEqualTo($endDate)) {
                // Facebook Boost every 2-3 days
                $boostAmount = rand(1500, 3500);
                $expensesData[] = [
                    'title'        => 'Facebook Campaign Boost',
                    'amount'       => $boostAmount,
                    'expense_type' => '1', // 1: Boost cost
                    'payment_type' => '2', // 2: Card / Online
                    'file'         => $expenseFiles[$eIdx % count($expenseFiles)],
                    'date'         => $expDate->toDateString(),
                    'status'       => 1,
                    'created_at'   => $expDate->copy()->setTime(11, rand(0, 50)),
                    'updated_at'   => $expDate->copy()->setTime(11, rand(0, 50)),
                ];
                $eIdx++;

                // Packaging carton / poly bags every 4-5 days
                if (rand(1, 100) <= 50) {
                    $pkgAmount = rand(1200, 2800);
                    $expensesData[] = [
                        'title'        => 'Packaging Cartons & Poly Bags',
                        'amount'       => $pkgAmount,
                        'expense_type' => '4', // 4: Packaging
                        'payment_type' => '3', // 3: Cash
                        'file'         => $expenseFiles[$eIdx % count($expenseFiles)],
                        'date'         => $expDate->toDateString(),
                        'status'       => 1,
                        'created_at'   => $expDate->copy()->setTime(15, rand(0, 50)),
                        'updated_at'   => $expDate->copy()->setTime(15, rand(0, 50)),
                    ];
                    $eIdx++;
                }

                // Transport / dispatch charges
                if (rand(1, 100) <= 45) {
                    $trAmount = rand(400, 1100);
                    $expensesData[] = [
                        'title'        => 'Hub Parcel Delivery Transport',
                        'amount'       => $trAmount,
                        'expense_type' => '5', // 5: Transport
                        'payment_type' => '3', // 3: Cash
                        'file'         => $expenseFiles[$eIdx % count($expenseFiles)],
                        'date'         => $expDate->toDateString(),
                        'status'       => 1,
                        'created_at'   => $expDate->copy()->setTime(18, rand(0, 50)),
                        'updated_at'   => $expDate->copy()->setTime(18, rand(0, 50)),
                    ];
                    $eIdx++;
                }

                // Office Utilities / tea / essentials
                if (rand(1, 100) <= 25) {
                    $offAmount = rand(600, 1800);
                    $expensesData[] = [
                        'title'        => 'Office Refreshments & Utilities',
                        'amount'       => $offAmount,
                        'expense_type' => '2', // 2: Office cost
                        'payment_type' => '3', // 3: Cash
                        'file'         => $expenseFiles[$eIdx % count($expenseFiles)],
                        'date'         => $expDate->toDateString(),
                        'status'       => 1,
                        'created_at'   => $expDate->copy()->setTime(16, rand(0, 50)),
                        'updated_at'   => $expDate->copy()->setTime(16, rand(0, 50)),
                    ];
                    $eIdx++;
                }

                $expDate->addDays(rand(2, 3));
            }
            DB::table('expenses')->insert($expensesData);

            // 6. Update Reviews & Campaign Reviews
            $this->info('6. Updating reviews timestamps to recent dates...');
            $revDates = ['2026-09-08 14:22:10', '2026-09-14 17:35:40', '2026-09-20 19:10:15'];
            $reviewIds = DB::table('reviews')->pluck('id')->toArray();
            foreach ($reviewIds as $idx => $rid) {
                $d = $revDates[$idx % count($revDates)];
                DB::table('reviews')->where('id', $rid)->update([
                    'created_at' => $d,
                    'updated_at' => $d,
                ]);
            }

            $campReviews = DB::table('campaign_reviews')->get();
            foreach ($campReviews as $cr) {
                $crDate = Carbon::create(2026, 8, 15)->addDays(rand(0, 35))->addHours(rand(10, 20));
                DB::table('campaign_reviews')->where('id', $cr->id)->update([
                    'created_at' => $crDate,
                    'updated_at' => $crDate,
                ]);
            }

            DB::commit();
            $this->info('Successfully realigned 2 months of active site operation data!');
            return 0;

        } catch (\Exception $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            $this->error('Failed to simulate data: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }
}
