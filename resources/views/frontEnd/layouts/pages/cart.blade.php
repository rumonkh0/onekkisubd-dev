@extends('frontEnd.layouts.master')
@section('title', 'শপিং কার্ট | Shopping Cart')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY SHOPPING CART SYSTEM
       ======================================================== */
    .tea-cart-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.06) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-cart-container {
        max-width: 1180px;
        margin: 0 auto;
    }

    /* Breadcrumb / Top Bar */
    .tea-cart-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 24px;
    }
    .tea-cart-breadcrumb a {
        color: #173f2c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .tea-cart-breadcrumb a:hover {
        color: #cdb06a;
    }
    .tea-cart-breadcrumb i {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Page Header */
    .tea-cart-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 26px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tea-cart-page-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 28px;
        font-weight: 700;
        color: #0a211b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-cart-page-title i {
        color: #245a2d;
    }
    .tea-cart-count-pill {
        font-size: 14px;
        font-weight: 600;
        color: #173f2c;
        background: #eaf4eb;
        border: 1px solid #c9dec4;
        padding: 5px 14px;
        border-radius: 20px;
    }

    /* Empty Cart State */
    .tea-empty-cart-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.08);
        padding: 60px 24px;
        text-align: center;
        max-width: 580px;
        margin: 40px auto;
    }
    .tea-empty-emblem {
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
    .tea-empty-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 10px;
    }
    .tea-empty-subtitle {
        font-size: 14.5px;
        color: #6b7280;
        margin: 0 auto 28px;
        max-width: 420px;
        line-height: 1.6;
    }
    .tea-empty-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .tea-btn-explore {
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
    .tea-btn-explore:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(23, 63, 44, 0.3);
    }
    .tea-btn-home-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #f4f6f3;
        color: #4b5563;
        border-radius: 30px;
        font-size: 14.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-btn-home-link:hover {
        background: #e8ede6;
        color: #111827;
    }

    /* Cart Main Grid */
    .tea-cart-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 28px;
        align-items: start;
    }

    /* Left Column: Items Card */
    .tea-cart-items-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 14px 36px -10px rgba(10, 33, 27, 0.06);
        overflow: hidden;
    }
    .tea-items-card-header {
        padding: 18px 24px;
        background: #fafbf9;
        border-bottom: 1px solid #f1ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .tea-items-header-title {
        font-size: 15px;
        font-weight: 700;
        color: #173f2c;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-items-header-title i {
        color: #cdb06a;
    }

    /* Items Table */
    .tea-cart-table {
        width: 100%;
        border-collapse: collapse;
    }
    .tea-cart-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #6b7280;
        font-weight: 600;
        padding: 14px 20px;
        background: #fafbf9;
        border-bottom: 1px solid #f1ede6;
        text-align: left;
    }
    .tea-cart-table th.col-price { text-align: right; }
    .tea-cart-table th.col-qty { text-align: center; }
    .tea-cart-table th.col-total { text-align: right; }
    .tea-cart-table th.col-action { text-align: center; width: 60px; }

    .tea-cart-table td {
        padding: 18px 20px;
        border-bottom: 1px solid #f4f1ea;
        vertical-align: middle;
        font-size: 14px;
    }
    .tea-cart-table tr:last-child td {
        border-bottom: none;
    }

    /* Product Cell */
    .tea-cart-prod-cell {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .tea-cart-prod-img {
        width: 64px;
        height: 64px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid #e8e4dc;
        background: #fbfbfb;
        flex-shrink: 0;
        transition: transform 0.2s ease;
    }
    .tea-cart-prod-cell:hover .tea-cart-prod-img {
        transform: scale(1.05);
    }
    .tea-cart-prod-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .tea-cart-prod-name {
        font-weight: 600;
        color: #0a211b;
        text-decoration: none;
        line-height: 1.4;
        transition: color 0.2s ease;
    }
    .tea-cart-prod-name:hover {
        color: #245a2d;
    }
    .tea-cart-prod-tags {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .tea-variant-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11.5px;
        font-weight: 500;
        color: #4b5563;
        background: #f4f6f3;
        padding: 2px 8px;
        border-radius: 10px;
    }

    /* Price & Total */
    .tea-unit-price {
        color: #4b5563;
        font-weight: 500;
        text-align: right;
        white-space: nowrap;
    }
    .tea-line-total {
        color: #173f2c;
        font-weight: 700;
        font-size: 15.5px;
        text-align: right;
        white-space: nowrap;
    }

    /* Quantity Stepper */
    .tea-cart-stepper {
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        width: 96px;
        height: 36px;
        border: 1.5px solid #d1d5db;
        border-radius: 20px;
        background: #ffffff;
        overflow: hidden;
        margin: 0 auto;
    }
    .tea-stepper-btn {
        width: 30px;
        height: 36px;
        border: none;
        background: #f3f4f6;
        color: #111827;
        font-size: 16px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s ease;
        padding: 0;
    }
    .tea-stepper-btn:hover {
        background: #e5e7eb;
        color: #173f2c;
    }
    .tea-stepper-val {
        width: 36px;
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        user-select: none;
    }

    /* Trash Action */
    .tea-btn-remove {
        background: transparent;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: all 0.2s ease;
    }
    .tea-btn-remove:hover {
        background: #fee2e2;
        color: #dc2626;
        transform: scale(1.1);
    }

    /* Actions Strip below Table */
    .tea-cart-actions-bar {
        padding: 18px 24px;
        background: #fafbf9;
        border-top: 1px solid #f1ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .tea-btn-continue {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        background: #ffffff;
        border: 1px solid #e8e4dc;
        border-radius: 20px;
        color: #173f2c;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-btn-continue:hover {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
        transform: translateX(-2px);
    }

    /* Coupon Box */
    .tea-coupon-box {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-coupon-input {
        height: 40px;
        padding: 0 14px;
        border: 1.5px solid #d1d5db;
        border-radius: 20px;
        font-size: 13.5px;
        color: #111827;
        background: #ffffff;
        outline: none;
        width: 170px;
        transition: all 0.2s ease;
    }
    .tea-coupon-input:focus {
        border-color: #245a2d;
        box-shadow: 0 0 0 3px rgba(36, 90, 45, 0.1);
    }
    .tea-btn-coupon {
        height: 40px;
        padding: 0 18px;
        background: #173f2c;
        color: #ffffff;
        border: none;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .tea-btn-coupon:hover {
        background: #245a2d;
        transform: translateY(-1px);
    }

    /* Right Column: Order Summary Card */
    .tea-cart-summary-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 14px 36px -10px rgba(10, 33, 27, 0.06);
        overflow: hidden;
        position: sticky;
        top: 100px;
    }
    .tea-summary-top-strip {
        height: 5px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }
    .tea-summary-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f1ede6;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
    }
    .tea-summary-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 20px;
        font-weight: 700;
        color: #0a211b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-summary-title i {
        color: #cdb06a;
    }
    .tea-summary-body {
        padding: 22px 24px;
    }
    .tea-summary-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        color: #4b5563;
        margin-bottom: 12px;
    }
    .tea-summary-row strong {
        color: #111827;
        font-weight: 600;
    }
    .tea-summary-row.discount-row {
        color: #047857;
    }
    .tea-summary-row.total-row {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px dashed #e8e4dc;
        font-size: 16px;
        font-weight: 700;
        color: #0a211b;
    }
    .tea-grand-total {
        color: #245a2d;
        font-size: 22px;
        font-family: 'Playfair Display', serif;
    }

    /* Checkout CTA */
    .tea-btn-checkout {
        width: 100%;
        height: 52px;
        background: linear-gradient(135deg, #173f2c 0%, #245a2d 100%);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(23, 63, 44, 0.22);
        transition: all 0.25s ease;
        margin-top: 20px;
        cursor: pointer;
    }
    .tea-btn-checkout:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        box-shadow: 0 12px 24px rgba(23, 63, 44, 0.3);
        transform: translateY(-2px);
        color: #ffffff;
    }

    /* Trust guarantees in summary */
    .tea-summary-guarantees {
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #f1ede6;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .tea-guarantee-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12.5px;
        color: #6b7280;
    }
    .tea-guarantee-item i {
        color: #245a2d;
        font-size: 14px;
        width: 18px;
        text-align: center;
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .tea-cart-grid {
            grid-template-columns: 1fr;
        }
        .tea-cart-summary-card {
            position: static;
        }
    }
    @media (max-width: 576px) {
        .tea-cart-page {
            padding: 20px 12px 60px;
        }
        .tea-cart-table th, 
        .tea-cart-table td {
            padding: 12px 10px;
        }
        .tea-cart-prod-img {
            width: 48px;
            height: 48px;
        }
        .tea-cart-prod-name {
            font-size: 13px;
        }
        .tea-cart-stepper {
            width: 82px;
            height: 32px;
        }
        .tea-stepper-btn {
            width: 26px;
            height: 32px;
            font-size: 14px;
        }
        .tea-cart-actions-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .tea-coupon-box {
            width: 100%;
        }
        .tea-coupon-input {
            flex: 1;
        }
    }
