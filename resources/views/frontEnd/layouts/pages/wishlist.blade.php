@extends('frontEnd.layouts.master')
@section('title', 'আমার উইশলিস্ট | My Wishlist')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY WISHLIST PAGE STYLES
       ======================================================== */
    .tea-wishlist-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.06) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-wishlist-container {
        max-width: 1180px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .tea-wishlist-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 24px;
    }
    .tea-wishlist-breadcrumb a {
        color: #173f2c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .tea-wishlist-breadcrumb a:hover {
        color: #cdb06a;
    }
    .tea-wishlist-breadcrumb i {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Header */
    .tea-wishlist-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tea-wishlist-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 28px;
        font-weight: 700;
        color: #0a211b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-wishlist-title i {
        color: #245a2d;
    }
    .tea-wishlist-count {
        font-size: 14px;
        font-weight: 600;
        color: #173f2c;
        background: #eaf4eb;
        border: 1px solid #c9dec4;
        padding: 5px 14px;
        border-radius: 20px;
    }

    /* Product Grid */
    .tea-wishlist-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
    }

    /* Product Card */
    .tea-wish-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 10px 28px -6px rgba(10, 33, 27, 0.05);
        overflow: hidden;
        transition: all 0.28s ease;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .tea-wish-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px -8px rgba(10, 33, 27, 0.12);
        border-color: #cdb06a;
    }

    /* Discount Badge */
    .tea-wish-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #b91c1c;
        color: #ffffff;
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 8px;
        z-index: 2;
        box-shadow: 0 2px 6px rgba(185, 28, 28, 0.25);
    }

    /* Image Wrapper */
    .tea-wish-img-wrap {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        background: #fbfbf9;
        display: block;
    }
    .tea-wish-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .tea-wish-card:hover .tea-wish-img {
        transform: scale(1.06);
    }

    /* Body */
    .tea-wish-body {
        padding: 18px 16px 14px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .tea-wish-prod-title {
        font-size: 14.5px;
        font-weight: 600;
        color: #0a211b;
        text-decoration: none;
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 40px;
        transition: color 0.2s ease;
    }
    .tea-wish-prod-title:hover {
        color: #245a2d;
    }

    .tea-wish-price-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 14px;
    }
    .tea-wish-cur-price {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: 700;
        color: #173f2c;
    }
    .tea-wish-old-price {
        font-size: 13.5px;
        color: #9ca3af;
        text-decoration: line-through;
    }

    /* Actions */
    .tea-wish-actions {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 8px;
        margin-top: auto;
    }
    .tea-btn-view-prod {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        height: 38px;
        background: linear-gradient(135deg, #173f2c 0%, #245a2d 100%);
        color: #ffffff;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-btn-view-prod:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        color: #ffffff;
    }
    .tea-btn-delete-wish {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 1px solid #fee2e2;
        background: #fff5f5;
        color: #dc2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .tea-btn-delete-wish:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
    }

    /* Empty State */
    .tea-wish-empty-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.08);
        padding: 60px 24px;
        text-align: center;
        max-width: 580px;
        margin: 40px auto;
    }
    .tea-wish-empty-emblem {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f4f8f2;
        border: 2px solid #e2cf9c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #173f2c;
        font-size: 34px;
        margin-bottom: 20px;
        box-shadow: 0 6px 18px rgba(23, 63, 44, 0.08);
    }
    .tea-wish-empty-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 10px;
    }
    .tea-wish-empty-subtitle {
        font-size: 14.5px;
        color: #6b7280;
        margin: 0 auto 28px;
        max-width: 420px;
        line-height: 1.6;
    }
    .tea-btn-explore-shop {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: linear-gradient(135deg, #173f2c 0%, #245a2d 100%);
        color: #ffffff;
        border-radius: 30px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 6px 16px rgba(23, 63, 44, 0.22);
        transition: all 0.25s ease;
    }
    .tea-btn-explore-shop:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        color: #ffffff;
        transform: translateY(-2px);
    }

    @media (max-width: 1199px) {
        .tea-wishlist-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 767px) {
        .tea-wishlist-page {
            padding: 20px 12px 60px;
        }
        .tea-wishlist-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .tea-wish-body {
            padding: 12px 10px;
        }
        .tea-wish-prod-title {
            font-size: 13px;
            height: 36px;
        }
        .tea-wish-cur-price {
            font-size: 16px;
        }
    }
