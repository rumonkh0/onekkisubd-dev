@extends('frontEnd.layouts.master')
@section('title', 'অনুসন্ধান: ' . $keyword . ' | Search Results')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY SEARCH RESULTS PAGE STYLES
       ======================================================== */
    .tea-search-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.05) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-search-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .tea-search-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 20px;
    }
    .tea-search-breadcrumb a {
        color: #173f2c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .tea-search-breadcrumb a:hover {
        color: #cdb06a;
    }
    .tea-search-breadcrumb i {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Search Banner Header */
    .tea-search-hero {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 10px 28px -6px rgba(10, 33, 27, 0.04);
        padding: 24px 28px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .tea-search-hero-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .tea-search-heading {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-search-heading i {
        color: #cdb06a;
    }
    .tea-search-keyword-badge {
        color: #173f2c;
        background: #f4f8f2;
        border: 1px solid #c9dec4;
        padding: 2px 12px;
        border-radius: 12px;
        font-size: 20px;
    }
    .tea-search-count-text {
        font-size: 13.5px;
        color: #6b7280;
    }

    /* Sort Control */
    .tea-search-sort-box {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-sort-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #4b5563;
        white-space: nowrap;
    }
    .tea-sort-select {
        height: 42px;
        padding: 0 32px 0 14px;
        border: 1.5px solid #e5e7eb;
        border-radius: 20px;
        background: #ffffff;
        font-size: 13.5px;
        font-weight: 500;
        color: #111827;
        outline: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .tea-sort-select:focus {
        border-color: #245a2d;
        box-shadow: 0 0 0 3px rgba(36, 90, 45, 0.1);
    }

    /* Product Grid */
    .tea-search-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
        margin-bottom: 36px;
    }

    /* Product Card */
    .tea-prod-card {
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
    .tea-prod-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px -8px rgba(10, 33, 27, 0.12);
        border-color: #cdb06a;
    }
    .tea-prod-badge {
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
    .tea-prod-img-wrap {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        background: #fbfbf9;
        display: block;
    }
    .tea-prod-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .tea-prod-card:hover .tea-prod-img {
        transform: scale(1.06);
    }

    .tea-prod-body {
        padding: 18px 16px 14px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .tea-prod-title-link {
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
    .tea-prod-title-link:hover {
        color: #245a2d;
    }
    .tea-prod-price-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 14px;
    }
    .tea-prod-cur-price {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: 700;
        color: #173f2c;
    }
    .tea-prod-old-price {
        font-size: 13.5px;
        color: #9ca3af;
        text-decoration: line-through;
    }

    .tea-prod-actions-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-top: auto;
    }
    .tea-btn-card-cart {
        height: 38px;
        background: #f4f6f3;
        color: #173f2c;
        border: 1px solid #c9dec4;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .tea-btn-card-cart:hover {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
    }
    .tea-btn-card-buy {
        height: 38px;
        background: linear-gradient(135deg, #173f2c 0%, #245a2d 100%);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(23, 63, 44, 0.2);
    }
    .tea-btn-card-buy:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        color: #ffffff;
        transform: translateY(-1px);
    }

    /* Empty Search State */
    .tea-search-empty-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.08);
        padding: 60px 24px;
        text-align: center;
        max-width: 600px;
        margin: 30px auto;
    }
    .tea-search-empty-emblem {
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
    .tea-search-empty-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 10px;
    }
    .tea-search-empty-subtitle {
        font-size: 14.5px;
        color: #6b7280;
        margin: 0 auto 24px;
        max-width: 440px;
        line-height: 1.6;
    }
    .tea-popular-terms {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }
    .tea-term-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 14px;
        background: #f4f6f3;
        border: 1px solid #e8e4dc;
        border-radius: 20px;
        color: #173f2c;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-term-pill:hover {
        background: #173f2c;
        color: #ffffff;
    }
    .tea-btn-browse-all {
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
    .tea-btn-browse-all:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Pagination */
    .tea-pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .tea-pagination-wrap .pagination {
        display: flex;
        gap: 6px;
    }
    .tea-pagination-wrap .page-item .page-link {
        border-radius: 10px;
        border: 1px solid #e8e4dc;
        color: #173f2c;
        padding: 8px 14px;
        font-weight: 600;
    }
    .tea-pagination-wrap .page-item.active .page-link {
        background: #173f2c;
        border-color: #173f2c;
        color: #ffffff;
    }

    @media (max-width: 1199px) {
        .tea-search-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 767px) {
        .tea-search-page {
            padding: 20px 12px 60px;
        }
        .tea-search-hero {
            padding: 18px 16px;
            flex-direction: column;
            align-items: flex-start;
        }
        .tea-search-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .tea-prod-body {
            padding: 12px 10px;
        }
        .tea-prod-title-link {
            font-size: 13px;
            height: 36px;
        }
        .tea-prod-cur-price {
            font-size: 16px;
        }
    }
</style>

<div class="tea-search-page">
    <div class="tea-search-container">
        <!-- Breadcrumb -->
        <div class="tea-search-breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('shop') }}">শপ</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>অনুসন্ধান ফলাফল</span>
        </div>

        @if($products->count() == 0)
            <!-- Empty Search State -->
            <div class="tea-search-empty-card">
                <div class="tea-search-empty-emblem">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h2 class="tea-search-empty-title">কোনো পণ্য খুঁজে পাওয়া যায়নি</h2>
                <p class="tea-search-empty-subtitle">
                    "<strong>{{ $keyword }}</strong>" সম্পর্কিত কোনো চা পণ্য পাওয়া যায়নি। অন্য কোনো নাম দিয়ে অনুসন্ধান করুন অথবা নিচের জনপ্রিয় ক্যাটাগরিগুলো দেখুন।
                </p>
                
                <div class="tea-popular-terms">
                    <span style="font-size: 13px; color: #6b7280; font-weight: 500;">জনপ্রিয় অনুসন্ধান:</span>
                    <a href="{{ route('search', ['keyword' => 'Black Tea']) }}" class="tea-term-pill">ব্ল্যাক টি</a>
                    <a href="{{ route('search', ['keyword' => 'Green Tea']) }}" class="tea-term-pill">গ্রিন টি</a>
                    <a href="{{ route('search', ['keyword' => 'হ্যান্ড মেড']) }}" class="tea-term-pill">হ্যান্ডমেড চা</a>
                    <a href="{{ route('search', ['keyword' => 'দুধ চা']) }}" class="tea-term-pill">দুধ চা</a>
                </div>

                <a href="{{ route('shop') }}" class="tea-btn-browse-all">
                    <i class="fa-solid fa-leaf"></i> সকল চা পণ্য দেখুন
                </a>
            </div>
        @else
            <!-- Search Hero Banner -->
            <div class="tea-search-hero">
                <div class="tea-search-hero-left">
                    <h1 class="tea-search-heading">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>অনুসন্ধান:</span>
                        <span class="tea-search-keyword-badge">{{ $keyword }}</span>
                    </h1>
                    <span class="tea-search-count-text">
                        মোট {{ $products->total() }}টি ফলাফল পাওয়া গেছে (দেখাচ্ছে {{ $products->firstItem() }}-{{ $products->lastItem() }})
                    </span>
                </div>

                <!-- Sort Control -->
                <div class="tea-search-sort-box">
                    <span class="tea-sort-label"><i class="fa-solid fa-arrow-down-short-wide"></i> সাজান:</span>
                    <form action="" class="sort-form m-0" id="search_sort_form">
                        <select name="sort" class="tea-sort-select sort" onchange="document.getElementById('search_sort_form').submit()">
                            <option value="1" @if (request()->get('sort') == 1) selected @endif>সর্বশেষ পণ্য (Latest)</option>
                            <option value="2" @if (request()->get('sort') == 2) selected @endif>পুরাতন পণ্য (Oldest)</option>
                            <option value="3" @if (request()->get('sort') == 3) selected @endif>মূল্য: বেশি থেকে কম</option>
                            <option value="4" @if (request()->get('sort') == 4) selected @endif>মূল্য: কম থেকে বেশি</option>
                            <option value="5" @if (request()->get('sort') == 5) selected @endif>নাম: A - Z</option>
                            <option value="6" @if (request()->get('sort') == 6) selected @endif>নাম: Z - A</option>
                        </select>
                        <input type="hidden" name="keyword" value="{{ $keyword }}" />
                    </form>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="tea-search-grid">
                @foreach ($products as $key => $value)
                    @php
                        $hasDiscount = !empty($value->old_price) && $value->old_price > $value->new_price;
                        $discountPercent = $hasDiscount ? round((($value->old_price - $value->new_price) * 100) / $value->old_price) : 0;
                        $hasVariants = !$value->prosizes->isEmpty() || !$value->procolors->isEmpty();
                    @endphp
                    <div class="tea-prod-card">
                        @if ($hasDiscount)
                            <span class="tea-prod-badge">{{ $discountPercent }}% ছাড়</span>
                        @endif

                        <a href="{{ route('product', $value->slug) }}" class="tea-prod-img-wrap">
                            <img src="{{ asset($value->image ? $value->image->image : '') }}" 
                                 alt="{{ $value->name }}" 
                                 class="tea-prod-img" 
                                 onerror="this.src='{{ asset('public/uploads/settings/1740644407-onekkisu.webp') }}'" />
                        </a>

                        <div class="tea-prod-body">
                            <a href="{{ route('product', $value->slug) }}" class="tea-prod-title-link">
                                {{ $value->name }}
                            </a>

                            <div class="tea-prod-price-row">
                                <span class="tea-prod-cur-price">৳{{ number_format($value->new_price) }}</span>
                                @if($hasDiscount)
                                    <span class="tea-prod-old-price">৳{{ number_format($value->old_price) }}</span>
                                @endif
                            </div>

                            <div class="tea-prod-actions-row">
                                @if ($hasVariants)
                                    <a href="{{ route('product', $value->slug) }}" class="tea-btn-card-cart">
                                        <i class="fa-solid fa-cart-shopping"></i> কার্ট
                                    </a>
                                    <a href="{{ route('product', $value->slug) }}" class="tea-btn-card-buy">
                                        <i class="fa-solid fa-bolt"></i> অর্ডার
                                    </a>
                                @else
                                    <button type="button" data-id="{{ $value->id }}" class="tea-btn-card-cart addcartbutton">
                                        <i class="fa-solid fa-cart-shopping"></i> কার্ট
                                    </button>
                                    <form action="{{ route('cart.store') }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $value->id }}" />
                                        <input type="hidden" name="qty" value="1" />
                                        <button type="submit" class="tea-btn-card-buy w-100">
                                            <i class="fa-solid fa-bolt"></i> অর্ডার
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="tea-pagination-wrap">
                {{ $products->appends(['keyword' => $keyword, 'sort' => request()->get('sort')])->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
</div>
@endsection
