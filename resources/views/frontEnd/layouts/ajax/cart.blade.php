@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
    $discount = Session::get('discount') ? Session::get('discount') : 0;
@endphp

<!-- Products Table -->
<table class="tea-clean-table">
    <thead>
        <tr>
            <th style="width: 46%;">পণ্য</th>
            <th style="width: 22%; text-align: center;">পরিমাণ</th>
            <th style="width: 14%; text-align: right;">মূল্য</th>
            <th style="width: 14%; text-align: right;">মোট</th>
            <th style="width: 4%; text-align: right;"></th>
        </tr>
    </thead>
    <tbody>
        @foreach (Cart::instance('shopping')->content() as $value)
            @php
                $single_product = App\Models\Product::find($value->id);
                $single_stock_quantity = $single_product ? $single_product->stock : 0;
                $has_variant_size = $value->options->product_size && App\Models\Productsize::where('product_id', $value->id)->where('size', $value->options->product_size)->exists();
                if ($has_variant_size) {
                    $variant_qty = App\Models\Productsize::where('product_id', $value->id)
                        ->where('size', $value->options->product_size)
                        ->sum('quantity');
                    $available_stock = $variant_qty > 0 ? $variant_qty : $single_stock_quantity;
                } else {
                    $available_stock = $single_stock_quantity;
                }
            @endphp
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-2.5">
                        <img src="{{ asset($value->options->image) }}" class="tea-clean-prod-thumb" alt="{{ $value->name }}" />
                        <div class="tea-clean-prod-info">
                            <a href="{{ route('product', $value->options->slug) }}" class="tea-clean-prod-name">
                                {{ Str::limit($value->name, 28) }}
                            </a>
                            @if ($value->options->product_size)
                                <div class="tea-clean-prod-variant">সাইজ/ওজন: {{ $value->options->product_size }}</div>
                            @endif
                            @if ($value->options->product_color)
                                <div class="tea-clean-prod-variant">রঙ: {{ $value->options->product_color }}</div>
                            @endif
                            @if ($available_stock < $value->qty)
                                <span class="stock-out-badge bg-danger text-white mt-1 d-inline-block px-2 py-0.5 rounded-pill" style="font-size: 10px; font-weight: 700;">স্টক শেষ</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="text-center cart_qty">
                    <div class="tea-clean-stepper">
                        <button type="button" class="tea-clean-stepper-btn cart_decrement" data-id="{{ $value->rowId }}" title="পরিমাণ কমান">−</button>
                        <span class="tea-clean-stepper-val qty-count-display">{{ $value->qty }}</span>
                        <input type="hidden" class="cart_qty_input" value="{{ $value->qty }}" />
                        <button type="button" class="tea-clean-stepper-btn cart_increment" data-id="{{ $value->rowId }}" title="পরিমাণ বাড়ান">+</button>
                    </div>
                </td>
                <td class="text-end tea-price-col">
                    <span class="font-bengali">৳</span> {{ number_format($value->price, 0) }}
                </td>
                <td class="text-end tea-total-col">
                    <strong><span class="font-bengali">৳</span> {{ number_format($value->price * $value->qty, 0) }}</strong>
                </td>
                <td class="text-end">
                    <a class="tea-clean-remove cart_remove" data-id="{{ $value->rowId }}" title="পণ্যটি সরান">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Coupon Code Row -->
<div class="tea-clean-coupon-wrap">
    <i class="fa-solid fa-tag text-muted"></i>
    <input type="text" id="coupon" name="coupon" placeholder="কুপন কোড লিখুন..." value="{{ session('coupon_code', '') }}" />
    <button class="tea-btn-coupon-apply" id="applyCoupon" type="button">প্রয়োগ</button>
</div>
<strong id="error" class="tea-coupon-msg d-block mb-3" style="font-size: 12.5px;"></strong>

<!-- Price Breakdown Totals -->
<div class="tea-clean-summary-breakdown">
    <div class="tea-clean-summary-line">
        <span class="tea-summary-label">সাবটোটাল</span>
        <span id="net_total" class="tea-summary-value"><span class="font-bengali">৳</span> {{ number_format($subtotal, 0) }}</span>
    </div>
    <div class="tea-clean-summary-line text-success">
        <span class="tea-summary-label">ডিসকাউন্ট</span>
        <span id="discount_amount" class="tea-summary-value">- <span class="font-bengali">৳</span> <strong id="discount">{{ number_format($discount, 0) }}</strong></span>
    </div>
    <div class="tea-clean-summary-line">
        <span class="tea-summary-label">ডেলিভারি চার্জ</span>
        <span id="cart_shipping_cost" class="tea-summary-value"><span class="font-bengali">৳</span> {{ number_format($shipping, 0) }}</span>
    </div>
    <div class="tea-clean-summary-line total">
        <span class="tea-summary-label">সর্বমোট পরিশোধযোগ্য</span>
        <span id="grand_total" class="tea-summary-value text-tea-800">
            <span class="font-bengali">৳</span> <strong>{{ number_format($subtotal + $shipping - $discount, 0) }}</strong>
        </span>
    </div>
</div>

<script>
    $('#order_summary_items_count').text("{{ Cart::instance('shopping')->count() }}");
</script>
