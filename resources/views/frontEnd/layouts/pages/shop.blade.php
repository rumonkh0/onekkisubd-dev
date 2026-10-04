@extends('frontEnd.layouts.master')
@section('title', 'আমাদের চা সম্ভার (All Tea Collections) - অনেককিছু')

@push('seo')
    <meta name="app-url" content="{{ route('shop') }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="অনেককিছু এর এক্সক্লুসিভ প্রিমিয়াম চা কালেকশন - ব্ল্যাক টি, গ্রিন টি, পাহাড়ি রোজেলা, ফ্রুট অ্যান্ড ফ্লাওয়ার টি।" />
    <meta name="keywords" content="tea, black tea, green tea, herbal tea, roselle tea, flower tea, bangladesh tea" />

    <!-- Open Graph data -->
    <meta property="og:title" content="আমাদের চা সম্ভার - অনেককিছু" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('shop') }}" />
    <meta property="og:image" content="{{ asset($generalsetting->white_logo ?? '') }}" />
    <meta property="og:description" content="বাছাইকৃত সেরা মানের প্রিমিয়াম চা ও ব্লেন্ডস" />
@endpush

@push('css')
<style>
    :root {
        --tea-dark: #0a211b;
        --tea-green: #173f2c;
        --tea-light-green: #245a2d;
        --tea-accent: #2e7d32;
        --tea-gold: #cdb06a;
        --tea-light-gold: #e2cf9c;
        --tea-cream: #faf8f5;
        --tea-surface: #ffffff;
        --tea-border: #e8e4dc;
        --font-serif: 'Playfair Display', 'Hind Siliguri', Georgia, serif;
        --font-sans: 'Poppins', 'Hind Siliguri', sans-serif;
    }

    html {
        scroll-behavior: smooth;
    }

    #content {
        width: 100%;
        padding-top: 0 !important;
        background: #fbf9f5;
    }

    .tea-shop-page {
        font-family: var(--font-sans);
        color: #1f2937;
        padding-bottom: 70px;
    }

    /* Hero Banner */
    .tea-shop-hero {
        background: linear-gradient(135deg, #0a211b 0%, #173f2c 60%, #245a2d 100%);
        color: #ffffff;
        padding: 50px 0 44px;
        position: relative;
        overflow: hidden;
        margin-bottom: 36px;
        box-shadow: 0 12px 36px rgba(10, 33, 27, 0.16);
    }
    .tea-shop-hero::before {
        content: '';
        position: absolute;
        top: -80px;
        right: -80px;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(205, 176, 106, 0.24) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .tea-shop-hero::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 10%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.06) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .tea-shop-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #d1fae5;
        margin-bottom: 14px;
    }
    .tea-shop-breadcrumb a {
        color: #e2cf9c;
        text-decoration: none;
        transition: color 0.2s;
    }
    .tea-shop-breadcrumb a:hover {
        color: #ffffff;
        text-decoration: underline;
    }
    .tea-shop-breadcrumb span.sep {
        color: rgba(226, 207, 156, 0.6);
        font-size: 11px;
    }
    .tea-shop-breadcrumb span.active {
        color: #ffffff;
        font-weight: 600;
    }

    .tea-shop-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(205, 176, 106, 0.2);
        border: 1px solid rgba(205, 176, 106, 0.45);
        color: var(--tea-light-gold);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 5px 14px;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .tea-shop-title {
        font-family: var(--font-serif);
        font-size: 36px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 10px 0;
        letter-spacing: -0.3px;
    }
    .tea-shop-subtitle {
        font-size: 15px;
        color: #d1fae5;
        max-width: 620px;
        margin: 0 0 24px 0;
        line-height: 1.6;
    }

    /* Jump Pills Bar */
    .tea-jump-nav {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow-x: auto;
        padding: 8px 4px 12px;
        scrollbar-width: none;
    }
    .tea-jump-nav::-webkit-scrollbar {
        display: none;
    }
    .tea-jump-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.22);
        color: #ffffff;
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
    }
    .tea-jump-chip:hover {
        background: rgba(205, 176, 106, 0.3);
        color: #ffffff;
        border-color: var(--tea-gold);
    }
    .tea-jump-chip.active {
        background: var(--tea-gold) !important;
        color: var(--tea-dark) !important;
        border-color: var(--tea-gold) !important;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.16);
    }

    /* Category Section */
    .tea-category-section {
        margin-bottom: 44px;
        scroll-margin-top: 110px;
    }
    .tea-section-header-card {
        background: #ffffff;
        border: 1.5px solid var(--tea-border);
        border-radius: 16px;
        padding: 16px 22px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        box-shadow: 0 4px 16px rgba(10, 33, 27, 0.03);
    }
    .tea-section-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .tea-section-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #f4f8f2;
        color: var(--tea-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .tea-section-title-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .tea-section-text {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }
    .tea-section-title-wrap h3 {
        margin: 0;
        font-family: var(--font-serif);
        font-size: 21px;
        font-weight: 700;
        color: var(--tea-dark);
        line-height: 1.35;
    }
    .tea-section-count-badge {
        display: inline-flex;
        align-items: center;
        width: fit-content;
        font-size: 11.5px;
        font-weight: 600;
        background: #faf8f5;
        color: #4b5563;
        padding: 3px 10px;
        border-radius: 12px;
        border: 1px solid var(--tea-border);
    }

    .tea-view-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--tea-green);
        text-decoration: none;
        padding: 6px 14px;
        border-radius: 10px;
        background: #f4f8f2;
        border: 1px solid #c9dec4;
        transition: all 0.2s ease;
    }
    .tea-view-all-btn:hover {
        background: var(--tea-green);
        color: #ffffff;
        border-color: var(--tea-green);
        transform: translateX(3px);
    }

    /* Product Grid */
    .tea-shop-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .tea-product-card {
        background: #ffffff;
        border: 1.5px solid var(--tea-border);
        border-radius: 18px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s, border-color 0.25s;
        position: relative;
    }
    .tea-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(10, 33, 27, 0.08);
        border-color: rgba(205, 176, 106, 0.55);
    }

    .tea-card-image-wrap {
        position: relative;
        aspect-ratio: 1 / 1;
        background: #faf8f5;
        overflow: hidden;
        padding: 12px;
    }
    .tea-card-image-wrap a {
        display: block;
        width: 100%;
        height: 100%;
    }
    .tea-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
        transition: transform 0.4s ease;
    }
    .tea-product-card:hover .tea-card-img {
        transform: scale(1.05);
    }

    .tea-card-discount-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
        background: #dc2626;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.3);
    }
    .tea-card-brand-chip {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(4px);
        color: var(--tea-green);
        font-size: 10.5px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 20px;
        border: 1px solid rgba(23, 63, 44, 0.12);
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .tea-card-brand-chip i {
        color: var(--tea-gold);
        font-size: 10px;
    }

    .tea-card-body {
        padding: 16px 14px 14px;
        display: flex;
        flex-direction: column;
        flex: 1;
        text-align: center;
    }

    .tea-card-title {
        font-family: var(--font-serif);
        font-size: 14.5px;
        font-weight: 700;
        line-height: 1.35;
        color: var(--tea-dark);
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 38px;
        margin-bottom: 4px;
        transition: color 0.2s;
    }
    .tea-card-title:hover {
        color: var(--tea-green);
    }
    .tea-card-bn-subtitle {
        font-size: 12px;
        color: #4b5563;
        margin: 0 0 10px 0;
        font-family: 'Hind Siliguri', sans-serif;
        text-align: center;
        width: 100%;
    }

    .tea-card-price-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: auto;
        margin-bottom: 12px;
    }
    .tea-card-old-price {
        font-size: 12.5px;
        color: #9ca3af;
        text-decoration: line-through;
    }
    .tea-card-new-price {
        font-size: 16px;
        font-weight: 800;
        color: var(--tea-green);
    }

    /* Actions */
    .tea-card-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-btn-addcart {
        flex: 1;
        background: var(--tea-green);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        padding: 9px 10px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.2s, transform 0.15s;
    }
    .tea-btn-addcart:hover {
        background: var(--tea-dark);
        transform: translateY(-1px);
    }
    .tea-btn-wishlist {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1.5px solid var(--tea-border);
        background: #ffffff;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
    }
    .tea-btn-wishlist:hover {
        border-color: #f87171;
        color: #ef4444;
        background: #fef2f2;
    }

    .tea-btn-buynow {
        width: 100%;
        margin-top: 8px;
        background: #faf8f5;
        color: var(--tea-dark) !important;
        border: 1.5px solid var(--tea-border);
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 12.5px;
        font-weight: 700;
        text-decoration: none;
        text-align: center;
        display: block;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tea-btn-buynow:hover {
        background: var(--tea-gold);
        border-color: var(--tea-gold);
        color: var(--tea-dark) !important;
    }

    /* Trust Strip */
    .tea-shop-trust-strip {
        background: linear-gradient(135deg, #0a211b 0%, #173f2c 100%);
        border-radius: 20px;
        padding: 32px 24px;
        color: #ffffff;
        margin-top: 50px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        text-align: center;
    }
    .tea-trust-feature {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    .tea-trust-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(226, 207, 156, 0.16);
        border: 1.5px solid rgba(226, 207, 156, 0.4);
        color: var(--tea-light-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .tea-trust-feature h6 {
        margin: 0;
        font-family: var(--font-serif);
        font-size: 15px;
        font-weight: 700;
        color: #ffffff;
    }
    .tea-trust-feature p {
        margin: 0;
        font-size: 12.5px;
        color: #d1fae5;
    }

    /* Responsive */
    @media (max-width: 1199px) {
        .tea-shop-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 991px) {
        .tea-category-section {
            scroll-margin-top: 90px;
        }
        .tea-shop-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .tea-shop-trust-strip {
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
    }
    @media (max-width: 576px) {
        .tea-category-section {
            scroll-margin-top: 85px;
        }
        .tea-shop-hero {
            padding: 32px 0 28px;
        }
        .tea-shop-title {
            font-size: 26px;
        }
        .tea-shop-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .tea-card-image-wrap {
            padding: 8px;
        }
        .tea-card-body {
            padding: 10px 8px 10px;
        }
        .tea-card-title {
            font-size: 13px;
            min-height: 34px;
        }
        .tea-card-price-row {
            margin-bottom: 8px;
        }
        .tea-card-new-price {
            font-size: 14.5px;
        }
        .tea-btn-addcart {
            font-size: 11.5px;
            padding: 7px 6px;
        }
        .tea-btn-wishlist {
            width: 32px;
            height: 32px;
        }
        .tea-btn-buynow {
            font-size: 11.5px;
            padding: 6px;
        }
        .tea-shop-trust-strip {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="tea-shop-page">

    <!-- Top Hero Banner -->
    <section class="tea-shop-hero">
        <div class="container">
            <div class="tea-shop-breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> হোম</a>
                <span class="sep">/</span>
                <span class="active">চা সম্ভার (Shop)</span>
            </div>

            <div class="tea-shop-hero-badge">
                <i class="fa-solid fa-leaf"></i> এক্সক্লুসিভ কালেকশন
            </div>

            <h1 class="tea-shop-title">আমাদের বিশেষ চা সম্ভার</h1>
            <p class="tea-shop-subtitle">
                প্রাকৃতিক বাগান থেকে সরাসরি সংগ্রহকৃত সেরা চা পাতা ও ভেষজ ব্লেন্ডস। প্রতিটি কাপে উপভোগ করুন খাঁটি ও সতেজ স্বাদ।
            </p>

            <!-- Jump Nav to Categories -->
            <div class="tea-jump-nav">
                @foreach ($homeproducts as $homecat)
                    @if (count($homecat->products) > 0)
                        <a href="#category-{{ $homecat->id }}" class="tea-jump-chip">
                            <i class="fa-solid fa-mug-saucer"></i>
                            <span>{{ preg_replace('/(?<=\S)\(/u', ' (', $homecat->name) }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Main Container: Categories & Products -->
    <div class="container">
        @foreach ($homeproducts as $homecat)
            @if (count($homecat->products) > 0)
                <section class="tea-category-section" id="category-{{ $homecat->id }}">
                    <!-- Section Header Card -->
                    <div class="tea-section-header-card">
                        <div class="tea-section-title-wrap">
                            <div class="tea-section-icon">
                                <i class="fa-solid fa-leaf"></i>
                            </div>
                            <div class="tea-section-text">
                                <h3>{{ preg_replace('/(?<=\S)\(/u', ' (', $homecat->name) }}</h3>
                                <span class="tea-section-count-badge">{{ count($homecat->products) }}টি পণ্য প্রদর্শিত হচ্ছে</span>
                            </div>
                        </div>

                        <a href="{{ route('category', $homecat->slug) }}" class="tea-view-all-btn">
                            <span>সবগুলো দেখুন (View All)</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Products Grid -->
                    <div class="tea-shop-grid">
                        @foreach ($homecat->products as $key => $value)
                            @php
                                $rawName = $value->name;
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

                                $hasDiscount = !empty($value->old_price) && $value->old_price > $value->new_price;
                                $discountPct = $hasDiscount ? round((($value->old_price - $value->new_price) * 100) / $value->old_price) : 0;
                                $prodImage = $value->image ? asset($value->image->image) : asset('public/uploads/default.png');
                                $isOutOfStock = isset($value->stock) && $value->stock <= 0;
                            @endphp

                            <article class="tea-product-card">
                                <!-- Image Container -->
                                <div class="tea-card-image-wrap">
                                    @if ($hasDiscount)
                                        <span class="tea-card-discount-badge">-{{ $discountPct }}% ছাড়</span>
                                    @endif

                                    <span class="tea-card-brand-chip">
                                        <i class="fa-solid fa-leaf"></i> অনেককিছু
                                    </span>

                                    <a href="{{ route('product', $value->slug) }}">
                                        <img src="{{ $prodImage }}" alt="{{ $engName }}" class="tea-card-img" loading="lazy" />
                                    </a>
                                </div>

                                <!-- Body -->
                                <div class="tea-card-body">
                                    <a href="{{ route('product', $value->slug) }}" class="tea-card-title" title="{{ $engName }}">
                                        {{ $engName }}
                                    </a>

                                    @if ($bnName)
                                        <p class="tea-card-bn-subtitle text-center">{{ $bnName }}</p>
                                    @endif

                                    <!-- Price -->
                                    <div class="tea-card-price-row">
                                        @if ($hasDiscount)
                                            <span class="tea-card-old-price">৳ {{ number_format($value->old_price) }}</span>
                                        @endif
                                        <span class="tea-card-new-price">৳ {{ number_format($value->new_price) }}</span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="tea-card-actions">
                                        <button type="button" class="cart_store tea-btn-addcart" data-id="{{ $value->id }}" {{ $isOutOfStock ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-cart-plus"></i>
                                            <span>কার্ট</span>
                                        </button>

                                        <button type="button" class="tea-btn-wishlist" onclick="addTowishlist('{{ $value->id }}')" title="Add to Wishlist">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </div>

                                    <!-- Buy Now CTA -->
                                    @if (!$value->prosizes->isEmpty() || !$value->procolors->isEmpty())
                                        <a href="{{ route('product', $value->slug) }}" class="tea-btn-buynow">
                                            এখনই অর্ডার করুন
                                        </a>
                                    @else
                                        <form action="{{ route('cart.store') }}" method="POST" class="m-0 p-0 w-100">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $value->id }}" />
                                            <input type="hidden" name="qty" value="1" />
                                            <button type="submit" class="tea-btn-buynow" {{ $isOutOfStock ? 'disabled' : '' }}>
                                                এখনই অর্ডার করুন
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach

        <!-- Trust Strip -->
        <div class="tea-shop-trust-strip">
            <div class="tea-trust-feature">
                <div class="tea-trust-icon">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <h6>১০০% খাঁটি ও প্রাকৃতিক</h6>
                <p>কোনো প্রকার কৃত্রিম ফ্লেভার বা কেমিক্যাল ছাড়া</p>
            </div>

            <div class="tea-trust-feature">
                <div class="tea-trust-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h6>সারাদেশে হোম ডেলিভারি</h6>
                <p>খুব দ্রুততম সময়ে আপনার ঠিকানায় পৌঁছাবে</p>
            </div>

            <div class="tea-trust-feature">
                <div class="tea-trust-icon">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <h6>ক্যাশ অন ডেলিভারি</h6>
                <p>পণ্য হাতে পেয়ে দেখে মূল্য পরিশোধ করুন</p>
            </div>

            <div class="tea-trust-feature">
                <div class="tea-trust-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h6>সহজ গ্রাহক সেবা</h6>
                <p>যেকোনো প্রয়োজনে আমাদের সাপোর্ট সবসময় প্রস্তুত</p>
            </div>
        </div>

    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Smooth scroll with dynamic header offset calculation
        $('.tea-jump-chip').on('click', function(e) {
            var targetId = $(this).attr('href');
            if (targetId && targetId.startsWith('#')) {
                var $target = $(targetId);
                if ($target.length) {
                    e.preventDefault();

                    var headerEl = document.getElementById('claude-header') || document.querySelector('header');
                    var headerHeight = headerEl ? headerEl.offsetHeight : 80;
                    var extraGap = 20; // 20px comfortable clearance
                    var targetOffset = $target.offset().top - (headerHeight + extraGap);

                    $('html, body').stop().animate({
                        scrollTop: Math.max(0, targetOffset)
                    }, 450);

                    // Update active state visual
                    $('.tea-jump-chip').removeClass('active');
                    $(this).addClass('active');

                    // Update URL hash cleanly
                    if (history.pushState) {
                        history.pushState(null, null, targetId);
                    }
                }
            }
        });

        // ScrollSpy to highlight chips as user scrolls
        var sections = $('.tea-category-section');
        if (sections.length) {
            $(window).on('scroll', function() {
                var scrollPos = $(window).scrollTop() + 140;
                sections.each(function() {
                    var top = $(this).offset().top;
                    var bottom = top + $(this).outerHeight();
                    var id = $(this).attr('id');
                    if (scrollPos >= top && scrollPos < bottom) {
                        $('.tea-jump-chip').removeClass('active');
                        $('.tea-jump-chip[href="#' + id + '"]').addClass('active');
                    }
                });
            });
        }
    });
</script>
@endpush
