@extends('frontEnd.layouts.master')
@section('title', 'স্পেশাল অফার ও ভাউচার | Special Offers & Discounts')

@section('content')
<style>
    /* ========================================================
       LUXURY DARK TEA SPECIAL OFFERS & COUPONS PAGE
       ======================================================== */
    .tea-offers-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.06) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-offers-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .tea-offers-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 22px;
    }
    .tea-offers-breadcrumb a {
        color: #173f2c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .tea-offers-breadcrumb a:hover {
        color: #cdb06a;
    }
    .tea-offers-breadcrumb i {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Hero Banner */
    .tea-offers-hero {
        background: linear-gradient(135deg, #0a211b 0%, #173f2c 60%, #1a4a32 100%);
        border-radius: 24px;
        padding: 40px 36px;
        margin-bottom: 32px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(205, 176, 106, 0.35);
        box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.25);
    }
    .tea-offers-hero::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, rgba(205, 176, 106, 0.2) 0%, rgba(205, 176, 106, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .tea-offers-hero-inner {
        position: relative;
        z-index: 2;
        max-width: 680px;
    }
    .tea-offers-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(205, 176, 106, 0.16);
        border: 1px solid rgba(205, 176, 106, 0.45);
        color: #e2cf9c;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 14px;
    }
    .tea-offers-pill i {
        color: #cdb06a;
    }
    .tea-offers-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 32px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 10px 0;
        line-height: 1.25;
    }
    .tea-offers-subtitle {
        font-size: 15px;
        color: #d1d5db;
        margin: 0;
        line-height: 1.6;
    }

    /* Coupon Vouchers Grid */
    .tea-coupons-section {
        margin-bottom: 36px;
    }
    .tea-section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
    }
    .tea-section-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 20px;
        font-weight: 700;
        color: #0a211b;
        margin: 0;
    }
    .tea-section-title i {
        color: #cdb06a;
    }

    .tea-coupons-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
    }
    .tea-coupon-card {
        background: #ffffff;
        border-radius: 18px;
        border: 2px dashed #cdb06a;
        padding: 20px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 6px 20px -4px rgba(10, 33, 27, 0.05);
        transition: all 0.25s ease;
    }
    .tea-coupon-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px -6px rgba(10, 33, 27, 0.1);
        border-color: #173f2c;
    }
    .tea-coupon-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }
    .tea-coupon-amount {
        font-size: 22px;
        font-weight: 800;
        color: #173f2c;
    }
    .tea-coupon-tag {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        background: #f4f8f2;
        color: #173f2c;
        border: 1px solid #c9dec4;
        padding: 3px 8px;
        border-radius: 8px;
    }
    .tea-coupon-info {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 16px;
    }
    .tea-coupon-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fbf9f5;
        border: 1px solid #e8e4dc;
        border-radius: 12px;
        padding: 8px 12px;
    }
    .tea-coupon-code {
        font-family: monospace;
        font-size: 15px;
        font-weight: 700;
        color: #0a211b;
        letter-spacing: 1px;
    }
    .tea-copy-btn {
        background: #173f2c;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .tea-copy-btn:hover {
        background: #cdb06a;
        color: #0a211b;
    }

    /* Toolbar Section */
    .tea-offers-toolbar {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 8px 24px -6px rgba(10, 33, 27, 0.04);
        padding: 18px 24px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .tea-toolbar-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #4b5563;
    }
    .tea-count-badge {
        background: #f4f8f2;
        color: #173f2c;
        border: 1px solid #c9dec4;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 13px;
    }

    .tea-sort-wrapper {
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
    .tea-offers-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 22px;
        margin-bottom: 40px;
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

    /* Badges */
    .tea-card-badges {
        position: absolute;
        top: 12px;
        left: 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        z-index: 3;
    }
    .tea-discount-badge {
        background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%);
        color: #ffffff;
        font-size: 11.5px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.3);
    }
    .tea-stockout-badge {
        background: #1f2937;
        color: #ffffff;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 10px;
    }

    /* Thumbnail */
    .tea-card-image-wrap {
        position: relative;
        background: #fdfcf9;
        overflow: hidden;
        padding-top: 100%;
    }
    .tea-card-image-wrap img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 16px;
        transition: transform 0.4s ease;
    }
    .tea-prod-card:hover .tea-card-image-wrap img {
        transform: scale(1.06);
    }

    /* Card Details */
    .tea-card-body {
        padding: 18px 18px 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }
    .tea-card-title {
        font-size: 14.5px;
        font-weight: 600;
        color: #111827;
        margin: 0 0 10px 0;
        line-height: 1.45;
        height: 42px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .tea-card-title a {
        color: #111827;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .tea-card-title a:hover {
        color: #173f2c;
    }

    /* Pricing */
    .tea-card-prices {
        display: flex;
        align-items: baseline;
        gap: 10px;
        margin-bottom: 14px;
    }
    .tea-price-new {
        font-size: 18px;
        font-weight: 700;
        color: #173f2c;
    }
    .tea-price-old {
        font-size: 13px;
        color: #9ca3af;
        text-decoration: line-through;
    }

    /* Card CTA Button */
    .tea-order-btn {
        width: 100%;
        background: #173f2c;
        color: #ffffff !important;
        border: 1px solid #173f2c;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.15);
    }
    .tea-order-btn:hover {
        background: #245a2d;
        border-color: #245a2d;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(36, 90, 45, 0.25);
    }

    /* Empty State */
    .tea-offers-empty {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 10px 30px -8px rgba(10, 33, 27, 0.05);
        padding: 60px 24px;
        text-align: center;
        max-width: 600px;
        margin: 20px auto 40px;
    }
    .tea-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f4f8f2;
        color: #173f2c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 20px;
        border: 1px solid #c9dec4;
    }
    .tea-empty-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 22px;
        font-weight: 700;
        color: #0a211b;
        margin-bottom: 8px;
    }
    .tea-empty-desc {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 24px;
        line-height: 1.6;
    }
    .tea-empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #173f2c;
        color: #ffffff;
        font-weight: 600;
        font-size: 14.5px;
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-empty-btn:hover {
        background: #245a2d;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Custom Pagination */
    .tea-pagination-wrap {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }
    .tea-pagination-wrap .pagination {
        display: inline-flex;
        gap: 6px;
        margin: 0;
        list-style: none;
        padding: 0;
    }
    .tea-pagination-wrap .page-item .page-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 14px;
        border-radius: 10px;
        border: 1.5px solid #e5e7eb;
        background: #ffffff;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-pagination-wrap .page-item.active .page-link {
        background: #173f2c;
        border-color: #173f2c;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.2);
    }
    .tea-pagination-wrap .page-item .page-link:hover:not(.active) {
        border-color: #cdb06a;
        color: #173f2c;
        background: #fbf9f5;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .tea-offers-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .tea-offers-hero {
            padding: 30px 24px;
        }
        .tea-offers-title {
            font-size: 26px;
        }
    }
    @media (max-width: 767px) {
        .tea-offers-page {
            padding: 20px 12px 60px;
        }
        .tea-offers-hero {
            padding: 24px 20px;
            border-radius: 18px;
            margin-bottom: 20px;
        }
        .tea-offers-title {
            font-size: 22px;
        }
        .tea-offers-subtitle {
            font-size: 13.5px;
        }
        .tea-offers-toolbar {
            padding: 14px 16px;
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }
        .tea-sort-wrapper {
            justify-content: space-between;
        }
        .tea-sort-select {
            flex-grow: 1;
        }
        .tea-offers-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .tea-card-body {
            padding: 12px 10px 14px;
        }
        .tea-card-title {
            font-size: 13px;
            height: 38px;
            margin-bottom: 6px;
        }
        .tea-price-new {
            font-size: 15px;
        }
        .tea-price-old {
            font-size: 11.5px;
        }
        .tea-order-btn {
            padding: 8px 10px;
            font-size: 12.5px;
            border-radius: 8px;
        }
    }
