@extends('frontEnd.layouts.master')

@section('title', 'Pure Taste of Nature - ' . ($generalsetting->name ?? 'OnekkisuBD'))

@push('seo')
    <meta name="app-url" content="{{ url('/') }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description"
        content="Handcrafted premium tea, collected from authentic sources to bring you a healthier and happier life. 100% Organic & Natural." />
    <meta name="keywords" content="tea, organic tea, green tea, roselle tea, orthodox black tea, bangladesh tea" />
    <meta property="og:title" content="OnekkisuBD - Experience The Pure Taste Of Nature" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ asset('images/hero.jpg') }}" />
    <meta property="og:description"
        content="Handcrafted premium tea, collected from authentic sources to bring you a healthier and happier life." />
@endpush

@section('content')
    <div class="claude-theme">

        @php
            $productImages = [
                29 => 'images/products/black-tea.jpg',
                11 => 'images/products/green-tea-jar.jpg',
                10 => 'images/products/roselle-tea.jpg',
                9 => 'images/products/green-tea-cup.jpg',
                6 => 'images/products/gold-tea.jpg',
                43 => 'images/products/roselle-pack.jpg',
                38 => 'images/products/chamomile.jpg',
                36 => 'images/products/tea-jar.jpg',
            ];
        @endphp

        <!-- ==========================================================================
                 SECTION 1: HERO (Hero.tsx)
                 ========================================================================== -->
        <section id="home" class="relative overflow-hidden bg-tea-900">
            <!-- Background image -->
            <img src="{{ asset('images/hero.jpg') }}" alt="Tea garden at sunrise with a cup of green tea"
                class="absolute inset-0 h-full w-full object-cover object-[70%_center]" />
            <!-- Overlays for readability -->
            <div class="absolute inset-0 bg-[#f4f6ec]/80 lg:hidden"></div>
            <div
                class="absolute inset-0 hidden bg-gradient-to-r from-[#f4f6ec]/95 via-[#f4f6ec]/55 via-40% to-transparent to-65% lg:block">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-tea-950/30 via-transparent to-transparent"></div>

            <!-- Floating leaves -->
            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute -left-4 top-6 h-20 w-20 rotate-[160deg] opacity-80 animate-float-slow"
                fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad1)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8M18 46c3-5 5-7 8-10" stroke="#e5efe2" stroke-width="1"
                    stroke-linecap="round" opacity=".7" />
                <defs>
                    <linearGradient id="heroLeafGrad1" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute left-[38%] top-4 hidden h-12 w-12 rotate-[200deg] opacity-70 animate-float lg:block"
                fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad2)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="heroLeafGrad2" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute right-[10%] top-8 hidden h-14 w-14 -rotate-12 opacity-80 animate-float-slow lg:block"
                fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad3)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="heroLeafGrad3" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute -bottom-3 left-[30%] h-16 w-16 rotate-45 opacity-70 animate-float"
                style="animation-delay: 1.5s;" fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad4)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="heroLeafGrad4" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute -right-4 bottom-10 h-24 w-24 rotate-[110deg] opacity-80 animate-float-slow"
                style="animation-delay: 2s;" fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad5)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="heroLeafGrad5" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <div class="relative mx-auto max-w-[1400px] px-4 sm:px-6">
                <div class="grid min-h-[560px] items-center py-16 lg:min-h-[640px] lg:grid-cols-2 lg:py-20">
                    <!-- Copy -->
                    <div class="max-w-xl xl:max-w-none">
                        <div class="mb-3 flex items-center gap-3 sm:ml-2">
                            <!-- Sprig Leaf SVG -->
                            <svg viewBox="0 0 64 64" class="pointer-events-none h-9 w-9" fill="none" aria-hidden="true">
                                <path d="M32 58C32 40 32 24 34 8" stroke="#2f6f37" stroke-width="2"
                                    stroke-linecap="round" />
                                <path d="M33 22c-9-1-15-7-16-16 9 1 15 7 16 16z" fill="#468a47" />
                                <path d="M34 36c9-1 15-7 16-16-9 1-15 7-16 16z" fill="#2f6f37" />
                                <path d="M32 50c-9-1-15-7-16-16 9 1 15 7 16 16z" fill="#6ba367" />
                                <path d="M33 22l-9-9M34 36l9-9M32 50l-9-9" stroke="#e5efe2" stroke-width="1"
                                    stroke-linecap="round" />
                            </svg>
                        </div>

                        <div class="mb-5 flex items-center gap-3">
                            <span class="h-px w-8 bg-gold-500"></span>
                            <span class="text-[11px] font-semibold tracking-[0.28em] text-tea-800 uppercase">
                                Bangladesh's Trusted Tea Brand
                            </span>
                            <span class="h-px w-8 bg-gold-500"></span>
                        </div>

                        <h1 class="font-serif text-[44px] font-bold leading-[1.02] text-tea-800 sm:text-6xl lg:text-[68px]">
                            Experience
                            <br />
                            <span class="text-gold-500">The Pure Taste</span>
                            <br />
                            Of Nature
                        </h1>

                        <p class="mt-6 max-w-md text-[15px] leading-relaxed text-tea-900/80">
                            Handcrafted premium tea, collected from authentic sources to bring you a healthier and happier
                            life.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-4">
                            <a href="{{ url('shop') }}"
                                class="group inline-flex items-center gap-2 rounded-full bg-tea-700 px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-tea-900/25 transition-all hover:bg-tea-800 hover:shadow-xl">
                                Shop Collection
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>
                            <a href="#features"
                                class="inline-flex items-center gap-2 rounded-full border-2 border-tea-700 bg-white/60 px-6 py-3 text-sm font-semibold text-tea-800 backdrop-blur transition-colors hover:bg-tea-700 hover:text-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                                    <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                                </svg>
                                Explore Benefits
                            </a>
                        </div>

                        <!-- Trust badges -->
                        <ul class="mt-10 hero-trust-list">
                            <li class="flex items-center gap-2.5">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-tea-700/30 bg-white/60 text-tea-700 backdrop-blur">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                                    </svg>
                                </span>
                                <span class="text-[12px] font-semibold leading-tight text-tea-900 whitespace-nowrap">
                                    100%<br />Natural
                                </span>
                            </li>
                            <li class="flex items-center gap-2.5 hero-trust-divider">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-tea-700/30 bg-white/60 text-tea-700 backdrop-blur">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                        <path d="m9 12 2 2 4-4" />
                                    </svg>
                                </span>
                                <span class="text-[12px] font-semibold leading-tight text-tea-900 whitespace-nowrap">
                                    Premium<br />Quality
                                </span>
                            </li>
                            <li class="flex items-center gap-2.5 hero-trust-divider-desktop">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-tea-700/30 bg-white/60 text-tea-700 backdrop-blur">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                        <path d="M15 18H9" />
                                        <path
                                            d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                                        <circle cx="17" cy="18.5" r="2.5" />
                                        <circle cx="7" cy="18.5" r="2.5" />
                                    </svg>
                                </span>
                                <span class="text-[12px] font-semibold leading-tight text-tea-900 whitespace-nowrap">
                                    Fast<br />Delivery
                                </span>
                            </li>
                            <li class="flex items-center gap-2.5 hero-trust-divider">
                                <span
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-tea-700/30 bg-white/60 text-tea-700 backdrop-blur">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                </span>
                                <span class="text-[12px] font-semibold leading-tight text-tea-900 whitespace-nowrap">
                                    Trusted<br />By Thousands
                                </span>
                            </li>
                        </ul>
                    </div>

                    <!-- Right side script quote -->
                    <div class="pointer-events-none relative hidden h-full lg:block">
                        <div class="absolute right-2 top-[42%] -translate-y-1/2 text-right xl:right-8">
                            <p
                                class="font-script text-4xl leading-[1.05] text-white drop-shadow-[0_2px_8px_rgba(0,0,0,0.45)] xl:text-[44px]">
                                Good Tea
                                <br />
                                Brings
                                <br />
                                Good People
                                <br />
                                Together
                            </p>
                            <span class="mt-3 ml-auto block h-px w-24 bg-white/80"></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================================================
                 SECTION 2: FLASH SALES (FlashSales.tsx)
                 ========================================================================== -->
        <section id="flash-sales" class="relative bg-cream py-12 lg:py-16">
            <div class="mx-auto max-w-[1400px] px-4 sm:px-6">
                <!-- Header -->
                <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <h2
                            class="flex items-center gap-2 font-serif text-3xl font-bold tracking-wide text-tea-950 sm:text-4xl">
                            FLASH <span class="text-tea-700">SALES</span>
                            <svg class="h-7 w-7 fill-tea-500 text-tea-500" viewBox="0 0 24 24" fill="currentColor"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                            </svg>
                        </h2>
                        <p class="mt-1 text-sm text-tea-900/70">
                            Premium Teas at Special Prices <span class="mx-2 text-tea-300">|</span> Limited Time Offer
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-5 sm:gap-8">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex h-10 w-10 items-center justify-center rounded-full border border-tea-200 bg-white text-tea-700 shadow-sm">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="13" r="8" />
                                    <path d="M12 9v4l2 2" />
                                    <path d="m5 3 2 2" />
                                    <path d="m19 3-2 2" />
                                    <path d="m6 19-2 2" />
                                    <path d="m18 19 2 2" />
                                </svg>
                            </span>
                            <span class="text-sm font-medium text-tea-900/80">Deal Ends In</span>
                            <div class="flex items-start gap-2">
                                <!-- Hours -->
                                <div class="flex flex-col items-center">
                                    <span id="flash-hours"
                                        class="flex h-11 w-12 items-center justify-center rounded-lg bg-tea-700 font-serif text-lg font-bold text-white shadow-inner tabular-nums">
                                        11
                                    </span>
                                    <span class="mt-1 text-[10px] font-medium text-tea-900/70">Hours</span>
                                </div>
                                <!-- Minutes -->
                                <div class="flex flex-col items-center">
                                    <span id="flash-mins"
                                        class="flex h-11 w-12 items-center justify-center rounded-lg bg-tea-700 font-serif text-lg font-bold text-white shadow-inner tabular-nums">
                                        56
                                    </span>
                                    <span class="mt-1 text-[10px] font-medium text-tea-900/70">Minutes</span>
                                </div>
                                <!-- Seconds -->
                                <div class="flex flex-col items-center">
                                    <span id="flash-secs"
                                        class="flex h-11 w-12 items-center justify-center rounded-lg bg-tea-700 font-serif text-lg font-bold text-white shadow-inner tabular-nums">
                                        23
                                    </span>
                                    <span class="mt-1 text-[10px] font-medium text-tea-900/70">Seconds</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ url('shop') }}"
                            class="group inline-flex items-center gap-1.5 rounded-full border border-tea-700 px-5 py-2 text-sm font-semibold text-tea-800 transition-colors hover:bg-tea-700 hover:text-white">
                            View All
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Grid (6 Flash Sale Product Cards) -->
                <div class="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3 xl:grid-cols-6">
                    @php
                        $flashItems = $hotdeal_top && $hotdeal_top->count() > 0 ? $hotdeal_top->take(6) : \App\Models\Product::with('image')->take(6)->get();
                    @endphp

                    @foreach($flashItems as $prod)
                        @php
                            $hasOldPrice = !empty($prod->old_price) && $prod->old_price > $prod->new_price;
                            $discountPct = $hasOldPrice ? round((($prod->old_price - $prod->new_price) / $prod->old_price) * 100) : 0;

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

                        <article
                            class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-tea-100 bg-white shadow-card transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover">
                            <!-- Discount Badge -->
                            @if($discountPct > 0)
                                <span
                                    class="absolute left-3 top-3 z-10 rounded-md bg-red-600 px-2 py-0.5 text-[10px] font-bold text-white shadow">
                                    {{ $discountPct }}% OFF
                                </span>
                            @endif

                            <!-- Brand Badge -->
                            <span
                                class="absolute right-3 top-3 z-10 flex items-center gap-1 rounded-full bg-white/90 px-2 py-0.5 text-[10px] font-semibold text-tea-800 shadow-sm">
                                <span class="flex h-3.5 w-3.5 items-center justify-center rounded-full bg-tea-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-gold-300"></span>
                                </span>
                                <span class="font-bengali">অনেককিছু</span>
                            </span>

                            <!-- Image -->
                            <div class="relative aspect-square overflow-hidden bg-white p-3">
                                <a href="{{ route('product', $prod->slug) }}" class="block h-full w-full">
                                    <img src="{{ $cardImg }}" alt="{{ $engName }}" loading="lazy"
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
                                @if($bnName)
                                    <p class="font-bengali text-center text-[12px] text-tea-900/70">{{ $bnName }}</p>
                                @endif

                                <div class="mt-2 flex items-center justify-center gap-2">
                                    @if($hasOldPrice)
                                        <span class="text-[12px] text-tea-900/50 line-through">
                                            <span class="font-bengali">৳</span> {{ number_format($prod->old_price, 0) }}
                                        </span>
                                    @endif
                                    <span class="text-[15px] font-bold text-tea-700">
                                        <span class="font-bengali">৳</span> {{ number_format($prod->new_price, 0) }}
                                    </span>
                                </div>

                                <div class="mt-auto pt-3">
                                    <div class="flex items-center gap-2">
                                        <button type="button" data-id="{{ $prod->id }}"
                                            class="cart_store flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-tea-700 px-3 py-2 text-[12px] font-semibold text-white transition-colors hover:bg-tea-800">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="8" cy="21" r="1" />
                                                <circle cx="19" cy="21" r="1" />
                                                <path
                                                    d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                                            </svg>
                                            Add to Cart
                                        </button>
                                        <button type="button" onclick="addTowishlist('{{ $prod->id }}')"
                                            aria-label="Add to wishlist"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-tea-200 text-tea-800 transition-colors hover:border-red-200 hover:text-red-500">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path
                                                    d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
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
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ==========================================================================
                 SECTION 3: NEW ARRIVALS (NewArrivals.tsx)
                 ========================================================================== -->
        <section id="new-arrivals" class="relative overflow-hidden bg-white py-12 lg:py-16">
            <!-- Floating decorative leaves -->
            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute -left-6 top-10 h-24 w-24 rotate-[150deg] opacity-40 animate-float-slow"
                fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#newLeafGrad1)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="newLeafGrad1" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute -right-6 top-6 h-24 w-24 -rotate-12 opacity-40 animate-float-slow"
                style="animation-delay: 3s;" fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#newLeafGrad2)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="newLeafGrad2" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <div class="relative mx-auto max-w-[1400px] px-4 sm:px-6">
                <!-- Header -->
                <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <span class="text-[10px] font-semibold tracking-[0.25em] text-tea-900/50 uppercase">Discover our
                            latest</span>
                        <h2
                            class="mt-1 flex items-center gap-2 font-serif text-3xl font-bold tracking-wide text-tea-950 sm:text-4xl">
                            NEW <span class="text-tea-700">ARRIVALS</span>
                            <!-- Sprig Leaf SVG -->
                            <svg viewBox="0 0 64 64" class="h-8 w-8 rotate-45" fill="none" aria-hidden="true">
                                <path d="M32 58C32 40 32 24 34 8" stroke="#2f6f37" stroke-width="2"
                                    stroke-linecap="round" />
                                <path d="M33 22c-9-1-15-7-16-16 9 1 15 7 16 16z" fill="#468a47" />
                                <path d="M34 36c9-1 15-7 16-16-9 1-15 7-16 16z" fill="#2f6f37" />
                                <path d="M32 50c-9-1-15-7-16-16 9 1 15 7 16 16z" fill="#6ba367" />
                                <path d="M33 22l-9-9M34 36l9-9M32 50l-9-9" stroke="#e5efe2" stroke-width="1"
                                    stroke-linecap="round" />
                            </svg>
                        </h2>
                        <p class="mt-1 text-sm text-tea-900/70">Fresh Teas. New Flavours. A Healthier You.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 lg:gap-8">
                        <ul class="flex flex-wrap items-center gap-6">
                            <li class="flex items-center gap-2.5">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-tea-700 text-white">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="8" width="18" height="4" rx="1" />
                                        <path d="M12 8v13" />
                                        <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7" />
                                        <path
                                            d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5" />
                                    </svg>
                                </span>
                                <span class="text-[12px] leading-tight">
                                    <span class="block font-semibold text-tea-950">Fast Delivery</span>
                                    <span class="text-tea-900/60">Across Bangladesh</span>
                                </span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-tea-700 text-white">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                                    </svg>
                                </span>
                                <span class="text-[12px] leading-tight">
                                    <span class="block font-semibold text-tea-950">100% Organic</span>
                                    <span class="text-tea-900/60">Pure & Natural</span>
                                </span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="flex h-9 w-9 items-center justify-center rounded-full bg-tea-700 text-white">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                        <path d="m9 12 2 2 4-4" />
                                    </svg>
                                </span>
                                <span class="text-[12px] leading-tight">
                                    <span class="block font-semibold text-tea-950">Trusted Quality</span>
                                    <span class="text-tea-900/60">Loved by Tea Lovers</span>
                                </span>
                            </li>
                        </ul>
                        <a href="{{ url('shop') }}"
                            class="group inline-flex items-center gap-1.5 rounded-full border border-tea-700 px-5 py-2 text-sm font-semibold text-tea-800 transition-colors hover:bg-tea-700 hover:text-white">
                            View All
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Carousel -->
                <div class="relative">
                    <button type="button" onclick="scrollNewArrivals(-1)" aria-label="Previous"
                        class="absolute -left-3 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-tea-200 bg-white text-tea-800 shadow-md transition-colors hover:bg-tea-700 hover:text-white md:flex xl:-left-5">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    <button type="button" onclick="scrollNewArrivals(1)" aria-label="Next"
                        class="absolute -right-3 top-1/2 z-10 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-tea-200 bg-white text-tea-800 shadow-md transition-colors hover:bg-tea-700 hover:text-white md:flex xl:-right-5">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>

                    <div id="new-arrivals-track"
                        class="no-scrollbar flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth py-2">
                        @php
                            $arrivalProducts = \App\Models\Product::where('status', 1)
                                ->orderByRaw("FIELD(id, 38, 36, 29, 11, 10, 9, 6, 43, 41)")
                                ->with('image', 'prosizes', 'procolors')
                                ->take(8)
                                ->get();
                        @endphp

                        @foreach($arrivalProducts as $nprod)
                            @php
                                $hasOldPrice = !empty($nprod->old_price) && $nprod->old_price > $nprod->new_price;
                                $discountPct = $hasOldPrice ? round((($nprod->old_price - $nprod->new_price) / $nprod->old_price) * 100) : 0;

                                $cardImg = isset($productImages[$nprod->id]) && file_exists(public_path($productImages[$nprod->id]))
                                    ? asset($productImages[$nprod->id])
                                    : ($nprod->image ? asset($nprod->image->image) : asset('images/products/black-tea.jpg'));

                                $rawName = $nprod->name;
                                if (str_contains($rawName, '80gm')) {
                                    $engName = 'Pahari Red Roselle 80gm';
                                    $bnName = '(পাহাড়ি রোজেলা)';
                                } elseif (preg_match('/^([^(]+)\s*\((.+)\)$/u', $rawName, $matches)) {
                                    $engName = trim($matches[1]);
                                    $bnName = '(' . trim($matches[2]) . ')';
                                } else {
                                    $engName = $rawName;
                                    $bnName = '';
                                }
                            @endphp

                            <div data-card
                                class="w-[calc(50%-8px)] shrink-0 snap-start sm:w-[calc(33.333%-11px)] lg:w-[calc(25%-12px)] xl:w-[calc(16.666%-14px)]">
                                <article
                                    class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-tea-100 bg-white shadow-card transition-all duration-300 hover:-translate-y-1 hover:shadow-card-hover">
                                    <!-- Discount Badge -->
                                    @if($discountPct > 0)
                                        <span
                                            class="absolute left-3 top-3 z-10 rounded-md bg-red-600 px-2 py-0.5 text-[10px] font-bold text-white shadow">
                                            {{ $discountPct }}% OFF
                                        </span>
                                    @endif

                                    <!-- Wishlist Button -->
                                    <button type="button" onclick="addTowishlist('{{ $nprod->id }}')"
                                        aria-label="Add to wishlist"
                                        class="absolute right-3 top-3 z-10 flex h-8 w-8 items-center justify-center rounded-full border border-tea-100 bg-white/90 shadow-sm transition-colors hover:text-red-500">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                        </svg>
                                    </button>

                                    <!-- Image -->
                                    <div class="relative aspect-square overflow-hidden bg-white p-3">
                                        <a href="{{ route('product', $nprod->slug) }}" class="block h-full w-full">
                                            <img src="{{ $cardImg }}" alt="{{ $engName }}" loading="lazy"
                                                class="h-full w-full rounded-xl object-cover transition-transform duration-500 group-hover:scale-105" />
                                        </a>
                                    </div>

                                    <!-- Body -->
                                    <div class="flex flex-1 flex-col px-3.5 pb-3.5 pt-1 text-center">
                                        <h3
                                            class="line-clamp-2 min-h-[2.5rem] text-[13.5px] font-semibold leading-snug text-tea-950">
                                            <a href="{{ route('product', $nprod->slug) }}"
                                                class="hover:text-tea-700 transition-colors">
                                                {{ $engName }}
                                            </a>
                                        </h3>
                                        @if($bnName)
                                            <p class="font-bengali text-center text-[12px] text-tea-900/70">{{ $bnName }}</p>
                                        @endif

                                        <!-- Rating -->
                                        <div class="mt-1.5 flex items-center justify-center gap-1">
                                            @for($s = 0; $s < 5; $s++)
                                                <svg class="h-3 w-3 fill-gold-500 text-gold-500" viewBox="0 0 24 24"
                                                    fill="currentColor" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <polygon
                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                                </svg>
                                            @endfor
                                            <span class="ml-1 text-[11px] text-tea-900/60">({{ rand(18, 42) }})</span>
                                        </div>

                                        <div class="mt-2 flex items-center justify-center gap-2">
                                            @if($hasOldPrice)
                                                <span class="text-[12px] text-tea-900/50 line-through">
                                                    <span class="font-bengali">৳</span> {{ number_format($nprod->old_price, 0) }}
                                                </span>
                                            @endif
                                            <span class="text-[15px] font-bold text-tea-700">
                                                <span class="font-bengali">৳</span> {{ number_format($nprod->new_price, 0) }}
                                            </span>
                                        </div>

                                        <div class="mt-auto pt-3">
                                            <button type="button" data-id="{{ $nprod->id }}"
                                                class="cart_store flex w-full items-center justify-center gap-1.5 rounded-lg bg-tea-700 px-3 py-2 text-[12px] font-semibold text-white transition-colors hover:bg-tea-800">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="8" cy="21" r="1" />
                                                    <circle cx="19" cy="21" r="1" />
                                                    <path
                                                        d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                                                </svg>
                                                Add to Cart
                                            </button>

                                            @if (!$nprod->prosizes->isEmpty() || !$nprod->procolors->isEmpty())
                                                <a href="{{ route('product', $nprod->slug) }}"
                                                    class="mt-2 block w-full rounded-lg border border-tea-300 px-3 py-2 text-center text-[12px] font-semibold text-tea-800 transition-colors hover:border-tea-700 hover:bg-tea-50">
                                                    Buy Now
                                                </a>
                                            @else
                                                <form action="{{ route('cart.store') }}" method="POST" class="m-0 p-0 w-full">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $nprod->id }}" />
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
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================================================
                 SECTION 4: FEATURES STRIP (FeaturesStrip.tsx)
                 ========================================================================== -->
        <section id="features" class="border-y border-tea-100 bg-tea-50">
            <div class="mx-auto grid max-w-[1400px] grid-cols-2 gap-y-6 px-4 py-6 sm:px-6 lg:grid-cols-4">
                <!-- 100% Natural Ingredients -->
                <div class="flex items-center gap-3 px-2 lg:justify-center">
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-tea-700 text-white shadow-md shadow-tea-900/20">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                            <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                        </svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-[13px] font-semibold text-tea-950">100% Natural Ingredients</span>
                        <span class="text-[11.5px] text-tea-900/60">Pure goodness in every cup</span>
                    </span>
                </div>

                <!-- Fast & Reliable Delivery -->
                <div class="flex items-center gap-3 px-2 lg:justify-center lg:border-l lg:border-tea-200">
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-tea-700 text-white shadow-md shadow-tea-900/20">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                            <path d="M15 18H9" />
                            <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                            <circle cx="17" cy="18.5" r="2.5" />
                            <circle cx="7" cy="18.5" r="2.5" />
                        </svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-[13px] font-semibold text-tea-950">Fast & Reliable Delivery</span>
                        <span class="text-[11.5px] text-tea-900/60">All over Bangladesh</span>
                    </span>
                </div>

                <!-- Secure Payment -->
                <div class="flex items-center gap-3 px-2 lg:justify-center lg:border-l lg:border-tea-200">
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-tea-700 text-white shadow-md shadow-tea-900/20">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                            <path d="m9 12 2 2 4-4" />
                        </svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-[13px] font-semibold text-tea-950">Secure Payment</span>
                        <span class="text-[11.5px] text-tea-900/60">Your information is safe with us</span>
                    </span>
                </div>

                <!-- Happy Customers -->
                <div class="flex items-center gap-3 px-2 lg:justify-center lg:border-l lg:border-tea-200">
                    <span
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-tea-700 text-white shadow-md shadow-tea-900/20">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-[13px] font-semibold text-tea-950">Happy Customers</span>
                        <span class="text-[11.5px] text-tea-900/60">Trusted by thousands</span>
                    </span>
                </div>
            </div>
        </section>

        <!-- ==========================================================================
                 SECTION 5: TOP CATEGORIES (TopCategories.tsx)
                 ========================================================================== -->
        <section id="categories" class="relative overflow-hidden bg-sand py-16 lg:py-20">
            <!-- Background texture -->
            <div class="pointer-events-none absolute inset-0 opacity-70"
                style="background-image: radial-gradient(ellipse at 20% 20%, rgba(255,255,255,0.9), transparent 50%), radial-gradient(ellipse at 80% 80%, rgba(255,255,255,0.8), transparent 55%);">
            </div>

            <!-- Decorative leaves -->
            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute left-6 top-12 h-16 w-16 rotate-[140deg] opacity-60 animate-float-slow"
                fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#catLeafGrad1)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="catLeafGrad1" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute left-[12%] bottom-10 h-14 w-14 rotate-[30deg] opacity-50 animate-float"
                style="animation-delay: 1s;" fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#catLeafGrad2)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="catLeafGrad2" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute right-[6%] top-1/3 h-12 w-12 -rotate-45 opacity-50 animate-float-slow"
                style="animation-delay: 2s;" fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#catLeafGrad3)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="catLeafGrad3" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute right-8 bottom-8 h-20 w-20 rotate-[100deg] opacity-60 animate-float"
                style="animation-delay: 0.5s;" fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#catLeafGrad4)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="catLeafGrad4" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <!-- Side scripts -->
            <div
                class="pointer-events-none absolute left-6 top-16 hidden text-[10px] font-semibold tracking-[0.3em] text-tea-900/40 uppercase xl:block">
                <p>Natural</p>
                <p class="mt-1">Pure</p>
                <p class="mt-1">Premium</p>
            </div>
            <p
                class="pointer-events-none absolute right-10 top-14 hidden -rotate-6 font-script text-3xl leading-tight text-tea-900/30 xl:block">
                Good
                <br />
                Tea
                <br />
                Better Days
            </p>

            <div class="relative mx-auto max-w-[1400px] px-4 sm:px-6">
                <!-- Heading -->
                <div class="mx-auto max-w-2xl text-center">
                    <div class="flex items-center justify-center gap-4">
                        <span class="h-px w-16 bg-gold-500/70"></span>
                        <span class="text-[11px] font-semibold tracking-[0.35em] text-tea-900/70 uppercase">Explore
                            our</span>
                        <span class="h-px w-16 bg-gold-500/70"></span>
                    </div>
                    <h2 class="mt-2 font-serif text-5xl font-bold text-tea-950 sm:text-6xl">
                        Top <span class="text-gold-500">Categories</span>
                    </h2>
                    <p class="mt-3 text-[11px] font-medium tracking-[0.3em] text-tea-900/60 text-center uppercase">
                        Premium teas for a healthier, happier you
                    </p>
                    <div class="mt-3 flex items-center justify-center gap-2">
                        <span class="h-px w-10 bg-gold-500/60"></span>
                        <!-- Sprig Leaf SVG -->
                        <svg viewBox="0 0 64 64" class="h-6 w-6" fill="none" aria-hidden="true">
                            <path d="M32 58C32 40 32 24 34 8" stroke="#2f6f37" stroke-width="2" stroke-linecap="round" />
                            <path d="M33 22c-9-1-15-7-16-16 9 1 15 7 16 16z" fill="#468a47" />
                            <path d="M34 36c9-1 15-7 16-16-9 1-15 7-16 16z" fill="#2f6f37" />
                            <path d="M32 50c-9-1-15-7-16-16 9 1 15 7 16 16z" fill="#6ba367" />
                        </svg>
                        <span class="h-px w-10 bg-gold-500/60"></span>
                    </div>
                </div>

                <!-- Arch cards (6 Categories) -->
                <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3 sm:gap-6 xl:grid-cols-6">
                    @php
                        $categoriesList = [
                            [
                                'name' => 'Fruit & Flower Tea',
                                'count' => 24,
                                'image' => asset('images/categories/cat-1.jpg'),
                                'tone' => 'pink',
                                'slug' => 'fruit-&-flower-(চা)',
                                'icon' => 'flower',
                            ],
                            [
                                'name' => 'Black Tea',
                                'count' => 18,
                                'image' => asset('images/categories/cat-2.jpg'),
                                'tone' => 'sand',
                                'slug' => 'black-tea(দুধ-চালাল-চা)',
                                'icon' => 'coffee',
                            ],
                            [
                                'name' => 'Green Tea',
                                'count' => 20,
                                'image' => asset('images/categories/cat-3.jpg'),
                                'tone' => 'sage',
                                'slug' => 'green-tea-(গ্রিন-টি-)',
                                'icon' => 'leaf',
                            ],
                            [
                                'name' => 'Roselle Tea',
                                'count' => 16,
                                'image' => asset('images/categories/cat-4.jpg'),
                                'tone' => 'rose',
                                'slug' => 'roselle-tea(চাশরবত)',
                                'icon' => 'flower',
                            ],
                            [
                                'name' => 'Masala',
                                'count' => 12,
                                'image' => asset('images/categories/cat-5.jpg'),
                                'tone' => 'ochre',
                                'slug' => 'masala(মসলা)',
                                'icon' => 'leaf',
                            ],
                            [
                                'name' => 'Tea Jar & Accessories',
                                'count' => 10,
                                'image' => asset('images/categories/cat-6.jpg'),
                                'tone' => 'olive',
                                'slug' => 'tea-jar-500ml-(সেল🔥)',
                                'icon' => 'coffee',
                            ],
                        ];
                    @endphp

                    <style>
                        .openai-category-item {
                            min-height: 255px;
                            min-width: 0;
                            position: relative;
                            display: flex;
                            align-items: center;
                            flex-direction: column;
                            padding: 6px 6px 12px;
                            border: 0;
                            border-radius: 110px 110px 42px 42px;
                            background: rgba(255, 255, 255, 0.76);
                            box-shadow: 0 9px 22px rgba(42, 45, 34, 0.075);
                            color: #1c2922;
                            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.28s cubic-bezier(0.16, 1, 0.3, 1);
                            text-decoration: none !important;
                        }

                        .openai-category-item:hover {
                            transform: translateY(-7px);
                            box-shadow: 0 15px 28px rgba(42, 64, 39, 0.16);
                            color: #173f2c;
                        }

                        .openai-category-photo {
                            width: 100%;
                            max-width: 160px;
                            aspect-ratio: 1 / 1;
                            border-radius: 50% !important;
                            padding: 4px;
                            border: 1px solid #d8d2c4;
                            background: #ffffff;
                            overflow: hidden;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin: 0 auto;
                            flex: none;
                        }

                        .openai-category-photo img {
                            width: 100% !important;
                            height: 100% !important;
                            border-radius: 50% !important;
                            object-fit: cover !important;
                            object-position: center !important;
                            display: block;
                            transition: transform 0.5s ease;
                        }

                        .openai-category-item:hover .openai-category-photo img {
                            transform: scale(1.08);
                        }

                        .openai-category-icon {
                            width: 38px;
                            height: 38px;
                            margin-top: -20px;
                            position: relative;
                            z-index: 2;
                            border-radius: 50%;
                            color: #fff;
                            display: grid;
                            place-items: center;
                            box-shadow: 0 3px 10px rgba(30, 40, 25, 0.18);
                            border: 2px solid #ffffff;
                        }

                        .openai-category-icon.pink { background: #edaaa8; }
                        .openai-category-icon.sand { background: #d9c49e; }
                        .openai-category-icon.sage { background: #879f7b; }
                        .openai-category-icon.rose { background: #c97878; }
                        .openai-category-icon.ochre { background: #d5ad65; }
                        .openai-category-icon.olive { background: #8c9c67; }

                        .openai-category-item strong {
                            font-family: var(--serif, "Playfair Display", Georgia, serif);
                            font-size: 15px;
                            font-weight: 700;
                            line-height: 1.15;
                            margin-top: 7px;
                            text-align: center;
                            color: #173528;
                            padding: 0 4px;
                        }

                        .openai-category-item small {
                            font-size: 11px;
                            color: #8c968c;
                            margin-top: 3px;
                            font-weight: 500;
                        }

                        .openai-category-arrow {
                            color: #c9c3b6;
                            margin-top: 6px;
                            width: 16px;
                            height: 16px;
                            transition: transform 0.2s, color 0.2s;
                        }

                        .openai-category-item:hover .openai-category-arrow {
                            transform: translateX(3px);
                            color: #d8b77c;
                        }
                    </style>

                    @foreach($categoriesList as $cat)
                        @php
                            $dbCategory = isset($frontcategory) ? $frontcategory->firstWhere('slug', $cat['slug']) : null;
                            $catUrl = $dbCategory ? route('category', $dbCategory->slug) : url('category/' . $cat['slug']);
                        @endphp
                        <a href="{{ $catUrl }}" class="group openai-category-item">
                            <div class="openai-category-photo">
                                <img src="{{ $cat['image'] }}" alt="{{ $cat['name'] }}" loading="lazy" />
                            </div>

                            <!-- Icon Badge -->
                            <span class="openai-category-icon {{ $cat['tone'] }}">
                                @if($cat['icon'] === 'coffee')
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 8h1a4 4 0 1 1 0 8h-1" />
                                        <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z" />
                                        <line x1="6" x2="6" y1="2" y2="4" />
                                        <line x1="10" x2="10" y1="2" y2="4" />
                                        <line x1="14" x2="14" y1="2" y2="4" />
                                    </svg>
                                @elseif($cat['icon'] === 'flower')
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3" />
                                        <path
                                            d="M12 16.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 1 1 12 7.5a4.5 4.5 0 1 1 4.5 4.5 4.5 4.5 0 1 1-4.5 4.5" />
                                        <path d="M12 7.5V9" />
                                        <path d="M7.5 12H9" />
                                        <path d="M16.5 12H15" />
                                        <path d="M12 16.5V15" />
                                    </svg>
                                @else
                                    <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z" />
                                        <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12" />
                                    </svg>
                                @endif
                            </span>

                            <strong>{{ $cat['name'] }}</strong>
                            <small>{{ $cat['count'] }} Products</small>
                            <svg class="openai-category-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </a>
                    @endforeach
                </div>

                <div class="mt-12 text-center">
                    <a href="{{ url('shop') }}"
                        class="group inline-flex items-center gap-2 rounded-full bg-tea-700 px-8 py-3.5 text-sm font-semibold text-white shadow-lg shadow-tea-900/25 transition-all hover:bg-tea-800">
                        View All Categories
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- ==========================================================================
                 SECTION 6: TEA STORIES & KNOWLEDGE BLOG (BlogSection.tsx)
                 ========================================================================== -->
        <section id="blog" class="relative overflow-hidden bg-white py-16 lg:py-20">
            <!-- Floating decorative leaves -->
            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute -left-8 top-1/3 h-28 w-28 rotate-[150deg] opacity-30 animate-float-slow"
                fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#blogLeafGrad1)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="blogLeafGrad1" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute -right-6 top-10 h-24 w-24 -rotate-12 opacity-30 animate-float"
                style="animation-delay: 2s;" fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#blogLeafGrad2)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="blogLeafGrad2" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <svg viewBox="0 0 64 64"
                class="pointer-events-none absolute right-[15%] bottom-6 h-14 w-14 rotate-[60deg] opacity-30 animate-float-slow"
                style="animation-delay: 1s;" fill="none" aria-hidden="true">
                <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#blogLeafGrad3)" />
                <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
                <defs>
                    <linearGradient id="blogLeafGrad3" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#2f6f37" />
                        <stop offset="1" stop-color="#6ba367" />
                    </linearGradient>
                </defs>
            </svg>

            <div class="relative mx-auto max-w-[1400px] px-4 sm:px-6">
                <!-- Header -->
                <div class="mb-10 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="relative">
                        <div class="flex items-center gap-3">
                            <span class="text-[10px] font-semibold tracking-[0.3em] text-tea-900/50 uppercase">From our
                                blog</span>
                            <span class="h-px w-16 bg-gold-500/60"></span>
                        </div>
                        <h2 class="mt-2 flex items-center gap-3 font-serif text-4xl font-bold text-tea-950 sm:text-5xl">
                            Tea Stories &amp; Knowledge
                            <!-- Sprig Leaf SVG -->
                            <svg viewBox="0 0 64 64" class="hidden h-10 w-10 rotate-45 sm:block" fill="none"
                                aria-hidden="true">
                                <path d="M32 58C32 40 32 24 34 8" stroke="#2f6f37" stroke-width="2"
                                    stroke-linecap="round" />
                                <path d="M33 22c-9-1-15-7-16-16 9 1 15 7 16 16z" fill="#468a47" />
                                <path d="M34 36c9-1 15-7 16-16-9 1-15 7-16 16z" fill="#2f6f37" />
                                <path d="M32 50c-9-1-15-7-16-16 9 1 15 7 16 16z" fill="#6ba367" />
                                <path d="M33 22l-9-9M34 36l9-9M32 50l-9-9" stroke="#e5efe2" stroke-width="1"
                                    stroke-linecap="round" />
                            </svg>
                        </h2>
                        <p class="mt-2 text-sm text-tea-900/70">
                            Discover health benefits, brewing tips, history and more about your favourite teas.
                        </p>
                    </div>

                    <div class="flex items-center gap-8">
                        <p class="hidden -rotate-6 font-script text-3xl leading-tight text-tea-900/30 lg:block">
                            Good Tea
                            <br />
                            Good Life
                        </p>
                        <a href="{{ url('blog-list') }}"
                            class="group inline-flex items-center gap-2 rounded-full bg-tea-700 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-tea-900/20 transition-colors hover:bg-tea-800">
                            View All Articles
                            <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Carousel -->
                <div class="relative">
                    <button type="button" onclick="scrollBlog(-1)" aria-label="Previous"
                        class="blog-nav-btn -left-3 lg:-left-5 top-1/2 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-tea-200 bg-white text-tea-800 shadow-xl transition-all hover:scale-105 hover:bg-tea-700 hover:text-white md:flex">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    <button type="button" onclick="scrollBlog(1)" aria-label="Next"
                        class="blog-nav-btn -right-3 lg:-right-5 top-1/2 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-tea-200 bg-white text-tea-800 shadow-xl transition-all hover:scale-105 hover:bg-tea-700 hover:text-white md:flex">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>

                    <style>
                        .blog-nav-btn {
                            z-index: 50 !important;
                            position: absolute !important;
                            box-shadow: 0 4px 14px rgba(10, 33, 27, 0.16) !important;
                        }

                        .blog-story-card {
                            border: 1px solid rgba(216, 183, 124, 0.32) !important;
                            box-shadow: 0 4px 20px rgba(10, 33, 27, 0.05) !important;
                            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease !important;
                        }

                        .blog-story-card:hover {
                            transform: translateY(-5px) !important;
                            border-color: rgba(216, 183, 124, 0.75) !important;
                            box-shadow: 0 14px 32px rgba(10, 33, 27, 0.09) !important;
                        }
                    </style>

                    <div id="blog-track"
                        class="no-scrollbar relative z-10 flex snap-x snap-mandatory gap-5 overflow-x-auto scroll-smooth py-6 px-1">
                        @php
                            $blogCategoryTags = ['HEALTH', 'LIFESTYLE', 'HISTORY', 'HEALTH', 'GUIDE'];
                            $blogItems = isset($blog) && $blog->count() > 0 ? $blog->take(5) : \App\Models\Blog::where('status', 1)->take(5)->get();
                        @endphp

                        @foreach($blogItems as $idx => $b)
                            @php
                                $tag = $blogCategoryTags[$idx % count($blogCategoryTags)];
                                $blogImgNum = ($idx % 5) + 1;
                                $blogImg = asset('images/blogs/blog-' . $blogImgNum . '.jpg');
                                $bTitle = !empty($b->b_title) ? $b->b_title : 'রোজেলা চায়ের স্বাস্থ্য উপকারিতা (Health Benefits of Hibiscus Roselle)';
                                $bExcerpt = !empty($b->b_short_des)
                                    ? Str::limit(strip_tags($b->b_short_des), 110)
                                    : (!empty($b->b_long_des)
                                        ? Str::limit(strip_tags($b->b_long_des), 110)
                                        : 'রোজেলা চা শুধু সুস্বাদু নয়, এটি স্বাস্থ্যের জন্যও অত্যন্ত উপকারী। এতে রয়েছে প্রাকৃতিক অ্যান্টিঅক্সিডেন্ট...');
                                $bDate = !empty($b->b_date) ? date('d M Y', strtotime($b->b_date)) : '12 Sep 2026';
                                $bUrl = url('blog-details/' . ($b->b_slug ?? $b->id));
                            @endphp

                            <article data-card
                                class="group blog-story-card flex w-[85%] shrink-0 snap-start flex-col overflow-hidden rounded-2xl bg-white sm:w-[calc(50%-10px)] lg:w-[calc(33.333%-14px)] xl:w-[calc(20%-16px)]">
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    <a href="{{ $bUrl }}" class="block h-full w-full">
                                        <img src="{{ $blogImg }}" alt="{{ $bTitle }}" loading="lazy"
                                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" />
                                    </a>
                                    <span
                                        class="absolute left-3 top-3 rounded-md bg-tea-700 px-2.5 py-1 text-[10px] font-bold tracking-wider text-white">
                                        {{ $tag }}
                                    </span>
                                </div>
                                <div class="flex flex-1 flex-col p-4">
                                    <h3
                                        class="font-bengali line-clamp-3 text-[14px] font-bold leading-snug text-tea-950 transition-colors group-hover:text-tea-700">
                                        <a href="{{ $bUrl }}">{{ $bTitle }}</a>
                                    </h3>
                                    <p class="font-bengali mt-2 line-clamp-4 text-[12.5px] leading-relaxed text-tea-900/70">
                                        {{ $bExcerpt }}
                                    </p>
                                    <div class="mt-auto flex items-center justify-between pt-4">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="flex h-7 w-7 items-center justify-center rounded-full bg-tea-100 text-tea-700">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                            </span>
                                            <span class="leading-tight">
                                                <span class="block text-[11.5px] font-semibold text-tea-950">Admin</span>
                                                <span class="text-[10px] text-tea-900/50">{{ $bDate }}</span>
                                            </span>
                                        </div>
                                        <a href="{{ $bUrl }}"
                                            class="inline-flex items-center gap-1 text-[12px] font-semibold text-tea-700 hover:text-tea-900">
                                            Read More
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M5 12h14" />
                                                <path d="m12 5 7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Countdown Timer and Carousel Scroll Scripts -->
    <script>
        // Flash Sale Countdown Timer
        (function () {
            function updateCountdown() {
                const now = new Date();
                const end = new Date(now);
                end.setHours(23, 59, 59, 999);
                const diff = Math.max(0, end.getTime() - now.getTime());
                const h = Math.floor(diff / 3600000);
                const m = Math.floor((diff % 3600000) / 60000);
                const s = Math.floor((diff % 60000) / 1000);

                const elH = document.getElementById('flash-hours');
                const elM = document.getElementById('flash-mins');
                const elS = document.getElementById('flash-secs');

                if (elH) elH.textContent = String(h).padStart(2, '0');
                if (elM) elM.textContent = String(m).padStart(2, '0');
                if (elS) elS.textContent = String(s).padStart(2, '0');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        })();

        // New Arrivals Carousel Scroll
        function scrollNewArrivals(dir) {
            const el = document.getElementById('new-arrivals-track');
            if (!el) return;
            const card = el.querySelector('[data-card]');
            const step = card ? card.offsetWidth + 16 : 280;
            el.scrollBy({ left: dir * step * 2, behavior: 'smooth' });
        }

        // Blog Carousel Scroll
        function scrollBlog(dir) {
            const el = document.getElementById('blog-track');
            if (!el) return;
            const card = el.querySelector('[data-card]');
            const step = card ? card.offsetWidth + 20 : 300;
            el.scrollBy({ left: dir * step, behavior: 'smooth' });
        }
    </script>
@endsection