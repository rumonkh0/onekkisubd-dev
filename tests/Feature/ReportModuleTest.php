<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderStatus;
use App\Models\IpBlock;

class ReportModuleTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::first();
    }

    public function test_stock_report_page_renders_and_filters_correctly()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.stock_report'));
        $response->assertOk();
        $response->assertViewHasAll([
            'products',
            'categories',
            'total_stock',
            'total_price',
            'total_purchase'
        ]);

        // Test filtering by keyword
        $responseFiltered = $this->actingAs($this->admin)->get(route('admin.stock_report', [
            'keyword' => 'shirt',
        ]));
        $responseFiltered->assertOk();

        // Test filtering by category if any exists
        $category = Category::first();
        if ($category) {
            $responseCat = $this->actingAs($this->admin)->get(route('admin.stock_report', [
                'category_id' => $category->id,
            ]));
            $responseCat->assertOk();
        }
    }

    public function test_order_report_page_renders_and_handles_filters_without_crashes()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.order_report'));
        $response->assertOk();
        $response->assertViewHasAll([
            'orders',
            'users',
            'order_statuses',
            'totalPurchase',
            'total_item',
            'total_sales',
            'discounts'
        ]);

        // Test keyword filter (regression test for product_name vs name column bug)
        $responseKeyword = $this->actingAs($this->admin)->get(route('admin.order_report', [
            'keyword' => 'test',
        ]));
        $responseKeyword->assertOk();

        // Test order_status = 'all' and verify OrderDetails->order->status relation loads (not stripped by select)
        $responseAllStatus = $this->actingAs($this->admin)->get(route('admin.order_report', [
            'order_status' => 'all',
        ]));
        $responseAllStatus->assertOk();
        $orders = $responseAllStatus->viewData('orders');
        if ($orders->count() > 0) {
            $firstItem = $orders->first();
            $this->assertNotNull($firstItem->order, 'OrderDetails->order relationship should be loaded');
            $this->assertNotNull($firstItem->order->order_status, 'Order->order_status foreign key must not be stripped by select()');
            $this->assertNotNull($firstItem->order->status, 'Order->status relationship must resolve to an OrderStatus model');
        }

        // Test order_status = 'delivered_completed'
        $responseDeliveredCompleted = $this->actingAs($this->admin)->get(route('admin.order_report', [
            'order_status' => 'delivered_completed',
        ]));
        $responseDeliveredCompleted->assertOk();

        // Test date range filter (including inverted dates auto-swap)
        $responseDates = $this->actingAs($this->admin)->get(route('admin.order_report', [
            'start_date' => '2026-12-31',
            'end_date' => '2025-01-01',
        ]));
        $responseDates->assertOk();

        // Test print=1 loads full unpaginated result set
        $responsePrintAll = $this->actingAs($this->admin)->get(route('admin.order_report', [
            'print' => 1,
        ]));
        $responsePrintAll->assertOk();
        $printOrders = $responsePrintAll->viewData('orders');
        $this->assertEquals($printOrders->total(), $printOrders->count());
        $this->assertFalse($printOrders->hasPages());
    }

    public function test_order_report_default_includes_delivered_and_completed_orders_sorted_chronologically()
    {
        \DB::beginTransaction();

        try {
            $product = Product::first();
            $this->assertNotNull($product);

            $createOrderWithDetail = function (int $statusId, string $createdAt) use ($product) {
                $order = new Order();
                $order->invoice_id = 'TEST-' . rand(100000, 999999);
                $order->amount = 500;
                $order->discount = 0;
                $order->shipping_charge = 0;
                $order->customer_id = 1;
                $order->order_status = $statusId;
                $order->created_at = $createdAt;
                $order->updated_at = $createdAt;
                $order->save();

                $detail = new OrderDetails();
                $detail->order_id = $order->id;
                $detail->product_id = $product->id;
                $detail->product_name = $product->name;
                $detail->purchase_price = 100;
                $detail->sale_price = 500;
                $detail->qty = 1;
                $detail->created_at = $createdAt;
                $detail->updated_at = $createdAt;
                $detail->save();

                return $detail;
            };

            $completedDetail = $createOrderWithDetail(6, '2030-01-10 10:00:00');
            $deliveredDetail = $createOrderWithDetail(12, '2030-01-15 12:00:00');
            $partialDetail = $createOrderWithDetail(13, '2030-01-12 11:00:00');
            $pendingDetail = $createOrderWithDetail(1, '2030-01-20 14:00:00');

            // Default report (no order_status parameter) should include 6, 12, 13 and exclude 1, ordered newest-first
            $responseDefault = $this->actingAs($this->admin)->get(route('admin.order_report'));
            $responseDefault->assertOk();
            $defaultIds = $responseDefault->viewData('orders')->pluck('id')->all();

            $this->assertContains($deliveredDetail->id, $defaultIds);
            $this->assertContains($partialDetail->id, $defaultIds);
            $this->assertContains($completedDetail->id, $defaultIds);
            $this->assertNotContains($pendingDetail->id, $defaultIds);

            $this->assertSame(
                [$deliveredDetail->id, $partialDetail->id, $completedDetail->id],
                array_slice($defaultIds, 0, 3)
            );

            // Explicit order_status=6 should only show Completed (6)
            $responseCompletedOnly = $this->actingAs($this->admin)->get(route('admin.order_report', [
                'order_status' => '6',
            ]));
            $responseCompletedOnly->assertOk();
            $completedOnlyIds = $responseCompletedOnly->viewData('orders')->pluck('id')->all();
            $this->assertContains($completedDetail->id, $completedOnlyIds);
            $this->assertNotContains($deliveredDetail->id, $completedOnlyIds);
        } finally {
            \DB::rollBack();
        }
    }

    public function test_ip_block_page_renders()
    {
        $response = $this->actingAs($this->admin)->get(route('customers.ip_block'));
        $response->assertOk();
        $response->assertViewHas('data');
    }

    public function test_ip_block_store_validation_and_creation()
    {
        $response = $this->actingAs($this->admin)
            ->from(route('customers.ip_block'))
            ->post(route('customers.ipblock.store'), []);
        $response->assertSessionHasErrors(['ip_no', 'reason']);

        $testIp = '198.51.' . rand(1, 254) . '.' . rand(1, 254);
        $response = $this->actingAs($this->admin)
            ->from(route('customers.ip_block'))
            ->post(route('customers.ipblock.store'), [
                'ip_no' => $testIp,
                'reason' => 'Automated bot attack',
            ]);
        $response->assertRedirect(route('customers.ip_block'));
        $this->assertDatabaseHas('ip_blocks', [
            'ip_no' => $testIp,
            'reason' => 'Automated bot attack',
        ]);
    }

    public function test_ip_block_update_and_delete()
    {
        $testIp = '198.51.' . rand(1, 254) . '.' . rand(1, 254);
        $ip = IpBlock::create([
            'ip_no' => $testIp,
            'reason' => 'Initial reason',
        ]);

        $responseUpdate = $this->actingAs($this->admin)
            ->from(route('customers.ip_block'))
            ->post(route('customers.ipblock.update'), [
                'id' => $ip->id,
                'ip_no' => $testIp,
                'reason' => 'Updated bot reason',
            ]);
        $responseUpdate->assertRedirect(route('customers.ip_block'));
        $this->assertDatabaseHas('ip_blocks', [
            'id' => $ip->id,
            'reason' => 'Updated bot reason',
        ]);

        $responseDelete = $this->actingAs($this->admin)
            ->from(route('customers.ip_block'))
            ->post(route('customers.ipblock.destroy'), [
                'id' => $ip->id,
            ]);
        $responseDelete->assertRedirect(route('customers.ip_block'));
        $this->assertDatabaseMissing('ip_blocks', [
            'id' => $ip->id,
        ]);
    }
}