</style>

<div class="tea-cart-page">
    <div class="tea-cart-container">
        <!-- Breadcrumb -->
        <div class="tea-cart-breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('shop') }}">শপ</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>শপিং কার্ট</span>
        </div>

        @php
            $cartContent = Cart::instance('shopping')->content();
            $cartCount = Cart::instance('shopping')->count();
            $subtotal = Cart::instance('shopping')->subtotal();
            $subtotal = str_replace(',', '', $subtotal);
            $subtotal = str_replace('.00', '', $subtotal);
            $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
            $discount = Session::get('discount') ? Session::get('discount') : 0;
        @endphp

        @if($cartCount == 0)
            <!-- Empty Cart State -->
            <div class="tea-empty-cart-card">
                <div class="tea-empty-emblem">
                    <i class="fa-solid fa-mug-hot"></i>
                </div>
                <h2 class="tea-empty-title">আপনার শপিং কার্ট খালি রয়েছে</h2>
                <p class="tea-empty-subtitle">
                    আপনার চায়ের কাপ ভরাতে আমাদের প্রিমিয়াম চা কালেকশন থেকে পছন্দের ব্ল্যাক টি, গ্রিন টি কিংবা স্পেশাল হ্যান্ডমেড চা বেছে নিন।
                </p>
                <div class="tea-empty-actions">
                    <a href="{{ route('shop') }}" class="tea-btn-explore">
                        <i class="fa-solid fa-leaf"></i>
                        <span>চা শপ ঘুরে দেখুন</span>
                    </a>
                    <a href="{{ route('home') }}" class="tea-btn-home-link">
                        <i class="fa-solid fa-house"></i>
                        <span>হোম পেজে যান</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Header with Active Items Count -->
            <div class="tea-cart-page-header">
                <h1 class="tea-cart-page-title">
                    <i class="fa-solid fa-bag-shopping"></i> শপিং কার্ট
                </h1>
                <span class="tea-cart-count-pill">
                    {{ $cartCount }}টি পণ্য নির্বাচিত
                </span>
            </div>

            <!-- Active Cart Grid -->
            <div class="tea-cart-grid">
                <!-- Left Column: Items Card -->
                <div class="tea-cart-items-card">
                    <div class="tea-items-card-header">
                        <span class="tea-items-header-title">
                            <i class="fa-solid fa-basket-shopping"></i> নির্বাচিত পণ্যসমূহ
                        </span>
                        <a href="{{ route('shop') }}" class="text-decoration-none" style="font-size: 13px; color: #245a2d; font-weight: 600;">
                            + আরও পণ্য যোগ করুন
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="tea-cart-table">
                            <thead>
                                <tr>
                                    <th>পণ্য (Product)</th>
                                    <th class="col-price">একক মূল্য</th>
                                    <th class="col-qty">পরিমাণ</th>
                                    <th class="col-total">মোট মূল্য</th>
                                    <th class="col-action">মুছুন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartContent as $value)
                                    <tr>
                                        <td>
                                            <div class="tea-cart-prod-cell">
                                                <a href="{{ route('product', $value->options->slug ?? '') }}">
                                                    <img src="{{ asset($value->options->image ?? '') }}" alt="{{ $value->name }}" class="tea-cart-prod-img" onerror="this.src='{{ asset('public/uploads/settings/1740644407-onekkisu.webp') }}'" />
                                                </a>
                                                <div class="tea-cart-prod-info">
                                                    <a href="{{ route('product', $value->options->slug ?? '') }}" class="tea-cart-prod-name">
                                                        {{ $value->name }}
                                                    </a>
                                                    <div class="tea-cart-prod-tags">
                                                        @if(!empty($value->options->product_size))
                                                            <span class="tea-variant-pill">
                                                                <i class="fa-solid fa-weight-scale"></i> {{ $value->options->product_size }}
                                                            </span>
                                                        @endif
                                                        @if(!empty($value->options->product_color))
                                                            <span class="tea-variant-pill">
                                                                <i class="fa-solid fa-tag"></i> {{ $value->options->product_color }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-price tea-unit-price">
                                            ৳{{ number_format($value->price) }}
                                        </td>
                                        <td class="col-qty">
                                            <div class="tea-cart-stepper">
                                                <button type="button" class="tea-stepper-btn cart_decrement" data-id="{{ $value->rowId }}" title="পরিমাণ কমান">−</button>
                                                <span class="tea-stepper-val">{{ $value->qty }}</span>
                                                <button type="button" class="tea-stepper-btn cart_increment" data-id="{{ $value->rowId }}" title="পরিমাণ বাড়ান">+</button>
                                            </div>
                                        </td>
                                        <td class="col-total tea-line-total">
                                            ৳{{ number_format($value->price * $value->qty) }}
                                        </td>
                                        <td class="col-action">
                                            <button type="button" class="tea-btn-remove cart_remove" data-id="{{ $value->rowId }}" title="পণ্যটি মুছে ফেলুন">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Bottom Action Strip -->
                    <div class="tea-cart-actions-bar">
                        <a href="{{ route('shop') }}" class="tea-btn-continue">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>আরও কেনাকাটা করুন</span>
                        </a>

                        <!-- Coupon Form -->
                        <div class="tea-coupon-box">
                            <input type="text" id="coupon_code_input" class="tea-coupon-input" placeholder="কুপন কোড (Coupon)" />
                            <button type="button" id="apply_coupon_btn" class="tea-btn-coupon">
                                প্রয়োগ করুন
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary Card -->
                <div class="tea-cart-summary-card">
                    <div class="tea-summary-top-strip"></div>

                    <div class="tea-summary-header">
                        <h3 class="tea-summary-title">
                            <i class="fa-solid fa-receipt"></i> অর্ডার সারাংশ
                        </h3>
                    </div>

                    <div class="tea-summary-body">
                        <div class="tea-summary-row">
                            <span>মোট পণ্যের সংখ্যা:</span>
                            <strong>{{ $cartCount }}টি (আইটেম)</strong>
                        </div>
                        <div class="tea-summary-row">
                            <span>সাবটোটাল (Subtotal):</span>
                            <strong>৳{{ number_format($subtotal) }}</strong>
                        </div>
                        <div class="tea-summary-row">
                            <span>ডেলিভারি চার্জ:</span>
                            <strong>
                                @if($shipping > 0)
                                    ৳{{ number_format($shipping) }}
                                @else
                                    <span style="font-size: 12.5px; color: #6b7280; font-weight: normal;">চেকআউটে নির্ধারিত হবে</span>
                                @endif
                            </strong>
                        </div>
                        @if($discount > 0)
                            <div class="tea-summary-row discount-row">
                                <span>কুপন ডিসকাউন্ট:</span>
                                <strong>-৳{{ number_format($discount) }}</strong>
                            </div>
                        @endif

                        <div class="tea-summary-row total-row">
                            <span>সর্বমোট পরিশোধযোগ্য:</span>
                            <span class="tea-grand-total">৳{{ number_format(($subtotal + $shipping) - $discount) }}</span>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('customer.checkout') }}" class="tea-btn-checkout">
                            <span>অর্ডার সম্পন্ন করতে এগিয়ে যান</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                        <!-- Guarantees -->
                        <div class="tea-summary-guarantees">
                            <div class="tea-guarantee-item">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span>১০০% নিরাপদ ও সুরক্ষিত চেকআউট</span>
                            </div>
                            <div class="tea-guarantee-item">
                                <i class="fa-solid fa-truck-fast"></i>
                                <span>সারা বাংলাদেশে হোম ডেলিভারি</span>
                            </div>
                            <div class="tea-guarantee-item">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                <span>ক্যাশ অন ডেলিভারি এবং বিকাশ সুবিধা</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Seamless reload on cart quantity or removal changes
    $(document).ajaxSuccess(function(event, xhr, settings) {
        if (settings.url && (
            settings.url.indexOf('cart/increment') !== -1 || 
            settings.url.indexOf('cart/decrement') !== -1 || 
            settings.url.indexOf('cart/remove') !== -1
        )) {
            window.location.reload();
        }
    });

    // Handle Coupon Application
    $('#apply_coupon_btn').on('click', function(e) {
        e.preventDefault();
        var coupon_code = $('#coupon_code_input').val().trim();
        if (!coupon_code) {
            if (typeof toastr !== 'undefined') {
                toastr.warning('অনুগ্রহ করে কুপন কোড লিখুন');
            } else {
                alert('অনুগ্রহ করে কুপন কোড লিখুন');
            }
            return;
        }

        $.ajax({
            type: "POST",
            url: "{{ route('coupon.apply') }}",
            data: {
                _token: "{{ csrf_token() }}",
                coupon: coupon_code,
                amount: {{ $subtotal ?? 0 }}
            },
            success: function(res) {
                if (res.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(res.message);
                    }
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(res.message);
                    } else {
                        alert(res.message);
                    }
                }
            },
            error: function() {
                if (typeof toastr !== 'undefined') {
                    toastr.error('কুপন প্রয়োগে সমস্যা হয়েছে, অনুগ্রহ করে আবার চেষ্টা করুন');
                }
            }
        });
    });
</script>
@endsection
