@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal = str_replace(',', '', $subtotal);
    $subtotal = str_replace('.00', '', $subtotal);
    view()->share('subtotal', $subtotal);
@endphp
<a href="{{ route('customer.checkout') }}" aria-label="Cart" class="relative block rounded-full p-2 text-tea-800 transition-colors hover:bg-tea-50">
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="8" cy="21" r="1"/>
        <circle cx="19" cy="21" r="1"/>
        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
    </svg>
    <span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-gold-500 px-1 text-[10px] font-semibold text-white">
        {{ Cart::instance('shopping')->count() }}
    </span>
</a>
<div class="cshort-summary">
    <ul>
        @foreach(Cart::instance('shopping')->content() as $key => $value)
            <li>
                <a href=""><img src="{{ asset($value->options->image) }}" alt="" /></a>
            </li>
            <li><a href="">{{ Str::limit($value->name, 28) }}</a></li>
            <li>Qty: {{ $value->qty }}</li>
            <li>
                <p>৳{{ $value->price }}</p>
                <button type="button" class="remove-cart cart_remove" data-id="{{ $value->rowId }}"><i data-feather="x"></i></button>
            </li>
        @endforeach
    </ul>
    <p><strong>সর্বমোট : ৳{{ $subtotal }}</strong></p>
    <a href="{{ route('customer.checkout') }}" class="go_cart">অর্ডার করুন</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
<script>
    feather.replace();
</script>
<script>
    $('.cart_remove').on('click', function () {
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                type: "GET",
                data: { 'id': id },
                url: "{{ route('cart.remove') }}",
                success: function (data) {
                    if (data) {
                        $("#cartlist").html(data);
                        return cart_count() + cart_summary();
                    }
                }
            });
        }
    });
</script>