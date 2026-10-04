@extends('frontEnd.layouts.master')
@section('title', $page->title . ' - OnekkisuBD')

@section('content')
@php
    $slug = $page->slug ?? '';
    
    // Page Title decomposition (first word dark serif, remaining words green italic serif)
    $titleParts = explode(' ', trim($page->title));
    if (count($titleParts) > 1) {
        $titleMain = array_shift($titleParts);
        $titleAccent = implode(' ', $titleParts);
    } else {
        $titleMain = $page->title;
        $titleAccent = '';
    }

    // Dynamic subtitles tailored for each policy
    $subtitles = [
        'return-policy' => "Your satisfaction is our priority. We're here to make your shopping experience worry-free.",
        'order-procedure' => "Simple, smooth, and convenient step-by-step guide to place your order with complete confidence.",
        'delivery-rules' => "Fast, reliable, and secure nationwide delivery straight to your doorstep across Bangladesh.",
        'terms-&-conditions' => "Clear, transparent, and fair policies governing our services and your purchases.",
        'privacy-policy' => "Your privacy is sacred to us. Learn how we safeguard and protect your personal information.",
        'about-us' => "Dedicated to bringing you the finest, purest, garden-fresh tea crafted with nature's best.",
        'contact-us' => "We are always here to help you. Reach out through call, email, or chat anytime."
    ];
    $subtitle = $subtitles[$slug] ?? "Authentic, garden-fresh premium tea delivered with love and unwavering commitment.";
@endphp

