<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\District;
use App\Models\OrderStatus;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use App\Models\ShippingCharge;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Courierapi;
use App\Models\GeneralSetting;
use App\Models\Contact;
use App\Services\PathaoService;
use Session;
use Cart;
use Toastr;
use Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExcelExport;

class OrderController extends Controller
{
    public function filterOrders($slug, Request $request)
    {
        $query = Order::latest()->with(['shipping', 'status', 'user', 'customer']);

        // Order Status Filter (Multi-select support, or fallback to tab slug)
        if ($request->filled('status_id')) {
            $statusIds = (array) $request->status_id;
            $query->whereIn('order_status', $statusIds);
        } elseif ($slug !== 'all') {
            $statusModel = OrderStatus::where('slug', $slug)->first();
            if ($statusModel) {
                $query->where('order_status', $statusModel->id);
            }
        }

        // Date Range (created_at)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // General Keyword Search
        if ($request->filled('keyword')) {
            $kw = trim($request->keyword);
            $query->where(function ($q) use ($kw) {
                $q->where('invoice_id', 'LIKE', "%{$kw}%")
                  ->orWhereHas('shipping', function ($sq) use ($kw) {
                      $sq->where('phone', 'LIKE', "%{$kw}%")
                         ->orWhere('name', 'LIKE', "%{$kw}%")
                         ->orWhere('address', 'LIKE', "%{$kw}%");
                  });
            });
        }

        // Specific Phone Filter
        if ($request->filled('phone')) {
            $ph = trim($request->phone);
            $query->whereHas('shipping', function ($q) use ($ph) {
                $q->where('phone', 'LIKE', "%{$ph}%");
            });
        }

        // Specific Invoice ID Filter
        if ($request->filled('invoice_id')) {
            $inv = trim($request->invoice_id);
            $query->where('invoice_id', 'LIKE', "%{$inv}%");
        }

        // Specific Customer Name Filter
        if ($request->filled('name')) {
            $nm = trim($request->name);
            $query->whereHas('shipping', function ($q) use ($nm) {
                $q->where('name', 'LIKE', "%{$nm}%");
            });
        }

        // Assignee / User Filter (Multi-select support)
        if ($request->filled('user_id')) {
            $userIds = (array) $request->user_id;
            $hasUnassigned = in_array('unassigned', $userIds);
            $numericIds = array_values(array_filter($userIds, function ($id) {
                return is_numeric($id);
            }));

            $query->where(function ($q) use ($hasUnassigned, $numericIds) {
                if ($hasUnassigned && !empty($numericIds)) {
                    $q->where(function ($sq) {
                        $sq->whereNull('user_id')->orWhere('user_id', 0);
                    })->orWhereIn('user_id', $numericIds);
                } elseif ($hasUnassigned) {
                    $q->whereNull('user_id')->orWhere('user_id', 0);
                } elseif (!empty($numericIds)) {
                    $q->whereIn('user_id', $numericIds);
                }
            });
        }

        // Order Type (Multi-select support)
        if ($request->filled('order_type')) {
            $types = (array) $request->order_type;
            $query->whereIn('order_type', $types);
        }

        // Delivery Area Filter (Multi-select support)
        if ($request->filled('area')) {
            $areas = (array) $request->area;
            $query->whereHas('shipping', function ($q) use ($areas) {
                $q->whereIn('area', $areas);
            });
        }

        // Amount Range
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', (float) $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', (float) $request->amount_max);
        }

        // Due & Partial Payment Status (Multi-select support)
        if ($request->filled('due_status')) {
            $dueStatuses = (array) $request->due_status;
            $query->where(function ($q) use ($dueStatuses) {
                foreach ($dueStatuses as $idx => $status) {
                    $clause = $idx === 0 ? 'where' : 'orWhere';
                    if ($status === 'has_due') {
                        $q->$clause(function ($sq) {
                            $sq->whereRaw('(amount - COALESCE(paid_partial_payment_amount, 0)) > 0');
                        });
                    } elseif ($status === 'partial') {
                        $q->$clause(function ($sq) {
                            $sq->whereNotNull('paid_partial_payment_amount')
                               ->where('paid_partial_payment_amount', '>', 0);
                        });
                    } elseif ($status === 'paid') {
                        $q->$clause(function ($sq) {
                            $sq->whereRaw('(amount - COALESCE(paid_partial_payment_amount, 0)) <= 0');
                        });
                    }
                }
            });
        }

        return $query;
    }

    public function index($slug, Request $request)
    {
        if ($slug == 'all') {
            $order_status = (object) [
                'name' => 'All',
                'orders_count' => Order::count(),
            ];
        } else {
            $order_status = OrderStatus::where('slug', $slug)->withCount('orders')->first();
            if (!$order_status) {
                $order_status = (object) [
                    'id' => null,
                    'name' => ucfirst($slug),
                    'orders_count' => 0,
                ];
            }
        }

        $query = $this->filterOrders($slug, $request);
        $total_filtered = (clone $query)->count();
        $total_filtered_amount = (clone $query)->sum('amount');

        $per_page = $request->input('per_page', 10);
        if ($per_page === 'all' || $per_page == -1) {
            $show_data = $query->paginate($total_filtered > 0 ? $total_filtered : 10)->withQueryString();
        } else {
            $show_data = $query->paginate((int) $per_page)->withQueryString();
        }

        $users = User::get();
        $orderstatuses = OrderStatus::get();
        $shippingcharges = ShippingCharge::get();
        $steadfast = Courierapi::where(['status' => 1, 'type' => 'steadfast'])->first();
        $pathaoService = new PathaoService();
        $pathao_info = $pathaoService->getCourier();
        $pathaocities = $pathaoService->getCities();
        $pathaostore = $pathaoService->getStores();

        return view('backEnd.order.index', compact(
            'show_data',
            'order_status',
            'users',
            'orderstatuses',
            'shippingcharges',
            'steadfast',
            'pathaostore',
            'pathaocities',
            'total_filtered',
            'total_filtered_amount',
            'slug'
        ));
    }

    public function pathaocity(Request $request)
    {
        $pathaoService = new PathaoService();
        return response()->json($pathaoService->getZones($request->city_id));
    }

    public function pathaozone(Request $request)
    {
        $pathaoService = new PathaoService();
        return response()->json($pathaoService->getAreas($request->zone_id));
    }

    public function order_pathao(Request $request)
    {
        $order_id = $request->order_ids;

        if (empty($order_id)) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Order ID is required.']);
            }
            Toastr::error('Order ID should not be empty');
            return redirect()->back();
        }

        $order = Order::with(['shipping', 'orderdetails'])->find($order_id);
        if (!$order) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Order not found.']);
            }
            Toastr::error('Order not found');
            return redirect()->back();
        }

        $pathaoService = new PathaoService();
        $res = $pathaoService->createOrder($order, [
            'store_id' => $request->pathaostore,
            'city_id' => $request->pathaocity,
            'zone_id' => $request->pathaozone,
            'area_id' => $request->pathaoarea,
        ]);

        if ($res['status']) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => $res['message'],
                    'consignment_id' => $res['consignment_id'] ?? null,
                ]);
            }
            Toastr::success($res['message'], 'Courier Dispatched');
            return redirect()->back();
        } else {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $res['message']]);
            }
            Toastr::error($res['message'], 'Courier Dispatch Failed');
            return redirect()->back();
        }
    }

    public function invoice($invoice_id){
        $order = Order::where(['invoice_id'=>$invoice_id])->with('orderdetails','payment','shipping','customer')->firstOrFail();
        return view('backEnd.order.invoice',compact('order'));
    }

    public function process($invoice_id)
    {
        $data = Order::where(['invoice_id' => $invoice_id])
            ->select('id', 'invoice_id', 'order_status', 'amount', 'paid_partial_payment_amount', 'shipping_charge', 'order_type', 'created_at', 'admin_note')
            ->with(['orderdetails', 'shipping'])
            ->firstOrFail();
        $shippingcharge = ShippingCharge::where('status', 1)->get();
        $steadfast = Courierapi::where(['status' => 1, 'type' => 'steadfast'])->first();
        $pathaoService = new PathaoService();
        $pathao_info = $pathaoService->getCourier();
        $pathaostore = $pathaoService->getStores();
        $pathaocities = $pathaoService->getCities();
        return view('backEnd.order.process', compact('data', 'shippingcharge', 'steadfast', 'pathao_info', 'pathaostore', 'pathaocities'));
    }

    public function order_process(Request $request)
    {
        $link = OrderStatus::find($request->status)->slug;
        $order = Order::with('shipping')->find($request->id);
        $courier = $order->order_status;
        $order->order_status = $request->status;
        if ($request->has('admin_note')) {
            $order->admin_note = $request->admin_note;
        }
        $order->save();

        $shipping_update = Shipping::where('order_id', $order->id)->first();
        $shippingfee = ShippingCharge::find($request->area);
        if ($shippingfee && $shippingfee->name != $request->area) {
            if ($order->shipping_charge > $shippingfee->amount) {
                $total = $order->amount + ($shippingfee->amount - $order->shipping_charge);
                $order->shipping_charge = $shippingfee->amount;
                $order->amount = $total;
                $order->save();
            } else {
                $total = $order->amount + ($shippingfee->amount - $order->shipping_charge);
                $order->shipping_charge = $shippingfee->amount;
                $order->amount = $total;
                $order->save();
            }
        }

        if ($shipping_update && $shippingfee) {
            $shipping_update->name = $request->name;
            $shipping_update->phone = $request->phone;
            $shipping_update->address = $request->address;
            $shipping_update->area = $shippingfee->name;
            $shipping_update->save();
        }

        if ($request->status == 5 && $courier != 5) {
            $courierType = $request->input('courier_type', 'steadfast');
            if ($courierType == 'pathao') {
                $pathaoService = new PathaoService();
                $res = $pathaoService->createOrder($order, [
                    'store_id' => $request->pathaostore,
                    'city_id' => $request->pathaocity,
                    'zone_id' => $request->pathaozone,
                    'area_id' => $request->pathaoarea,
                ]);
                if ($res['status']) {
                    Toastr::success($res['message'], 'Pathao Dispatch');
                } else {
                    Toastr::error($res['message'], 'Pathao Dispatch Failed');
                }
            } elseif ($courierType == 'steadfast') {
                $courier_info = Courierapi::where(['status' => 1, 'type' => 'steadfast'])->first();
                if ($courier_info) {
                    $recipientName = $order->shipping && $order->shipping->name ? $order->shipping->name : 'Customer';
                    $recipientPhone = $order->shipping && $order->shipping->phone ? $order->shipping->phone : '';
                    $recipientAddress = $order->shipping && $order->shipping->address ? $order->shipping->address : '';
                    $codAmount = round($order->amount - ($order->paid_partial_payment_amount ?? 0));

                    $consignmentData = [
                        'invoice' => $order->invoice_id,
                        'recipient_name' => $recipientName,
                        'recipient_phone' => $recipientPhone,
                        'recipient_address' => $recipientAddress,
                        'cod_amount' => $codAmount > 0 ? $codAmount : 0,
                    ];
                    try {
                        $client = new Client();
                        $response = $client->post($courier_info->url, [
                            'json' => $consignmentData,
                            'headers' => [
                                'Api-Key' => $courier_info->api_key,
                                'Secret-Key' => $courier_info->secret_key,
                                'Accept' => 'application/json',
                            ],
                        ]);
                        $responseData = json_decode($response->getBody(), true);
                        if (isset($responseData['consignment']['consignment_id'])) {
                            $cid = $responseData['consignment']['consignment_id'];
                            $note = trim($order->admin_note ?? '');
                            $order->admin_note = $note ? $note . " | Steadfast: {$cid}" : "Steadfast: {$cid}";
                            $order->save();
                        }
                        Toastr::success('Success', 'Order dispatched to Steadfast successfully');
                    } catch (\Exception $e) {
                        Toastr::error('Steadfast dispatch error: ' . $e->getMessage());
                    }
                }
            }
            return redirect('admin/order/' . $link);
        }

        Toastr::success('Success', 'Order status change successfully');
        return redirect('admin/order/' . $link);
    }

    public function destroy(Request $request){
        $order = Order::where('id',$request->id)->delete();
        $order_details = OrderDetails::where('order_id',$request->id)->delete();
        $shipping = Shipping::where('order_id',$request->id)->delete();
        $payment = Payment::where('order_id',$request->id)->delete();
        Toastr::success('Success','Order delete success successfully');
        return redirect()->back();
    }

    public function order_assign(Request $request)
    {
        if ($request->input('all_matching')) {
            $slug = $request->input('slug', 'all');
            $updated = $this->filterOrders($slug, $request)->update(['user_id' => $request->user_id]);
            return response()->json(['status' => 'success', 'message' => "Assigned user to {$updated} orders successfully"]);
        }
        $ids = (array) $request->input('order_ids', []);
        if (empty($ids)) {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one order']);
        }
        Order::whereIn('id', $ids)->update(['user_id' => $request->user_id]);
        return response()->json(['status' => 'success', 'message' => 'Order user assigned successfully']);
    }

    public function order_status(Request $request)
    {
        if ($request->input('all_matching')) {
            $slug = $request->input('slug', 'all');
            $ids = $this->filterOrders($slug, $request)->pluck('id')->toArray();
        } else {
            $ids = (array) $request->input('order_ids', []);
        }

        if (empty($ids)) {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one order']);
        }

        Order::whereIn('id', $ids)->update(['order_status' => $request->order_status]);

        // Stock is already decremented upon order creation at checkout.
        // Prevent double-decrement when marking orders shipped:
        /*
        if ($request->order_status == 5) {
            $orders = Order::whereIn('id', $ids)->get();
            foreach ($orders as $order) {
                $orders_details = OrderDetails::select('id', 'order_id', 'product_id', 'qty')->where('order_id', $order->id)->get();
                foreach ($orders_details as $order_details) {
                    $product = Product::select('id', 'stock')->find($order_details->product_id);
                    if ($product) {
                        $product->stock -= $order_details->qty;
                        $product->save();
                    }
                }
            }
        }
        */
        return response()->json(['status' => 'success', 'message' => 'Order status changed successfully']);
    }

    public function bulk_destroy(Request $request)
    {
        if ($request->input('all_matching')) {
            $slug = $request->input('slug', 'all');
            $orders_id = $this->filterOrders($slug, $request)->pluck('id')->toArray();
        } else {
            $orders_id = (array) $request->input('order_ids', []);
        }

        if (empty($orders_id)) {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one order']);
        }

        foreach ($orders_id as $order_id) {
            Order::where('id', $order_id)->delete();
            OrderDetails::where('order_id', $order_id)->delete();
            Shipping::where('order_id', $order_id)->delete();
            Payment::where('order_id', $order_id)->delete();
        }
        return response()->json(['status' => 'success', 'message' => 'Orders deleted successfully']);
    }

    public function order_print(Request $request)
    {
        $all_matching = $request->input('all_matching');
        $slug = $request->input('slug', 'all');

        if ($all_matching) {
            $orders = $this->filterOrders($slug, $request)->with(['orderdetails', 'payment', 'shipping', 'customer'])->get();
        } else {
            $ids = (array) $request->input('order_ids', []);
            if (empty($ids)) {
                return response()->json(['status' => 'error', 'message' => 'Please select at least one order']);
            }
            $orders = Order::whereIn('id', $ids)->with(['orderdetails', 'payment', 'shipping', 'customer'])->get();
        }

        if ($orders->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'No orders found to print']);
        }

        $generalsetting = GeneralSetting::first();
        $contact = Contact::first();
        $view = view('backEnd.order.print', compact('orders', 'generalsetting', 'contact'))->render();
        return response()->json(['status' => 'success', 'view' => $view, 'count' => $orders->count()]);
    }

    public function order_export(Request $request)
    {
        $slug = $request->input('slug', 'all');
        $all_matching = $request->input('all_matching');
        $format = strtolower($request->input('export_format', 'xlsx'));

        if ($all_matching) {
            $query = $this->filterOrders($slug, $request);
        } else {
            $ids = (array) $request->input('order_ids', []);
            if (!empty($ids)) {
                $query = Order::whereIn('id', $ids);
            } else {
                $query = $this->filterOrders($slug, $request);
            }
        }

        // 1. Native Excel (.xlsx) Download
        if ($format === 'xlsx' || $format === 'excel') {
            $filename = 'orders_export_' . date('Y_m_d_His') . '.xlsx';
            return Excel::download(new OrderExcelExport($query), $filename);
        }

        // 2. Fast Streamed CSV (.csv) Download
        $filename = 'orders_export_' . date('Y_m_d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($query) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel compatibility with Bengali & unicode text
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'Invoice ID',
                'Date',
                'Customer Name',
                'Customer Phone',
                'Delivery Address',
                'Delivery Area',
                'Order Type',
                'Products Ordered',
                'SubTotal (Tk)',
                'Shipping Charge (Tk)',
                'Discount (Tk)',
                'Total Amount (Tk)',
                'Partial Paid (Tk)',
                'Due Amount (Tk)',
                'Payment Method',
                'Order Status',
                'Assigned Staff',
                'Customer Note'
            ]);

            $query->with(['orderdetails', 'shipping', 'payment', 'status', 'user'])->chunk(200, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    $productsSummary = $order->orderdetails->map(function ($d) {
                        $str = $d->product_name . ' (Qty: ' . $d->qty . ')';
                        if ($d->product_size) $str .= ' [Size: ' . $d->product_size . ']';
                        if ($d->product_color) $str .= ' [Color: ' . $d->product_color . ']';
                        return $str;
                    })->implode('; ');

                    $due = $order->amount - ($order->paid_partial_payment_amount ?? 0);

                    fputcsv($handle, [
                        $order->invoice_id,
                        $order->created_at ? $order->created_at->format('d-m-Y h:i A') : '',
                        $order->shipping ? $order->shipping->name : '',
                        $order->shipping ? $order->shipping->phone : '',
                        $order->shipping ? $order->shipping->address : '',
                        $order->shipping ? $order->shipping->area : '',
                        $order->order_type,
                        $productsSummary,
                        $order->orderdetails->sum(function ($d) { return $d->sale_price * $d->qty; }),
                        $order->shipping_charge ?? 0,
                        $order->discount ?? 0,
                        $order->amount,
                        $order->paid_partial_payment_amount ?? 0,
                        $due,
                        $order->payment ? $order->payment->payment_method : 'Cash On Delivery',
                        $order->status ? $order->status->name : 'Status ' . $order->order_status,
                        $order->user ? $order->user->name : 'Unassigned',
                        $order->note ?? ''
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    public function bulk_courier($slug, Request $request)
    {
        if ($request->input('all_matching')) {
            $filterSlug = $request->input('filter_slug', 'all');
            $orders_id = $this->filterOrders($filterSlug, $request)->pluck('id')->toArray();
        } else {
            $orders_id = (array) $request->input('order_ids', []);
        }

        if (empty($orders_id)) {
            return response()->json(['status' => 'error', 'message' => 'Please select at least one order']);
        }

        if ($slug == 'pathao') {
            $pathaoService = new PathaoService();
            if (!$pathaoService->isConfigured()) {
                return response()->json(['status' => 'error', 'message' => 'Pathao courier is not configured or active']);
            }

            if (!$pathaoService->ensureValidToken()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pathao access token is missing or expired. Please connect your credentials in Courier API Settings.',
                ]);
            }

            $cityId = $request->input('city_id');
            $zoneId = $request->input('zone_id');
            $storeId = $request->input('store_id');
            $areaId = $request->input('area_id');

            if (empty($cityId) || empty($zoneId)) {
                return response()->json([
                    'status' => 'error',
                    'action' => 'open_modal',
                    'message' => 'Pathao strictly requires destination City and Zone. Please dispatch using the Pathao modal.',
                ]);
            }

            $success_count = 0;
            $failed_count = 0;
            $errors = [];

            foreach ($orders_id as $order_id) {
                $order = Order::with(['shipping', 'orderdetails'])->find($order_id);
                if (!$order) continue;

                $res = $pathaoService->createOrder($order, [
                    'store_id' => $storeId,
                    'city_id' => $cityId,
                    'zone_id' => $zoneId,
                    'area_id' => $areaId,
                ]);

                if ($res['status']) {
                    $success_count++;
                } else {
                    $failed_count++;
                    $errors[] = "Order #{$order->invoice_id}: " . $res['message'];
                }
            }

            if ($success_count > 0 && $failed_count == 0) {
                return response()->json(['status' => 'success', 'message' => "All {$success_count} orders dispatched to Pathao successfully!"]);
            } elseif ($success_count > 0 && $failed_count > 0) {
                return response()->json([
                    'status' => 'warning',
                    'message' => "{$success_count} orders dispatched, {$failed_count} failed: " . implode(' | ', array_slice($errors, 0, 2)),
                ]);
            } else {
                $errMsg = count($errors) > 0 ? implode(' | ', array_slice($errors, 0, 2)) : 'Failed to dispatch orders to Pathao.';
                return response()->json(['status' => 'error', 'message' => $errMsg]);
            }
        } else {
            $courier_info = Courierapi::where(['status' => 1, 'type' => $slug])->first();
            if (!$courier_info) {
                return response()->json(['status' => 'error', 'message' => 'Steadfast courier is not configured or active']);
            }

            $success_count = 0;
            $failed_count = 0;

            foreach ($orders_id as $order_id) {
                $order = Order::with('shipping')->find($order_id);
                if (!$order) continue;

                $codAmount = round($order->amount - ($order->paid_partial_payment_amount ?? 0));
                $ress = Http::withHeaders([
                    'Api-Key' => $courier_info->api_key,
                    'Secret-Key' => $courier_info->secret_key,
                    'Content-Type' => 'application/json'
                ])->post('https://portal.packzy.com/api/v1/create_order', [
                    'invoice' => $order->invoice_id,
                    'recipient_name' => $order->shipping ? $order->shipping->name : 'Customer',
                    'recipient_address' => $order->shipping ? $order->shipping->address : '',
                    'recipient_phone' => $order->shipping ? $order->shipping->phone : '',
                    'cod_amount' => $codAmount > 0 ? $codAmount : 0,
                    'note' => $order->note ? $order->note : 'as fast as possible',
                ]);

                $res = json_decode($ress->getBody()->getContents());
                if (isset($res->consignment)) {
                    $order->order_status = 5;
                    $cid = $res->consignment->consignment_id ?? null;
                    if ($cid) {
                        $note = trim($order->admin_note ?? '');
                        $order->admin_note = $note ? $note . " | Steadfast: {$cid}" : "Steadfast: {$cid}";
                    }
                    $order->update();
                    $success_count++;
                } else {
                    $failed_count++;
                }
            }

            if ($success_count > 0 && $failed_count == 0) {
                return response()->json(['status' => 'success', 'message' => "All {$success_count} orders dispatched to Steadfast successfully"]);
            } elseif ($success_count > 0 && $failed_count > 0) {
                return response()->json(['status' => 'warning', 'message' => "{$success_count} orders dispatched, {$failed_count} failed"]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to dispatch orders to Steadfast']);
            }
        }
    }
    
    
    public function stock_report(Request $request){
        $query = Product::with(['category', 'prosizes'])->where('status', 1);

        if ($request->keyword) {
            $query->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        } elseif ($request->start_date) {
            $query->whereDate('updated_at', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->whereDate('updated_at', '<=', $request->end_date);
        }

        // Calculate totals across matched dataset
        $all_products = (clone $query)->get();
        $total_stock = 0;
        $total_price = 0;
        $total_purchase = 0;

        foreach ($all_products as $prod) {
            if ($prod->prosizes && $prod->prosizes->count() > 0) {
                foreach ($prod->prosizes as $sz) {
                    $total_stock += $sz->quantity;
                    $total_price += ($sz->quantity * $sz->SalePrice);
                    $total_purchase += ($sz->quantity * ($prod->purchase_price ?: 0));
                }
            } else {
                $total_stock += $prod->stock;
                $total_price += ($prod->stock * $prod->new_price);
                $total_purchase += ($prod->stock * ($prod->purchase_price ?: 0));
            }
        }

        $products = $query->paginate(20)->withQueryString();
        $categories = Category::where('status', 1)->select('id', 'name')->orderBy('name')->get();

        return view('backEnd.reports.stock', compact('products', 'categories', 'total_purchase', 'total_stock', 'total_price'));
    }

    public function order_report(Request $request)
    {
        // Retrieve active users and order statuses
        $users = User::where('status', 1)->get();
        $order_statuses = OrderStatus::where('status', 1)->get();

        // Initialize the query for orders with related shipping, order, and status
        $query = OrderDetails::with(['shipping', 'order.status']);

        // Filter by order_status (defaults to 6: Completed, but allows any status or all)
        if ($request->filled('order_status')) {
            $statusId = $request->order_status;
            if ($statusId !== 'all') {
                $query->whereHas('order', function ($q) use ($statusId) {
                    $q->where('order_status', $statusId);
                });
            }
        } else {
            // Default to Completed orders (status 6)
            $query->whereHas('order', function ($q) {
                $q->where('order_status', 6);
            });
        }

        // Apply keyword filter (searches product_name, invoice_id, customer name, customer phone)
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('product_name', 'LIKE', '%' . $keyword . '%')
                  ->orWhereHas('order', function ($oq) use ($keyword) {
                      $oq->where('invoice_id', 'LIKE', '%' . $keyword . '%');
                  })
                  ->orWhereHas('shipping', function ($sq) use ($keyword) {
                      $sq->where('name', 'LIKE', '%' . $keyword . '%')
                         ->orWhere('phone', 'LIKE', '%' . $keyword . '%');
                  });
            });
        }

        // Apply user filter if provided
        if ($request->user_id) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }

        // Apply date range filter if provided
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        } elseif ($request->start_date) {
            $query->whereDate('updated_at', '>=', $request->start_date);
        } elseif ($request->end_date) {
            $query->whereDate('updated_at', '<=', $request->end_date);
        }

        // Calculate totals over entire matched dataset
        $totalPurchase = (clone $query)->sum(\DB::raw('purchase_price * qty'));
        $total_item = (clone $query)->sum('qty');
        $total_sales = (clone $query)->sum(\DB::raw('sale_price * qty'));

        // Calculate discounts only for the filtered orders (prevents lifetime discount subtraction!)
        $matched_order_ids = (clone $query)->pluck('order_id')->unique();
        $discounts = Order::whereIn('id', $matched_order_ids)->sum('discount');

        $orders = $query->orderBy('id', 'DESC')->paginate(20)->withQueryString();

        return view('backEnd.reports.order', compact('orders', 'users', 'order_statuses', 'totalPurchase', 'total_item', 'total_sales', 'discounts'));
    }


    public function order_create(){
        $products = Product::select('id','name','new_price','product_code')->where(['status'=>1])->get();
        $cartinfo  = Cart::instance('pos_shopping')->content();
        $shippingcharge = ShippingCharge::where('status',1)->get();
        return view('backEnd.order.create',compact('products','cartinfo','shippingcharge'));
    }

    public function order_store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'area'=>'required',
        ]);

        if(Cart::instance('pos_shopping')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');
            return redirect()->back();
        }

        $subtotal = Cart::instance('pos_shopping')->subtotal();
        $subtotal = str_replace(',','',$subtotal);
        $subtotal = str_replace('.00', '',$subtotal);
        $discount = Session::get('pos_discount')+Session::get('product_discount');
        $shippingfee  = ShippingCharge::find($request->area);
        $shipping_charge_amount = $shippingfee ? $shippingfee->amount : 0;
        $shipping_area_name = $shippingfee ? $shippingfee->name : 'Inside Dhaka';

        $exits_customer = Customer::where('phone',$request->phone)->select('phone','id')->first();
        if($exits_customer){
            $customer_id = $exits_customer->id;
        }else{
            $password = rand(111111,999999);
            $store              = new Customer();
            $store->name        = $request->name;
            $store->slug        = $request->name;
            $store->phone       = $request->phone;
            $store->password    = bcrypt($password);
            $store->verify      = 1;
            $store->status      = 'active';
            $store->save();
            $customer_id = $store->id;
        }

         // order data save
        $order                   = new Order();
        $order->invoice_id       = rand(11111,99999);
        $order->amount           = ($subtotal + $shipping_charge_amount) - $discount;
        $order->discount         = $discount ? $discount : 0;
        $order->shipping_charge  = $shipping_charge_amount;
        $order->customer_id      =  $customer_id;
        $order->order_status     = 1;
        $order->note             = $request->note;
        $order->save();

        // shipping data save
        $shipping              =   new Shipping();
        $shipping->order_id    =   $order->id;
        $shipping->customer_id =   $customer_id;
        $shipping->name        =   $request->name;
        $shipping->phone       =   $request->phone;
        $shipping->address     =   $request->address;
        $shipping->area        =   $shipping_area_name;
        $shipping->save();

        // payment data save
        $payment                 = new Payment();
        $payment->order_id       = $order->id;
        $payment->customer_id    = $customer_id;
        $payment->payment_method = 'Cash On Delivery';
        $payment->amount         = $order->amount;
        $payment->payment_status = 'pending';
        $payment->save();

       // order details data save
        foreach(Cart::instance('pos_shopping')->content() as $cart){
            $order_details                   =   new OrderDetails();
            $order_details->order_id         =   $order->id;
            $order_details->product_id       =   $cart->id;
            $order_details->product_name     =   $cart->name;
            $order_details->purchase_price   =   $cart->options->purchase_price;
            $order_details->product_discount =   $cart->options->product_discount;
            $order_details->sale_price       =   $cart->price;
            $order_details->qty              =   $cart->qty;
            $order_details->save();
        }
        Cart::instance('pos_shopping')->destroy();
        Session::forget('pos_shipping');
        Session::forget('pos_discount');
        Session::forget('product_discount');
        Toastr::success('Thanks, Your order place successfully', 'Success!');
        return redirect('admin/order/pending');
    }
    public function cart_add(Request $request){
        $product = Product::select('id','name','stock','new_price','old_price','purchase_price','slug')->where(['id' => $request->id])->first();
        $qty = 1;
        $cartinfo = Cart::instance('pos_shopping')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image,
                'old_price' => $product->old_price,
                'purchase_price' => $product->purchase_price,
                'product_discount' => 0,
            ],
        ]);
        return response()->json(compact('cartinfo'));
    }
    public function cart_content(){
        $cartinfo = Cart::instance('pos_shopping')->content();
        return view('backEnd.order.cart_content',compact('cartinfo'));
    }
    public function cart_details(){
        $cartinfo = Cart::instance('pos_shopping')->content();
        $discount = 0;
        foreach($cartinfo as $cart){
            $discount += $cart->options->product_discount*$cart->qty;
        }
        Session::put('product_discount',$discount);
        return view('backEnd.order.cart_details',compact('cartinfo'));
    }
    public function cart_increment(Request $request){
        $item = Cart::instance('pos_shopping')->get($request->id);
        $qty = $request->has('qty') ? ($request->qty + 1) : ($item ? $item->qty + 1 : 1);
        $cartinfo = Cart::instance('pos_shopping')->update($request->id, $qty);
        return response()->json($cartinfo);
    }
    public function cart_decrement(Request $request){
        $item = Cart::instance('pos_shopping')->get($request->id);
        $qty = $request->has('qty') ? max(1, $request->qty - 1) : ($item ? max(1, $item->qty - 1) : 1);
        $cartinfo = Cart::instance('pos_shopping')->update($request->id, $qty);
        return response()->json($cartinfo);
    }
    public function cart_remove(Request $request){
        $remove = Cart::instance('pos_shopping')->remove($request->id);
        $cartinfo = Cart::instance('pos_shopping')->content();
        return response()->json($cartinfo);
    }
    public function product_discount(Request $request){
        $discount = $request->discount;
        $cart = Cart::instance('pos_shopping')->content()->where('rowId', $request->id)->first();
        if (!$cart) {
            return response()->json(['error' => 'Cart item not found'], 404);
        }
        $cartinfo = Cart::instance('pos_shopping')->update($request->id, [
            'options' => [
                'slug' => $cart->options->slug,
                'image' => $cart->options->image,
                'old_price' => $cart->options->old_price,
                'purchase_price' => $cart->options->purchase_price,
                'product_discount' => $request->discount,
            ],
        ]);
        return response()->json($cartinfo);
    }
    public function cart_shipping(Request $request){
         $shipping = ShippingCharge::where(['status'=>1,'id'=>$request->id])->first()->amount;
        Session::put('pos_shipping', $shipping);
        return response()->json($shipping);
    }

    public function cart_clear(Request $request){
        $cartinfo = Cart::instance('pos_shopping')->destroy();
        Session::forget('pos_shipping');
        Session::forget('pos_discount');
        Session::forget('product_discount');
        return redirect()->back();
    }
    public function order_edit($invoice_id){
        $products = Product::select('id','name','new_price','product_code')->where(['status'=>1])->get();
        $shippingcharge = ShippingCharge::where('status',1)->get();
        $order = Order::where('invoice_id',$invoice_id)->first();
        $cartinfo  = Cart::instance('pos_shopping')->destroy();
        $shippinginfo  = Shipping::where('order_id',$order->id)->first();
        Session::put('product_discount',$order->discount);
        Session::put('pos_shipping',$order->shipping_charge);
        $orderdetails = OrderDetails::where('order_id',$order->id)->get();
        foreach($orderdetails as $ordetails){
        $cartinfo = Cart::instance('pos_shopping')->add([
            'id' => $ordetails->product_id,
            'name' => $ordetails->product_name,
            'qty' => $ordetails->qty,
            'price' => $ordetails->sale_price,
            'options' => [
                'image' => $ordetails->image->image,
                'purchase_price' => $ordetails->purchase_price,
                'product_discount' => $ordetails->product_discount,
                'details_id' => $ordetails->id,
                'product_color' => $ordetails->product_color,
            ],
        ]);
        }
        $cartinfo  = Cart::instance('pos_shopping')->content();
        return view('backEnd.order.edit',compact('products','cartinfo','shippingcharge','shippinginfo','order'));
    }

    public function order_update(Request $request)
{
    $this->validate($request, [
        'name'    => 'required',
        'phone'   => 'required',
        'address' => 'required',
        'area'    => 'required',
    ]);

    if (Cart::instance('pos_shopping')->count() <= 0) {
        Toastr::error('Your shopping cart is empty', 'Failed!');
        return redirect()->back();
    }

    // Get subtotal from cart
    $subtotal = Cart::instance('pos_shopping')->subtotal();
    $subtotal = str_replace([',', '.00'], '', $subtotal);

    // Discounts and shipping
    $discount     = Session::get('pos_discount') + Session::get('product_discount');
    $shippingfee  = ShippingCharge::find($request->area);
    $shipping_charge_amount = $shippingfee ? $shippingfee->amount : 0;
    $shipping_area_name = $shippingfee ? $shippingfee->name : 'Inside Dhaka';

    // Handle customer
    $exits_customer = Customer::where('phone', $request->phone)->select('phone', 'id')->first();
    if ($exits_customer) {
        $customer_id = $exits_customer->id;
    } else {
        $password           = rand(111111, 999999);
        $store              = new Customer();
        $store->name        = $request->name;
        $store->slug        = $request->name;
        $store->phone       = $request->phone;
        $store->password    = bcrypt($password);
        $store->verify      = 1;
        $store->status      = 'active';
        $store->save();
        $customer_id = $store->id;
    }

    // Update Order
    $order                   = Order::where('id', $request->order_id)->first();
    $order->amount           = ($subtotal + $shipping_charge_amount) - $discount;
    $order->discount         = $discount ? $discount : 0;
    $order->shipping_charge  = $shipping_charge_amount;
    $order->customer_id      = $customer_id;
    $order->order_status     = 1;
    $order->note             = $request->note;
    $order->save();

    // Update Shipping
    $shipping              = Shipping::where('order_id', $request->order_id)->first();
    $shipping->order_id    = $order->id;
    $shipping->customer_id = $customer_id;
    $shipping->name        = $request->name;
    $shipping->phone       = $request->phone;
    $shipping->address     = $request->address;
    $shipping->area        = $shipping_area_name;
    $shipping->save();

    // Update Payment
    $payment                 = Payment::where('order_id', $request->order_id)->first();
    $payment->order_id       = $order->id;
    $payment->customer_id    = $customer_id;
    $payment->payment_method = 'Cash On Delivery';
    $payment->amount         = $order->amount;
    $payment->payment_status = 'pending';
    $payment->save();

    // --- remove delete cart DB
    $cartRowIds = [];
    foreach (Cart::instance('pos_shopping')->content() as $cart) {
        $cartRowIds[] = $cart->options->details_id ?? null;
    }

    OrderDetails::where('order_id', $order->id)
        ->whereNotIn('id', array_filter($cartRowIds))
        ->delete();

    // --- update or Insert  cart it--
    foreach (Cart::instance('pos_shopping')->content() as $cart) {
        $exits = OrderDetails::where('id', $cart->options->details_id)->first();

        if ($exits) {
            $order_details = OrderDetails::find($exits->id);
        } else {
            $order_details = new OrderDetails();
            $order_details->order_id   = $order->id;
            $order_details->product_id = $cart->id;
        }

        $order_details->product_name     = $cart->name;
        $order_details->purchase_price   = $cart->options->purchase_price;
        $order_details->product_discount = $cart->options->product_discount;
        $order_details->sale_price       = $cart->price;
        $order_details->qty              = $cart->qty;
        $order_details->save();
    }

    // --- Clear Cart & Session ---
    Cart::instance('pos_shopping')->destroy();
    Session::forget('pos_shipping');
    Session::forget('pos_discount');
    Session::forget('product_discount');

    Toastr::success('Thanks, Order updated successfully', 'Success!');
    return redirect('admin/order/pending');
}


    public function maplist()
    {
        $districts = District::select('district')->distinct()->pluck('district');;
        return view('backEnd.order.maplist',compact('districts'));
    }

}
