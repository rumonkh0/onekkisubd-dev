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
        $pathao_info = Courierapi::where(['status' => 1, 'type' => 'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();

        // pathao courier info
        $pathaocities = [];
        $pathaostore = [];
        if ($pathao_info) {
            try {
                $response = Http::timeout(2)->get($pathao_info->url . '/api/v1/countries/1/city-list');
                $pathaocities = $response->json();
                $response2 = Http::timeout(2)->withHeaders([
                    'Authorization' => 'Bearer ' . $pathao_info->token,
                    'Content-Type' => 'application/json',
                ])->get($pathao_info->url . '/api/v1/stores');
                $pathaostore = $response2->json();
            } catch (\Throwable $e) {
                // Ignore API timeouts
            }
        }

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
        $pathao_info = Courierapi::where(['status'=>1, 'type'=>'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();
        if($pathao_info) {
            $response = Http::get($pathao_info->url . '/api/v1/cities/'.$request->city_id.'/zone-list');
            $pathaozones = $response->json();
            return response()->json($pathaozones);
        } else {
            return response()->json([]);
        }
    }
    public function pathaozone(Request $request)
    {
        $pathao_info = Courierapi::where(['status'=>1, 'type'=>'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();
        if($pathao_info) {
            $response = Http::get($pathao_info->url . '/api/v1/zones/'.$request->zone_id.'/area-list');
            $pathaoareas = $response->json();
            return response()->json($pathaoareas);
        } else {
             return response()->json([]);
        }
    }

    public function order_pathao(Request $request)
    {
        $order_id = $request->order_ids;

        if(isset($order_id)){

            $order = Order::with('shipping')->find($order_id);
            $order_count = OrderDetails::select('order_id')->where('order_id', $order->id)->count();

            $pathao_info = Courierapi::where(['status' => 1, 'type' => 'pathao'])->select('id', 'type', 'url', 'token', 'status')->first();
            if ($pathao_info) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $pathao_info->token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($pathao_info->url . '/api/v1/orders', [
                    'store_id' => $request->pathaostore,
                    'merchant_order_id' => $order->invoice_id,
                    'sender_name' => 'Test',
                    'sender_phone' => $order->shipping ? $order->shipping->phone : '',
                    'recipient_name' => $order->shipping ? $order->shipping->name : '',
                    'recipient_phone' => $order->shipping ? $order->shipping->phone : '',
                    'recipient_address' => $order->shipping ? $order->shipping->address : '',
                    'recipient_city' => $request->pathaocity,
                    'recipient_zone' => $request->pathaozone,
                    'recipient_area' => $request->pathaoarea,
                    'delivery_type' => 48,
                    'item_type' => 2,
                    'special_instruction' => 'Special note- product must be check after delivery',
                    'item_quantity' => 1,
                    'item_weight' => 0.5,
                    'amount_to_collect' => round($order->amount),
                    'item_description' => 'Special note- product must be check after delivery',
                ]);
            }
            if ($response->status() == '200') {
                Toastr::success($response['data']['consignment_id'], 'Courier Tracking ID');
                return redirect()->back();
            } else {
                Toastr::error($response['message'], 'Courier Order Faild');
                return response()->json(['status' => 'failed', 'message' => $response['message'], 'Courier Order Faild']);
            }
            return redirect()->back();
        }else{
            Toastr::error('Order Id should not be empty');

            return redirect()->back();
        }



    }

    public function invoice($invoice_id){
        $order = Order::where(['invoice_id'=>$invoice_id])->with('orderdetails','payment','shipping','customer')->firstOrFail();
        return view('backEnd.order.invoice',compact('order'));
    }

    public function process($invoice_id){
        $data = Order::where(['invoice_id'=>$invoice_id])->select('id','invoice_id','order_status')->with('orderdetails')->first();
        $shippingcharge = ShippingCharge::where('status',1)->get();
        return view('backEnd.order.process',compact('data','shippingcharge'));
    }

    public function order_process(Request $request)
    {

        $link = OrderStatus::find($request->status)->slug;
        $order = Order::find($request->id);
        $courier = $order->order_status;
        $order->order_status = $request->status;
        $order->admin_note = $request->admin_note;
        $order->save();

        $shipping_update = Shipping::where('order_id', $order->id)->first();
        $shippingfee = ShippingCharge::find($request->area);
        if ($shippingfee->name != $request->area) {
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

        $shipping_update->name = $request->name;
        $shipping_update->phone = $request->phone;
        $shipping_update->address = $request->address;
        $shipping_update->area = $shippingfee->name;
        $shipping_update->save();

        if ($request->status == 5 && $courier != 5) {
            $courier_info = Courierapi::where(['status' => 1, 'type' => 'steadfast'])->first();
            if ($courier_info) {
                $consignmentData = [
                    'invoice' => $order->invoice_id,
                    'recipient_name' => $order->shipping ? $order->shipping->name : 'InboxHat',
                    'recipient_phone' => $order->shipping ? $order->shipping->phone : '01750578495',
                    'recipient_address' => $order->shipping ? $order->shipping->address : '01750578495',
                    'cod_amount' => $order->amount
                ];
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
            } else {
                return "ok";
            }
            Toastr::success('Success', 'Order status change successfully');
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
            $courier_info = Courierapi::where(['status' => 1, 'type' => $slug])->first();
            if (!$courier_info) {
                return response()->json(['status' => 'error', 'message' => 'Pathao courier is not configured or active']);
            }

            foreach ($orders_id as $order_id) {
                $order = Order::with('shipping')->find($order_id);
                if (!$order) continue;

                $firstDetail = OrderDetails::where('order_id', $order->id)->first();
                $itemDesc = $firstDetail ? $firstDetail->product_name : 'Ecommerce parcel';

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $courier_info->token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($courier_info->url . '/api/v1/orders', [
                    'store_id' => '114665',
                    'merchant_order_id' => $order->invoice_id,
                    'sender_name' => 'Store',
                    'sender_phone' => $order->shipping ? $order->shipping->phone : '',
                    'recipient_name' => $order->shipping ? $order->shipping->name : '',
                    'recipient_phone' => $order->shipping ? $order->shipping->phone : '',
                    'recipient_address' => $order->shipping ? $order->shipping->address : '',
                    'delivery_type' => 48,
                    'item_type' => 2,
                    'special_instruction' => '',
                    'item_quantity' => 1,
                    'item_weight' => 0.5,
                    'amount_to_collect' => round($order->amount),
                    'item_description' => $itemDesc,
                ]);

                if ($response->status() == 200) {
                    $order->order_status = 5;
                    $order->update();
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Orders dispatched to Pathao successfully']);
        } else {
            $courier_info = Courierapi::where(['status' => 1, 'type' => $slug])->first();
            if (!$courier_info) {
                return response()->json(['status' => 'error', 'message' => 'Steadfast courier is not configured or active']);
            }

            foreach ($orders_id as $order_id) {
                $order = Order::find($order_id);
                if (!$order) continue;

                $ress = Http::withHeaders([
                    'Api-Key' => $courier_info->api_key,
                    'Secret-Key' => $courier_info->secret_key,
                    'Content-Type' => 'application/json'
                ])->post('https://portal.packzy.com/api/v1/create_order', [
                    'invoice' => $order->invoice_id,
                    'recipient_name' => $order->shipping ? $order->shipping->name : 'Customer',
                    'recipient_address' => $order->shipping ? $order->shipping->address : '',
                    'recipient_phone' => $order->shipping ? $order->shipping->phone : '',
                    'cod_amount' => $order->amount,
                    'note' => $order->note ? $order->note : 'as fast as possible',
                ]);

                $res = json_decode($ress->getBody()->getContents());
                if (isset($res->consignment)) {
                    $order->order_status = 5;
                    $order->update();
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Orders dispatched to Steadfast successfully']);
        }
    }
    
    
    public function stock_report(Request $request){
        $products = Product::select('id', 'name','new_price','stock')
            ->where('status', 1);
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category_id) {
            $products = $products->where('category_id', $request->category_id);
        }
        if ($request->start_date && $request->end_date) {
            $products =$products->whereBetween('updated_at', [$request->start_date,$request->end_date]);
        }
        $total_purchase = $products->sum(\DB::raw('purchase_price * stock'));
        $total_stock = $products->sum('stock');
        $total_price = $products->sum(\DB::raw('new_price * stock'));
        $products = $products->paginate(20);
        $categories = Category::where('status',1)->get();
        return view('backEnd.reports.stock',compact('products','categories','total_purchase','total_stock','total_price'));
    }
    public function order_report(Request $request)
    {
        // Retrieve active users
        $users = User::where('status', 1)->get();

        // Initialize the query for orders with related shipping and order details
        $orders = OrderDetails::with('shipping', 'order')
            ->whereHas('order', function ($query) {
                $query->where('order_status', 6); // Only include orders with status 6
            });

        // Apply keyword filter if provided
        if ($request->keyword) {
            $orders = $orders->where('name', 'LIKE', '%' . $request->keyword . '%');
        }

        // Apply user filter if provided
        if ($request->user_id) {
            $orders = $orders->whereHas('order', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            });
        }

        // Apply date range filter if both start_date and end_date are provided
        if ($request->start_date && $request->end_date) {
            $orders = $orders->whereBetween('updated_at', [$request->start_date, $request->end_date]);
        }

        // Calculate the total purchase, total item, and total sales over the entire dataset (before pagination)
        $totalPurchase = $orders->sum(\DB::raw('purchase_price * qty'));
        $total_item = $orders->sum('qty');
        $total_sales = $orders->sum(\DB::raw('sale_price * qty'));
        $discounts = Order::sum('discount');

        // Now apply pagination (this won't affect the totals as they are calculated before pagination)
        $orders = $orders->paginate(10);

        // Return the view with the necessary data
        return view('backEnd.reports.order', compact('orders', 'users', 'totalPurchase', 'total_item', 'total_sales', 'discounts'));
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
