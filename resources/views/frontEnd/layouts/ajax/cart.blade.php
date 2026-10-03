@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
    $discount = Session::get('discount') ? Session::get('discount') : 0;
@endphp
<table class="cart_table table mb-0">
    <thead>
        <tr>
            <th style="width: 12%; text-align: center;">মুছুন</th>
            <th style="width: 48%;">পণ্য (Product)</th>
            <th style="width: 20%; text-align: center;">পরিমাণ</th>
            <th style="width: 20%; text-align: right;">মূল্য</th>
        </tr>
    </thead>

    <tbody>
        @foreach (Cart::instance('shopping')->content() as $value)
            <tr>
                <td class="text-center">
                    <a class="cart_remove" data-id="{{ $value->rowId }}" title="Remove item">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="{{ asset($value->options->image) }}" class="cart-prod-img" alt="{{ $value->name }}" />
                        <div>
                            <a href="{{ route('product', $value->options->slug) }}" class="cart-prod-title">
                                {{ Str::limit($value->name, 24) }}
                            </a>
                            @if ($value->options->product_size)
                                <div class="cart-variant-tag">সাইজ: {{ $value->options->product_size }}</div>
                            @endif
                            @if ($value->options->product_color)
                                <div class="cart-variant-tag">রঙ: {{ $value->options->product_color }}</div>
                            @endif
                        </div>
                    </div>
                </td>
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
                <td class="cart_qty text-center">
                    <div class="qty-cart vcart-qty d-inline-block">
                        <div class="quantity d-inline-flex align-items-center justify-content-between" style="width: 100px !important; height: 36px !important; border: 1.5px solid #d1d5db !important; border-radius: 20px !important; background: #ffffff !important; overflow: hidden !important; margin: 0 auto !important; position: relative !important; box-sizing: border-box !important;">
                            <button type="button" class="minus cart_decrement" data-id="{{ $value->rowId }}" style="position: static !important; width: 32px !important; height: 36px !important; border: 0 !important; background: #f3f4f6 !important; color: #111827 !important; font-size: 18px !important; font-weight: 700 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; line-height: 1 !important; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;">-</button>
                            <span class="qty-count-display" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; width: 36px !important; height: 36px !important; text-align: center !important; font-size: 15px !important; font-weight: 700 !important; color: #111827 !important; line-height: 1 !important; user-select: none !important; margin: 0 !important; padding: 0 !important; flex-grow: 1 !important;">{{ $value->qty }}</span>
                            <input type="hidden" class="cart_qty_input" value="{{ $value->qty }}" />
                            <button type="button" class="plus cart_increment" data-id="{{ $value->rowId }}" style="position: static !important; width: 32px !important; height: 36px !important; border: 0 !important; background: #f3f4f6 !important; color: #111827 !important; font-size: 18px !important; font-weight: 700 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; line-height: 1 !important; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;">+</button>
                        </div>
                    </div>
                    @if ($available_stock < $value->qty)
                        <div class="mt-1"><span class="badge bg-danger text-white">স্টক শেষ</span></div>
                    @endif
                </td>
                <td class="text-end">
                    <span class="alinur">৳ </span><strong>{{ $value->price * $value->qty }}</strong>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end">সাবটোটাল (Subtotal)</th>
            <td class="text-end">
                <span id="net_total"><span class="alinur">৳ </span><strong>{{ $subtotal }}</strong></span>
            </td>
        </tr>
        <tr>
            <th colspan="3" class="text-end">ডিসকাউন্ট (Discount)</th>
            <td class="text-end text-success">
                <span id="discount_amount"><span class="alinur">৳ </span><strong id="discount">00</strong></span>
            </td>
        </tr>
        <tr>
            <th colspan="3" class="text-end">ডেলিভারি চার্জ (Delivery Charge)</th>
            <td class="text-end">
                <span id="cart_shipping_cost"><span class="alinur">৳ </span><strong>{{ $shipping }}</strong></span>
            </td>
        </tr>
        <tr>
            <th colspan="3" class="text-end">সর্বমোট (Grand Total)</th>
            <td class="text-end">
                <span id="grand_total"><span class="alinur">৳ </span><strong>{{ $subtotal + $shipping - session('discount', 0) }}</strong></span>
            </td>
        </tr>
    </tfoot>
</table>

<!-- cart js start -->
<script>
    $('.cart_store').on('click', function() {
        var id = $(this).data('id');
        var qty = $(this).parent().find('input').val();
        if (id) {
            $.ajax({
                type: "GET",
                data: {
                    'id': id,
                    'qty': qty ? qty : 1
                },
                url: "{{ route('cart.store') }}",
                success: function(data) {
                    if (data) {
                        return cart_count();
                    }
                }
            });
        }
    });

    $('#order_summary_items_count').text("{{ Cart::instance('shopping')->count() }}");

    function cart_count() {
        $.ajax({
            type: "GET",
            url: "{{ route('cart.count') }}",
            success: function(data) {
                if (data) {
                    $("#cart-qty").html(data);
                    var countVal = $('<div>').html(data).find('a span').first().text().trim();
                    if (countVal) {
                        $("#order_summary_items_count").text(countVal);
                    }
                } else {
                    $("#cart-qty").empty();
                    $("#order_summary_items_count").text(0);
                }
            }
        });
    };
</script>
<!-- cart js end -->
