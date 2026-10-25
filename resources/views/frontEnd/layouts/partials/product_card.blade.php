@php
    $hasOldPrice = !empty($prod->old_price) && $prod->old_price > $prod->new_price;
    $discountPct = $hasOldPrice ? round((($prod->old_price - $prod->new_price) / $prod->old_price) * 100) : 0;

    $productImages = $productImages ?? [];
    $cardImg = isset($productImages[$prod->id]) && file_exists(public_path($productImages[$prod->id]))
        ? asset($productImages[$prod->id])
        : ($prod->image ? asset($prod->image->image) : asset('images/products/black-tea.jpg'));

    $rawName = $prod->name;
    if (str_contains($rawName, '80gm')) {
        $engName = 'Pahari Red Roselle Net Weight 80gm';
        $bnName = '(পাহাড়ি রোজেলা)';
    } elseif (preg_match('/^([^(]+)\s*\((.+)\)$/u', $rawName, $matches)) {
        $engName = trim($matches[1]);
        $bnName = '(' . trim($matches[2]) . ')';
    } else {
        $engName = $rawName;
        $bnName = '';
    }
@endphp

<article class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-tea-100 bg-white shadow-card transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover">
    <!-- Discount & Promotion Badges -->
    <div class="absolute left-3 top-3 z-10 flex flex-col items-start gap-1">
        @if($discountPct > 0)
            <span class="tea-badge-discount">
                {{ $discountPct }}% OFF
            </span>
        @endif
        @if(!empty($prod->deal_of_theday) && $prod->deal_of_theday == 1)
            <span class="tea-badge-deal">
                <svg class="tea-badge-icon" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Deal of the Day
            </span>
        @elseif(!empty($prod->feature_product) && $prod->feature_product == 1)
            <span class="tea-badge-trending">
                <svg class="tea-badge-icon" viewBox="0 0 24 24" fill="currentColor"><path d="M12 23c6.075 0 11-4.925 11-11 0-4.004-2.146-7.51-5.362-9.432a.5.5 0 0 0-.742.536C17.26 5.12 17.5 7.152 16.5 8.5c-.83 1.116-2.03 1.76-3.23 2.5C12.07 11.75 11 12.4 11 14a1 1 0 0 0 2 0c0-.85.74-1.29 1.54-1.78 1.16-.71 2.46-1.5 3.08-2.92C19.04 10.74 20 12.78 20 15c0 4.418-3.582 8-8 8s-8-3.582-8-8c0-3.66 2.05-6.84 5.06-8.44a.5.5 0 0 0 .19-.66C8.28 4.2 8 2.3 8 .5a.5.5 0 0 0-.85-.35C3.89 3.51 1 7.91 1 13c0 6.075 4.925 11 11 11z"/></svg>
                Trending
            </span>
        @elseif(!empty($prod->topsale) && $prod->topsale == 1)
            <span class="tea-badge-flash">
                <svg class="tea-badge-icon" viewBox="0 0 24 24" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Flash Deal
            </span>
        @endif
    </div>

    <!-- Brand Badge -->
    <span class="absolute right-3 top-3 z-10 flex items-center gap-1 rounded-full bg-white/90 px-2 py-0.5 text-[10px] font-semibold text-tea-800 shadow-sm">
        <span class="flex h-3.5 w-3.5 items-center justify-center rounded-full bg-tea-700">
            <span class="h-1.5 w-1.5 rounded-full bg-gold-300"></span>
        </span>
        <span class="font-bengali">অনেককিছু</span>
    </span>

    <!-- Image -->
    <div class="relative aspect-square overflow-hidden bg-white p-3">
        <a href="{{ route('product', $prod->slug) }}" class="block h-full w-full" tabindex="-1" aria-hidden="true">
            <img src="{{ $cardImg }}" alt="{{ $engName }}" loading="lazy" decoding="async"
                class="h-full w-full rounded-xl object-cover transition-transform duration-500 group-hover:scale-105" />
        </a>
    </div>

    <!-- Body -->
    <div class="flex flex-1 flex-col px-3.5 pb-3.5 pt-1 text-center">
        <h3 class="line-clamp-2 min-h-[2.5rem] text-[13.5px] font-semibold leading-snug text-tea-950">
            <a href="{{ route('product', $prod->slug) }}" class="hover:text-tea-700 transition-colors">
                {{ $engName }}
            </a>
        </h3>
        @if(!empty($bnName))
            <p class="font-bengali text-center text-[12px] text-tea-900">{{ $bnName }}</p>
        @endif

        <!-- Rating Stars & Reviews -->
        <div class="mt-1.5 flex items-center justify-center gap-1">
            @for($s = 0; $s < 5; $s++)
                <svg class="h-3 w-3 fill-gold-500 text-gold-500" viewBox="0 0 24 24" fill="currentColor"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                </svg>
            @endfor
            <span class="ml-1 text-[11px] text-tea-800">({{ (abs(crc32($prod->slug ?? 'tea')) % 25) + 18 }})</span>
        </div>

        <div class="mt-2 flex items-center justify-center gap-2">
            @if($hasOldPrice)
                <span class="text-[12px] text-tea-800/80 line-through">
                    <span class="font-bengali">৳</span> {{ number_format($prod->old_price ?? 0, 0) }}
                </span>
            @endif
            <span class="text-[15px] font-bold text-tea-700">
                <span class="font-bengali">৳</span> {{ number_format($prod->new_price ?? 0, 0) }}
            </span>
        </div>

        <div class="mt-auto pt-3">
            <div class="flex items-center gap-2">
                <button type="button" data-id="{{ $prod->id }}"
                    aria-label="Add {{ $engName }} to cart"
                    class="cart_store flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-tea-700 px-3 py-2 text-[12px] font-semibold text-white transition-colors hover:bg-tea-800">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="21" r="1" />
                        <circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                    </svg>
                    Add to Cart
                </button>
                <button type="button" onclick="addTowishlist('{{ $prod->id }}')"
                    aria-label="Add {{ $engName }} to wishlist"
                    class="flex h-11 w-11 min-h-[44px] min-w-[44px] items-center justify-center rounded-lg border border-tea-200 text-tea-800 transition-colors hover:border-red-200 hover:text-red-500">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                    </svg>
                </button>
            </div>

            @if (!$prod->prosizes->isEmpty() || !$prod->procolors->isEmpty())
                <a href="{{ route('product', $prod->slug) }}"
                    class="mt-2 block w-full rounded-lg border border-tea-300 px-3 py-2 text-center text-[12px] font-semibold text-tea-800 transition-colors hover:border-tea-700 hover:bg-tea-50">
                    Buy Now
                </a>
            @else
                <form action="{{ route('cart.store') }}" method="POST" class="m-0 p-0 w-full">
                    @csrf
                    <input type="hidden" name="id" value="{{ $prod->id }}" />
                    <input type="hidden" name="qty" value="1" />
                    <button type="submit"
                        class="mt-2 w-full rounded-lg border border-tea-300 px-3 py-2 text-[12px] font-semibold text-tea-800 transition-colors hover:border-tea-700 hover:bg-tea-50">
                        Buy Now
                    </button>
                </form>
            @endif
        </div>
    </div>
</article>
