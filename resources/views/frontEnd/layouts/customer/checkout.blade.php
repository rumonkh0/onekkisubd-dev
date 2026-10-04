@extends('frontEnd.layouts.master')
@section('title', 'চেকআউট - অর্ডার সম্পন্ন করুন | ' . $generalsetting->name)

@push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}" />
<style>
    /* ==========================================================================
       CLEAN TEA CHECKOUT THEME WITH FULL-PAGE FLOATING LEAVES
       ========================================================================== */
    :root {
        --tea-dark: #0f2c1f;
        --tea-green: #173f2c;
        --tea-green-light: #245a2d;
        --tea-accent: #2e7d32;
        --tea-bg-circle: #eaf3ed;
        --tea-bg-page: #f8faf7;
        --tea-card-bg: #ffffff;
        --tea-border: #e8ede6;
        --tea-border-focus: #173f2c;
        --tea-muted: #6b7280;
        --tea-gold: #cdb06a;
        --font-serif: "Playfair Display", Georgia, serif;
        --font-bn: "SolaimanLipi", "Solaiman Lipi", "Hind Siliguri", "Poppins", sans-serif;
    }

    .tea-clean-checkout-page {
        background-color: var(--tea-bg-page);
        background-image: 
            radial-gradient(at 10% 10%, rgba(36, 90, 45, 0.05) 0px, transparent 50%),
            radial-gradient(at 90% 90%, rgba(205, 176, 106, 0.05) 0px, transparent 50%);
        padding: 40px 0 90px;
        min-height: 90vh;
        font-family: var(--font-bn);
        color: #1f2937;
        position: relative;
        overflow: hidden;
    }

    /* Full-page Floating Leaves Background */
    .tea-floating-leaves-container {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: 1;
    }
    .tea-floating-leaf {
        position: absolute;
        pointer-events: none;
        will-change: transform;
    }
    .tea-leaf-1 {
        top: 30px;
        left: -15px;
        width: 80px;
        height: 80px;
        opacity: 0.75;
        transform: rotate(155deg);
        animation: teaFloat1 9s ease-in-out infinite;
    }
    .tea-leaf-2 {
        top: 50px;
        right: 2%;
        width: 65px;
        height: 65px;
        opacity: 0.70;
        transform: rotate(-30deg);
        animation: teaFloat2 12s ease-in-out infinite 1s;
    }
    .tea-leaf-3 {
        top: 24%;
        left: 1%;
        width: 55px;
        height: 55px;
        opacity: 0.65;
        transform: rotate(45deg);
        animation: teaFloat3 8.5s ease-in-out infinite 2s;
    }
    .tea-leaf-4 {
        top: 36%;
        right: 1.5%;
        width: 85px;
        height: 85px;
        opacity: 0.80;
        transform: rotate(200deg);
        animation: teaFloat1 13s ease-in-out infinite 0.5s;
    }
    .tea-leaf-5 {
        top: 54%;
        left: 2%;
        width: 60px;
        height: 60px;
        opacity: 0.65;
        transform: rotate(-65deg);
        animation: teaFloat2 10.5s ease-in-out infinite 3s;
    }
    .tea-leaf-6 {
        top: 68%;
        right: 2.5%;
        width: 72px;
        height: 72px;
        opacity: 0.75;
        transform: rotate(110deg);
        animation: teaFloat3 11s ease-in-out infinite 1.5s;
    }
    .tea-leaf-7 {
        bottom: 60px;
        left: 2.5%;
        width: 68px;
        height: 68px;
        opacity: 0.70;
        transform: rotate(35deg);
        animation: teaFloat1 10s ease-in-out infinite 2.5s;
    }
    .tea-leaf-8 {
        bottom: 45px;
        right: 3%;
        width: 82px;
        height: 82px;
        opacity: 0.80;
        transform: rotate(165deg);
        animation: teaFloat2 14s ease-in-out infinite 4s;
    }
    .tea-leaf-9 {
        top: 48%;
        left: 48%;
        width: 46px;
        height: 46px;
        opacity: 0.35;
        transform: rotate(85deg);
        animation: teaFloat1 15s ease-in-out infinite 2s;
    }

    @keyframes teaFloat1 {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-18px) rotate(6deg);
        }
    }
    @keyframes teaFloat2 {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-24px) rotate(-8deg);
        }
    }
    @keyframes teaFloat3 {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-15px) rotate(10deg);
        }
    }

    /* Container content elevated above floating leaves */
    .tea-clean-checkout-page > .container {
        position: relative;
        z-index: 2;
    }

    /* Cards */
    .tea-checkout-clean-card {
        background: var(--tea-card-bg);
        border: 1px solid var(--tea-border);
        border-radius: 18px;
        box-shadow: 0 4px 20px -2px rgba(15, 44, 31, 0.04);
        padding: 26px 28px;
        margin-bottom: 22px;
        transition: box-shadow 0.25s ease;
    }
    .tea-checkout-clean-card:hover {
        box-shadow: 0 8px 28px -4px rgba(15, 44, 31, 0.06);
    }

    /* Card Header Group */
    .tea-clean-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 1px solid #f1f4ee;
    }
    .tea-clean-icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--tea-bg-circle);
        color: var(--tea-green);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .tea-clean-card-title {
        font-family: var(--font-serif);
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.25;
    }
    .tea-clean-card-sub {
        font-size: 13px;
        color: var(--tea-muted);
        margin: 3px 0 0;
        line-height: 1.4;
    }
    .tea-clean-badge-pill {
        background: var(--tea-bg-circle);
        color: var(--tea-green);
        font-size: 12px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    /* Clean Input Fields */
    .tea-form-group {
        margin-bottom: 16px;
    }
    .tea-clean-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 7px;
    }
    .tea-clean-label i {
        font-size: 12px;
        color: var(--tea-green);
    }
    .tea-input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }
    .tea-input-prefix-icon {
        position: absolute;
        left: 14px;
        color: #9ca3af;
        font-size: 14px;
        pointer-events: none;
        z-index: 2;
    }
    .tea-clean-control {
        width: 100%;
        padding: 11px 14px 11px 40px;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
        font-size: 13.5px;
        color: #111827;
        font-family: var(--font-bn);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .tea-clean-control:focus {
        border-color: var(--tea-border-focus);
        outline: none;
        box-shadow: 0 0 0 3.5px rgba(23, 63, 44, 0.08);
    }
    .tea-clean-control::placeholder {
        color: #9ca3af;
        font-size: 13px;
    }
    .tea-input-with-icon.is-textarea {
        align-items: flex-start;
    }
    .tea-input-with-icon.is-textarea .tea-input-prefix-icon {
        top: 13px;
    }
    textarea.tea-clean-control {
        padding-top: 10px;
        resize: vertical;
        min-height: 72px;
    }
    .select2-container--default .select2-selection--single {
        border: 1.5px solid #e5e7eb !important;
        border-radius: 10px !important;
        height: 44px !important;
        padding-left: 32px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 42px !important;
        color: #111827 !important;
        font-size: 13.5px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px !important;
        right: 10px !important;
    }

    /* Payment Methods Grid */
    .tea-clean-payment-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-top: 8px;
    }
    @media (max-width: 575px) {
        .tea-clean-payment-grid {
            grid-template-columns: 1fr;
        }
    }
    .tea-clean-payment-card {
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        padding: 15px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        margin: 0;
        user-select: none;
    }
    .tea-clean-payment-card:hover {
        border-color: var(--tea-gold);
    }
    .tea-clean-payment-card.active {
        border-color: var(--tea-green);
        background: #fafcf9;
        box-shadow: 0 3px 12px rgba(23, 63, 44, 0.08);
    }
    .tea-clean-payment-card input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: var(--tea-green);
        cursor: pointer;
        margin: 0;
        flex-shrink: 0;
    }
    .tea-pay-icon-box {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #f4f8f4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: var(--tea-green);
        flex-shrink: 0;
    }
    .tea-clean-payment-card.active .tea-pay-icon-box {
        background: var(--tea-green);
        color: #ffffff;
    }
    .tea-pay-info {
        flex-grow: 1;
    }
    .tea-pay-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.3;
    }
    .tea-pay-subtitle {
        font-size: 11.5px;
        color: var(--tea-muted);
        margin: 2px 0 0;
        line-height: 1.3;
    }

    /* Place Order CTA Button */
    .tea-btn-place-order {
        width: 100%;
        background: var(--tea-green);
        color: #ffffff !important;
        border: 0;
        border-radius: 10px;
        padding: 15px 24px;
        font-size: 15.5px;
        font-weight: 700;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(23, 63, 44, 0.22);
        transition: all 0.25s ease;
        margin-top: 22px;
        text-decoration: none !important;
        text-transform: uppercase;
    }
    .tea-btn-place-order:hover {
        background: #0f2c1f;
        transform: translateY(-2px);
        box-shadow: 0 6px 22px rgba(23, 63, 44, 0.32);
        color: #ffffff !important;
    }
    .tea-btn-place-order:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none;
    }
    .tea-btn-place-order i,
    .tea-btn-place-order svg {
        font-size: 15px;
        color: #ffffff;
    }

    /* Legal Security Disclaimer */
    .tea-checkout-legal {
        text-align: center;
        margin-top: 14px;
        font-size: 12px;
        color: #6b7280;
        line-height: 1.5;
    }
    .tea-checkout-legal a {
        color: var(--tea-green) !important;
        font-weight: 700;
        text-decoration: none;
    }
    .tea-checkout-legal a:hover {
        text-decoration: underline;
    }

    /* Sticky Right Summary */
    @media (min-width: 992px) {
        .tea-sticky-summary {
            position: sticky;
            top: 90px;
        }
    }

    /* Products Table Styles */
    .tea-clean-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 18px;
    }
    .tea-clean-table th {
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        padding: 8px 6px;
        border-bottom: 1.5px solid #f0f2ed;
        letter-spacing: 0.3px;
    }
    .tea-clean-table td {
        padding: 13px 6px;
        vertical-align: middle;
        border-bottom: 1px solid #f6f8f5;
    }
    .tea-clean-prod-thumb {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #f0f2ed;
        background: #fbfbfb;
        flex-shrink: 0;
    }
    .tea-clean-prod-info {
        flex-grow: 1;
    }
    .tea-clean-prod-name {
        font-size: 13.5px;
        font-weight: 700;
        color: #111827;
        line-height: 1.35;
        text-decoration: none;
        display: block;
    }
    .tea-clean-prod-name:hover {
        color: var(--tea-green);
    }
    .tea-clean-prod-variant {
        font-size: 11px;
        color: var(--tea-muted);
        margin-top: 2px;
    }

    /* Compact Stepper */
    .tea-clean-stepper {
        display: inline-flex;
        align-items: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #ffffff;
        padding: 2px 4px;
        height: 32px;
    }
    .tea-clean-stepper-btn {
        width: 25px;
        height: 25px;
        border: 0;
        background: transparent;
        color: #4b5563;
        font-size: 16px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border-radius: 5px;
        transition: background 0.15s, color 0.15s;
        line-height: 1;
        padding: 0;
        box-shadow: none;
    }
    .tea-clean-stepper-btn:hover {
        background: #f3f4f6;
        color: var(--tea-green);
    }
    .tea-clean-stepper-val {
        width: 28px;
        text-align: center;
        font-size: 13.5px;
        font-weight: 700;
        color: #111827;
        user-select: none;
    }
    .tea-price-col {
        font-size: 13px;
        color: #4b5563;
        white-space: nowrap;
    }
    .tea-total-col {
        font-size: 13.5px;
        color: #111827;
        white-space: nowrap;
    }
    .tea-clean-remove {
        color: #9ca3af;
        font-size: 14px;
        cursor: pointer;
        padding: 4px;
        transition: color 0.15s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .tea-clean-remove:hover {
        color: #ef4444;
    }

    /* Clean Coupon Wrap */
    .tea-clean-coupon-wrap {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 5px 6px 5px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        transition: border-color 0.2s;
    }
    .tea-clean-coupon-wrap:focus-within {
        border-color: var(--tea-green);
        background: #ffffff;
    }
    .tea-clean-coupon-wrap input {
        border: 0;
        background: transparent;
        outline: none;
        font-size: 13px;
        flex: 1;
        color: #111827;
        font-family: var(--font-bn);
    }
    .tea-btn-coupon-apply {
        background: var(--tea-green);
        color: #ffffff;
        border: 0;
        border-radius: 7px;
        padding: 7px 18px;
        font-size: 12.5px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }
    .tea-btn-coupon-apply:hover {
        background: #0f2c1f;
    }

    /* SUMMARY BREAKDOWN RESETS & ALIGNMENT (PREVENTS COLLAPSE / OVERLAP) */
    .cartlist span,
    .tea-clean-summary-breakdown span,
    .tea-clean-summary-line span,
    .tea-clean-table span {
        height: auto !important;
        width: auto !important;
        max-width: none !important;
        min-width: 0 !important;
        border-radius: 0 !important;
        display: inline !important;
    }
    .tea-clean-summary-breakdown {
        border-top: 1px solid #edf2eb;
        margin-top: 14px;
        padding-top: 12px;
    }
    .tea-clean-summary-line {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 9px 0 !important;
        font-size: 14px !important;
        color: #4b5563 !important;
        line-height: 1.5 !important;
        border-bottom: 1px dashed #f0f2ed !important;
    }
    .tea-clean-summary-line .tea-summary-label {
        font-size: 13.5px !important;
        color: #4b5563 !important;
        white-space: nowrap !important;
        display: inline-block !important;
    }
    .tea-clean-summary-line .tea-summary-value {
        font-size: 14px !important;
        color: #111827 !important;
        font-weight: 700 !important;
        white-space: nowrap !important;
        text-align: right !important;
        display: inline-block !important;
    }
    .tea-clean-summary-line.text-success,
    .tea-clean-summary-line.text-success * {
        color: #16a34a !important;
    }
    .tea-clean-summary-line.total {
        border-top: 2px solid #e2ebe0 !important;
        border-bottom: none !important;
        margin-top: 8px !important;
        padding-top: 16px !important;
        padding-bottom: 4px !important;
    }
    .tea-clean-summary-line.total .tea-summary-label {
        font-size: 16.5px !important;
        font-weight: 800 !important;
        color: var(--tea-green) !important;
    }
    .tea-clean-summary-line.total .tea-summary-value {
        font-size: 21px !important;
        font-weight: 800 !important;
        color: var(--tea-green) !important;
    }
    .tea-clean-summary-line.total strong {
        font-size: 22px !important;
        color: var(--tea-green) !important;
    }

    /* Trust Quality Box */
    .tea-clean-trust-card {
        background: #f4f8f4;
        border: 1px solid #e2ebe3;
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 18px;
    }
    .tea-trust-brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-trust-leaf-icon {
        font-size: 26px;
        color: var(--tea-green);
    }
    .tea-trust-quote-text {
        font-family: var(--font-serif);
        font-style: italic;
        font-weight: 700;
        color: var(--tea-green);
        font-size: 15px;
        line-height: 1.25;
    }
    .tea-trust-badges-row {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .tea-trust-badge-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 4px;
    }
    .tea-badge-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #ffffff;
        border: 1px solid #c9dec4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: var(--tea-green);
        box-shadow: 0 2px 6px rgba(23, 63, 44, 0.05);
    }
    .tea-trust-badge-item span {
        font-size: 11px;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
    }

    /* Helpline Quick Box */
    .tea-clean-help-box {
        background: #ffffff;
        border: 1px dashed #d1decb;
        border-radius: 12px;
        padding: 12px 18px;
        margin-top: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12.5px;
        color: #4b5563;
    }
    .tea-clean-help-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--tea-green);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        flex-shrink: 0;
    }
    .tea-clean-help-box a {
        color: var(--tea-green) !important;
        font-weight: 700;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="tea-clean-checkout-page">
    <!-- ==================== FULL-PAGE FLOATING TEA LEAVES ==================== -->
    <div class="tea-floating-leaves-container" aria-hidden="true">
        <!-- Leaf 1 (Top Left) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-1" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad1)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8M18 46c3-5 5-7 8-10" stroke="#e5efe2" stroke-width="1" stroke-linecap="round" opacity=".7" />
            <defs>
                <linearGradient id="checkoutLeafGrad1" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#245a2d" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Leaf 2 (Top Right) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-2" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad2)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="checkoutLeafGrad2" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#1b4526" />
                    <stop offset="1" stop-color="#468a47" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Leaf 3 (Mid-Upper Left) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-3" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad3)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="checkoutLeafGrad3" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#2f6f37" />
                    <stop offset="1" stop-color="#9fc39a" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Leaf 4 (Mid-Right) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-4" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad4)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8" stroke="#e5efe2" stroke-width="1" stroke-linecap="round" opacity=".7" />
            <defs>
                <linearGradient id="checkoutLeafGrad4" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#173f2c" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Leaf 5 (Mid-Lower Left) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-5" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad5)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="checkoutLeafGrad5" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#245a2d" />
                    <stop offset="1" stop-color="#468a47" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Leaf 6 (Mid-Lower Right) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-6" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad6)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="checkoutLeafGrad6" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#12301b" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Leaf 7 (Bottom Left) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-7" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad7)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="checkoutLeafGrad7" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#1b4526" />
                    <stop offset="1" stop-color="#9fc39a" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Leaf 8 (Bottom Right) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-8" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad8)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8" stroke="#e5efe2" stroke-width="1" stroke-linecap="round" opacity=".7" />
            <defs>
                <linearGradient id="checkoutLeafGrad8" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#245a2d" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <!-- Leaf 9 (Subtle Center Ambient) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-leaf-9" fill="none">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#checkoutLeafGrad9)" />
            <defs>
                <linearGradient id="checkoutLeafGrad9" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#9fc39a" />
                    <stop offset="1" stop-color="#c9dec4" />
                </linearGradient>
            </defs>
        </svg>
    </div>

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

    <div class="container" style="max-width: 1180px;">
        <div class="row g-4 align-items-start">
            <!-- ==================== LEFT COLUMN: Delivery Details & Payment ==================== -->
            <div class="col-lg-7 col-md-12 order-lg-1 order-2">
                <form action="{{ route('customer.ordersave') }}" method="POST" id="checkout_order_form">
                    @csrf
                    <input type="hidden" name="paid_partial_payment_amount" value="{{ $partial_payment }}">
                    <input type="hidden" id="hidden_couponId" name="couponId" value="">
                    <input type="hidden" id="hidden_coupon" value="00">
                    <input type="hidden" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">

                    <!-- Card 1: Shipping & Delivery Information -->
                    <div class="tea-checkout-clean-card">
                        <div class="tea-clean-card-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="tea-clean-icon-circle">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>
                                <div>
                                    <h2 class="tea-clean-card-title">শিপিং ও ডেলিভারি তথ্য</h2>
                                    <p class="tea-clean-card-sub">আপনার অর্ডারটি সঠিকভাবে পৌঁছানোর জন্য নিচের তথ্যগুলো পূরণ করুন</p>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <!-- Full Name -->
                            <div class="col-sm-6">
                                <div class="tea-form-group mb-0">
                                    <label for="name" class="tea-clean-label">
                                        <i class="fa-regular fa-user"></i> আপনার পূর্ণ নাম *
                                    </label>
                                    <div class="tea-input-with-icon">
                                        <i class="fa-regular fa-user tea-input-prefix-icon"></i>
                                        <input type="text" id="name" name="name"
                                            class="tea-clean-control @error('name') is-invalid @enderror"
                                            value="@if ($customer) {{ $customer->name }} @endif"
                                            placeholder="আপনার পূর্ণ নাম লিখুন" required />
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-sm-6">
                                <div class="tea-form-group mb-0">
                                    <label for="phone" class="tea-clean-label">
                                        <i class="fa-solid fa-phone"></i> মোবাইল নম্বর *
                                    </label>
                                    <div class="tea-input-with-icon">
                                        <i class="fa-solid fa-phone tea-input-prefix-icon"></i>
                                        <input type="tel" minlength="11" maxlength="11" id="phone" name="phone"
                                            class="tea-clean-control @error('phone') is-invalid @enderror"
                                            value="@if ($customer) {{ $customer->phone }} @endif"
                                            placeholder="01XXXXXXXXX" required />
                                    </div>
                                    @error('phone')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- City / District -->
                            <div class="col-12">
                                <div class="tea-form-group mb-0">
                                    <label class="tea-clean-label">
                                        <i class="fa-solid fa-location-dot"></i> জেলা (City / District) *
                                    </label>
                                    <div class="tea-input-with-icon">
                                        <i class="fa-solid fa-location-dot tea-input-prefix-icon"></i>
                                        <select class="tea-clean-control city @error('city') is-invalid @enderror" name="city" required>
                                            <option value="" disabled selected>আপনার জেলা সিলেক্ট করুন</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('city')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <div class="tea-form-group mb-0">
                                    <label for="address" class="tea-clean-label">
                                        <i class="fa-solid fa-house"></i> সম্পূর্ণ ঠিকানা (বাসা, রোড, এলাকা) *
                                    </label>
                                    <div class="tea-input-with-icon">
                                        <i class="fa-solid fa-location-arrow tea-input-prefix-icon"></i>
                                        <input type="text" id="address" name="address"
                                            class="tea-clean-control @error('address') is-invalid @enderror"
                                            value="@if ($customer) {{ $customer->address }} @endif"
                                            placeholder="সম্পূর্ণ ঠিকানা লিখুন (যেমন: বাসা নং, রোড নং, থানা, জেলা)" required />
                                    </div>
                                    @error('address')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Delivery Area / Shipping Charge -->
                            <div class="col-12">
                                <div class="tea-form-group mb-0">
                                    <label for="area" class="tea-clean-label">
                                        <i class="fa-solid fa-truck-ramp-box"></i> ডেলিভারি এরিয়া সিলেক্ট করুন *
                                    </label>
                                    <div class="tea-input-with-icon">
                                        <i class="fa-solid fa-map-location-dot tea-input-prefix-icon"></i>
                                        <select id="area" class="tea-clean-control @error('area') is-invalid @enderror" name="area" required>
                                            <option value="">ডেলিভারি এরিয়া সিলেক্ট করুন</option>
                                            @foreach ($shippingcharge as $key => $value)
                                                <option value="{{ $value->id }}" {{ $loop->first ? 'selected' : '' }}>
                                                    {{ $value->name }} (৳ {{ $value->amount }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('area')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Order Note (Optional) -->
                            <div class="col-12">
                                <div class="tea-form-group mb-0">
                                    <label for="note" class="tea-clean-label">
                                        <i class="fa-regular fa-pen-to-square"></i> অর্ডার নোট (ঐচ্ছিক)
                                    </label>
                                    <div class="tea-input-with-icon is-textarea">
                                        <i class="fa-regular fa-pen-to-square tea-input-prefix-icon"></i>
                                        <textarea id="note" name="note" class="tea-clean-control" rows="2"
                                            placeholder="ডেলিভারি সম্পর্কে বিশেষ কোনো নির্দেশনা থাকলে লিখুন...">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Payment Method -->
                    <div class="tea-checkout-clean-card">
                        <div class="tea-clean-card-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="tea-clean-icon-circle">
                                    <i class="fa-regular fa-credit-card"></i>
                                </div>
                                <div>
                                    <h3 class="tea-clean-card-title">পেমেন্ট পদ্ধতি</h3>
                                    <p class="tea-clean-card-sub">আপনার সুবিধাজনক পেমেন্ট মাধ্যম বেছে নিন</p>
                                </div>
                            </div>
                        </div>

                        <div class="tea-clean-payment-grid">
                            @if (!$partial_payment || $partial_payment == 0)
                                <label class="tea-clean-payment-card active p_cash" for="inlineRadio1">
                                    <input type="radio" name="payment_method" id="inlineRadio1" value="Cash On Delivery" checked required />
                                    <div class="tea-pay-icon-box">
                                        <i class="fa-solid fa-hand-holding-dollar"></i>
                                    </div>
                                    <div class="tea-pay-info">
                                        <h6 class="tea-pay-title">ক্যাশ অন ডেলিভারি</h6>
                                        <p class="tea-pay-subtitle">পণ্য হাতে পেয়ে মূল্য দিন</p>
                                    </div>
                                </label>
                            @endif

                            @if ($bkash_gateway || $shurjopay_gateway)
                                <label class="tea-clean-payment-card p_online" for="inlineRadio2">
                                    <input type="radio" name="payment_method" id="inlineRadio2"
                                        value="{{ $bkash_gateway ? 'bkash' : 'shurjopay' }}"
                                        @if ($partial_payment) checked @endif required />
                                    <div class="tea-pay-icon-box" style="color: #d12053;">
                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                    </div>
                                    <div class="tea-pay-info">
                                        <h6 class="tea-pay-title">অনলাইন পেমেন্ট</h6>
                                        <p class="tea-pay-subtitle">বিকাশ / নগদ / কার্ড</p>
                                    </div>
                                </label>
                            @else
                                <div class="tea-clean-payment-card" style="opacity: 0.6; cursor: not-allowed;">
                                    <input type="radio" disabled />
                                    <div class="tea-pay-icon-box">
                                        <i class="fa-regular fa-credit-card"></i>
                                    </div>
                                    <div class="tea-pay-info">
                                        <h6 class="tea-pay-title">অনলাইন পেমেন্ট</h6>
                                        <p class="tea-pay-subtitle">শীঘ্রই আসছে</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Place Order Button -->
                        <button class="order_place tea-btn-place-order" id="Checkout_orderPlace" type="submit">
                            <i class="fa-solid fa-lock"></i>
                            <span>অর্ডার নিশ্চিত করুন &nbsp;➔</span>
                        </button>

                        <!-- Legal Agreement Text -->
                        <div class="tea-checkout-legal">
                            <i class="fa-solid fa-shield-halved text-muted me-1"></i>
                            অর্ডার নিশ্চিত করার মাধ্যমে আপনি আমাদের
                            <a href="{{ url('page/terms-conditions') }}">শর্তাবলী</a> ও
                            <a href="{{ url('page/privacy-policy') }}">গোপনীয়তা নীতি</a> মেনে নিচ্ছেন।
                        </div>
                    </div>
                </form>
            </div>

            <!-- ==================== RIGHT COLUMN: Order Summary & Trust ==================== -->
            <div class="col-lg-5 col-md-12 order-lg-2 order-1">
                <div class="tea-sticky-summary">
                    <!-- Order Summary Card -->
                    <div class="tea-checkout-clean-card">
                        <div class="tea-clean-card-header">
                            <div class="d-flex align-items-center gap-3">
                                <div class="tea-clean-icon-circle">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <div>
                                    <h3 class="tea-clean-card-title">অর্ডার সারাংশ</h3>
                                    <p class="tea-clean-card-sub">অর্ডার করার পূর্বে পণ্যগুলো যাচাই করে নিন</p>
                                </div>
                            </div>
                            <span class="tea-clean-badge-pill" id="order_summary_badge">
                                <span id="order_summary_items_count">{{ Cart::instance('shopping')->count() }}</span> টি আইটেম
                            </span>
                        </div>

                        <!-- Products, Coupon & Breakdown inside .cartlist -->
                        <div class="cartlist cart_area">
                            @include('frontEnd.layouts.ajax.cart')
                        </div>
                    </div>

                    <!-- Trust & Quality Box -->
                    <div class="tea-clean-trust-card">
                        <div class="tea-trust-brand">
                            <i class="fa-solid fa-leaf tea-trust-leaf-icon"></i>
                            <div class="tea-trust-quote-text">
                                A Better You<br>With Every Cup
                            </div>
                        </div>
                        <div class="tea-trust-badges-row">
                            <div class="tea-trust-badge-item">
                                <div class="tea-badge-circle">
                                    <i class="fa-solid fa-leaf"></i>
                                </div>
                                <span>১০০% প্রাকৃতিক</span>
                            </div>
                            <div class="tea-trust-badge-item">
                                <div class="tea-badge-circle">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>
                                <span>দ্রুত ডেলিভারি</span>
                            </div>
                            <div class="tea-trust-badge-item">
                                <div class="tea-badge-circle">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>
                                <span>নিরাপদ পেমেন্ট</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pre-booking Alert if applicable -->
                    @if ($partial_payment)
                        <div class="alert alert-warning mt-3 border-0 rounded-3 shadow-sm" style="font-size: 13px; background: #fffbeb; color: #92400e;">
                            <strong>প্রি-বুকিং নোট:</strong> অগ্রিম পরিশোধ করতে হবে <span class="font-bengali">৳</span> {{ number_format($partial_payment, 0) }}। অবশিষ্ট <span class="font-bengali">৳</span> {{ number_format($subtotal - $partial_payment, 0) }} + ডেলিভারি চার্জ পণ্য হাতে পেয়ে পরিশোধ করবেন।
                        </div>
                    @endif

                    <!-- Helpline Box -->
                    <div class="tea-clean-help-box">
                        <div class="tea-clean-help-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div>অর্ডার করতে সহায়তা প্রয়োজন হলে কল করুন:</div>
                            <a href="tel:{{ $contact->hotline }}" style="font-size: 14.5px;">{{ $contact->hotline }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('public/frontEnd/js/select2.min.js') }}"></script>
<script>
    // Delegated Coupon Apply Handler
    $(document).on('click', '#applyCoupon', function() {
        var couponCode = $('#coupon').val();
        if (!couponCode) {
            $('#error').html('অনুগ্রহ করে কুপন কোড লিখুন!').css('color', '#dc2626');
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
                var shipping = parseInt($('#cart_shipping_cost strong').text().replace(/[^0-9]/g, '')) || 0;
                if (response.success == true) {
                    $('#discount').html(response.discount);
                    $('#hidden_coupon').val(response.discount);
                    $('#hidden_couponId').val(response.id);
                    $('#grand_total strong').html(parseInt(response.amount) + shipping);
                    $('#error').html(response.message).css('color', '#16a34a');
                } else {
                    $('#error').html(response.message).css('color', '#dc2626');
                }
            },
            error: function(xhr, status, error) {
                $('#error').html(error).css('color', '#dc2626');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(".select2").select2();

        // Payment method card selection active class
        $(document).on('change', '.tea-clean-payment-card input[type="radio"]', function() {
            $('.tea-clean-payment-card').removeClass('active');
            $(this).closest('.tea-clean-payment-card').addClass('active');
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

        // Phone number input cleanup (11 digits, strip 880)
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
