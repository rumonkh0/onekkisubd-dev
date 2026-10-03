@extends('frontEnd.layouts.master')
@section('title', $category->meta_title ?? $category->name . ' - এক অনন্য চা কালেকশন')

@push('css')
<link rel="stylesheet" href="{{ asset('public/frontEnd/css/jquery-ui.css') }}" />
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

    #content {
        width: 100%;
        padding-top: 0 !important;
        background: #fbf9f5;
    }

    .tea-category-page {
        font-family: var(--font-sans);
        color: #1f2937;
        padding-bottom: 70px;
    }

    /* Category Hero Banner */
    .tea-cat-hero {
        background: linear-gradient(135deg, #0a211b 0%, #173f2c 60%, #245a2d 100%);
        color: #ffffff;
        padding: 42px 0 38px;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        box-shadow: 0 10px 30px rgba(10, 33, 27, 0.15);
    }
    .tea-cat-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(205, 176, 106, 0.22) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .tea-cat-hero::after {
        content: '';
        position: absolute;
        bottom: -40px;
        left: 20%;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.06) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .tea-cat-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #d1fae5;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }
    .tea-cat-breadcrumb a {
        color: #e2cf9c;
        text-decoration: none;
        transition: color 0.2s;
    }
    .tea-cat-breadcrumb a:hover {
        color: #ffffff;
        text-decoration: underline;
    }
    .tea-cat-breadcrumb span.sep {
        color: rgba(226, 207, 156, 0.6);
        font-size: 11px;
    }
    .tea-cat-breadcrumb span.active {
        color: #ffffff;
        font-weight: 600;
    }

    .tea-cat-header-content {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .tea-cat-title-wrap h1 {
        font-family: var(--font-serif);
        font-size: 32px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 6px 0;
        letter-spacing: -0.3px;
    }
    .tea-cat-title-wrap p {
        margin: 0;
        font-size: 14.5px;
        color: #d1fae5;
        max-width: 600px;
        line-height: 1.5;
    }

    .tea-cat-count-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(8px);
        padding: 7px 16px;
        border-radius: 30px;
        font-size: 13px;
        color: #fef3c7;
        border: 1px solid rgba(254, 243, 199, 0.25);
    }
    .tea-cat-count-pill i {
        color: var(--tea-gold);
    }

    /* Subcategories Pill Bar */
    .tea-subcat-nav {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 6px;
        margin-top: 20px;
        scrollbar-width: none;
    }
    .tea-subcat-nav::-webkit-scrollbar {
        display: none;
    }
    .tea-subcat-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s ease;
    }
    .tea-subcat-chip:hover, .tea-subcat-chip.active {
        background: var(--tea-gold);
        color: var(--tea-dark);
        border-color: var(--tea-gold);
        font-weight: 600;
        transform: translateY(-1px);
    }

    /* Toolbar / Sort Bar */
    .tea-toolbar-card {
        background: #ffffff;
        border: 1.5px solid var(--tea-border);
        border-radius: 16px;
        padding: 14px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        box-shadow: 0 4px 14px rgba(10, 33, 27, 0.03);
    }
    .tea-results-count {
        font-size: 14px;
        font-weight: 600;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-results-count strong {
        color: var(--tea-dark);
    }

    .tea-controls-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .tea-sort-select {
        background: #fbf9f5 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23173f2c'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat right 12px center;
        background-size: 16px;
        border: 1.5px solid var(--tea-border);
        border-radius: 12px;
        padding: 9px 38px 9px 14px;
        font-size: 13.5px;
        font-weight: 600;
        color: var(--tea-dark);
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .tea-sort-select:focus {
        border-color: var(--tea-green);
        box-shadow: 0 0 0 3px rgba(23, 63, 44, 0.12);
    }

    .tea-mobile-filter-btn {
        display: none;
        align-items: center;
        gap: 8px;
        background: var(--tea-dark);
        color: #ffffff !important;
        border: none;
        border-radius: 12px;
        padding: 9px 16px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .tea-mobile-filter-btn:hover {
        background: var(--tea-green);
    }

    /* Active Filter Tags */
    .tea-active-filters {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        width: 100%;
        padding-top: 10px;
        border-top: 1px dashed var(--tea-border);
    }
    .tea-filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f4f8f2;
        color: var(--tea-green);
        border: 1px solid #c9dec4;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: 600;
    }
    .tea-filter-tag a {
        color: #b91c1c;
        text-decoration: none;
        margin-left: 2px;
        font-size: 14px;
    }
    .tea-clear-all-link {
        font-size: 12px;
        color: #b91c1c;
        text-decoration: none;
        font-weight: 600;
        margin-left: 6px;
    }
    .tea-clear-all-link:hover {
        text-decoration: underline;
    }

    /* Sidebar Filter Card */
    .tea-filter-card {
        background: #ffffff;
        border: 1.5px solid var(--tea-border);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(10, 33, 27, 0.04);
        margin-bottom: 24px;
    }
    .tea-filter-header {
        background: linear-gradient(to right, #faf8f5, #ffffff);
        padding: 16px 20px;
        border-bottom: 1.5px solid var(--tea-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .tea-filter-header h5 {
        margin: 0;
        font-family: var(--font-serif);
        font-size: 16px;
        font-weight: 700;
        color: var(--tea-dark);
        display: flex;
        align-items: center;
        gap: 9px;
    }
    .tea-filter-header h5 i {
        color: var(--tea-green);
        font-size: 15px;
    }
    .tea-filter-body {
        padding: 20px;
    }

    /* Accordion in Sidebar */
    .tea-filter-accordion .accordion-item {
        border: none;
        border-bottom: 1px solid #f1ede4;
        margin-bottom: 0;
    }
    .tea-filter-accordion .accordion-item:last-child {
        border-bottom: none;
    }
    .tea-filter-accordion .accordion-button {
        font-family: var(--font-serif);
        font-size: 15px;
        font-weight: 700;
        color: var(--tea-dark);
        padding: 14px 0;
        background: transparent;
        box-shadow: none;
    }
    .tea-filter-accordion .accordion-button:not(.collapsed) {
        color: var(--tea-green);
        background: transparent;
    }
    .tea-filter-accordion .accordion-button::after {
        background-size: 14px;
    }
    .tea-filter-accordion .accordion-body {
        padding: 4px 0 16px 0;
    }

    /* Subcategory Filter Checklist */
    .tea-filter-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .tea-filter-item {
        margin-bottom: 9px;
    }
    .tea-filter-item:last-child {
        margin-bottom: 0;
    }
    .tea-filter-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        padding: 6px 8px;
        border-radius: 8px;
        transition: background 0.15s;
        margin: 0;
    }
    .tea-filter-label:hover {
        background: #f4f8f2;
    }
    .tea-filter-check-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-checkbox {
        width: 18px;
        height: 18px;
        border-radius: 5px;
        border: 1.5px solid #cbd5e1;
        accent-color: var(--tea-green);
        cursor: pointer;
    }
    .tea-filter-name {
        font-size: 13.5px;
        font-weight: 500;
        color: #374151;
        margin: 0;
    }
    .tea-filter-label:hover .tea-filter-name {
        color: var(--tea-green);
        font-weight: 600;
    }

    /* Price Range Slider Styling */
    .tea-price-slider-box {
        padding: 8px 4px 12px;
    }
    .tea-price-inputs-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 18px;
    }
    .tea-price-badge {
        flex: 1;
        background: #faf8f5;
        border: 1.5px solid var(--tea-border);
        border-radius: 10px;
        padding: 6px 10px;
        text-align: center;
    }
    .tea-price-badge span.lbl {
        display: block;
        font-size: 10.5px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }
    .tea-price-badge input {
        width: 100%;
        border: none;
        background: transparent;
        font-size: 14px;
        font-weight: 700;
        color: var(--tea-dark);
        text-align: center;
        outline: none;
    }
    .tea-price-sep {
        color: #9ca3af;
        font-weight: 600;
    }

    /* Custom jQuery UI Slider */
    .ui-slider-horizontal {
        height: 6px !important;
        background: #e5e7eb !important;
        border: none !important;
        border-radius: 6px !important;
    }
    .ui-slider .ui-slider-range {
        background: linear-gradient(to right, var(--tea-green), var(--tea-gold)) !important;
        border-radius: 6px !important;
    }
    .ui-slider .ui-slider-handle {
        width: 18px !important;
        height: 18px !important;
        top: -6px !important;
        border-radius: 50% !important;
        background: #ffffff !important;
        border: 2.5px solid var(--tea-green) !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.18) !important;
        cursor: pointer !important;
        outline: none !important;
        transition: transform 0.15s, border-color 0.15s;
    }
    .ui-slider .ui-slider-handle:hover, .ui-slider .ui-slider-handle.ui-state-active {
        transform: scale(1.15);
        border-color: var(--tea-gold) !important;
    }

    .tea-apply-price-btn {
        width: 100%;
        margin-top: 16px;
        background: var(--tea-green);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: background 0.2s, transform 0.2s;
    }
    .tea-apply-price-btn:hover {
        background: var(--tea-dark);
        transform: translateY(-1px);
    }

    /* Product Cards Grid */
    .tea-products-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
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

    /* Card Badges */
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

    /* Card Action Buttons */
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

    /* Out of Stock Pill */
    .tea-out-stock-chip {
        display: inline-block;
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        margin-bottom: 6px;
    }

    /* Empty State */
    .tea-empty-state {
        background: #ffffff;
        border: 1.5px solid var(--tea-border);
        border-radius: 20px;
        padding: 50px 30px;
        text-align: center;
        grid-column: 1 / -1;
    }
    .tea-empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: #fbf7ee;
        color: var(--tea-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin: 0 auto 16px;
    }
    .tea-empty-state h4 {
        font-family: var(--font-serif);
        font-size: 20px;
        font-weight: 700;
        color: var(--tea-dark);
        margin-bottom: 8px;
    }
    .tea-empty-state p {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Pagination */
    .tea-pagination-wrap {
        margin-top: 36px;
        display: flex;
        justify-content: center;
    }
    .tea-pagination-wrap .pagination {
        gap: 6px;
    }
    .tea-pagination-wrap .page-item .page-link {
        border-radius: 10px;
        border: 1.5px solid var(--tea-border);
        color: var(--tea-dark);
        font-weight: 600;
        font-size: 13.5px;
        padding: 8px 14px;
        transition: all 0.2s;
    }
    .tea-pagination-wrap .page-item.active .page-link {
        background: var(--tea-green);
        border-color: var(--tea-green);
        color: #ffffff;
    }
    .tea-pagination-wrap .page-item .page-link:hover {
        background: #f4f8f2;
        border-color: var(--tea-green);
        color: var(--tea-green);
    }

    /* Mobile Drawer */
    @media (max-width: 991px) {
        .tea-products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .tea-mobile-filter-btn {
            display: inline-flex;
        }

        .filter_sidebar {
            position: fixed;
            top: 0;
            left: -320px;
            width: 300px;
            height: 100vh;
            background: #ffffff;
            z-index: 99999;
            overflow-y: auto;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
            transition: left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 20px;
        }
        .filter_sidebar.active {
            left: 0;
        }
        .filter_close {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 15px;
            font-weight: 700;
            color: var(--tea-dark);
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid var(--tea-border);
            cursor: pointer;
        }
        .filter_close i {
            font-size: 18px;
            color: #ef4444;
        }
    }

    @media (min-width: 992px) {
        .filter_close {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .tea-cat-hero {
            padding: 28px 0 24px;
        }
        .tea-cat-title-wrap h1 {
            font-size: 24px;
        }
        .tea-products-grid {
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
    }
</style>
@endpush

@push('seo')
    <meta name="app-url" content="{{ route('category', $category->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ $category->meta_description }}" />
    <meta name="keywords" content="{{ $category->slug }}" />

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product" />
    <meta name="twitter:site" content="{{ $category->name }}" />
    <meta name="twitter:title" content="{{ $category->name }}" />
    <meta name="twitter:description" content="{{ $category->meta_description }}" />
    <meta name="twitter:creator" content="gomobd.com" />
    <meta property="og:url" content="{{ route('category', $category->slug) }}" />
    <meta name="twitter:image" content="{{ asset($category->image) }}" />

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $category->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('category', $category->slug) }}" />
    <meta property="og:image" content="{{ asset($category->image) }}" />
    <meta property="og:description" content="{{ $category->meta_description }}" />
    <meta property="og:site_name" content="{{ $category->name }}" />
@endpush

@section('content')
<div class="tea-category-page">

    <!-- Category Header Hero -->
    <section class="tea-cat-hero">
        <div class="container">
            <!-- Breadcrumbs -->
            <div class="tea-cat-breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> হোম</a>
                <span class="sep">/</span>
                <a href="{{ route('shop') }}">চা সম্ভার (Shop)</a>
                <span class="sep">/</span>
                <span class="active">{{ preg_replace('/(?<=\S)\(/u', ' (', $category->name) }}</span>
            </div>

            <!-- Title & Count -->
            <div class="tea-cat-header-content">
                <div class="tea-cat-title-wrap">
                    <h1>{{ preg_replace('/(?<=\S)\(/u', ' (', $category->name) }}</h1>
                    <p>
                        @if (!empty($category->meta_description))
                            {{ Str::limit(strip_tags($category->meta_description), 140) }}
                        @else
                            বাছাইকৃত সেরা মানের প্রিমিয়াম চা ও হার্বাল ব্লেন্ডস
                        @endif
                    </p>
                </div>

                <div class="tea-cat-count-pill">
                    <i class="fa-solid fa-leaf"></i>
                    <span>মোট <strong>{{ $products->total() }}</strong> টি পণ্য</span>
                </div>
            </div>

            <!-- Quick Subcategories Pills -->
            @if (count($subcategories) > 0)
                <div class="tea-subcat-nav">
                    <a href="{{ route('category', $category->slug) }}"
                        class="tea-subcat-chip {{ !request()->get('subcategory') ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i> সব চা (All)
                    </a>
                    @foreach ($subcategories as $subcat)
                        @php
                            $isSubActive = is_array(request()->get('subcategory')) && in_array($subcat->id, request()->get('subcategory'));
                        @endphp
                        <a href="{{ url('subcategory/' . $subcat->slug) }}"
                            class="tea-subcat-chip {{ $isSubActive ? 'active' : '' }}">
                            {{ $subcat->subcategoryName }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Main Content: Sidebar + Products -->
    <div class="container">
        <div class="row g-4">

            <!-- LEFT SIDEBAR: FILTERS -->
            <div class="col-lg-3 col-md-4 filter_sidebar">
                <div class="filter_close">
                    <span><i class="fa-solid fa-sliders me-2"></i> ফিল্টারসমূহ (Filters)</span>
                    <i class="fa-solid fa-xmark"></i>
                </div>

                <form action="" method="GET" class="attribute-submit" id="categoryFilterForm">
                    <input type="hidden" name="sort" id="filter_sort_hidden" value="{{ request()->get('sort') }}" />

                    <div class="tea-filter-card">
                        <div class="tea-filter-header">
                            <h5>
                                <i class="fa-solid fa-filter"></i>
                                ফিল্টার (Filter By)
                            </h5>
                            @if(request()->get('min_price') || request()->get('max_price') || request()->get('subcategory'))
                                <a href="{{ route('category', $category->slug) }}" class="tea-clear-all-link">
                                    রিসেট
                                </a>
                            @endif
                        </div>
                        <div class="tea-filter-body pt-2 pb-2">
                            <div class="accordion tea-filter-accordion" id="categorySidebarAccordion">

                                <!-- Subcategories Section -->
                                @if (count($subcategories) > 0)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseSubcategories" aria-expanded="true">
                                                সাব-ক্যাটেগরি (Categories)
                                            </button>
                                        </h2>
                                        <div id="collapseSubcategories" class="accordion-collapse collapse show">
                                            <div class="accordion-body">
                                                <ul class="tea-filter-list">
                                                    @foreach ($subcategories as $subcategory)
                                                        @php
                                                            $isChecked = is_array(request()->get('subcategory')) && in_array($subcategory->id, request()->get('subcategory'));
                                                        @endphp
                                                        <li class="tea-filter-item">
                                                            <label for="subcat-{{ $subcategory->id }}" class="tea-filter-label">
                                                                <div class="tea-filter-check-wrap">
                                                                    <input class="tea-checkbox form-attribute"
                                                                        type="checkbox"
                                                                        id="subcat-{{ $subcategory->id }}"
                                                                        name="subcategory[]"
                                                                        value="{{ $subcategory->id }}"
                                                                        {{ $isChecked ? 'checked' : '' }} />
                                                                    <span class="tea-filter-name">{{ $subcategory->subcategoryName }}</span>
                                                                </div>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Price Range Section -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapsePrice" aria-expanded="true">
                                            মূল্য সীমা (Price Range)
                                        </button>
                                    </h2>
                                    <div id="collapsePrice" class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <div class="tea-price-slider-box">
                                                <div class="tea-price-inputs-row">
                                                    <div class="tea-price-badge">
                                                        <span class="lbl">সর্বনিম্ন</span>
                                                        <input type="text" name="min_price" id="min_price" readonly />
                                                    </div>
                                                    <span class="tea-price-sep">-</span>
                                                    <div class="tea-price-badge">
                                                        <span class="lbl">সর্বোচ্চ</span>
                                                        <input type="text" name="max_price" id="max_price" readonly />
                                                    </div>
                                                </div>

                                                <div id="price-range"></div>

                                                <button type="submit" class="tea-apply-price-btn">
                                                    <i class="fa-solid fa-check"></i> মূল্য ফিল্টার করুন
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- RIGHT COLUMN: TOOLBAR & PRODUCT GRID -->
            <div class="col-lg-9 col-md-8 col-12">

                <!-- Top Toolbar Card -->
                <div class="tea-toolbar-card">
                    <div class="tea-results-count">
                        <i class="fa-solid fa-boxes-stacked text-success"></i>
                        <span>
                            প্রদর্শিত হচ্ছে <strong>{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong>
                            (মোট <strong>{{ $products->total() }}</strong> টির মধ্যে)
                        </span>
                    </div>

                    <div class="tea-controls-group">
                        <!-- Mobile Filter Trigger -->
                        <button type="button" class="tea-mobile-filter-btn filter_btn">
                            <i class="fa-solid fa-sliders"></i>
                            <span>ফিল্টার</span>
                        </button>

                        <!-- Sort Dropdown Form -->
                        <form action="" method="GET" class="sort-form m-0" id="sortDropdownForm">
                            <input type="hidden" name="min_price" value="{{ request()->get('min_price') }}" />
                            <input type="hidden" name="max_price" value="{{ request()->get('max_price') }}" />
                            @if(is_array(request()->get('subcategory')))
                                @foreach(request()->get('subcategory') as $subVal)
                                    <input type="hidden" name="subcategory[]" value="{{ $subVal }}" />
                                @endforeach
                            @endif

                            <select name="sort" class="tea-sort-select sort" onchange="this.form.submit()">
                                <option value="1" {{ request()->get('sort') == 1 ? 'selected' : '' }}>নতুন পণ্য (Latest)</option>
                                <option value="4" {{ request()->get('sort') == 4 ? 'selected' : '' }}>দাম: কম থেকে বেশি (Low to High)</option>
                                <option value="3" {{ request()->get('sort') == 3 ? 'selected' : '' }}>দাম: বেশি থেকে কম (High to Low)</option>
                                <option value="5" {{ request()->get('sort') == 5 ? 'selected' : '' }}>নাম: A থেকে Z</option>
                                <option value="6" {{ request()->get('sort') == 6 ? 'selected' : '' }}>নাম: Z থেকে A</option>
                                <option value="2" {{ request()->get('sort') == 2 ? 'selected' : '' }}>পুরাতন পণ্য (Oldest)</option>
                            </select>
                        </form>
                    </div>

                    <!-- Active Filter Badges (if applied) -->
                    @if(request()->get('min_price') || request()->get('max_price') || request()->get('subcategory'))
                        <div class="tea-active-filters">
                            <span style="font-size: 12px; color: #6b7280; font-weight: 600;">সক্রিয় ফিল্টার:</span>

                            @if(request()->get('min_price') && request()->get('max_price'))
                                <span class="tea-filter-tag">
                                    ৳{{ request()->get('min_price') }} - ৳{{ request()->get('max_price') }}
                                </span>
                            @endif

                            @if(is_array(request()->get('subcategory')))
                                @foreach($subcategories as $sc)
                                    @if(in_array($sc->id, request()->get('subcategory')))
                                        <span class="tea-filter-tag">
                                            {{ $sc->subcategoryName }}
                                        </span>
                                    @endif
                                @endforeach
                            @endif

                            <a href="{{ route('category', $category->slug) }}" class="tea-clear-all-link">
                                <i class="fa-solid fa-rotate-left"></i> ফিল্টার মুছুন
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Products Grid -->
                @if ($products->count() > 0)
                    <div class="tea-products-grid">
                        @foreach ($products as $key => $value)
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
                                    @if($isOutOfStock)
                                        <div>
                                            <span class="tea-out-stock-chip">স্টক শেষ (Out of Stock)</span>
                                        </div>
                                    @endif

                                    <a href="{{ route('product', $value->slug) }}" class="tea-card-title" title="{{ $engName }}">
                                        {{ $engName }}
                                    </a>

                                    @if ($bnName)
                                        <p class="tea-card-bn-subtitle">{{ $bnName }}</p>
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

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="tea-pagination-wrap">
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    @endif

                @else
                    <!-- Empty State -->
                    <div class="tea-empty-state">
                        <div class="tea-empty-icon">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                        <h4>দুঃখিত, কোনো চা পণ্য পাওয়া যায়নি</h4>
                        <p>আপনার নির্বাচিত ফিল্টার বা ক্যাটেগরিতে বর্তমানে কোনো পণ্য নেই। ফিল্টার পরিবর্তন করে আবার চেষ্টা করুন।</p>
                        <a href="{{ route('category', $category->slug) }}" class="tea-btn-buynow d-inline-block px-4 py-2">
                            <i class="fa-solid fa-rotate-left me-1"></i> সব পণ্য দেখুন (Reset Filters)
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
    <script>
        $(function() {
            var minP = {{ $min_price ?? 0 }};
            var maxP = {{ $max_price ?? 2000 }};
            var curMin = {{ request()->get('min_price') ? request()->get('min_price') : ($min_price ?? 0) }};
            var curMax = {{ request()->get('max_price') ? request()->get('max_price') : ($max_price ?? 2000) }};

            $("#price-range").slider({
                step: 10,
                range: true,
                min: minP,
                max: maxP,
                values: [curMin, curMax],
                slide: function(event, ui) {
                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                }
            });

            $("#min_price").val(curMin);
            $("#max_price").val(curMax);

            // Auto-submit on checkbox change
            $(".tea-checkbox").on("change", function() {
                $("#categoryFilterForm").submit();
            });
        });
    </script>
@endpush
