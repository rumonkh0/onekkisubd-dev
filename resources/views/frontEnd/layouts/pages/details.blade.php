@extends('frontEnd.layouts.master')
@section('title', $details->name)

@push('seo')
    <meta name="app-url" content="{{ route('product', $details->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $details->meta_description }}" />
    <meta name="keywords" content="{{ $details->slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $details->name }}" />
    <meta name="twitter:title" content="{{ $details->name }}" />
    <meta name="twitter:description" content="{{ $details->meta_description }}" />
    <meta name="twitter:creator" content="onekkisubd.com" />
    <meta property="og:url" content="{{ route('product', $details->slug) }}" />
    <meta name="twitter:image" content="{{ asset($details->image ? $details->image->image : '') }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $details->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('product', $details->slug) }}" />
    <meta property="og:image" content="{{ asset($details->image ? $details->image->image : '') }}" />
    <meta property="og:description" content="{{ $details->meta_description }}" />
    <meta property="og:site_name" content="{{ $details->name }}" />
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/zoomsl.css') }}">
    <style>
        /* ==========================================================================
           LUXURY TEA BOUTIQUE: PRODUCT DETAILS DESIGN SYSTEM
           ========================================================================== */
        :root {
            --tea-dark: #0a211b;
            --tea-deep: #103426;
            --tea-green: #173f2c;
            --tea-accent: #235d41;
            --tea-gold: #d8b77c;
            --tea-gold-light: #f4e6c3;
            --tea-gold-dark: #b89355;
            --tea-cream: #faf8f5;
            --tea-parchment: #f4f0e6;
            --tea-border: rgba(216, 183, 124, 0.28);
            --tea-text: #1c2826;
            --tea-muted: #5e6d66;
            --font-serif: 'Playfair Display', Georgia, serif;
            --font-sans: 'Plus Jakarta Sans', system-ui, sans-serif;
            --font-bn: 'Hind Siliguri', sans-serif;
        }

        .tea-product-page {
            background-color: var(--tea-cream);
            color: var(--tea-text);
            font-family: var(--font-sans);
            padding: 24px 0 60px;
        }

        /* Breadcrumb */
        .tea-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 13px;
            color: var(--tea-muted);
            margin-bottom: 24px;
            padding: 10px 18px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--tea-border);
            box-shadow: 0 2px 10px rgba(10, 33, 27, 0.03);
        }
        .tea-breadcrumb a {
            color: var(--tea-muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .tea-breadcrumb a:hover {
            color: var(--tea-accent);
        }
        .tea-breadcrumb .sep {
            color: var(--tea-gold);
            font-size: 11px;
        }
        .tea-breadcrumb .current {
            color: var(--tea-dark);
            font-weight: 600;
        }

        /* Product Main Grid */
        .tea-details-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid var(--tea-border);
            padding: 32px;
            box-shadow: 0 10px 40px rgba(10, 33, 27, 0.05);
            margin-bottom: 40px;
        }

        /* Gallery Showcase */
        .tea-gallery-wrap {
            position: relative;
        }
        .tea-main-slider {
            position: relative;
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(216, 183, 124, 0.2);
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(10, 33, 27, 0.04);
        }
        .tea-main-slider .dimage_item {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 480px;
            background: radial-gradient(circle at center, #ffffff 60%, #faf8f5 100%);
            padding: 20px;
        }
        .tea-main-slider .dimage_item img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.4s ease;
        }

        /* Luxury Floating Badges */
        .tea-badge-discount {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 10;
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            color: #ffffff;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 6px 14px;
            border-radius: 30px;
            box-shadow: 0 4px 14px rgba(185, 28, 28, 0.35);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .tea-badge-organic {
            position: absolute;
            top: 16px;
            right: 16px;
            z-index: 10;
            background: rgba(255, 255, 255, 0.95);
            color: var(--tea-green);
            border: 1px solid var(--tea-border);
            font-size: 11px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 30px;
            box-shadow: 0 2px 8px rgba(10, 33, 27, 0.06);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            backdrop-filter: blur(6px);
        }
        .tea-badge-organic svg {
            color: #16a34a;
        }

        /* Thumbnails Strip */
        .tea-thumbs-strip {
            display: flex;
            gap: 12px;
            margin-top: 16px;
            overflow-x: auto;
            padding-bottom: 4px;
        }
        .tea-thumbs-strip::-webkit-scrollbar {
            height: 4px;
        }
        .tea-thumbs-strip::-webkit-scrollbar-thumb {
            background: var(--tea-gold);
            border-radius: 4px;
        }
        .tea-thumb-item {
            flex: 0 0 80px;
            height: 80px;
            border-radius: 12px;
            border: 2px solid rgba(216, 183, 124, 0.3);
            overflow: hidden;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
        }
        .tea-thumb-item:hover,
        .tea-thumb-item.active {
            border-color: var(--tea-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(216, 183, 124, 0.3);
        }
        .tea-thumb-item img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Purchase & Info Panel */
        .tea-info-panel {
            padding-left: 15px;
        }
        @media (max-width: 991px) {
            .tea-info-panel {
                padding-left: 0;
                margin-top: 30px;
            }
            .tea-main-slider .dimage_item {
                height: 360px;
            }
        }

        .tea-meta-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 12px;
        }
        .tea-cat-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(23, 63, 44, 0.08);
            color: var(--tea-green);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid rgba(23, 63, 44, 0.15);
        }
        .tea-sku-pill {
            font-size: 12px;
            color: var(--tea-muted);
            background: #f4f1ea;
            padding: 4px 10px;
            border-radius: 8px;
        }
        .tea-stock-pill {
            font-size: 12px;
            font-weight: 600;
            color: #15803d;
            background: #dcfce7;
            padding: 4px 10px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Title */
        .tea-product-title {
            font-family: var(--font-serif);
            font-size: 32px;
            font-weight: 700;
            color: var(--tea-dark);
            line-height: 1.25;
            margin: 0 0 14px 0;
            letter-spacing: -0.5px;
        }
        @media (max-width: 768px) {
            .tea-product-title {
                font-size: 24px;
            }
        }

        /* Rating Stars Row */
        .tea-rating-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            font-size: 13px;
        }
        .tea-stars {
            color: #eab308;
            display: inline-flex;
            gap: 2px;
        }
        .tea-rating-count {
            color: var(--tea-muted);
            text-decoration: underline;
            cursor: pointer;
        }

        /* Price Showcase Box */
        .tea-price-box {
            display: flex;
            align-items: baseline;
            gap: 14px;
            padding: 16px 20px;
            background: linear-gradient(135deg, #faf8f5 0%, #f4f0e6 100%);
            border-radius: 16px;
            border: 1px solid var(--tea-border);
            margin-bottom: 22px;
        }
        .tea-current-price {
            font-family: var(--font-sans);
            font-size: 34px;
            font-weight: 800;
            color: var(--tea-dark);
            letter-spacing: -0.5px;
        }
        .tea-current-price .currency {
            font-family: var(--font-bn);
            font-weight: 700;
            margin-right: 2px;
            color: var(--tea-accent);
        }
        .tea-old-price {
            font-size: 18px;
            color: #94a3b8;
            text-decoration: line-through;
        }
        .tea-old-price .currency {
            font-family: var(--font-bn);
        }
        .tea-savings-pill {
            margin-left: auto;
            background: rgba(22, 101, 52, 0.12);
            color: #166534;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 8px;
            border: 1px solid rgba(22, 101, 52, 0.25);
        }

        /* Short Description / Sensory Highlights */
        .tea-short-des {
            background: #ffffff;
            border-left: 3px solid var(--tea-gold);
            padding: 14px 18px;
            border-radius: 0 12px 12px 0;
            margin-bottom: 24px;
            font-size: 13.5px;
            line-height: 1.7;
            color: #374151;
            font-family: var(--font-bn);
            box-shadow: 0 2px 10px rgba(10, 33, 27, 0.02);
            border-top: 1px solid rgba(216, 183, 124, 0.15);
            border-right: 1px solid rgba(216, 183, 124, 0.15);
            border-bottom: 1px solid rgba(216, 183, 124, 0.15);
        }

        /* Selector Sections */
        .tea-selector-group {
            margin-bottom: 22px;
        }
        .tea-selector-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--tea-dark);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .tea-selector-label svg {
            color: var(--tea-gold-dark);
        }

        /* Weight / Pack Pills */
        .tea-weight-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .tea-weight-option {
            position: relative;
        }
        .tea-weight-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .tea-weight-option label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 18px;
            border-radius: 12px;
            background: #faf8f5;
            border: 1.5px solid rgba(216, 183, 124, 0.35);
            color: var(--tea-dark);
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(10, 33, 27, 0.03);
            user-select: none;
        }
        .tea-weight-option input[type="radio"]:checked + label {
            background: var(--tea-dark);
            border-color: var(--tea-gold);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(10, 33, 27, 0.25);
            transform: translateY(-1px);
        }
        .tea-weight-option label:hover {
            border-color: var(--tea-gold);
            background: #ffffff;
        }

        /* Color / Blend Thumbnails */
        .tea-color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .tea-color-option {
            position: relative;
        }
        .tea-color-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .tea-color-option label {
            display: block;
            width: 54px;
            height: 54px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 2px;
            background: #ffffff;
        }
        .tea-color-option label img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
        .tea-color-option input[type="radio"]:checked + label {
            border-color: var(--tea-gold) !important;
            box-shadow: 0 0 0 3px rgba(216, 183, 124, 0.35);
            transform: scale(1.05);
        }

        /* Quantity & Actions */
        .tea-actions-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            margin-top: 24px;
        }

        /* Modern Quantity Stepper */
        .tea-qty-stepper {
            display: inline-flex;
            align-items: center;
            background: #faf8f5;
            border: 1.5px solid rgba(216, 183, 124, 0.4);
            border-radius: 14px;
            padding: 3px;
            box-shadow: 0 2px 8px rgba(10, 33, 27, 0.03);
            height: 52px;
        }
        .tea-qty-btn {
            width: 44px;
            height: 44px;
            border: none;
            background: #ffffff;
            color: var(--tea-dark);
            border-radius: 10px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(10, 33, 27, 0.04);
            user-select: none;
        }
        .tea-qty-btn:hover {
            background: var(--tea-gold);
            color: var(--tea-dark);
        }
        .tea-qty-input {
            width: 52px;
            height: 44px;
            border: none;
            background: transparent;
            text-align: center;
            font-size: 16px;
            font-weight: 700;
            color: var(--tea-dark);
            outline: none;
        }

        /* CTA Buttons */
        .tea-btn-buy {
            flex: 1 1 200px;
            height: 52px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #d8b77c 0%, #b89355 100%);
            color: #0a211b;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 6px 20px rgba(216, 183, 124, 0.4);
            text-decoration: none;
        }
        .tea-btn-buy:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(216, 183, 124, 0.5);
            color: #0a211b;
        }
        .tea-btn-cart {
            flex: 1 1 200px;
            height: 52px;
            border: 1px solid #165732;
            border-radius: 14px;
            background: linear-gradient(110deg, #105b34 0%, #0a211b 100%);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 6px 20px rgba(16, 91, 52, 0.25);
            text-decoration: none;
        }
        .tea-btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 91, 52, 0.35);
            color: #ffffff;
        }
        .tea-btn-cart svg,
        .tea-btn-buy svg {
            width: 18px;
            height: 18px;
        }

        /* Stock Out Alert */
        .product_stock_out {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #f87171;
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Hotline Order Box */
        .tea-hotline-box {
            margin-top: 18px;
            background: #ffffff;
            border: 1.5px dashed var(--tea-gold);
            border-radius: 16px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            transition: all 0.2s;
        }
        .tea-hotline-box:hover {
            background: #faf8f5;
        }
        .tea-hotline-text {
            font-size: 13px;
            color: var(--tea-muted);
            font-family: var(--font-bn);
        }
        .tea-hotline-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 800;
            color: var(--tea-dark);
            text-decoration: none;
            background: rgba(216, 183, 124, 0.18);
            padding: 6px 14px;
            border-radius: 20px;
            transition: background 0.2s;
        }
        .tea-hotline-link:hover {
            background: var(--tea-gold);
            color: var(--tea-dark);
        }

        /* Guarantees Strip */
        .tea-guarantee-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(216, 183, 124, 0.2);
        }
        @media (max-width: 640px) {
            .tea-guarantee-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        .tea-guarantee-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--tea-dark);
        }
        .tea-guarantee-item svg {
            color: var(--tea-gold-dark);
            flex-shrink: 0;
            width: 18px;
            height: 18px;
        }

        /* ==========================================================================
           TABS: DESCRIPTION & REVIEWS
           ========================================================================== */
        .tea-tabs-section {
            margin-top: 40px;
        }
        .tea-tabs-nav {
            display: flex;
            gap: 12px;
            border-bottom: 2px solid rgba(216, 183, 124, 0.25);
            margin-bottom: 30px;
            padding-bottom: 2px;
        }
        .tea-tab-link {
            padding: 12px 24px;
            font-size: 15px;
            font-weight: 700;
            color: var(--tea-muted);
            border-radius: 12px 12px 0 0;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .tea-tab-link.active,
        .tea-tab-link:hover {
            color: var(--tea-dark);
        }
        .tea-tab-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--tea-gold);
            border-radius: 3px;
        }
        .tea-tab-badge {
            background: rgba(216, 183, 124, 0.25);
            color: var(--tea-dark);
            font-size: 11px;
            padding: 2px 7px;
            border-radius: 10px;
        }

        /* Tabs Switching */
        .tea-tab-pane {
            display: none;
        }
        .tea-tab-pane.active {
            display: block;
        }
        @media (max-width: 768px) {
            .tea-tab-content-card {
                padding: 20px;
            }
        }

        .tea-description-body {
            font-family: var(--font-bn);
            font-size: 15px;
            line-height: 1.85;
            color: #374151;
        }
        .tea-description-body h2,
        .tea-description-body h3,
        .tea-description-body h4 {
            font-family: var(--font-serif);
            color: var(--tea-dark);
            margin-top: 24px;
            margin-bottom: 12px;
            font-weight: 700;
        }
        .tea-description-body img {
            max-width: 100%;
            border-radius: 16px;
            margin: 16px 0;
        }

        /* Video Showcase */
        .tea-video-card {
            background: #0a211b;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--tea-border);
            padding: 20px;
            color: #ffffff;
        }
        .tea-video-card h3 {
            font-family: var(--font-serif);
            font-size: 20px;
            color: var(--tea-gold);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .tea-video-wrap {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 14px;
        }
        .tea-video-wrap iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Reviews Section */
        .tea-reviews-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(216, 183, 124, 0.2);
            margin-bottom: 28px;
        }
        .tea-reviews-header h3 {
            font-family: var(--font-serif);
            font-size: 24px;
            color: var(--tea-dark);
            margin: 0;
        }
        .tea-btn-write-review {
            background: var(--tea-dark);
            color: var(--tea-gold);
            border: 1px solid var(--tea-border);
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .tea-btn-write-review:hover {
            background: var(--tea-green);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .tea-review-card {
            background: #faf8f5;
            border-radius: 16px;
            border: 1px solid rgba(216, 183, 124, 0.2);
            padding: 20px;
            margin-bottom: 16px;
        }
        .tea-review-author {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }
        .tea-author-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--tea-dark);
            color: var(--tea-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            overflow: hidden;
            border: 1px solid var(--tea-border);
        }
        .tea-author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .tea-author-info strong {
            display: block;
            font-size: 14px;
            color: var(--tea-dark);
        }
        .tea-author-info small {
            color: var(--tea-muted);
            font-size: 11.5px;
        }
        .tea-review-text {
            font-size: 13.5px;
            line-height: 1.6;
            color: #4b5563;
            margin-top: 8px;
        }

        .tea-empty-reviews {
            text-align: center;
            padding: 40px 20px;
            color: var(--tea-muted);
        }
        .tea-empty-reviews svg {
            width: 48px;
            height: 48px;
            color: var(--tea-gold);
            margin-bottom: 12px;
        }

        /* Review Modal */
        .modal-content {
            border-radius: 20px !important;
            border: 1px solid var(--tea-border) !important;
            box-shadow: 0 20px 50px rgba(10, 33, 27, 0.2) !important;
            overflow: hidden;
        }
        .modal-header {
            background: var(--tea-dark) !important;
            color: #ffffff !important;
            border-bottom: 1px solid var(--tea-border) !important;
            padding: 18px 24px !important;
        }
        .modal-header .modal-title {
            font-family: var(--font-serif);
            color: var(--tea-gold) !important;
            font-size: 20px;
        }
        .modal-header .btn-close {
            filter: invert(1);
        }
        .modal-body {
            padding: 24px !important;
            background: #ffffff;
        }
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 6px;
            font-size: 26px;
            margin-bottom: 14px;
        }
        .rating input {
            display: none;
        }
        .rating label {
            cursor: pointer;
            color: #cbd5e1;
            transition: color 0.2s;
        }
        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #eab308;
        }
        .details-review-button {
            width: 100%;
            height: 48px;
            background: var(--tea-dark);
            color: var(--tea-gold);
            border: 1px solid var(--tea-border);
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .details-review-button:hover {
            background: var(--tea-green);
            color: #ffffff;
        }

        /* ==========================================================================
           RELATED PRODUCTS SECTION (LUXURY CARDS)
           ========================================================================== */
        .tea-related-section {
            margin-top: 50px;
            padding-top: 40px;
            border-top: 1px solid rgba(216, 183, 124, 0.25);
        }
        .tea-section-header {
            text-align: center;
            margin-bottom: 34px;
        }
        .tea-section-subtitle {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--tea-gold-dark);
            margin-bottom: 6px;
            display: block;
        }
        .tea-section-title {
            font-family: var(--font-serif);
            font-size: 32px;
            font-weight: 700;
            color: var(--tea-dark);
            margin: 0;
        }
        .tea-divider-leaf {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 10px;
        }
        .tea-divider-leaf::before,
        .tea-divider-leaf::after {
            content: '';
            width: 60px;
            height: 1px;
            background: var(--tea-gold);
        }
        .tea-divider-leaf svg {
            color: var(--tea-gold);
            width: 16px;
            height: 16px;
        }

        /* Luxury Product Card (Owl Slider) */
        .tea-product-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid rgba(216, 183, 124, 0.25);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(10, 33, 27, 0.03);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            margin: 8px 4px;
        }
        .tea-product-card:hover {
            transform: translateY(-5px);
            border-color: var(--tea-gold);
            box-shadow: 0 12px 30px rgba(10, 33, 27, 0.08);
        }
        .tea-card-media {
            position: relative;
            aspect-ratio: 1/1;
            padding: 12px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .tea-card-media img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.4s ease;
        }
        .tea-product-card:hover .tea-card-media img {
            transform: scale(1.06);
        }
        .tea-card-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #dc2626;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            z-index: 2;
        }
        .tea-card-body {
            padding: 12px 14px 14px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            text-align: center;
            background: #ffffff;
        }
        .tea-card-title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--tea-dark);
            line-height: 1.35;
            margin: 0 0 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-decoration: none;
            min-height: 36px;
        }
        .tea-card-title:hover {
            color: var(--tea-accent);
        }
        .tea-card-pricing {
            display: flex;
            align-items: baseline;
            justify-content: center;
            gap: 6px;
            margin-top: auto;
            margin-bottom: 10px;
        }
        .tea-card-price {
            font-size: 15px;
            font-weight: 700;
            color: var(--tea-dark);
        }
        .tea-card-oldprice {
            font-size: 12px;
            color: #94a3b8;
            text-decoration: line-through;
        }
        .tea-card-btn {
            width: 100%;
            padding: 8px 12px;
            background: #faf8f5;
            border: 1px solid rgba(216, 183, 124, 0.4);
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            color: var(--tea-dark);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            display: block;
        }
        .tea-card-btn:hover {
            background: var(--tea-dark);
            color: var(--tea-gold);
            border-color: var(--tea-dark);
        }

        /* Carousel Navigation Controls */
        .owl-theme .owl-nav [class*="owl-"] {
            background: #ffffff !important;
            color: var(--tea-dark) !important;
            border: 1px solid var(--tea-border) !important;
            width: 36px;
            height: 36px;
            border-radius: 50% !important;
            box-shadow: 0 3px 10px rgba(10, 33, 27, 0.08) !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            transition: all 0.2s !important;
        }
        .owl-theme .owl-nav [class*="owl-"]:hover {
            background: var(--tea-dark) !important;
            color: var(--tea-gold) !important;
        }
    </style>