</style>

<div class="tea-offers-page">
    <div class="tea-offers-container">
        <!-- Breadcrumb -->
        <div class="tea-offers-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> হোম</a>
            <i class="fas fa-chevron-right"></i>
            <span>স্পেশাল অফার ও ভাউচার</span>
        </div>

        <!-- Hero Section -->
        <div class="tea-offers-hero">
            <div class="tea-offers-hero-inner">
                <div class="tea-offers-pill">
                    <i class="fas fa-gift"></i>
                    <span>বিশেষ অফার ও কুপন ডিসকাউন্ট</span>
                </div>
                <h1 class="tea-offers-title">সেরা ডিসকাউন্ট ও স্পেশাল অফার</h1>
                <p class="tea-offers-subtitle">
                    আপনার পছন্দের প্রিমিয়াম চায়ের প্রতিটি কেনাকাটায় উপভোগ করুন বিশেষ মূল্যছাড় ও সাশ্রয়ী ভাউচার অফার।
                </p>
            </div>
        </div>

        @if(isset($coupons) && $coupons->count() > 0)
            <!-- Active Coupons Section -->
            <div class="tea-coupons-section">
                <div class="tea-section-header">
                    <i class="fas fa-ticket-alt fa-lg text-warning"></i>
                    <h2 class="tea-section-title">সক্রিয় কুপন ভাউচার</h2>
                </div>
                <div class="tea-coupons-grid">
                    @foreach($coupons as $coupon)
                        <div class="tea-coupon-card">
                            <div>
                                <div class="tea-coupon-top">
                                    <div class="tea-coupon-amount">
                                        @if($coupon->coupon_type == 1)
                                            ৳ {{ number_format($coupon->amount, 0) }} ছাড়
                                        @else
                                            {{ $coupon->amount }}% ছাড়
                                        @endif
                                    </div>
                                    <span class="tea-coupon-tag">কুপন</span>
                                </div>
                                <div class="tea-coupon-info">
                                    <i class="far fa-calendar-alt"></i> মেয়াদ: {{ date('d M, Y', strtotime($coupon->validity)) }} পর্যন্ত
                                </div>
                            </div>
                            <div class="tea-coupon-action">
                                <span class="tea-coupon-code" id="coupon-{{ $coupon->id }}">{{ $coupon->coupon_name }}</span>
                                <button type="button" class="tea-copy-btn" onclick="copyCoupon('{{ $coupon->coupon_name }}')">
                                    <i class="far fa-copy"></i> কপি করুন
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Toolbar: Results Count & Sort Dropdown -->
        <div class="tea-offers-toolbar">
            <div class="tea-toolbar-info">
                <span>অফারের চা:</span>
                <span class="tea-count-badge">{{ $products->total() }}টি পণ্যে বিশেষ ছাড় রয়েছে</span>
            </div>

            <div class="tea-sort-wrapper">
                <label for="offers-sort" class="tea-sort-label">ক্রমানুসারে সাজান:</label>
                <form action="" method="GET" class="sort-form m-0">
                    <select name="sort" id="offers-sort" class="tea-sort-select sort">
                        <option value="1" @if(request()->get('sort')==1 || !request()->has('sort')) selected @endif>সর্বশেষ পণ্য (Latest)</option>
                        <option value="2" @if(request()->get('sort')==2) selected @endif>পুরাতন পণ্য (Oldest)</option>
                        <option value="3" @if(request()->get('sort')==3) selected @endif>মূল্য: বেশি থেকে কম (High to Low)</option>
                        <option value="4" @if(request()->get('sort')==4) selected @endif>মূল্য: কম থেকে বেশি (Low to High)</option>
                        <option value="5" @if(request()->get('sort')==5) selected @endif>নাম: A - Z</option>
                        <option value="6" @if(request()->get('sort')==6) selected @endif>নাম: Z - A</option>
                    </select>
                </form>
            </div>
        </div>

        @if($products->count() > 0)
            <!-- Products Grid -->
            <div class="tea-offers-grid">
                @foreach($products as $key => $value)
                    @php
                        $discount = 0;
                        if ($value->old_price && $value->old_price > $value->new_price) {
                            $discount = (($value->old_price - $value->new_price) * 100) / $value->old_price;
                        }
                    @endphp

                    <div class="tea-prod-card">
                        <!-- Badges -->
                        <div class="tea-card-badges">
                            @if($discount > 0)
                                <span class="tea-discount-badge">
                                    {{ number_format($discount, 0) }}% ছাড়
                                </span>
                            @endif
                            @if(isset($value->stock) && $value->stock <= 0)
                                <span class="tea-stockout-badge">স্টক শেষ</span>
                            @endif
                        </div>

                        <!-- Image -->
                        <div class="tea-card-image-wrap">
                            <a href="{{ route('product', $value->slug) }}">
                                <img src="{{ asset($value->image ? $value->image->image : 'public/uploads/default.png') }}"
                                     alt="{{ $value->name }}"
                                     loading="lazy" />
                            </a>
                        </div>

                        <!-- Content -->
                        <div class="tea-card-body">
                            <div>
                                <h3 class="tea-card-title">
                                    <a href="{{ route('product', $value->slug) }}" title="{{ $value->name }}">
                                        {{ $value->name }}
                                    </a>
                                </h3>

                                <div class="tea-card-prices">
                                    <span class="tea-price-new">৳ {{ number_format($value->new_price, 0) }}</span>
                                    @if($value->old_price && $value->old_price > $value->new_price)
                                        <span class="tea-price-old">৳ {{ number_format($value->old_price, 0) }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Button -->
                            @if(! $value->prosizes->isEmpty() || ! $value->procolors->isEmpty())
                                <a href="{{ route('product', $value->slug) }}" class="tea-order-btn">
                                    <i class="fas fa-shopping-bag"></i> অর্ডার করুন
                                </a>
                            @else
                                <form action="{{ route('cart.store') }}" method="POST" class="m-0">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $value->id }}" />
                                    <input type="hidden" name="qty" value="1" />
                                    <button type="submit" class="tea-order-btn">
                                        <i class="fas fa-shopping-bag"></i> অর্ডার করুন
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Custom Pagination -->
            <div class="tea-pagination-wrap">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @else
            <!-- Empty Offers State -->
            <div class="tea-offers-empty">
                <div class="tea-empty-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="tea-empty-title">বর্তমানে কোন বিশেষ ডিসকাউন্ট সক্রিয় নেই</h3>
                <p class="tea-empty-desc">
                    নতুন অফার ও বিশেষ ছাড় শীঘ্রই আসছে! আমাদের সম্পূর্ণ প্রিমিয়াম চা কালেকশন দেখতে শপ পেইজে ভিজিট করুন।
                </p>
                <a href="{{ route('shop') }}" class="tea-empty-btn">
                    <i class="fas fa-store"></i> সকল চা কালেকশন দেখুন
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $(".sort").change(function(){
            $('#loading').show();
            $(".sort-form").submit();
        });
    });

    function copyCoupon(code) {
        navigator.clipboard.writeText(code).then(function() {
            if (typeof toastr !== 'undefined') {
                toastr.success('কুপন কোড "' + code + '" কপি করা হয়েছে!');
            } else {
                alert('কুপন কোড "' + code + '" কপি করা হয়েছে!');
            }
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endpush