@extends('frontEnd.layouts.master')
@section('title', 'Contact Us - OnekkisuBD')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CONTACT PAGE (MATCHING POLICY DESIGN SYSTEM)
       ======================================================== */
    .tea-policy-wrapper {
        background: #fbfbf9;
        background-image: 
            radial-gradient(circle at 10% 15%, rgba(39, 90, 56, 0.04) 0%, rgba(251, 251, 249, 0) 50%),
            radial-gradient(circle at 90% 10%, rgba(39, 90, 56, 0.05) 0%, rgba(251, 251, 249, 0) 45%),
            radial-gradient(circle at 50% 100%, rgba(39, 90, 56, 0.03) 0%, rgba(251, 251, 249, 0) 60%);
        min-height: calc(100vh - 200px);
        padding-bottom: 70px;
        color: #2b3831;
        font-family: 'Poppins', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* --------------------------------------------------------
       1. TOP SUB-NAV BAR (Tabs)
       -------------------------------------------------------- */
    .tea-subnav-bar {
        background: #ffffff;
        border-bottom: 1px solid #edf1eb;
        box-shadow: 0 2px 10px rgba(15, 40, 26, 0.02);
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .tea-subnav-scroll {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        padding: 0;
        margin: 0;
        list-style: none;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .tea-subnav-scroll::-webkit-scrollbar {
        display: none;
    }
    .tea-subnav-item {
        position: relative;
        display: inline-flex;
        align-items: center;
    }
    .tea-subnav-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 16px 18px;
        font-size: 13.5px;
        font-weight: 500;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.2s ease;
        position: relative;
    }
    .tea-subnav-link i {
        font-size: 14.5px;
        color: #6b7280;
        transition: color 0.2s ease;
    }
    .tea-subnav-link:hover {
        color: #173f2c;
    }
    .tea-subnav-link:hover i {
        color: #275a38;
    }
    .tea-subnav-item.active .tea-subnav-link {
        color: #111827;
        font-weight: 700;
    }
    .tea-subnav-item.active .tea-subnav-link i {
        color: #173f2c;
    }
    .tea-subnav-item.active::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 16px;
        right: 16px;
        height: 3px;
        background: #275a38;
        border-radius: 3px 3px 0 0;
    }
    .tea-subnav-sep {
        color: #e5e7eb;
        font-size: 14px;
        font-weight: 300;
        user-select: none;
    }

    /* --------------------------------------------------------
       2. HERO HEADER SECTION
       -------------------------------------------------------- */
    .tea-hero-section {
        position: relative;
        z-index: 2;
        padding: 48px 16px 75px; /* Increased bottom padding for generous gap matching reference */
        margin-bottom: 28px;
        overflow: hidden;
        text-align: center;
    }
    .tea-hero-container {
        max-width: 1220px;
        margin: 0 auto;
        position: relative;
    }

    /* Floating leaves SVG like homepage */
    .tea-floating-leaf {
        position: absolute;
        pointer-events: none;
        user-select: none;
        z-index: 0;
    }
    .tea-float-1 {
        --leaf-rot: 145deg;
        left: 20%;
        top: 22px;
        width: 48px;
        height: 48px;
        opacity: 0.65;
        animation: teaFloatSlow 10s ease-in-out infinite;
    }
    .tea-float-2 {
        --leaf-rot: -20deg;
        right: 21%;
        top: 26px;
        width: 52px;
        height: 52px;
        opacity: 0.7;
        animation: teaFloat 8s ease-in-out infinite;
        animation-delay: 1.5s;
    }
    .tea-float-3 {
        --leaf-rot: 35deg;
        left: 5%;
        bottom: 30px;
        width: 44px;
        height: 44px;
        opacity: 0.6;
        animation: teaFloat 7s ease-in-out infinite;
        animation-delay: 3s;
    }
    .tea-float-4 {
        --leaf-rot: -45deg;
        right: 6%;
        bottom: 25px;
        width: 46px;
        height: 46px;
        opacity: 0.65;
        animation: teaFloatSlow 12s ease-in-out infinite;
        animation-delay: 2s;
    }
    .tea-float-5 {
        --leaf-rot: 65deg;
        left: 50%;
        bottom: 22px;
        margin-left: -18px;
        width: 36px;
        height: 36px;
        opacity: 0.55;
        animation: teaFloat 9s ease-in-out infinite;
        animation-delay: 4s;
    }

    @keyframes teaFloat {
        0%, 100% {
            transform: translateY(0) rotate(var(--leaf-rot, 0deg));
        }
        50% {
            transform: translateY(-16px) rotate(calc(var(--leaf-rot, 0deg) + 6deg));
        }
    }
    @keyframes teaFloatSlow {
        0%, 100% {
            transform: translateY(0) rotate(var(--leaf-rot, 0deg));
        }
        50% {
            transform: translateY(-22px) rotate(calc(var(--leaf-rot, 0deg) - 8deg));
        }
    }

    /* Realistic Fresh Tea Leaf Branch Accents */
    .tea-leaf-decor {
        position: absolute;
        pointer-events: none;
        user-select: none;
        z-index: 0;
    }
    .tea-leaf-tl {
        top: -65px;
        left: -35px;
        width: 155px;
        transform: rotate(12deg);
        filter: drop-shadow(0 10px 18px rgba(23, 63, 44, 0.08));
        opacity: 0.95;
    }
    .tea-leaf-tr {
        top: -65px;
        right: -35px;
        width: 165px;
        transform: rotate(-30deg);
        filter: drop-shadow(0 10px 18px rgba(23, 63, 44, 0.08));
        opacity: 0.95;
    }
    .tea-leaf-bl {
        bottom: -20px;
        left: -20px;
        width: 110px;
        transform: rotate(-35deg);
        opacity: 0.85;
    }

    /* Handcrafted Script Stamps (Caveat) */
    .tea-script-left {
        position: absolute;
        left: 120px;
        top: 60%;
        transform: translateY(-50%) rotate(-8deg);
        font-family: 'Caveat', cursive;
        font-size: 30px;
        line-height: 1.15;
        font-weight: 600;
        color: #789c7c;
        text-align: left;
        pointer-events: none;
        user-select: none;
        z-index: 3;
    }
    .tea-script-right {
        position: absolute;
        right: 120px;
        top: 60%;
        transform: translateY(-50%) rotate(6deg);
        font-family: 'Caveat', cursive;
        font-size: 28px;
        line-height: 1.15;
        font-weight: 600;
        color: #789c7c;
        text-align: right;
        pointer-events: none;
        user-select: none;
        z-index: 3;
    }
    .tea-script-swoosh {
        display: block;
        margin-top: -4px;
        margin-left: auto;
        width: 110px;
        height: 14px;
    }

    /* Hero Center Typography */
    .tea-hero-content {
        max-width: 780px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .tea-hero-overline {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 10px;
    }
    .tea-overline-line {
        display: inline-block;
        width: 38px;
        height: 1px;
        background: #9ca3af;
    }
    .tea-overline-text {
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 3.5px;
        color: #4b5563;
        text-transform: uppercase;
        font-family: 'Poppins', sans-serif;
    }
    .tea-hero-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 52px;
        line-height: 1.15;
        margin: 0 0 12px;
        letter-spacing: -0.3px;
    }
    .tea-title-main {
        font-weight: 700;
        color: #112a1d;
    }
    .tea-title-accent {
        font-style: italic;
        font-weight: 500;
        color: #275a38;
        margin-left: 8px;
    }
    .tea-hero-subtitle {
        font-size: 15.5px;
        line-height: 1.6;
        color: #4b5563;
        max-width: 660px;
        margin: 0 auto;
        font-weight: 400;
    }

    /* --------------------------------------------------------
       3. CONTACT INFO CARDS & FORM CONTAINER
       -------------------------------------------------------- */
    .tea-cards-container {
        max-width: 1220px;
        margin: 0 auto;
        padding: 0 16px;
        position: relative;
        z-index: 2;
    }
    .tea-contact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 36px;
    }
    .tea-contact-card {
        background: #ffffff;
        border: 1px solid #edf2ec;
        border-radius: 18px;
        padding: 28px 24px 26px;
        box-shadow: 0 4px 20px rgba(15, 40, 26, 0.03);
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        text-align: center;
        align-items: center;
    }
    .tea-contact-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(15, 40, 26, 0.07);
        border-color: #c9dec4;
    }
    .tea-contact-icon-circle {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 16px;
        background: #eaf4eb;
        border: 1.5px solid #d5e8d5;
        color: #275a38;
    }
    .tea-contact-card-title {
        font-size: 19px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 8px;
    }
    .tea-contact-card-desc {
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 16px;
        line-height: 1.55;
    }
    .tea-btn-contact-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 22px;
        background: #f4f7f3;
        border: 1px solid #dbe5da;
        border-radius: 20px;
        font-size: 13.5px;
        font-weight: 600;
        color: #173f2c;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-top: auto;
    }
    .tea-btn-contact-action:hover {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
    }

    /* Message Form Card */
    .tea-form-card {
        background: #ffffff;
        border: 1px solid #edf2ec;
        border-radius: 20px;
        box-shadow: 0 6px 26px rgba(15, 40, 26, 0.04);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto 36px;
    }
    .tea-form-header {
        padding: 28px 36px 20px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #edf1eb;
        text-align: center;
    }
    .tea-form-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 26px;
        font-weight: 700;
        color: #112a1d;
        margin: 0 0 6px;
    }
    .tea-form-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }
    .tea-form-body {
        padding: 32px 36px;
    }
    .tea-field-group {
        margin-bottom: 20px;
    }
    .tea-field-label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 7px;
    }
    .tea-input-ctrl {
        width: 100%;
        height: 48px;
        padding: 0 16px;
        font-size: 14px;
        color: #111827;
        background: #fbfbfb;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.2s ease;
        font-family: inherit;
    }
    .tea-input-ctrl:focus {
        border-color: #275a38;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(39, 90, 56, 0.12);
        outline: none;
    }
    .tea-textarea-ctrl {
        width: 100%;
        height: 120px;
        padding: 14px 16px;
        font-size: 14px;
        color: #111827;
        background: #fbfbfb;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.2s ease;
        font-family: inherit;
        resize: vertical;
    }
    .tea-textarea-ctrl:focus {
        border-color: #275a38;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(39, 90, 56, 0.12);
        outline: none;
    }
    .tea-btn-send {
        width: 100%;
        height: 50px;
        background: #235d39;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 15.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 4px 16px rgba(35, 93, 57, 0.25);
        transition: all 0.22s ease;
    }
    .tea-btn-send:hover {
        background: #173f2c;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(23, 63, 44, 0.3);
        color: #ffffff;
    }

    /* --------------------------------------------------------
       4. BOTTOM PROMISE & TRUST BANNER
       -------------------------------------------------------- */
    .tea-promise-banner {
        background: #f3f7f2;
        border: 1px solid #e1ebe0;
        border-radius: 16px;
        padding: 18px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-top: 36px;
        box-shadow: 0 4px 16px rgba(23, 63, 44, 0.03);
    }
    .tea-promise-col {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .tea-promise-icon {
        font-size: 28px;
        color: #275a38;
        line-height: 1;
    }
    .tea-shield-badge {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #1c452e;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }
    .tea-promise-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0;
        margin: 0;
    }
    .tea-promise-info h4 {
        padding: 0 !important;
        padding-top: 0 !important;
        margin: 0 0 2px 0 !important;
        margin-top: 0 !important;
        font-size: 15.5px;
        font-weight: 700;
        color: #173f2c;
        line-height: 1.15;
    }
    .tea-promise-info p {
        padding: 0 !important;
        margin: 0 !important;
        font-size: 13px;
        color: #6b7280;
        line-height: 1.25;
    }
    .tea-promise-divider {
        width: 1px;
        height: 38px;
        background: #dbe5da;
    }
    .tea-btn-continue-shopping {
        background: #235d39;
        color: #ffffff !important;
        padding: 12px 28px;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.22s ease;
        box-shadow: 0 4px 14px rgba(35, 93, 57, 0.22);
        white-space: nowrap;
    }
    .tea-btn-continue-shopping:hover {
        background: #173f2c;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(23, 63, 44, 0.28);
    }

    @media (max-width: 1100px) {
        .tea-leaf-tl { width: 140px; left: -15px; }
        .tea-leaf-tr { width: 150px; right: -20px; }
        .tea-script-left { left: 1%; font-size: 24px; }
        .tea-script-right { right: 1%; font-size: 22px; }
        .tea-contact-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 900px) {
        .tea-script-left, .tea-script-right { display: none; }
        .tea-promise-banner {
            flex-direction: column;
            align-items: stretch;
            gap: 16px;
            padding: 22px 20px;
        }
        .tea-promise-col {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .tea-promise-banner .tea-promise-col:first-child {
            padding-bottom: 14px;
            border-bottom: 1px solid #e2ebe0;
        }
        .tea-promise-divider { display: none; }
        .tea-promise-action {
            width: 100%;
            margin-top: 2px;
        }
        .tea-btn-continue-shopping {
            width: 100%;
            justify-content: center;
            padding: 12px 20px;
        }
    }

    @media (max-width: 768px) {
        .tea-leaf-decor {
            display: none !important;
        }
    }

    @media (max-width: 640px) {
        .tea-hero-title { font-size: 34px; }
        .tea-hero-subtitle { font-size: 14px; }
        .tea-hero-section { padding: 30px 14px 24px; }
        .tea-leaf-decor { display: none !important; }
        .tea-floating-leaf { display: none !important; }
        .tea-contact-grid { grid-template-columns: 1fr; gap: 16px; }
        .tea-form-header { padding: 22px 18px 16px; }
        .tea-form-body { padding: 22px 18px; }
        .tea-promise-banner { padding: 18px 16px; }
        .tea-promise-info h4 { font-size: 15px; }
        .tea-promise-info p { font-size: 12px; line-height: 1.35; }
    }
</style>

<div class="tea-policy-wrapper">
    <!-- 1. TOP SUB-NAV BAR (Tabs) -->
    <nav class="tea-subnav-bar">
        <div class="container">
            <ul class="tea-subnav-scroll">
                <li class="tea-subnav-item">
                    <a href="{{ route('page', 'order-procedure') }}" class="tea-subnav-link">
                        <i class="fa-regular fa-clipboard"></i>
                        <span>Order Procedure</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item">
                    <a href="{{ route('page', 'delivery-rules') }}" class="tea-subnav-link">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Delivery Rules</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item">
                    <a href="{{ route('page', 'return-policy') }}" class="tea-subnav-link">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span>Return Policy</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item">
                    <a href="{{ route('page', 'terms-&-conditions') }}" class="tea-subnav-link">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>Terms &amp; Conditions</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item">
                    <a href="{{ route('page', 'privacy-policy') }}" class="tea-subnav-link">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Privacy Policy</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item">
                    <a href="{{ route('page', 'about-us') }}" class="tea-subnav-link">
                        <i class="fa-regular fa-user"></i>
                        <span>About Us</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item active">
                    <a href="{{ route('contact') }}" class="tea-subnav-link">
                        <i class="fa-solid fa-phone"></i>
                        <span>Contact Us</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- 2. HERO HEADER SECTION -->
    <header class="tea-hero-section">
        <!-- Floating leaves SVG like homepage -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-1" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#contactLeafGrad1)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8M18 46c3-5 5-7 8-10" stroke="#e5efe2" stroke-width="1" stroke-linecap="round" opacity=".7" />
            <defs>
                <linearGradient id="contactLeafGrad1" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#2f6f37" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-2" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#contactLeafGrad2)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="contactLeafGrad2" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#245a2d" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-3" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#contactLeafGrad3)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="contactLeafGrad3" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#1b4526" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-4" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#contactLeafGrad4)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="contactLeafGrad4" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#2f6f37" />
                    <stop offset="1" stop-color="#88be84" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-5" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#contactLeafGrad5)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="contactLeafGrad5" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#245a2d" />
                    <stop offset="1" stop-color="#468a47" />
                </linearGradient>
            </defs>
        </svg>

        <div class="tea-hero-container">
            <!-- Decorative Green Tea Leaves -->
            <img src="{{ asset('public/frontEnd/images/tea-branch.png') }}" class="tea-leaf-decor tea-leaf-tl" alt="Fresh Tea Leaves" />
            <img src="{{ asset('public/frontEnd/images/tea-branch.png') }}" class="tea-leaf-decor tea-leaf-tr" alt="Fresh Tea Leaves" />
            <img src="{{ asset('public/frontEnd/images/tea-branch.png') }}" class="tea-leaf-decor tea-leaf-bl" alt="Organic Tea Leaf" />

            <!-- Left Script Accent -->
            <div class="tea-script-left">
                Good<br>
                Tea<br>
                Good Life
            </div>

            <!-- Hero Center Title & Subtitle -->
            <div class="tea-hero-content">
                <div class="tea-hero-overline">
                    <span class="tea-overline-line"></span>
                    <span class="tea-overline-text">SHOP WITH CONFIDENCE</span>
                    <span class="tea-overline-line"></span>
                </div>

                <h1 class="tea-hero-title">
                    <span class="tea-title-main">Contact</span>
                    <span class="tea-title-accent">Us</span>
                </h1>

                <p class="tea-hero-subtitle">
                    We are always here to help you. Reach out through call, email, or send us a message anytime.
                </p>
            </div>

            <!-- Right Script Accent -->
            <div class="tea-script-right">
                100%<br>
                Customer<br>
                Satisfaction
                <svg class="tea-script-swoosh" viewBox="0 0 100 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12 Q 50 18, 95 8" stroke="#749b78" stroke-width="2.5" stroke-linecap="round" fill="none" />
                </svg>
            </div>
        </div>
    </header>

    <!-- 3. CONTACT PAGE BODY -->
    <main class="tea-cards-container">
        <!-- 3 Contact Cards -->
        <div class="tea-contact-grid">
            <!-- Hotline Phone -->
            <div class="tea-contact-card">
                <div class="tea-contact-icon-circle">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <h3 class="tea-contact-card-title">Phone &amp; Hotline</h3>
                <p class="tea-contact-card-desc">Call us directly for prompt orders, inquiries, and customer care.</p>
                <a href="tel:{{ $contact->hotline ?? $contact->phone ?? '01850945080' }}" class="tea-btn-contact-action">
                    <i class="fa-solid fa-phone"></i>
                    <span>{{ $contact->hotline ?? $contact->phone ?? '01850945080' }}</span>
                </a>
            </div>

            <!-- WhatsApp Concierge -->
            <div class="tea-contact-card">
                <div class="tea-contact-icon-circle" style="background: #e9fbf0; color: #25d366; border-color: #a7f3d0;">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 class="tea-contact-card-title">WhatsApp Support</h3>
                <p class="tea-contact-card-desc">Message our dedicated tea specialists on WhatsApp for instant assistance.</p>
                <a href="https://wa.me/+88{{ $contact->phone ?? '01850945080' }}?text=Hello%20OnekkisuBD" target="_blank" class="tea-btn-contact-action" style="background:#25d366; color:#ffffff; border-color:#25d366;">
                    <i class="fa-brands fa-whatsapp"></i>
                    <span>Start WhatsApp Chat</span>
                </a>
            </div>

            <!-- Office & Email -->
            <div class="tea-contact-card">
                <div class="tea-contact-icon-circle" style="background: #fffbeb; color: #b45309; border-color: #fde68a;">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3 class="tea-contact-card-title">Office &amp; Email</h3>
                <p class="tea-contact-card-desc">{{ $contact->address ?? 'Jashore, Bangladesh' }}</p>
                <a href="mailto:{{ $contact->email ?? 'onekkisuponno@gmail.com' }}" class="tea-btn-contact-action">
                    <i class="fa-regular fa-envelope"></i>
                    <span>{{ $contact->email ?? 'onekkisuponno@gmail.com' }}</span>
                </a>
            </div>
        </div>

        <!-- Contact Form Card -->
        <div class="tea-form-card">
            <div class="tea-form-header">
                <h2 class="tea-form-title">Send Us a Message</h2>
                <p class="tea-form-subtitle">Fill in the form below and our tea support team will get back to you shortly.</p>
            </div>

            <div class="tea-form-body">
                <form action="{{ route('home') }}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="" id="contact_message_form">
                    @csrf
                    <div class="col-md-6">
                        <div class="tea-field-group">
                            <label for="name" class="tea-field-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="tea-input-ctrl @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Your Full Name" required data-parsley-required-message="Please enter your name">
                            @error('name')
                                <span class="text-danger small" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="tea-field-group">
                            <label for="phone" class="tea-field-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" id="phone" class="tea-input-ctrl @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required data-parsley-required-message="Please enter phone number">
                            @error('phone')
                                <span class="text-danger small" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="tea-field-group">
                            <label for="email" class="tea-field-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" id="email" class="tea-input-ctrl @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="you@example.com" required data-parsley-required-message="Please enter valid email">
                            @error('email')
                                <span class="text-danger small" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="tea-field-group">
                            <label for="subject" class="tea-field-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" id="subject" class="tea-input-ctrl @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" placeholder="Subject of your message" required data-parsley-required-message="Please enter subject">
                            @error('subject')
                                <span class="text-danger small" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="tea-field-group">
                            <label for="message" class="tea-field-label">Your Message <span class="text-danger">*</span></label>
                            <textarea id="message" class="tea-textarea-ctrl @error('message') is-invalid @enderror" name="message" placeholder="Type your inquiry or message here..." required data-parsley-required-message="Please write your message">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="text-danger small" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="tea-btn-send">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Send Message</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 4. BOTTOM PROMISE & TRUST BANNER -->
        <div class="tea-promise-banner">
            <!-- Left: Our Promise -->
            <div class="tea-promise-col">
                <div class="tea-shield-badge">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <div class="tea-promise-info">
                    <h4>Our Promise</h4>
                    <p>Quality Products &nbsp;|&nbsp; Honest Service &nbsp;|&nbsp; Happy Customers</p>
                </div>
            </div>

            <!-- Divider -->
            <div class="tea-promise-divider"></div>

            <!-- Middle: Shop with Confidence -->
            <div class="tea-promise-col">
                <div class="tea-shield-badge">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="tea-promise-info">
                    <h4>Shop with Confidence</h4>
                    <p>Safe. Secure. Satisfaction Guaranteed.</p>
                </div>
            </div>

            <!-- Right: Continue Shopping CTA -->
            <div class="tea-promise-action">
                <a href="{{ route('shop') }}" class="tea-btn-continue-shopping">
                    <span>Continue Shopping</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </main>
</div>
@endsection

@push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
@endpush
