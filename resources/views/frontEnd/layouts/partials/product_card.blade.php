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
    <!-- Discount Badge (only if discount exists) -->
    @if($discountPct > 0)
        <div class="absolute left-3 top-3 z-10 flex flex-col items-start gap-1">
            <span class="tea-badge-discount">
                {{ $discountPct }}% OFF
            </span>
        </div>
    @endif

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