</style>

<div class="tea-wishlist-page">
    <div class="tea-wishlist-container">
        <!-- Breadcrumb -->
        <div class="tea-wishlist-breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>আমার উইশলিস্ট</span>
        </div>

        @php
            $wishlistItems = Cart::instance('wishlist')->content();
            $wishlistCount = Cart::instance('wishlist')->count();
        @endphp

        @if($wishlistCount == 0)
            <!-- Empty Wishlist -->
            <div class="tea-wish-empty-card">
                <div class="tea-wish-empty-emblem">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h2 class="tea-wish-empty-title">আপনার উইশলিস্ট খালি রয়েছে</h2>
                <p class="tea-wish-empty-subtitle">
                    পছন্দের চা পাতা সংরক্ষণ করতে আমাদের শপ ব্রাউজ করুন এবং পছন্দের পণ্যে হার্ট (Wishlist) আইকনে ক্লিক করুন।
                </p>
                <a href="{{ route('shop') }}" class="tea-btn-explore-shop">
                    <i class="fa-solid fa-leaf"></i>
                    <span>চা শপ ঘুরে দেখুন</span>
                </a>
            </div>
        @else
            <!-- Header -->
            <div class="tea-wishlist-header">
                <h1 class="tea-wishlist-title">
                    <i class="fa-solid fa-heart"></i> সংরক্ষিত পছন্দের পণ্যসমূহ
                </h1>
                <span class="tea-wishlist-count">
                    {{ $wishlistCount }}টি পণ্য সংরক্ষিত
                </span>
            </div>

            <!-- Grid -->
            <div class="tea-wishlist-grid">
                @foreach ($wishlistItems as $key => $value)
                    @php
                        $hasDiscount = !empty($value->old_price) && $value->old_price > $value->price;
                        $discountPercent = $hasDiscount ? round((($value->old_price - $value->price) * 100) / $value->old_price) : 0;
                    @endphp
                    <div class="tea-wish-card" id="item{{ $value->rowId }}">
                        @if ($hasDiscount)
                            <span class="tea-wish-badge">{{ $discountPercent }}% ছাড়</span>
                        @endif

                        <a href="{{ route('product', $value->options->slug ?? '') }}" class="tea-wish-img-wrap">
                            <img src="{{ asset($value->options->image ?? '') }}" alt="{{ $value->name }}" class="tea-wish-img" onerror="this.src='{{ asset('public/uploads/settings/1740644407-onekkisu.webp') }}'" />
                        </a>

                        <div class="tea-wish-body">
                            <a href="{{ route('product', $value->options->slug ?? '') }}" class="tea-wish-prod-title">
                                {{ $value->name }}
                            </a>

                            <div class="tea-wish-price-row">
                                <span class="tea-wish-cur-price">৳{{ number_format($value->price) }}</span>
                                @if($hasDiscount)
                                    <span class="tea-wish-old-price">৳{{ number_format($value->old_price) }}</span>
                                @endif
                            </div>

                            <div class="tea-wish-actions">
                                <a href="{{ route('product', $value->options->slug ?? '') }}" class="tea-btn-view-prod">
                                    <i class="fa-solid fa-eye"></i> বিস্তারিত
                                </a>
                                <button type="button" 
                                        onclick="remove_wishlist('{{ $value->rowId }}')" 
                                        class="tea-btn-delete-wish" 
                                        title="উইশলিস্ট থেকে মুছুন">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
