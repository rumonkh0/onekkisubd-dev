@extends('frontEnd.layouts.master')
@section('title','Order Success')
@section('content')
<section class="customer-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="success-img">
                    <img src="{{asset('public/frontEnd/images/order-success.png')}}" alt="">
                </div>
                <div class="success-title" >
                    <h4 style="text-align: left;">Dear Sir,</h4>
                    <h4 style="text-align: left;">Thanks for your purchase. Our customer representatives call you soon. If you have any inquiries please call us at +88{{ App\Models\Contact::first()->phone }}.</h4>
                     <h4 style="text-align: left;">Regards,</h4>
                      <h4 style="text-align: left;">{{ env('APP_NAME') }}.</h4>

                </div>

                <h5 class="my-3">Your Order Details</h5>
                <div class="success-table">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    <p>Invoice ID</p>
                                    <p><strong>{{$order->invoice_id}}</strong></p>
                                </td>
                                <td>
                                    <p>Date</p>
                                    <p><strong>{{$order->created_at->format('d-m-y')}}</strong></p>
                                </td>
                                <td>
                                    <p>Phone</p>
                                    <p><strong>{{$order->shipping?$order->shipping->phone:''}}</strong></p>
                                </td>
                                <td>
                                    <p>Total</p>
                                    <p><strong>৳ {{$order->amount}}</strong></p>
                                </td>
                            </tr>
                            <tr>
                                @php
                                    $payments = App\Models\Payment::where('order_id',$order->id)->first();
                                @endphp
                                <td colspan="4">
                                    <p>Payment Method</p>
                                    <p><strong>{{$payments->payment_method}}</strong></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- success table -->
                <h5 class="my-4">Pay with cash upon delivery</h5>
                <div class="success-table">
                    <h6 class="mb-3">Order Delivery</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderdetails as $key=>$value)
                            <tr>
                                <td>
                                    <p>{{$value->product_name}} x {{$value->qty}}</p>

                                </td>
                                <td><p><strong>৳ {{$value->sale_price}}</strong></p></td>
                            </tr>
                            @endforeach
                            <tr>
                                <th  class="text-end px-4">Net Total</th>
                                <td><strong id="net_total">৳{{$order->amount-$order->shipping_charge}}</strong></td>
                            </tr>
                            <tr>
                                <th  class="text-end px-4">Shipping Cost</th>
                                <td>
                                    <strong id="cart_shipping_cost">৳{{$order->shipping_charge}}</strong>
                                </td>
                            </tr>
                            <tr>
                                <th  class="text-end px-4">Grand Total</th>
                                <td>
                                    <strong id="grand_total">৳{{$order->amount}}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>
                                    <h5 class="my-4">Billing Address</h5>
                                    <p>{{$order->shipping?$order->shipping->name:''}}</p>
                                    <p>{{$order->shipping?$order->shipping->phone:''}}</p>
                                    <p>{{$order->shipping?$order->shipping->address:''}}</p>
                                    <p>{{$order->shipping?$order->shipping->area:''}}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- success table -->
                <a href="{{route('home')}}" class=" my-5 btn btn-primary">Go To Home</a>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    @php
        $postal_code = '';
        if (!empty($order->postal_code)) {
            $postal_code = $order->postal_code;
        } elseif ($order->shipping && !empty($order->shipping->postal_code)) {
            $postal_code = $order->shipping->postal_code;
        } elseif ($order->shipping && !empty($order->shipping->address)) {
            if (preg_match('/\b[0-9]{4}\b/', $order->shipping->address, $matches)) {
                $postal_code = $matches[0];
            }
        }
    @endphp

    // Clear the previous ecommerce object.
    dataLayer.push({ ecommerce: null });

    // Push the purchase event to dataLayer with user data, IP, and user agent.
    dataLayer.push({
        event: "purchase",
        client_ip_address: "{{ request()->ip() }}",
        client_user_agent: navigator.userAgent,
        user_data: {
            phone_number: "{{ $order->shipping ? $order->shipping->phone : '' }}",
            address: {
                first_name: "{{ $order->shipping ? $order->shipping->name : '' }}",
                street: "{{ $order->shipping ? $order->shipping->address : '' }}",
                city: "{{ $order->city ?? '' }}",
                postal_code: "{{ $postal_code }}",
                country: "BD"
            }
        },
        ecommerce: {
            currency: "BDT",
            value: Number("<?php echo $order->amount ?>"),
            shipping: "<?php echo $order->shipping_charge ?>",
            tax: 0,
            coupon: "",
            affiliation: "",
            external_id: "<?php echo $order->id ?>",
            transaction_id: "<?php echo 'TRXLR' . $order->id ?>",
            items: [@foreach ($order->orderdetails as $cartInfo)
                {
                    item_name: "{{$cartInfo->product_name}}",
                    item_id: Number("{{$cartInfo->product_id}}"),
                    price: Number("{{$cartInfo->sale_price}}"),
                    item_size: "{{$cartInfo->product_size}}",
                    item_color: "{{$cartInfo->product_color}}",
                    currency: "BDT",
                    quantity: {{$cartInfo->qty ?? 0}}
                },
            @endforeach],
            more: [
                {
                    Customer_Name: "{{ $order->shipping ? $order->shipping->name : '' }}",
                    Customer_Address: "{{ $order->shipping ? $order->shipping->address : '' }}",
                    Customer_Phone_Number: "{{ $order->shipping ? $order->shipping->phone : '' }}",
                    Customer_Country: 'Bangladesh',
                    Customer_Postal_Code: "{{ $postal_code }}",
                    Customer_IP: "{{ request()->ip() }}",
                    Customer_User_Agent: navigator.userAgent,
                    Customer_Visitor_ID: "{{ $order->shipping ? $order->shipping->id : '' }}",
                    payment_method: "{{ $payments ? $payments->payment_method : '' }}",
                }
            ]
        }
    });

</script>

<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush
