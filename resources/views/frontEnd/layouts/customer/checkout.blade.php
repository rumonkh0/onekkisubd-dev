@extends('frontEnd.layouts.master')
@section('title', 'Customer Checkout - ' . $generalsetting->name)

@push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
<style>
    /* ==========================================================================
       LUXURY TEA CHECKOUT THEME
       ========================================================================== */
    :root {
        --tea-dark: #0a211b;
        --tea-green: #173f2c;
        --tea-light-green: #245a2d;
        --tea-gold: #d8b77c;
        --tea-gold-dark: #b8963e;
        --tea-cream: #fbfaf7;
        --tea-border: rgba(23, 63, 44, 0.1);
        --tea-muted: #6b7280;
        --font-serif: "Playfair Display", Georgia, serif;
        --font-bn: "Hind Siliguri", "Poppins", sans-serif;
    }

    .tea-checkout-section {
        background: #f8f7f2;
        padding: 36px 0 80px;
        min-height: 80vh;
        font-family: var(--font-bn);
    }

    /* Page Header */
    .tea-checkout-header {
        text-align: center;
        margin-bottom: 32px;
    }
    .tea-checkout-subtitle {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--tea-gold-dark);
        display: block;
        margin-bottom: 6px;
    }
    .tea-checkout-title {
        font-family: var(--font-serif);
        font-size: 30px;
        font-weight: 700;
        color: var(--tea-dark);
        margin: 0;
    }
    .tea-checkout-trust-strip {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 14px;
        font-size: 13px;
        color: #4b5563;
    }
    .tea-trust-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.7);
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid var(--tea-border);
    }
    .tea-trust-item svg {
        color: var(--tea-green);
    }

    /* Cards */
    .tea-checkout-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid var(--tea-border);
        box-shadow: 0 4px 24px rgba(10, 33, 27, 0.04);
        overflow: hidden;
        margin-bottom: 24px;
        transition: box-shadow 0.3s ease;
    }
    .tea-checkout-card:hover {
        box-shadow: 0 8px 30px rgba(10, 33, 27, 0.06);
    }
    .tea-card-header-styled {
        background: linear-gradient(135deg, rgba(248, 247, 242, 0.95) 0%, rgba(244, 248, 242, 0.7) 100%);
        padding: 18px 24px;
        border-bottom: 1px solid var(--tea-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .tea-card-header-styled h5 {
        font-family: var(--font-serif);
        font-size: 18px;
        font-weight: 700;
        color: var(--tea-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-card-header-styled .step-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--tea-dark);
        color: var(--tea-gold);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-family: sans-serif;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(10, 33, 27, 0.15);
    }
    .tea-card-body-styled {
        padding: 24px;
    }

    /* Form Inputs */
    .tea-form-label {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--tea-dark);
        margin-bottom: 6px;
        display: block;
    }
    .tea-form-control {
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 14px;
        color: #1f2937;
        transition: all 0.2s ease;
        background: #ffffff;
        width: 100%;
    }
    .tea-form-control:focus {
        border-color: var(--tea-green);
        box-shadow: 0 0 0 3px rgba(23, 63, 44, 0.1);
        outline: none;
    }
    .form-select.tea-form-control {
        background-position: right 14px center;
    }

    /* Payment Methods Selectable Cards */
    .tea-payment-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-top: 8px;
    }
    .tea-payment-card {
        border: 1.5px solid #e5e7eb;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #faf8f5;
        position: relative;
        margin: 0;
    }
    .tea-payment-card:hover {
        border-color: var(--tea-gold);
        background: #ffffff;
    }
    .tea-payment-card.active {
        border-color: var(--tea-green);
        background: #f4f8f2;
        box-shadow: 0 4px 14px rgba(23, 63, 44, 0.08);
    }
    .tea-payment-card input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: var(--tea-green);
        margin: 0;
        cursor: pointer;
    }
    .tea-payment-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid var(--tea-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .tea-payment-info {
        flex-grow: 1;
    }
    .tea-payment-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--tea-dark);
        margin: 0;
    }
    .tea-payment-desc {
        font-size: 12px;
        color: var(--tea-muted);
        margin: 2px 0 0;
    }

    /* Order Submit Button */
    .order_place,
    .tea-order-place-btn {
        width: 100%;
        background: linear-gradient(135deg, #173f2c 0%, #0a211b 100%);
        color: #ffffff;
        border: 1px solid rgba(216, 183, 124, 0.3);
        border-radius: 14px;
        padding: 16px 24px;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(10, 33, 27, 0.2);
        transition: all 0.3s ease;
        margin-top: 18px;
    }
    .order_place:hover,
    .tea-order-place-btn:hover {
        background: linear-gradient(135deg, #245a2d 0%, #173f2c 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(23, 63, 44, 0.3);
        color: #ffffff;
    }
    .order_place:disabled,
    .tea-order-place-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none;
    }

    /* Order Summary Sticky */
    @media (min-width: 992px) {
        .tea-sticky-summary {
            position: sticky;
            top: 90px;
        }
    .checkout-summary-badge {
        background: #173f2c !important;
        color: #ffffff !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        padding: 5px 12px !important;
        border-radius: 20px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        box-shadow: 0 2px 8px rgba(23, 63, 44, 0.2) !important;
    }
    .checkout-summary-badge i {
        color: #e2cf9c !important;
    }
    #order_summary_items_count svg,
    #order_summary_items_count a,
    #order_summary_items_count .cshort-summary {
        display: none !important;
    }

    /* Cart Table Styling */
    .cart_table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .cart_table th {
        background: #fbfaf7;
        color: var(--tea-dark);
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        padding: 12px 10px;
        border-bottom: 1.5px solid var(--tea-border);
    }
    .cart_table td {
        padding: 14px 10px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(23, 63, 44, 0.06);
    }
    .cart_table tbody tr:hover {
        background: rgba(248, 247, 242, 0.6);
    }
    .cart_table .cart-prod-img {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        border: 1px solid var(--tea-border);
        object-fit: cover;
        margin-right: 10px;
        background: #ffffff;
    }
    .cart_table .cart-prod-title {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--tea-dark);
        text-decoration: none;
        line-height: 1.3;
    }
    .cart_table .cart-prod-title:hover {
        color: var(--tea-light-green);
    }
    .cart-variant-tag {
        font-size: 11px;
        color: var(--tea-muted);
        margin: 2px 0 0;
    }
    .cart_remove {
        cursor: pointer;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        background: #fee2e2;
        transition: all 0.2s;
        text-decoration: none;
    }
    .cart_remove:hover {
        background: #ef4444;
        color: #ffffff;
    }

    /* Quantity Stepper */
    .cart_table .qty-cart .quantity,
    .cart_qty .quantity,
    .vcart-qty .quantity {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        position: relative !important;
        width: 100px !important;
        height: 36px !important;
        border: 1.5px solid #d1d5db !important;
        border-radius: 20px !important;
        background: #ffffff !important;
        overflow: hidden !important;
        margin: 0 auto !important;
        box-sizing: border-box !important;
    }
    .cart_table .qty-cart .quantity button,
    .cart_qty .quantity button,
    .cart_qty .quantity .minus,
    .cart_qty .quantity .plus,
    .vcart-qty .quantity .minus,
    .vcart-qty .quantity .plus {
        position: static !important;
        width: 32px !important;
        height: 36px !important;
        border: 0 !important;
        background: #f3f4f6 !important;
        color: #111827 !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        cursor: pointer !important;
        transition: background 0.2s !important;
        padding: 0 !important;
        margin: 0 !important;
        line-height: 1 !important;
        box-shadow: none !important;
        flex-shrink: 0 !important;
    }
    .cart_table .qty-cart .quantity button:hover,
    .cart_qty .quantity button:hover,
    .cart_qty .quantity .minus:hover,
    .cart_qty .quantity .plus:hover {
        background: #e5e7eb !important;
        color: #173f2c !important;
    }
    .cart_table .qty-cart .quantity .qty-count-display,
    .cart_qty .quantity .qty-count-display,
    .vcart-qty .quantity .qty-count-display,
    .quantity .qty-count-display {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 36px !important;
        height: 36px !important;
        text-align: center !important;
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #111827 !important;
        line-height: 1 !important;
        user-select: none !important;
        margin: 0 !important;
        padding: 0 !important;
        flex-grow: 1 !important;
    }
    .cart_table .qty-cart .quantity input,
    .cart_qty .quantity input,
    .vcart-qty .quantity input,
    .quantity input {
        display: none !important;
    }
    .stock-out-badge,
    .cart_qty .badge,
    .cart_qty .bg-danger {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        background-color: #dc2626 !important;
        color: #ffffff !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        line-height: 1 !important;
        padding: 4px 10px !important;
        border-radius: 12px !important;
        white-space: nowrap !important;
        width: auto !important;
        height: auto !important;
        min-width: 62px !important;
        text-align: center !important;
        box-shadow: 0 1px 3px rgba(220, 38, 38, 0.25) !important;
    }

    /* Summary Totals */
    .cart_table tfoot th {
        font-size: 13px;
        font-weight: 600;
        color: var(--tea-muted);
        border: 0;
        padding: 8px 12px;
    }
    .cart_table tfoot td {
        font-size: 14px;
        font-weight: 700;
        color: var(--tea-dark);
        border: 0;
        padding: 8px 12px;
    }
    .cart_table tfoot tr:last-child {
        border-top: 1.5px dashed var(--tea-border);
    }
    .cart_table tfoot tr:last-child th {
        font-size: 15px;
        font-weight: 700;
        color: var(--tea-dark);
        padding-top: 14px;
    }
    .cart_table tfoot tr:last-child td {
        font-size: 18px;
        font-weight: 800;
        color: var(--tea-green);
        padding-top: 14px;
    }

    /* Coupon Box */
    .tea-coupon-box {
        position: relative;
        display: flex;
        gap: 8px;
    }
    .tea-coupon-input {
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 13.5px;
        flex-grow: 1;
    }
    .tea-coupon-btn {
        background: var(--tea-dark);
        color: var(--tea-gold);
        border: 0;
        border-radius: 12px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tea-coupon-btn:hover {
        background: var(--tea-green);
        color: #ffffff;
    }

    /* Helpline Box */
    .tea-help-box {
        background: #faf8f5;
        border: 1px dashed var(--tea-border);
        border-radius: 14px;
        padding: 14px 18px;
        margin-top: 18px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: var(--tea-dark);
    }
    .tea-help-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--tea-green);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .tea-help-box a {
        color: var(--tea-green);
        font-weight: 700;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<section class="tea-checkout-section">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $shipping = Session::get('shipping') ? Session::get('shipping') : 0;
        $partial_amount = Cart::instance('shopping')->content();
        $partial_payment = 0;
        foreach ($partial_amount as $amount) {
            $partial_payment += $amount->options->preebooking;
        }
    @endphp

    <div class="container">
        <!-- Page Header -->
        <div class="tea-checkout-header">
            <span class="tea-checkout-subtitle">Secure Order Completion</span>
            <h1 class="tea-checkout-title">অর্ডার সম্পন্ন করুন (Checkout)</h1>
            <div class="tea-checkout-trust-strip">
                <span class="tea-trust-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    ১০০% অথেনটিক চা
                </span>
                <span class="tea-trust-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    ক্যাশ অন ডেলিভারি সুবিধা
                </span>
                <span class="tea-trust-item">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    দ্রুত ডেলিভারি
                </span>
            </div>
        </div>

        <div class="row g-4 align-items-start">
            <!-- LEFT COLUMN: Delivery Form & Payment -->
            <div class="col-lg-7 col-md-12 order-lg-1 order-2">
                <form action="{{ route('customer.ordersave') }}" method="POST" id="checkout_order_form">
                    @csrf
                    <input type="hidden" name="paid_partial_payment_amount" value="{{ $partial_payment }}">
                    <input type="hidden" id="hidden_couponId" name="couponId" value="">

                    <!-- STEP 1: Delivery Details -->
                    <div class="tea-checkout-card">
                        <div class="tea-card-header-styled">
                            <h5>
                                <span class="step-num">১</span>
                                ডেলিভারি তথ্য (Delivery Details)
                            </h5>
                            <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 11px;">প্রয়োজনীয় তথ্য</span>
                        </div>
                        <div class="tea-card-body-styled">
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-sm-12">
                                    <div>
                                        <label for="name" class="tea-form-label">আপনার পূর্ণ নাম (Full Name) *</label>
                                        <input type="text" id="name"
                                            class="tea-form-control @error('name') is-invalid @enderror" name="name"
                                            value="@if ($customer) {{ $customer->name }} @endif"
                                            placeholder="যেমন: মোঃ সাকিব হোসেন"
                                            required />
                                        @error('name')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-sm-12">
                                    <div>
                                        <label for="phone" class="tea-form-label">মোবাইল নাম্বার (Mobile Number) *</label>
                                        <input type="tel" minlength="11" maxlength="11" id="phone"
                                            class="tea-form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="@if ($customer) {{ $customer->phone }} @endif"
                                            placeholder="01XXXXXXXXX"
                                            required />
                                        <small class="text-muted" style="font-size: 11.5px;">অর্ডারের তথ্য ও ডেলিভারি আপডেটের জন্য ১১ ডিজিটের নম্বর দিন</small>
                                        @error('phone')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-sm-6">
                                    <div>
                                        <label class="tea-form-label">জেলা (District / City) *</label>
                                        <select class="form-select tea-form-control city" name="city" required>
                                            <option value="" disabled selected>আপনার জেলা সিলেক্ট করুন</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                            @endforeach
                                        </select>
                                        @error('city')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Postal / Zip Code -->
                                <div class="col-sm-6">
                                    <div>
                                        <label for="postal_code" class="tea-form-label">পোস্টাল / জিপ কোড (Postal / Zip Code)</label>
                                        <input type="text" id="postal_code"
                                            class="tea-form-control @error('postal_code') is-invalid @enderror"
                                            name="postal_code"
                                            maxlength="10"
                                            value="{{ old('postal_code') }}"
                                            placeholder="যেমন: 1216" />
                                        @error('postal_code')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Area / Shipping Charge -->
                                <div class="col-sm-12">
                                    <div>
                                        <label for="area" class="tea-form-label">ডেলিভারি এরিয়া (Delivery Area) *</label>
                                        <select id="area" class="form-select tea-form-control @error('area') is-invalid @enderror" name="area" required>
                                            <option value="">ডেলিভারি এরিয়া সিলেক্ট করুন</option>
                                            @foreach ($shippingcharge as $key => $value)
                                                <option value="{{ $value->id }}" {{ $loop->first ? 'selected' : '' }}>
                                                    {{ $value->name }} (৳ {{ $value->amount }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('area')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-sm-12">
                                    <div>
                                        <label for="address" class="tea-form-label">সম্পূর্ণ ঠিকানা (Full Address) *</label>
                                        <input type="text" id="address"
                                            class="tea-form-control @error('address') is-invalid @enderror"
                                            name="address"
                                            value="@if ($customer) {{ $customer->address }} @endif"
                                            placeholder="বাসা নং, রোড নং, থানা, জেলা"
                                            required />
                                        @error('address')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Note -->
                                <div class="col-sm-12">
                                    <div>
                                        <label for="note" class="tea-form-label">অর্ডার নোট / ডেলিভারি নির্দেশনা (Optional)</label>
                                        <input type="text" id="note"
                                            class="tea-form-control @error('note') is-invalid @enderror" name="note"
                                            placeholder="ডেলিভারি সম্পর্কে বিশেষ কোনো নির্দেশনা থাকলে লিখুন..."
                                            value="{{ old('note') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Payment Gateway Selection -->
                    <div class="tea-checkout-card">
                        <div class="tea-card-header-styled">
                            <h5>
                                <span class="step-num">৩</span>
                                পেমেন্ট পদ্ধতি (Payment Method)
                            </h5>
                            <span class="badge bg-light text-success border px-2 py-1" style="font-size: 11px;">নিরাপদ পেমেন্ট</span>
                        </div>
                        <div class="tea-card-body-styled">
                            <div class="tea-payment-grid">
                                @if (!$partial_payment || $partial_payment == 0)
                                    <label class="tea-payment-card active p_cash" for="inlineRadio1">
                                        <input type="radio" name="payment_method" id="inlineRadio1" value="Cash On Delivery" checked required />
                                        <div class="tea-payment-icon text-success">
                                            <i class="fa-solid fa-hand-holding-dollar"></i>
                                        </div>
                                        <div class="tea-payment-info">
                                            <h6 class="tea-payment-title">ক্যাশ অন ডেলিভারি (Cash On Delivery)</h6>
                                            <p class="tea-payment-desc">পণ্য হাতে পেয়ে দেখে ডেলিভারি ম্যানের কাছে মূল্য পরিশোধ করুন</p>
                                        </div>
                                    </label>
                                @endif

                                @if ($bkash_gateway)
                                    <label class="tea-payment-card p_bkash" for="inlineRadio2">
                                        <input type="radio" name="payment_method" id="inlineRadio2" value="bkash" @if ($partial_payment) checked @endif required />
                                        <div class="tea-payment-icon" style="color:#d12053;">
                                            <i class="fa-solid fa-mobile-screen-button"></i>
                                        </div>
                                        <div class="tea-payment-info">
                                            <h6 class="tea-payment-title">বিকাশ (bKash Payment)</h6>
                                            <p class="tea-payment-desc">বিকাশ ওয়ালেট বা পেমেন্ট গেটওয়ের মাধ্যমে সরাসরি পরিশোধ</p>
                                        </div>
                                    </label>
                                @endif

                                @if ($shurjopay_gateway)
                                    <label class="tea-payment-card p_shurjo" for="inlineRadio3">
                                        <input type="radio" name="payment_method" id="inlineRadio3" value="shurjopay" required />
                                        <div class="tea-payment-icon text-primary">
                                            <i class="fa-solid fa-credit-card"></i>
                                        </div>
                                        <div class="tea-payment-info">
                                            <h6 class="tea-payment-title">অনলাইন পেমেন্ট (Cards / MFS / Shurjopay)</h6>
                                            <p class="tea-payment-desc">ভিসা, মাস্টারকার্ড, নগদ বা ইন্টারনেট ব্যাংকিং</p>
                                        </div>
                                    </label>
                                @endif
                            </div>

                            <!-- Place Order Button -->
                            <button class="order_place tea-order-place-btn" id="Checkout_orderPlace" type="submit">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                অর্ডার কনফার্ম করুন (Place Order)
                            </button>
                            <p class="text-center text-muted mt-2 mb-0" style="font-size: 12px;">
                                <i class="fa-solid fa-lock text-success me-1"></i> আপনার তথ্য সম্পূর্ণ সুরক্ষিত ও এনক্রিপ্টেড
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- RIGHT COLUMN: Order Summary (Sticky) -->
            <div class="col-lg-5 col-md-12 order-lg-2 order-1">
                <div class="tea-sticky-summary">
                    <div class="tea-checkout-card">
                        <div class="tea-card-header-styled">
                            <h5>
                                <span class="step-num">২</span>
                                আপনার অর্ডার (Order Summary)
                            </h5>
                            <span class="checkout-summary-badge" id="order_summary_badge">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span id="order_summary_items_count">{{ Cart::instance('shopping')->count() }}</span> টি পণ্য
                            </span>
                        </div>
                        <div class="card-body p-0 cartlist cart_area">
                            <table class="cart_table table mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 12%; text-align: center;">মুছুন</th>
                                        <th style="width: 48%;">পণ্য (Product)</th>
                                        <th style="width: 20%; text-align: center;">পরিমাণ</th>
                                        <th style="width: 20%; text-align: right;">মূল্য</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::instance('shopping')->content() as $value)
                                        <tr>
                                            <td class="text-center">
                                                <a class="cart_remove" data-id="{{ $value->rowId }}" title="Remove item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($value->options->image) }}" class="cart-prod-img" alt="{{ $value->name }}" />
                                                    <div>
                                                        <a href="{{ route('product', $value->options->slug) }}" class="cart-prod-title">
                                                            {{ Str::limit($value->name, 24) }}
                                                        </a>
                                                        @if ($value->options->product_size)
                                                            <div class="cart-variant-tag">সাইজ: {{ $value->options->product_size }}</div>
                                                        @endif
                                                        @if ($value->options->product_color)
                                                            <div class="cart-variant-tag">রঙ: {{ $value->options->product_color }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            @php
                                                $single_product = App\Models\Product::find($value->id);
                                                $single_stock_quantity = $single_product ? $single_product->stock : 0;
                                                $has_variant_size = $value->options->product_size && App\Models\Productsize::where('product_id', $value->id)->where('size', $value->options->product_size)->exists();
                                                if ($has_variant_size) {
                                                    $variant_qty = App\Models\Productsize::where('product_id', $value->id)
                                                        ->where('size', $value->options->product_size)
                                                        ->sum('quantity');
                                                    $available_stock = $variant_qty > 0 ? $variant_qty : $single_stock_quantity;
                                                } else {
                                                    $available_stock = $single_stock_quantity;
                                                }
                                            @endphp
                                            <td class="cart_qty text-center">
                                                <div class="qty-cart vcart-qty d-inline-block">
                                                    <div class="quantity d-inline-flex align-items-center justify-content-between" style="width: 100px !important; height: 36px !important; border: 1.5px solid #d1d5db !important; border-radius: 20px !important; background: #ffffff !important; overflow: hidden !important; margin: 0 auto !important; position: relative !important; box-sizing: border-box !important;">
                                                        <button type="button" class="minus cart_decrement" data-id="{{ $value->rowId }}" style="position: static !important; width: 32px !important; height: 36px !important; border: 0 !important; background: #f3f4f6 !important; color: #111827 !important; font-size: 18px !important; font-weight: 700 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; line-height: 1 !important; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;">-</button>
                                                        <span class="qty-count-display" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; width: 36px !important; height: 36px !important; text-align: center !important; font-size: 15px !important; font-weight: 700 !important; color: #111827 !important; line-height: 1 !important; user-select: none !important; margin: 0 !important; padding: 0 !important; flex-grow: 1 !important;">{{ $value->qty }}</span>
                                                        <input type="hidden" class="cart_qty_input" value="{{ $value->qty }}" />
                                                        <button type="button" class="plus cart_increment" data-id="{{ $value->rowId }}" style="position: static !important; width: 32px !important; height: 36px !important; border: 0 !important; background: #f3f4f6 !important; color: #111827 !important; font-size: 18px !important; font-weight: 700 !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; line-height: 1 !important; padding: 0 !important; margin: 0 !important; flex-shrink: 0 !important;">+</button>
                                                    </div>
                                                </div>
                                                @if ($available_stock < $value->qty)
                                                    <div class="mt-1 d-flex justify-content-center">
                                                        <span class="stock-out-badge bg-danger text-white" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; background-color: #dc2626 !important; color: #ffffff !important; font-size: 11px !important; font-weight: 700 !important; line-height: 1 !important; padding: 4px 10px !important; border-radius: 12px !important; white-space: nowrap !important; width: auto !important; height: auto !important; min-width: 62px !important; text-align: center !important; box-shadow: 0 1px 3px rgba(220, 38, 38, 0.25) !important;">স্টক শেষ</span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <span class="alinur">৳ </span><strong>{{ $value->price * $value->qty }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">সাবটোটাল (Subtotal)</th>
                                        <td class="text-end">
                                            <span id="net_total"><span class="alinur">৳ </span><strong>{{ $subtotal }}</strong></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">ডিসকাউন্ট (Discount)</th>
                                        <td class="text-end text-success">
                                            <span id="discount_amount"><span class="alinur">৳ </span><strong id="discount">00</strong></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">ডেলিভারি চার্জ (Delivery Charge)</th>
                                        <td class="text-end">
                                            <span id="cart_shipping_cost"><span class="alinur">৳ </span><strong>{{ $shipping }}</strong></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end">সর্বমোট (Grand Total)</th>
                                        <td class="text-end">
                                            <span id="grand_total"><span class="alinur">৳ </span><strong>{{ $subtotal + $shipping }}</strong></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Coupon Card -->
                    <div class="tea-checkout-card">
                        <div class="tea-card-body-styled">
                            <label for="coupon" class="tea-form-label mb-2">কুপন কোড থাকলে প্রয়োগ করুন</label>
                            <div class="tea-coupon-box">
                                <input type="text" id="coupon" name="coupon" class="tea-coupon-input" placeholder="কুপন কোড লিখুন..." />
                                <input type="hidden" id="hidden_coupon" value="00" />
                                <button class="tea-coupon-btn" id="applyCoupon" type="button">প্রয়োগ</button>
                            </div>
                            <strong id="error" class="d-block mt-2" style="font-size: 13px;"></strong>
                        </div>
                    </div>

                    @if ($partial_payment)
                        <div class="tea-checkout-card">
                            <div class="tea-card-body-styled">
                                <div class="alert alert-warning m-0" style="font-size: 13px;">
                                    <strong>নোট:</strong> প্রি-বুকিং এর জন্য এখন আপনাকে {{ $partial_payment }} টাকা অগ্রিম পরিশোধ করতে হবে। বাকি {{ $subtotal - $partial_payment }} টাকা + ডেলিভারি চার্জ পণ্য হাতে পাওয়ার পর পরিশোধ করবেন।
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Direct Help Box -->
                    <div class="tea-help-box">
                        <div class="tea-help-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div>অর্ডার করতে অসুবিধা হলে কল করুন:</div>
                            <a href="tel:{{ $contact->hotline }}" style="font-size: 15px;">{{ $contact->hotline }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script src="{{ asset('public/frontEnd/js/select2.min.js') }}"></script>
<script>
    $('#applyCoupon').on('click', function() {
        var couponCode = $('#coupon').val();
        if (!couponCode) {
            $('#error').html('Please enter a coupon code!').css('color', 'red');
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ route('coupon.apply') }}',
            type: 'POST',
            data: {
                coupon: couponCode,
                amount: Number("<?php echo $subtotal; ?>"),
            },
            success: function(response) {
                var shipping = {{ $shipping }};
                if (response.success == true) {
                    $('#discount').html(response.discount);
                    $('#hidden_coupon').val(response.discount);
                    $('#hidden_couponId').val(response.id);
                    $('#grand_total > strong').html(parseInt(response.amount) + parseInt(shipping));
                    $('#error').html(response.message).css('color', 'green');
                } else {
                    $('#error').html(response.message).css('color', 'red');
                }
            },
            error: function(xhr, status, error) {
                $('#error').html(error).css('color', 'red');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(".select2").select2();

        // Payment method card selection active class
        $('.tea-payment-card input[type="radio"]').on('change', function() {
            $('.tea-payment-card').removeClass('active');
            $(this).closest('.tea-payment-card').addClass('active');
        });
    });
</script>

<script>
    function checkStockState() {
        if ($('.cart_qty .bg-danger').length > 0) {
            $('.order_place').prop('disabled', true);
        } else {
            $('.order_place').prop('disabled', false);
        }
    }

    $("#area").on("change", function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            data: {
                id: id,
                discount: $('#hidden_coupon').val(),
            },
            url: "{{ route('shipping.charge') }}",
            dataType: "html",
            success: function(response) {
                $(".cartlist").html(response);
                checkStockState();
            },
        });
    });
</script>

<script type="text/javascript">
    dataLayer.push({ ecommerce: null });
    dataLayer.push({
        event: "view_cart",
        ecommerce: {
            currency: "BDT",
            value: Number("<?php echo $subtotal; ?>"),
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: Number("<?php echo $cartInfo->id; ?>"),
                        price: Number("<?php echo $cartInfo->price; ?>"),
                        item_brand: "{{ $cartInfo->options->brands }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });
</script>

<script type="text/javascript">
    dataLayer.push({ ecommerce: null });
    dataLayer.push({
        event: "begin_checkout",
        client_ip_address: "{{ request()->ip() }}",
        client_user_agent: navigator.userAgent,
        user_data: {
            address: {
                postal_code: "{{ old('postal_code') }}"
            }
        },
        ecommerce: {
            currency: "BDT",
            value: Number("<?php echo $subtotal; ?>"),
            items: [
                @foreach (Cart::instance('shopping')->content() as $cartInfo)
                    {
                        item_name: "{{ $cartInfo->name }}",
                        item_id: Number("<?php echo $cartInfo->id; ?>"),
                        price: Number("<?php echo $cartInfo->price; ?>"),
                        item_brand: "{{ $cartInfo->options->brands }}",
                        item_category: "{{ $cartInfo->options->category }}",
                        item_size: "{{ $cartInfo->options->size }}",
                        item_color: "{{ $cartInfo->options->color }}",
                        currency: "BDT",
                        quantity: {{ $cartInfo->qty ?? 0 }}
                    },
                @endforeach
            ]
        }
    });

    $('#postal_code').on('change blur', function() {
        var zip = $(this).val().trim();
        if (zip) {
            dataLayer.push({
                event: "user_data_update",
                postal_code: zip,
                user_data: {
                    address: {
                        postal_code: zip
                    }
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        checkStockState();

        // Phone number input cleanup
        $('#phone').on('input', function() {
            var val = $(this).val().replace(/[^0-9]/g, '');
            if (val.startsWith('880')) {
                val = val.substring(2);
            }
            $(this).val(val);
        });

        // Ensure Place Order button validates and submits reliably with GTM
        var orderSubmitting = false;
        $('#checkout_order_form').on('submit', function(e) {
            if (orderSubmitting) return;
            orderSubmitting = true;

            var form = this;
            setTimeout(function() {
                try {
                    HTMLFormElement.prototype.submit.call(form);
                } catch (err) {
                    form.submit();
                }
            }, 1200);
        });

        $('#Checkout_orderPlace').on('click', function(e) {
            var form = document.getElementById('checkout_order_form');
            if (!form) return;

            if (!form.checkValidity()) {
                form.reportValidity();
                e.preventDefault();
                return false;
            }
        });
    });
</script>
@endpush