@endpush

@section('content')
<main class="tea-product-page">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav class="tea-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>Home
            </a>
            <span class="sep">/</span>
            @if ($details->category)
                <a href="{{ route('category', $details->category->slug) }}">{{ $details->category->name }}</a>
                <span class="sep">/</span>
            @endif
            @if ($details->subcategory)
                <a href="{{ route('subcategory', $details->subcategory->slug) }}">{{ $details->subcategory->subcategoryName }}</a>
                <span class="sep">/</span>
            @endif
            <span class="current">{{ Str::limit($details->name, 45) }}</span>
        </nav>

        <!-- Main Product Card: Gallery + Purchase Panel -->
        <div class="tea-details-card">
            <div class="row align-items-start">
                <!-- LEFT: Gallery Showcase -->
                <div class="col-lg-6 col-md-12">
                    <div class="tea-gallery-wrap">
                        <!-- Floating Discount Badge -->
                        @if ($details->old_price && $details->old_price > $details->new_price)
                            @php
                                $discount = ((($details->old_price) - ($details->new_price)) * 100) / ($details->old_price);
                            @endphp
                            <div class="tea-badge-discount">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                {{ number_format($discount, 0) }}% OFF
                            </div>
                        @endif

                        <!-- Organic Trust Badge -->
                        <div class="tea-badge-organic">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path></svg>
                            100% Pure & Organic
                        </div>

                        <!-- Main Big Slider -->
                        <div class="tea-main-slider details_slider owl-carousel">
                            @if ($productcolors->count() > 0)
                                @foreach ($productcolors as $proc)
                                    <div class="dimage_item">
                                        <img src="{{ asset($proc->Image) }}" class="block__pic" alt="{{ $details->name }}" />
                                    </div>
                                @endforeach
                            @else
                                @foreach ($details->images as $value)
                                    <div class="dimage_item">
                                        <img src="{{ asset($value->image) }}" class="block__pic" alt="{{ $details->name }}" />
                                    </div>
                                @endforeach
                            @endif

                            @if (isset($details->PostImage))
                                @foreach (json_decode($details->PostImage) as $key => $image)
                                    <div class="dimage_item">
                                        <img src="{{ asset('public/images/product/slider') }}/{{ $image }}" class="block__pic" alt="{{ $details->name }}" />
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Thumbnails Strip -->
                        <div class="tea-thumbs-strip indicator_thumb @if ($details->images->count() > 4) thumb_slider owl-carousel @endif">
                            @php
                                $keyidone = 0;
                                $keyid = 0;
                            @endphp

                            @if ($productcolors->count() > 0)
                                @foreach ($productcolors as $key => $procs)
                                    <div class="tea-thumb-item indicator-item {{ $key == 0 ? 'active' : '' }}" id="{{ ++$keyidone }}" data-id="{{ $key }}">
                                        <img src="{{ asset($procs->Image) }}" alt="Thumb {{ $key }}" />
                                    </div>
                                @endforeach
                            @else
                                @foreach ($details->images as $key => $image)
                                    @php $keyid = $key + $keyidone + 1; @endphp
                                    <div class="tea-thumb-item indicator-item {{ $key == 0 ? 'active' : '' }}" id="{{ $keyid }}" data-id="{{ $key + $keyidone }}">
                                        <img src="{{ asset($image->image) }}" alt="Thumb {{ $key }}" />
                                    </div>
                                @endforeach
                            @endif

                            @if (isset($details->PostImage))
                                @foreach (json_decode($details->PostImage) as $key => $image)
                                    <div class="tea-thumb-item indicator-item" data-id="{{ $key + $keyid + 1 }}">
                                        <img src="{{ asset('public/images/product/slider') }}/{{ $image }}" alt="Thumb Post {{ $key }}" />
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Purchase & Details Panel -->
                <div class="col-lg-6 col-md-12">
                    <div class="tea-info-panel">
                        <!-- Meta Pills: Category, SKU & Stock -->
                        <div class="tea-meta-row">
                            @if ($details->category)
                                <span class="tea-cat-pill">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    {{ $details->category->name }}
                                </span>
                            @endif
                            <span class="tea-sku-pill">SKU: {{ $details->product_code }}</span>
                            <span class="tea-stock-pill">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                In Stock
                            </span>
                        </div>

                        <!-- Product Title -->
                        <h1 class="tea-product-title">{{ $details->name }}</h1>

                        <!-- Ratings summary -->
                        <div class="tea-rating-row">
                            <div class="tea-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="text-muted" style="font-size: 13px;">5.0</span>
                            <a href="#reviews-section" class="tea-rating-count">({{ $reviews->count() }} customer {{ Str::plural('review', $reviews->count()) }})</a>
                        </div>

                        <!-- Price Showcase -->
                        <div class="tea-price-box">
                            <div class="tea-current-price">
                                <span class="currency">৳</span><span id="regp">@if ($productsizes->count() > 0){{ $productsizes[0]->SalePrice }}@else{{ $details->new_price }}@endif</span>
                            </div>

                            @if ($productsizes->count() > 0 && $productsizes[0]->RegularPrice > $productsizes[0]->SalePrice)
                                <div class="tea-old-price">
                                    <span class="currency">৳</span><span id="delp">{{ $productsizes[0]->RegularPrice }}</span>
                                </div>
                                <span class="tea-savings-pill">
                                    Save ৳{{ $productsizes[0]->RegularPrice - $productsizes[0]->SalePrice }}
                                </span>
                            @elseif ($details->old_price && $details->old_price > $details->new_price)
                                <div class="tea-old-price">
                                    <span class="currency">৳</span><span id="delp">{{ $details->old_price }}</span>
                                </div>
                                <span class="tea-savings-pill">
                                    Save ৳{{ $details->old_price - $details->new_price }}
                                </span>
                            @endif
                        </div>

                        <!-- Short Description / Highlights -->
                        @if (isset($details->short_des) && !empty($details->short_des))
                            <div class="tea-short-des">
                                {!! $details->short_des !!}
                            </div>
                        @endif

                        <!-- PURCHASE FORM -->
                        <form action="{{ route('cart.store') }}" method="POST" id="addcart" name="formName">
                            @csrf
                            <input type="hidden" name="id" value="{{ $details->id }}" />

                            <!-- Color / Blend Selector -->
                            @if ($productcolors->count() > 0)
                                <div class="tea-selector-group">
                                    <label class="tea-selector-label">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="m4.93 4.93 4.24 4.24"></path><path d="m14.83 9.17 4.24-4.24"></path><path d="m14.83 14.83 4.24 4.24"></path><path d="m9.17 14.83-4.24 4.24"></path></svg>
                                        Choose Variant / Blend:
                                    </label>
                                    <div class="tea-color-options">
                                        @foreach ($productcolors as $key => $procolor)
                                            <div class="tea-color-option">
                                                <input type="radio"
                                                    id="fc-option{{ $procolor->id }}"
                                                    value="{{ $procolor->color }}"
                                                    name="product_color"
                                                    class="emptyalert"
                                                    {{ $key == 0 ? 'checked' : '' }}
                                                    required />
                                                <label for="fc-option{{ $procolor->id }}"
                                                    id="smimg{{ $key }}"
                                                    onclick="setimg({{ $key }})"
                                                    title="{{ $procolor->color }}">
                                                    <img src="{{ asset($procolor->Image) }}" alt="{{ $procolor->color }}" />
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Weight / Pack Size Selector -->
                            @if ($productsizes->count() > 0)
                                <div class="tea-selector-group">
                                    <label class="tea-selector-label">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"></path><path d="M7 21h10"></path><path d="M12 3v18"></path><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"></path></svg>
                                        Select Weight / Pack:
                                    </label>
                                    <div class="tea-weight-options">
                                        @foreach ($productsizes as $prosize)
                                            <div class="tea-weight-option">
                                                <input type="radio"
                                                    id="f-option{{ $prosize->id }}"
                                                    value="{{ $prosize->size }}"
                                                    name="product_size"
                                                    class="select_product_size emptyalert"
                                                    {{ $loop->first ? 'checked' : '' }}
                                                    required />
                                                <label for="f-option{{ $prosize->id }}"
                                                    onclick="setprice({{ $prosize->RegularPrice }}, {{ $prosize->SalePrice }})">
                                                    {{ $prosize->size }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Hidden Unit if any -->
                            @if ($details->pro_unit)
                                <div class="mb-3 text-muted" style="font-size: 13px;">
                                    <strong>Packaging:</strong> {{ $details->pro_unit }}
                                    <input type="hidden" name="pro_unit" value="{{ $details->pro_unit }}" />
                                </div>
                            @endif

                            <!-- Quantity Stepper & Primary Actions -->
                            <div class="tea-actions-row">
                                <!-- Stepper -->
                                <div class="tea-qty-stepper">
                                    <button type="button" class="tea-qty-btn minus" aria-label="Decrease quantity">−</button>
                                    <input type="text" id="getqty" name="qty" value="1" readonly class="tea-qty-input" />
                                    <button type="button" class="tea-qty-btn plus" aria-label="Increase quantity">+</button>
                                </div>

                                <!-- Add to Cart Button -->
                                <button type="submit" id="addtocart_btn_m" name="add_cart" value="ADD TO CART"
                                    class="tea-btn-cart" onclick="return sendSuccess();">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
                                    Add to Cart
                                </button>

                                <!-- Buy Now Button -->
                                <button type="submit" id="order_now_btn_m" name="order_now" value="BUY NOW"
                                    class="tea-btn-buy" onclick="return sendSuccess();">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m13 2-2 10h5L11 22l2-10H8l5-10Z"></path></svg>
                                    Buy Now (অর্ডার করুন)
                                </button>
                            </div>

                            <!-- Stock Out Notification -->
                            <div class="product_stock_out d-none">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                Currently Out of Stock for this variant.
                            </div>

                            <!-- Hotline Quick Order Box -->
                            @if (isset($contact->hotline))
                                <div class="tea-hotline-box">
                                    <div class="tea-hotline-text">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:-2px; margin-right:4px; color:#15803d;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        সরাসরি ফোনে অর্ডার করতে কল করুন:
                                    </div>
                                    <a class="tea-hotline-link" href="tel:{{ $contact->hotline }}">
                                        {{ $contact->hotline }}
                                    </a>
                                </div>
                            @endif

                            <!-- Guarantees Grid -->
                            <div class="tea-guarantee-grid">
                                <div class="tea-guarantee-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"></path></svg>
                                    100% Organic
                                </div>
                                <div class="tea-guarantee-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                    Fast Delivery
                                </div>
                                <div class="tea-guarantee-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                                    Cash on Delivery
                                </div>
                                <div class="tea-guarantee-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                    Quality Tested
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description & Video Section -->
        <section class="tea-description-section" id="description-section">
            <div class="tea-section-header text-start mb-4">
                <span class="tea-section-subtitle">Craft & Details</span>
                <h2 class="tea-section-title" style="font-size: 26px;">বিস্তারিত ও বৈশিষ্ট্য (Description)</h2>
                <div class="tea-divider-leaf" style="justify-content: flex-start;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path></svg>
                </div>
            </div>

            <div class="row">
                <!-- Description Body -->
                <div class="col-lg-{{ isset($details->pro_video) && !empty($details->pro_video) ? '8' : '12' }}">
                    <div class="tea-tab-content-card">
                        <div class="tea-description-body">
                            {!! $details->description !!}
                        </div>
                    </div>
                </div>

                <!-- Video Showcase Sidebar (if available) -->
                @if (isset($details->pro_video) && !empty($details->pro_video))
                    <div class="col-lg-4">
                        <div class="tea-video-card">
                            <h3>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                                ভিডিও রিভিউ ও প্রস্তুতি
                            </h3>
                            <div class="tea-video-wrap">
                                <iframe src="https://www.youtube.com/embed/{{ $details->pro_video }}" title="Tea Video Showcase" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Customer Reviews Section (Directly under Description) -->
        <section class="tea-reviews-section mt-5" id="reviews-section">
            <div class="tea-tab-content-card">
                <div class="tea-reviews-header">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="m-0">Customer Reviews (গ্রাহকদের রিভিউ)</h3>
                            <span class="tea-tab-badge">{{ $reviews->count() }} Reviews</span>
                        </div>
                        <p class="text-muted m-0 mt-1" style="font-size: 13px;">Real experiences from customers who tasted this authentic blend.</p>
                    </div>
                    <button type="button" class="tea-btn-write-review" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        Write a Review (রিভিউ দিন)
                    </button>
                </div>

                @if ($reviews->count() > 0)
                    <div class="tea-reviews-list">
                        @foreach ($reviews as $review)
                            <div class="tea-review-card">
                                <div class="tea-review-author">
                                    <div class="tea-author-avatar">
                                        @if ($review->image)
                                            <img src="{{ asset($review->image) }}" alt="{{ $review->name }}">
                                        @else
                                            {{ strtoupper(substr($review->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="tea-author-info">
                                        <strong>{{ $review->name }}</strong>
                                        <small>{{ $review->created_at->format('d M, Y') }} • Verified Buyer</small>
                                    </div>
                                    <div class="tea-stars ms-auto">
                                        {!! str_repeat('<i class="fa-solid fa-star"></i>', $review->ratting) !!}
                                    </div>
                                </div>
                                <p class="tea-review-text">{{ $review->review }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="tea-empty-reviews">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path><path d="M16 13H8"></path><path d="M16 17H8"></path><path d="M10 9H8"></path></svg>
                        <p style="font-size: 15px; font-weight: 600; color: var(--tea-dark);">No reviews yet for this tea.</p>
                        <p style="font-size: 13px;">Be the first tea lover to share your brewing experience and taste notes!</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- RELATED PRODUCTS SECTION -->
        @if ($products->count() > 0)
            <section class="tea-related-section">
                <div class="tea-section-header">
                    <span class="tea-section-subtitle">Curated Collection</span>
                    <h2 class="tea-section-title">You May Also Savor (সম্পর্কিত পণ্য)</h2>
                    <div class="tea-divider-leaf">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"></path></svg>
                    </div>
                </div>

                <div class="owl-carousel related_slider">
                    @foreach ($products as $key => $value)
                        <div class="tea-product-card">
                            @if ($value->old_price && $value->old_price > $value->new_price)
                                @php
                                    $rel_discount = (($value->old_price - $value->new_price) * 100) / $value->old_price;
                                @endphp
                                <span class="tea-card-badge">{{ number_format($rel_discount, 0) }}% OFF</span>
                            @endif

                            <a href="{{ route('product', $value->slug) }}" class="tea-card-media">
                                <img src="{{ asset($value->image ? $value->image->image : '') }}" alt="{{ $value->name }}" loading="lazy" />
                            </a>

                            <div class="tea-card-body">
                                <a href="{{ route('product', $value->slug) }}" class="tea-card-title">
                                    {{ Str::limit($value->name, 55) }}
                                </a>

                                <div class="tea-card-pricing">
                                    @if ($value->old_price && $value->old_price > $value->new_price)
                                        <span class="tea-card-oldprice">৳ {{ $value->old_price }}</span>
                                    @endif
                                    <span class="tea-card-price">৳ {{ $value->new_price }}</span>
                                </div>

                                <a href="{{ route('product', $value->slug) }}" class="tea-card-btn">
                                    View Details & Buy
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</main>

<!-- Review Modal Dialog -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Share Your Tea Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (Auth::guard('customer')->user())
                    <form action="{{ route('customer.review') }}" id="review-form" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $details->id }}">

                        <div class="mb-3">
                            <label class="form-label font-weight-bold" style="font-size: 13px;">Your Rating *</label>
                            <div class="rating">
                                <input required type="radio" id="star5" name="ratting" value="5" /><label for="star5" title="Excellent">★</label>
                                <input required type="radio" id="star4" name="ratting" value="4" /><label for="star4" title="Very Good">★</label>
                                <input required type="radio" id="star3" name="ratting" value="3" /><label for="star3" title="Good">★</label>
                                <input required type="radio" id="star2" name="ratting" value="2" /><label for="star2" title="Fair">★</label>
                                <input required type="radio" id="star1" name="ratting" value="1" /><label for="star1" title="Poor">★</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="message-text" class="form-label font-weight-bold" style="font-size: 13px;">Your Review / Tasting Notes *</label>
                            <textarea required class="form-control" name="review" id="message-text" rows="4" placeholder="How was the aroma, flavor and taste?" style="border-radius: 12px; border: 1px solid var(--tea-border);"></textarea>
                            <span id="validation-message" style="color: red; font-size: 12px;"></span>
                        </div>

                        <button class="details-review-button" type="submit">Submit Review</button>
                    </form>
                @else
                    <div class="text-center py-4">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2 text-warning"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <h6 style="color: var(--tea-dark); font-weight: 700;">Sign in to Share Your Review</h6>
                        <p class="text-muted" style="font-size: 13px;">Please log in with your customer account to post a verified review.</p>
                        <a class="btn tea-btn-buy" href="{{ route('customer.login') }}" style="display: inline-block; padding: 10px 24px;">Login to Review</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ asset('public/frontEnd/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('public/frontEnd/js/zoomsl.min.js') }}"></script>

    <script>
        function setprice(delp, regp) {
            $('#delp').html(delp);
            $('#regp').html(regp);
        }

        $(document).ready(function() {
            // Main Product Details Image Slider
            var detailsSlider = $(".details_slider").owlCarousel({
                margin: 0,
                items: 1,
                loop: false,
                dots: false,
                nav: false,
                autoplay: false,
            });

            // Thumbnail Click Handler
            $(".indicator-item").on("click", function() {
                var slideIndex = $(this).data("id");
                $(".indicator-item").removeClass("active");
                $(this).addClass("active");
                detailsSlider.trigger("to.owl.carousel", [slideIndex, 300]);
            });

            // Thumbnails strip carousel if > 4 images
            $(".thumb_slider").owlCarousel({
                margin: 10,
                items: 5,
                loop: false,
                dots: false,
                nav: true,
                responsive: {
                    0: { items: 3 },
                    480: { items: 4 },
                    768: { items: 5 }
                }
            });

            // Related Products Slider
            $(".related_slider").owlCarousel({
                margin: 16,
                items: 5,
                loop: true,
                dots: true,
                nav: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: { items: 2, margin: 8 },
                    600: { items: 3, margin: 12 },
                    1024: { items: 5, margin: 16 }
                }
            });

            // Zoom feature
            if ($(window).width() > 768) {
                $(".block__pic").imagezoomsl({
                    zoomrange: [2.5, 2.5]
                });
            }

            // Smooth scroll to reviews section from top rating summary
            $(".tea-rating-count").on("click", function(e) {
                e.preventDefault();
                $("html, body").animate({
                    scrollTop: $("#reviews-section").offset().top - 90
                }, 400);
            });
        });

        function setimg(indx) {
            $(".tea-color-option label").css("border-color", '#e2e8f0');
            $("#smimg" + indx).css("border-color", '#d8b77c');
            $(".details_slider").trigger("to.owl.carousel", [indx, 300]);
        }

        // Stepper & Stock AJAX
        $(document).ready(function() {
            $(".minus").click(function() {
                var $input = $('#getqty');
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count).change();
                checkStock(count);
                return false;
            });

            $(".plus").click(function() {
                var $input = $('#getqty');
                var count = parseInt($input.val()) + 1;
                $input.val(count).change();
                checkStock(count);
                return false;
            });

            $(document).on('change', '.select_product_size', function() {
                var count = parseInt($('#getqty').val()) || 1;
                checkStock(count);
            });

            function checkStock(count) {
                var product_type = "{{ $details->type }}";
                var single_product_stock = "{{ $details->stock }}";
                var product_id = "{{ $details->id }}";
                var size = $('.select_product_size:checked').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ url('get/quantity/cart') }}",
                    data: {
                        product_id: product_id,
                        size: size
                    },
                    success: function(data) {
                        if (product_type == 1) {
                            if (data < count) {
                                $('#addtocart_btn_m, #order_now_btn_m').prop('disabled', true).css('opacity', '0.5');
                                $('.product_stock_out').removeClass('d-none');
                            } else {
                                $('#addtocart_btn_m, #order_now_btn_m').prop('disabled', false).css('opacity', '1');
                                $('.product_stock_out').addClass('d-none');
                            }
                        } else {
                            if (single_product_stock < count) {
                                $('#addtocart_btn_m, #order_now_btn_m').prop('disabled', true).css('opacity', '0.5');
                                $('.product_stock_out').removeClass('d-none');
                            } else {
                                $('#addtocart_btn_m, #order_now_btn_m').prop('disabled', false).css('opacity', '1');
                                $('.product_stock_out').addClass('d-none');
                            }
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });

        function sendSuccess() {
            if ($('input[name="product_size"]').length > 0) {
                if (!$('input[name="product_size"]:checked').val()) {
                    toastr.warning("Please select a size / weight");
                    return false;
                }
            }
            if ($('input[name="product_color"]').length > 0) {
                if (!$('input[name="product_color"]:checked').val()) {
                    toastr.error("Please select a color / variant");
                    return false;
                }
            }
            return true;
        }
    </script>

    <!-- Google Tag Manager Data Layer -->
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            event: "view_item",
            ecommerce: {
                currency: "BDT",
                value: Number("{{ $details->new_price }}"),
                items: [{
                    item_name: "{{ $details->name }}",
                    item_id: Number("{{ $details->id }}"),
                    price: Number("{{ $details->new_price }}"),
                    item_brand: "{{ $details->brand ? $details->brand->name : '' }}",
                    item_category: "{{ $details->category ? $details->category->name : '' }}",
                    item_variant: Number("{{ $details->pro_unit }}"),
                    currency: "BDT",
                    quantity: $('#getqty').val()
                }]
            }
        });

        $(document).ready(function() {
            var addcartEl = document.getElementById('addcart');
            if (addcartEl) {
                addcartEl.addEventListener('submit', function(event) {
                    window.dataLayer = window.dataLayer || [];
                    dataLayer.push({ ecommerce: null });
                    dataLayer.push({
                        event: "add_to_cart",
                        ecommerce: {
                            currency: "BDT",
                            value: Number("{{ $details->new_price }}"),
                            items: [{
                                item_name: "{{ $details->name }}",
                                item_id: Number("{{ $details->id }}"),
                                price: Number("{{ $details->new_price }}"),
                                item_brand: "{{ $details->brand ? $details->brand->name : '' }}",
                                item_category: "{{ $details->category ? $details->category->name : '' }}",
                                item_variant: Number("{{ $details->pro_unit }}"),
                                currency: "BDT",
                                quantity: $('#getqty').val()
                            }]
                        }
                    });
                });
            }
        });
    </script>
@endpush