<style>
    /* ========================================================
       TEA LUXURY POLICY & CMS PAGE SYSTEM (PIXEL-PERFECT)
       ======================================================== */
    .tea-policy-wrapper {
        background: #fbfbf9;
        background-image: 
            radial-gradient(circle at 10% 15%, rgba(39, 90, 56, 0.035) 0%, rgba(251, 251, 249, 0) 50%),
            radial-gradient(circle at 90% 10%, rgba(39, 90, 56, 0.04) 0%, rgba(251, 251, 249, 0) 45%),
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
        max-width: 1240px;
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
        left: 18%;
        top: 25px;
        width: 48px;
        height: 48px;
        opacity: 0.65;
        animation: teaFloatSlow 10s ease-in-out infinite;
    }
    .tea-float-2 {
        --leaf-rot: -20deg;
        right: 18%;
        top: 30px;
        width: 52px;
        height: 52px;
        opacity: 0.7;
        animation: teaFloat 8s ease-in-out infinite;
        animation-delay: 1.5s;
    }
    .tea-float-3 {
        --leaf-rot: 35deg;
        left: 7%;
        bottom: 35px;
        width: 44px;
        height: 44px;
        opacity: 0.6;
        animation: teaFloat 7s ease-in-out infinite;
        animation-delay: 3s;
    }
    .tea-float-4 {
        --leaf-rot: -45deg;
        right: 7%;
        bottom: 35px;
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
        top: 55%;
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
        top: 55%;
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
        margin-top: -3px;
        margin-left: auto;
        width: 110px;
        height: 14px;
    }

    /* Hero Center Typography */
    .tea-hero-content {
        max-width: 760px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    .tea-hero-overline {
        display: inline-flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 12px;
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
       3. CARDS GRID SYSTEM (3 Columns Desktop)
       -------------------------------------------------------- */
    .tea-cards-container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 16px;
        position: relative;
        z-index: 2;
    }
    .tea-policy-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 36px;
    }

    /* Individual Policy Card */
    .tea-policy-card {
        background: #ffffff;
        border: 1px solid #edf2ec;
        border-radius: 18px;
        padding: 28px 24px 26px;
        box-shadow: 0 4px 20px rgba(15, 40, 26, 0.03);
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .tea-policy-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(15, 40, 26, 0.07);
        border-color: #c9dec4;
    }

    /* Card Top (Icon + Badge + Title) */
    .tea-card-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }
    .tea-icon-wrapper {
        position: relative;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #eaf4eb;
        border: 1.5px solid #d5e8d5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #275a38;
        font-size: 21px;
    }
    .tea-icon-wrapper svg {
        width: 24px;
        height: 24px;
        stroke: #275a38;
    }
    .tea-badge-num {
        position: absolute;
        top: -6px;
        left: -6px;
        width: 26px;
        height: 26px;
        min-width: 26px;
        min-height: 26px;
        aspect-ratio: 1 / 1;
        padding: 0;
        border-radius: 50%;
        background: #1c452e;
        color: #ffffff;
        font-size: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ffffff;
        font-family: 'Poppins', sans-serif;
        line-height: 1;
        box-sizing: border-box;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
    }
    .tea-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        letter-spacing: -0.2px;
    }

    /* Card Body & Content Items */
    .tea-card-body {
        font-size: 13.5px;
        line-height: 1.68;
        color: #374151;
        flex-grow: 1;
    }
    .tea-card-body p {
        margin: 0 0 12px;
    }
    .tea-card-body p:last-child {
        margin-bottom: 0;
    }
    .tea-bullet-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .tea-bullet-item {
        position: relative;
        padding-left: 18px;
        margin-bottom: 12px;
        line-height: 1.62;
    }
    .tea-bullet-item:last-child {
        margin-bottom: 0;
    }
    .tea-bullet-item::before {
        content: "•";
        position: absolute;
        left: 0;
        top: 0;
        color: #111827;
        font-size: 18px;
        line-height: 1.1;
    }
    .tea-bullet-item strong {
        color: #111827;
        font-weight: 700;
    }

    /* Numbered steps (for Return Process & Order Procedure) */
    .tea-step-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .tea-step-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
        line-height: 1.6;
    }
    .tea-step-item:last-child {
        margin-bottom: 0;
    }
    .tea-step-badge {
        width: 19px;
        height: 19px;
        border-radius: 50%;
        background: #275a38;
        color: #ffffff;
        font-size: 10.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .tea-step-text strong {
        color: #111827;
        font-weight: 700;
    }

    /* Contact Card Details */
    .tea-contact-list {
        margin-top: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .tea-contact-link-row {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: #173f2c;
        text-decoration: none;
        font-size: 13.5px;
        transition: color 0.18s ease;
    }
    .tea-contact-link-row svg {
        width: 18px;
        height: 18px;
        stroke: #275a38;
        flex-shrink: 0;
    }
    .tea-contact-link-row:hover {
        color: #2e7d32;
        text-decoration: underline;
    }
    .tea-stamp-help {
        position: absolute;
        bottom: 16px;
        right: 20px;
        font-family: 'Caveat', cursive;
        font-size: 26px;
        color: #789c7c;
        transform: rotate(-8deg);
        pointer-events: none;
        user-select: none;
        font-weight: 600;
        line-height: 1;
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
        line-height: 1;
        display: flex;
        align-items: center;
    }
    .tea-promise-icon svg {
        width: 28px;
        height: 28px;
        stroke: #275a38;
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
        color: #4b5563;
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

    /* --------------------------------------------------------
       5. FALLBACK ARTICLE CARD (For Custom CMS Pages)
       -------------------------------------------------------- */
    .tea-custom-page-card {
        background: #ffffff;
        border: 1px solid #edf2ec;
        border-radius: 20px;
        padding: 40px 48px;
        box-shadow: 0 6px 26px rgba(15, 40, 26, 0.04);
        margin-bottom: 36px;
    }
    .tea-custom-page-body {
        font-size: 15px;
        line-height: 1.85;
        color: #374151;
    }
    .tea-custom-page-body h1, .tea-custom-page-body h2, .tea-custom-page-body h3, .tea-custom-page-body h4 {
        font-family: 'Playfair Display', Georgia, serif;
        color: #112a1d;
        margin-top: 28px;
        margin-bottom: 12px;
        font-weight: 700;
    }
    .tea-custom-page-body p {
        margin-bottom: 16px;
    }
    .tea-custom-page-body ul, .tea-custom-page-body ol {
        margin-bottom: 20px;
        padding-left: 24px;
    }
    .tea-custom-page-body li {
        margin-bottom: 8px;
    }

    /* --------------------------------------------------------
       6. RESPONSIVE MEDIA QUERIES
       -------------------------------------------------------- */
    @media (max-width: 1200px) {
        .tea-script-left { left: 30px; font-size: 26px; }
        .tea-script-right { right: 30px; font-size: 24px; }
        .tea-leaf-tl { width: 150px; }
        .tea-leaf-tr { width: 160px; }
    }

    @media (max-width: 991px) {
        .tea-script-left, .tea-script-right { display: none; }
        .tea-policy-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
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
        .tea-policy-grid { grid-template-columns: 1fr; gap: 16px; }
        .tea-policy-card { padding: 22px 18px 20px; }
        .tea-custom-page-card { padding: 26px 18px; }
        .tea-subnav-link { padding: 14px 14px; font-size: 13px; }
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
                <li class="tea-subnav-item {{ $slug == 'order-procedure' ? 'active' : '' }}">
                    <a href="{{ route('page', 'order-procedure') }}" class="tea-subnav-link">
                        <i class="fa-regular fa-clipboard"></i>
                        <span>Order Procedure</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item {{ $slug == 'delivery-rules' ? 'active' : '' }}">
                    <a href="{{ route('page', 'delivery-rules') }}" class="tea-subnav-link">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Delivery Rules</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item {{ $slug == 'return-policy' ? 'active' : '' }}">
                    <a href="{{ route('page', 'return-policy') }}" class="tea-subnav-link">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span>Return Policy</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item {{ $slug == 'terms-&-conditions' ? 'active' : '' }}">
                    <a href="{{ route('page', 'terms-&-conditions') }}" class="tea-subnav-link">
                        <i class="fa-regular fa-file-lines"></i>
                        <span>Terms &amp; Conditions</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item {{ $slug == 'privacy-policy' ? 'active' : '' }}">
                    <a href="{{ route('page', 'privacy-policy') }}" class="tea-subnav-link">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Privacy Policy</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item {{ $slug == 'about-us' ? 'active' : '' }}">
                    <a href="{{ route('page', 'about-us') }}" class="tea-subnav-link">
                        <i class="fa-regular fa-user"></i>
                        <span>About Us</span>
                    </a>
                </li>
                <li class="tea-subnav-sep">|</li>
                <li class="tea-subnav-item {{ request()->routeIs('contact') || $slug == 'contact-us' ? 'active' : '' }}">
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
        <!-- Floating leaves SVG like homepage (across entire hero section) -->
        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-1" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad1)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <path d="M22 42c6-1 10-2 14-5M30 34c6-2 9-4 12-8M18 46c3-5 5-7 8-10" stroke="#e5efe2" stroke-width="1" stroke-linecap="round" opacity=".7" />
            <defs>
                <linearGradient id="heroLeafGrad1" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#2f6f37" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-2" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad2)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="heroLeafGrad2" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#245a2d" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-3" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad3)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="heroLeafGrad3" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#1b4526" />
                    <stop offset="1" stop-color="#6ba367" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-4" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad4)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="heroLeafGrad4" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#2f6f37" />
                    <stop offset="1" stop-color="#88be84" />
                </linearGradient>
            </defs>
        </svg>

        <svg viewBox="0 0 64 64" class="tea-floating-leaf tea-float-5" fill="none" aria-hidden="true">
            <path d="M10 54C12 30 30 12 56 8c-4 26-22 44-46 46z" fill="url(#heroLeafGrad5)" />
            <path d="M12 52L52 12" stroke="#e5efe2" stroke-width="1.5" stroke-linecap="round" />
            <defs>
                <linearGradient id="heroLeafGrad5" x1="10" y1="54" x2="56" y2="8" gradientUnits="userSpaceOnUse">
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
                    <span class="tea-title-main">{{ $titleMain }}</span>
                    @if($titleAccent)
                        <span class="tea-title-accent">{{ $titleAccent }}</span>
                    @endif
                </h1>

                <p class="tea-hero-subtitle">
                    {{ $subtitle }}
                </p>
            </div>

            <!-- Right Script Accent -->
            <div class="tea-script-right">
                100%<br>
                Customer<br>
                Satisfaction
                <svg class="tea-script-swoosh" viewBox="0 0 100 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12 Q 50 18, 95 8" stroke="#789c7c" stroke-width="2.5" stroke-linecap="round" fill="none" />
                </svg>
            </div>
        </div>
    </header>

    <!-- 3. PAGE CONTENT SECTION -->
    <main class="tea-cards-container">
        @if($slug == 'return-policy')
            <!-- ==========================================
                 RETURN POLICY: EXACT 6 CARDS FROM DESIGN
                 ========================================== -->
            <div class="tea-policy-grid">
                <!-- Card 01: Overview -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">01</span>
                            <!-- Clean Document Icon -->
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Overview</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>At OnekkisuBD, we strive to ensure you are completely satisfied with your purchase. If for any reason you are not satisfied, we are here to help.</p>
                    </div>
                </div>

                <!-- Card 02: Returns -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">02</span>
                            <!-- Clean 3D Box Package Icon -->
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                                <path d="m3.3 7 8.7 5 8.7-5"></path>
                                <path d="M12 22V12"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Returns</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item">
                                <strong>Eligibility:</strong> Items must be returned within <strong>7 days</strong> of receipt.
                            </li>
                            <li class="tea-bullet-item">
                                <strong>Condition:</strong> Items must be unused, undamaged, and in their original packaging.
                            </li>
                            <li class="tea-bullet-item">
                                <strong>Exceptions:</strong> Certain types of items (such as perishable goods, custom products, and intimate items) are non-returnable.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Card 03: Return Process -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">03</span>
                            <!-- Curved Return Arrow Icon -->
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 14 4 9l5-5"></path>
                                <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5v0a5.5 5.5 0 0 1-5.5 5.5H11"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Return Process</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-step-list">
                            <li class="tea-step-item">
                                <span class="tea-step-badge">1</span>
                                <div class="tea-step-text">
                                    <strong>Initiate Return:</strong> Contact our customer support at <a href="mailto:onekkisuponno@gmail.com" style="color:#173f2c; font-weight:600;">onekkisuponno@gmail.com</a> or <a href="tel:01850945080" style="color:#173f2c; font-weight:600;">01850945080</a> to initiate a return.
                                </div>
                            </li>
                            <li class="tea-step-item">
                                <span class="tea-step-badge">2</span>
                                <div class="tea-step-text">
                                    <strong>Return Authorization:</strong> Once your return is approved, you will receive further instructions.
                                </div>
                            </li>
                            <li class="tea-step-item">
                                <span class="tea-step-badge">3</span>
                                <div class="tea-step-text">
                                    <strong>Securely pack:</strong> your item and send it to the OnekkisuBD office.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Card 04: Refunds -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">04</span>
                            <!-- Wallet / Card Icon -->
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                <line x1="2" x2="22" y1="10" y2="10"></line>
                                <path d="M6 15h2"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Refunds</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item">
                                <strong>Processing Time:</strong> Once we receive your returned item, we will inspect it and notify you of the approval or rejection of your refund within 7 business days.
                            </li>
                            <li class="tea-bullet-item">
                                <strong>Method of Refund:</strong> If approved, your refund will be processed to your original payment method within 7 business days.
                            </li>
                            <li class="tea-bullet-item">
                                <strong>Shipping Costs:</strong> Original shipping costs are non-refundable. Return shipping costs are the responsibility of the customer, unless the item was incorrect or defective.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Card 05: Exchanges -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">05</span>
                            <!-- Horizontal Exchange Arrows Icon -->
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m16 3 4 4-4 4"></path>
                                <path d="M20 7H4"></path>
                                <path d="m8 21-4-4 4-4"></path>
                                <path d="M4 17h16"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Exchanges</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item">
                                <strong>Eligibility:</strong> If you need to exchange an item, please initiate the return process and specify that you would like an exchange.
                            </li>
                            <li class="tea-bullet-item">
                                <strong>Processing Time:</strong> Exchanges will be processed once the returned item is received and inspected.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Card 06: Contact Us -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">06</span>
                            <!-- Telephone Handset Icon -->
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Contact Us</h3>
                    </div>
                    <div class="tea-card-body" style="position:relative; z-index:2;">
                        <p>If you have any questions about our refund and return policies, please contact us:</p>
                        <div class="tea-contact-list">
                            <a href="mailto:onekkisuponno@gmail.com" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                                <span>onekkisuponno@gmail.com</span>
                            </a>
                            <a href="tel:01850945080" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>01850945080</span>
                            </a>
                        </div>
                    </div>
                    <!-- Slanted "We're Here to Help!" stamp in bottom right corner -->
                    <div class="tea-stamp-help">We're Here to Help!</div>
                </div>
            </div>

        @elseif($slug == 'order-procedure')
            <!-- ==========================================
                 ORDER PROCEDURE: STRUCTURED LUXURY CARDS
                 ========================================== -->
            <div class="tea-policy-grid">
                <!-- 01 Placing an Order -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">01</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="8" cy="21" r="1"></circle>
                                <circle cx="19" cy="21" r="1"></circle>
                                <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Placing an Order</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Browsing Products:</strong> Visit our store at <strong>www.onekkisubd.com</strong> and browse pure tea categories or use the instant search bar.</li>
                            <li class="tea-bullet-item"><strong>Selecting Products:</strong> View product details, select quantity and variant, then click <strong>Add to Cart</strong> or <strong>Order Now</strong>.</li>
                            <li class="tea-bullet-item"><strong>Shopping Cart:</strong> Review your selected tea items, adjust quantities, and click <strong>Checkout</strong>.</li>
                        </ul>
                    </div>
                </div>

                <!-- 02 Account Creation -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">02</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <line x1="19" x2="19" y1="8" y2="14"></line>
                                <line x1="22" x2="16" y1="11" y2="11"></line>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Account Creation</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>New Customers:</strong> Create an account or place instant guest orders with your mobile number and delivery address.</li>
                            <li class="tea-bullet-item"><strong>Returning Customers:</strong> Sign in with your phone or email to view past orders, track deliveries, and save addresses.</li>
                        </ul>
                    </div>
                </div>

                <!-- 03 Shipping Information -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">03</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Shipping Info</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Accurate Details:</strong> Provide your complete delivery address, contact mobile number, and district to ensure error-free dispatch.</li>
                            <li class="tea-bullet-item"><strong>Nationwide Reach:</strong> We deliver throughout Bangladesh through standard express courier logistics.</li>
                        </ul>
                    </div>
                </div>

                <!-- 04 Payment Information -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">04</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="14" x="2" y="5" rx="2"></rect>
                                <line x1="2" x2="22" y1="10" y2="10"></line>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Payment Methods</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Cash on Delivery (COD):</strong> Pay conveniently in cash when the parcel reaches your hands.</li>
                            <li class="tea-bullet-item"><strong>Digital Payments:</strong> Secure payments via bKash, Nagad, cards, and online banking.</li>
                        </ul>
                    </div>
                </div>

                <!-- 05 Order Review -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">05</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 11 3 3L22 4"></path>
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Order Review</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Summary Verification:</strong> Check total amount, shipping charges, and customer information.</li>
                            <li class="tea-bullet-item"><strong>Coupon Code:</strong> Apply valid promotional coupon codes at checkout for extra savings.</li>
                        </ul>
                    </div>
                </div>

                <!-- 06 Order Confirmation -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">06</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Confirmation</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Place Order:</strong> Click "Place Order" to finalize your purchase.</li>
                            <li class="tea-bullet-item"><strong>Instant Notification:</strong> You will immediately receive SMS and email verification containing your unique Order ID.</li>
                        </ul>
                    </div>
                </div>

                <!-- 07 Processing & Shipment -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">07</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16.5 9.4 7.55 4.24a1.78 1.78 0 0 0-2.5 1.55v8.87a1.78 1.78 0 0 0 .89 1.55l8.95 5.17a1.78 1.78 0 0 0 2.5-1.55V10.95a1.78 1.78 0 0 0-.89-1.55Z"></path>
                                <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                <line x1="12" y1="22" x2="12" y2="12"></line>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Processing &amp; Dispatch</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Garden Fresh Pack:</strong> Each tea package is safely sealed in moisture-proof packaging.</li>
                            <li class="tea-bullet-item"><strong>Fast Dispatch:</strong> Orders are typically processed and handed over to couriers on the same business day.</li>
                        </ul>
                    </div>
                </div>

                <!-- 08 Order Tracking -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">08</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="6" cy="19" r="3"></circle>
                                <path d="M9 19h8.5a3.5 3.5 0 0 0 0-7h-11a3.5 3.5 0 0 1 0-7H15"></path>
                                <circle cx="18" cy="5" r="3"></circle>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Live Tracking</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Tracking ID:</strong> Once dispatched, you will receive a tracking link via SMS to monitor live parcel status until arrival.</li>
                        </ul>
                    </div>
                </div>

                <!-- 09 Contact Us -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">09</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Need Help?</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>Need assistance or have special order requests? Contact our team:</p>
                        <div class="tea-contact-list">
                            <a href="mailto:onekkisuponno@gmail.com" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                                <span>onekkisuponno@gmail.com</span>
                            </a>
                            <a href="tel:01850945080" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>01850945080</span>
                            </a>
                        </div>
                    </div>
                    <div class="tea-stamp-help">Order with Ease!</div>
                </div>
            </div>

        @elseif($slug == 'delivery-rules')
            <!-- ==========================================
                 DELIVERY RULES: STRUCTURED LUXURY CARDS
                 ========================================== -->
            <div class="tea-policy-grid">
                <!-- 01 General Information -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">01</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">General Info</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Nationwide Delivery:</strong> We deliver to all 64 districts in Bangladesh. We do not ship to P.O. boxes.</li>
                            <li class="tea-bullet-item"><strong>Processing Speed:</strong> Orders are processed and dispatched on the same business day for maximum freshness.</li>
                        </ul>
                    </div>
                </div>

                <!-- 02 Shipping Options -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">02</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="16" height="13" x="1" y="3" rx="2"></rect>
                                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                <circle cx="18.5" cy="18.5" r="2.5"></circle>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Delivery Options</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Inside Dhaka:</strong> Doorstep delivery within <strong>24 to 48 hours</strong>.</li>
                            <li class="tea-bullet-item"><strong>Outside Dhaka:</strong> Delivered safely within <strong>2 to 4 business days</strong>.</li>
                        </ul>
                    </div>
                </div>

                <!-- 03 Shipping Costs -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">03</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"></path>
                                <path d="M7 7h.01"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Shipping Costs</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Standard Inside Dhaka:</strong> ৳60 standard delivery charge.</li>
                            <li class="tea-bullet-item"><strong>Standard Outside Dhaka:</strong> ৳100 nationwide delivery charge.</li>
                            <li class="tea-bullet-item"><strong>Free Shipping:</strong> Available on eligible promotional campaigns and bundles.</li>
                        </ul>
                    </div>
                </div>

                <!-- 04 Order Tracking -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">04</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Order Tracking</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Live SMS Tracking:</strong> As soon as your order is dispatched, you receive a courier tracking number and direct tracking link via SMS.</li>
                        </ul>
                    </div>
                </div>

                <!-- 05 Delivery Time -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">05</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Delivery Schedule</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Delivery Window:</strong> Couriers deliver between 9:00 AM and 8:00 PM on working days.</li>
                            <li class="tea-bullet-item"><strong>Holidays:</strong> National public holidays, extreme weather, or regional road blocks may slightly affect delivery timelines.</li>
                        </ul>
                    </div>
                </div>

                <!-- 06 Failed Delivery Attempts -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">06</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                                <line x1="12" y1="9" x2="12" y2="13"></line>
                                <line x1="12" y1="17" x2="12.01" y2="17"></line>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Delivery Attempts</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Two Attempts:</strong> If delivery is unsuccessful after <strong>two attempts</strong> due to unreachable phone or absence, the package is returned. Re-shipping costs apply.</li>
                        </ul>
                    </div>
                </div>

                <!-- 07 Damaged or Lost Packages -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">07</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Damaged Packages</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Immediate Claim:</strong> If your package shows physical damage upon transit, please inform our support desk within <strong>3 days</strong> of delivery for an instant replacement.</li>
                        </ul>
                    </div>
                </div>

                <!-- 08 Contact Us -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">08</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Delivery Support</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>Questions regarding parcel transit or dispatch? Contact us anytime:</p>
                        <div class="tea-contact-list">
                            <a href="mailto:onekkisuponno@gmail.com" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                                <span>onekkisuponno@gmail.com</span>
                            </a>
                            <a href="tel:01850945080" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>01850945080</span>
                            </a>
                        </div>
                    </div>
                    <div class="tea-stamp-help">Fast &amp; Secure!</div>
                </div>
            </div>

        @elseif($slug == 'privacy-policy')
            <!-- ==========================================
                 PRIVACY POLICY: STRUCTURED LUXURY CARDS
                 ========================================== -->
            <div class="tea-policy-grid">
                <!-- 01 Introduction -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">01</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Introduction</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>At OnekkisuBD, safeguarding your personal data and privacy is our top priority. This Privacy Policy details how we collect, store, and protect your information when visiting our website.</p>
                    </div>
                </div>

                <!-- 02 Information We Collect -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">02</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Data We Collect</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Personal Information:</strong> Name, delivery address, phone number, and email provided during order checkout.</li>
                            <li class="tea-bullet-item"><strong>Order History:</strong> Products ordered, billing preferences, and communication notes.</li>
                        </ul>
                    </div>
                </div>

                <!-- 03 How We Use Your Info -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">03</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">How Data Is Used</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Order Processing:</strong> To verify, pack, and ship your tea items securely to your home.</li>
                            <li class="tea-bullet-item"><strong>Customer Support:</strong> To answer inquiries, provide shipment tracking, and process return requests.</li>
                        </ul>
                    </div>
                </div>

                <!-- 04 Information Security -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">04</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Data Security</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>SSL Encryption:</strong> High-grade cryptographic encryption keeps sensitive data completely safe.</li>
                            <li class="tea-bullet-item"><strong>Zero Data Selling:</strong> We NEVER sell, rent, or trade your personal information to third parties.</li>
                        </ul>
                    </div>
                </div>

                <!-- 05 Third Party Disclosure -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">05</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Trusted Partners</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>We share strictly necessary shipping info (name, address, phone) with licensed courier companies solely to fulfill parcel delivery.</p>
                    </div>
                </div>

                <!-- 06 Contact Privacy Officer -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">06</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Privacy Inquiries</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>If you have any questions or wish to update/delete your data, please contact us:</p>
                        <div class="tea-contact-list">
                            <a href="mailto:onekkisuponno@gmail.com" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                                <span>onekkisuponno@gmail.com</span>
                            </a>
                            <a href="tel:01850945080" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>01850945080</span>
                            </a>
                        </div>
                    </div>
                    <div class="tea-stamp-help">Your Privacy First!</div>
                </div>
            </div>

        @elseif($slug == 'terms-&-conditions')
            <!-- ==========================================
                 TERMS & CONDITIONS: STRUCTURED LUXURY CARDS
                 ========================================== -->
            <div class="tea-policy-grid">
                <!-- 01 Introduction -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">01</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Introduction</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>These Terms &amp; Conditions govern your access to and use of OnekkisuBD website and services. By placing an order, you agree to comply with these terms.</p>
                    </div>
                </div>

                <!-- 02 Authenticity & Products -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">02</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path>
                                <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Product Guarantee</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>100% Genuine:</strong> All tea products displayed are authentic, unadulterated, and packaged under stringent sanitary standards.</li>
                            <li class="tea-bullet-item"><strong>Accurate Descriptions:</strong> We strive to provide truthful images and accurate taste profiles.</li>
                        </ul>
                    </div>
                </div>

                <!-- 03 Pricing & Orders -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">03</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path>
                                <path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path>
                                <path d="M7 21h10"></path>
                                <path d="M12 3v18"></path>
                                <path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Orders &amp; Pricing</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Transparent Pricing:</strong> Prices listed in BDT are final at checkout.</li>
                            <li class="tea-bullet-item"><strong>Order Acceptance:</strong> We reserve the right to cancel orders in event of pricing errors or unavailability.</li>
                        </ul>
                    </div>
                </div>

                <!-- 04 User Responsibilities -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">04</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <polyline points="16 11 18 13 22 9"></polyline>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">User Conduct</h3>
                    </div>
                    <div class="tea-card-body">
                        <ul class="tea-bullet-list">
                            <li class="tea-bullet-item"><strong>Accurate Info:</strong> Users must provide valid contact and address details to avoid courier return charges.</li>
                            <li class="tea-bullet-item"><strong>Lawful Use:</strong> The site must not be used for fraudulent or unlawful orders.</li>
                        </ul>
                    </div>
                </div>

                <!-- 05 Intellectual Property -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">05</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M14.83 14.83a4 4 0 1 1 0-5.66"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Intellectual Property</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>All brand content, logos, packaging graphics, and trademarks are proprietary to OnekkisuBD and protected by applicable copyright laws.</p>
                    </div>
                </div>

                <!-- 06 Contact Legal -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">06</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Legal Inquiries</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>For questions or clarifications regarding our operating terms and conditions:</p>
                        <div class="tea-contact-list">
                            <a href="mailto:onekkisuponno@gmail.com" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                                <span>onekkisuponno@gmail.com</span>
                            </a>
                            <a href="tel:01850945080" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>01850945080</span>
                            </a>
                        </div>
                    </div>
                    <div class="tea-stamp-help">Fair &amp; Transparent!</div>
                </div>
            </div>

        @elseif($slug == 'about-us')
            <!-- ==========================================
                 ABOUT US: STRUCTURED LUXURY CARDS
                 ========================================== -->
            <div class="tea-policy-grid">
                <!-- 01 Our Story -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">01</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path>
                                <line x1="16" y1="8" x2="2" y2="22"></line>
                                <line x1="17.5" y1="15" x2="9" y2="15"></line>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Our Heritage</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>OnekkisuBD was founded with a singular passion: to deliver pure, unadulterated, garden-fresh premium tea directly from verdant gardens to your daily teacup.</p>
                    </div>
                </div>

                <!-- 02 100% Pure & Organic -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">02</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 10a6 6 0 0 0-6-6H3v2a6 6 0 0 0 6 6h3Z"></path>
                                <path d="M12 14a6 6 0 0 1 6-6h3v2a6 6 0 0 1-6 6h-3Z"></path>
                                <path d="M12 2v20"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">100% Organic Purity</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>We strictly reject artificial colors, chemical fragrances, and stale blends. Every leaf is natural, vibrant, and packed with health-promoting antioxidants.</p>
                    </div>
                </div>

                <!-- 03 Handpicked Selection -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">03</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"></path>
                                <path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"></path>
                                <path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"></path>
                                <path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Artisan Selection</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>From fine orthodox whole leaves to delicate green tea, roselle infusions, and golden tippy teas, our masters taste and certify every harvest.</p>
                    </div>
                </div>

                <!-- 04 Sustainable Sourcing -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">04</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                                <path d="M2 12h20"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Ethical Sourcing</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>We work directly with traditional tea growers, promoting sustainable cultivation, fair compensation, and eco-friendly moisture-lock packaging.</p>
                    </div>
                </div>

                <!-- 05 Quality Commitment -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">05</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="6"></circle>
                                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Our Promise</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>Your ultimate satisfaction is our priority. If any tea doesn't deliver the taste and freshness promised, our replacement policy ensures you are cared for.</p>
                    </div>
                </div>

                <!-- 06 Connect With Us -->
                <div class="tea-policy-card">
                    <div class="tea-card-header">
                        <div class="tea-icon-wrapper">
                            <span class="tea-badge-num">06</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <h3 class="tea-card-title">Connect With Us</h3>
                    </div>
                    <div class="tea-card-body">
                        <p>We love hearing from fellow tea enthusiasts. Reach our office and customer support:</p>
                        <div class="tea-contact-list">
                            <a href="mailto:onekkisuponno@gmail.com" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                                <span>onekkisuponno@gmail.com</span>
                            </a>
                            <a href="tel:01850945080" class="tea-contact-link-row">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                <span>01850945080</span>
                            </a>
                        </div>
                    </div>
                    <div class="tea-stamp-help">Good Tea Good Life!</div>
                </div>
            </div>

        @else
            <!-- ==========================================
                 CUSTOM / GENERAL CMS PAGE VIEW
                 ========================================== -->
            <article class="tea-custom-page-card">
                <div class="tea-custom-page-body">
                    {!! $page->description !!}
                </div>
            </article>
        @endif

        <!-- 4. BOTTOM PROMISE & TRUST BANNER (Shared across all pages) -->
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
