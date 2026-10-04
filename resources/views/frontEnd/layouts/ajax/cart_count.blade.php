@php
    $headerCartItems = Cart::instance('shopping')->content();
    $headerCartCount = Cart::instance('shopping')->count();
    $rawSubtotal = Cart::instance('shopping')->subtotal();
    $rawSubtotal = str_replace(',', '', $rawSubtotal);
    $headerSubtotal = (float) str_replace('.00', '', $rawSubtotal);
@endphp
<a href="{{ route('customer.checkout') }}" aria-label="Cart"
    class="tea-cart-nav-trigger relative block rounded-full p-2 text-tea-800 transition-colors hover:bg-tea-50">
    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <circle cx="8" cy="21" r="1" />
        <circle cx="19" cy="21" r="1" />
        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
    </svg>
    <span class="tea-cart-nav-badge absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-gold-500 px-1 text-[10px] font-semibold text-white">
        {{ $headerCartCount }}
    </span>
</a>

<div class="cshort-summary tea-header-cart-dropdown">
    <!-- Dropdown Header -->
    <div class="tea-cart-dropdown-header">
        <div class="tea-cart-dropdown-title">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>শপিং ব্যাগ</span>
        </div>
        <span class="tea-cart-dropdown-badge">{{ $headerCartCount }}টি আইটেম</span>
    </div>

    @if($headerCartCount > 0)
        <!-- Items List -->
        <div class="tea-cart-dropdown-list">
            @foreach($headerCartItems as $key => $value)
                @php
                    $itemSlug = $value->options->slug ?? '';
                    $rawImg = (string) ($value->options->image ?? '');
                    $cleanImgPath = ltrim($rawImg, '/');
                    if (str_starts_with($cleanImgPath, 'public/')) {
                        $cleanImgPath = substr($cleanImgPath, 7);
                    }
                    if (!empty($cleanImgPath) && file_exists(public_path($cleanImgPath))) {
                        $itemImg = asset($cleanImgPath);
                    } elseif (!empty($rawImg) && file_exists(base_path($rawImg))) {
                        $itemImg = asset($rawImg);
                    } else {
                        $itemImg = asset('public/uploads/settings/1740644407-onekkisu.webp');
                    }
                    $fallbackImg = asset('public/uploads/settings/1740644407-onekkisu.webp');
                    $itemPrice = (float) str_replace(',', '', $value->price);
                    $itemTotal = $itemPrice * $value->qty;
                @endphp
                <div class="tea-cart-dropdown-item">
                    <a href="{{ $itemSlug ? route('product', $itemSlug) : '#' }}" class="tea-cart-item-thumb">
                        <img src="{{ $itemImg }}" alt="{{ $value->name }}"
                             onerror="if(this.src!=='{{ $fallbackImg }}'){this.src='{{ $fallbackImg }}';}" />
                    </a>
                    <div class="tea-cart-item-details">
                        <h4 class="tea-cart-item-name">
                            <a href="{{ $itemSlug ? route('product', $itemSlug) : '#' }}" title="{{ $value->name }}">
                                {{ $value->name }}
                            </a>
                        </h4>
                        @if(!empty($value->options->size))
                            <span class="tea-cart-item-size">সাইজ: {{ $value->options->size }}</span>
                        @endif
                        <div class="tea-cart-item-pricing">
                            <span class="tea-cart-item-unit">{{ $value->qty }} × ৳{{ number_format($itemPrice, 0) }}</span>
                            <span class="tea-cart-item-total">৳{{ number_format($itemTotal, 0) }}</span>
                        </div>
                    </div>
                    <button type="button" class="tea-cart-item-del cart_remove" data-id="{{ $value->rowId }}" title="কার্ট থেকে মুছুন" aria-label="Remove item">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Footer -->
        <div class="tea-cart-dropdown-footer">
            <div class="tea-cart-subtotal-bar">
                <span class="tea-cart-subtotal-lbl">সাবটোটাল (Subtotal):</span>
                <span class="tea-cart-subtotal-val">৳{{ number_format($headerSubtotal, 0) }}</span>
            </div>

            <div class="tea-cart-perk-note">
                <i class="fa-solid fa-shield-halved"></i>
                <span>ক্যাশ অন ডেলিভারি সারা দেশে প্রযোজ্য</span>
            </div>

            <div class="tea-cart-cta-actions">
                <a href="{{ route('customer.checkout') }}" class="tea-cart-checkout-btn" style="background: linear-gradient(135deg, #173f2c 0%, #0a211b 100%) !important; color: #ffffff !important;">
                    <i class="fa-solid fa-lock" style="color: #e2cf9c !important; font-size: 14px;"></i>
                    <span style="color: #ffffff !important; font-weight: 800 !important; font-size: 14.5px; text-shadow: 0 1px 2px rgba(0,0,0,0.4);">অর্ডার সম্পন্ন করুন</span>
                    <i class="fa-solid fa-arrow-right" style="color: #e2cf9c !important; font-size: 14px;"></i>
                </a>
                <a href="{{ route('cart.show') }}" class="tea-cart-view-link">
                    <i class="fa-solid fa-eye"></i> সম্পূর্ণ কার্ট দেখুন
                </a>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="tea-cart-empty-box">
            <div class="tea-cart-empty-icon">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h4 class="tea-cart-empty-heading">আপনার ব্যাগটি এখনো খালি</h4>
            <p class="tea-cart-empty-text">আমাদের সতেজ ও খাঁটি পাহাড়ি চা সম্ভার থেকে আপনার পছন্দের চা যোগ করুন।</p>
            <a href="{{ route('shop') }}" class="tea-cart-empty-cta">
                <i class="fa-solid fa-leaf"></i>
                <span>চা কালেকশন দেখুন</span>
            </a>
        </div>
    @endif
</div>