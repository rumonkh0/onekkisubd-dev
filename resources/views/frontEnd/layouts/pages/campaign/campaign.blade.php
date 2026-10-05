<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $campaign_data->name }} | {{ $generalsetting->name }}</title>
    <link rel="shortcut icon" href="{{ asset($generalsetting->favicon) }}" type="image/x-icon" />

    <!-- Font Awesome 6 & Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/all.css" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/animate.css" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/owl.theme.default.css" />
    <link rel="stylesheet" href="{{ asset('public/frontEnd/campaign/css') }}/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- Google Fonts for Editorial Luxury Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Facebook Pixel Code -->
    <script>
        !(function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = "2.0";
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s);
        })(window, document, "script", "https://connect.facebook.net/en_US/fbevents.js");
        fbq("init", "620464097560166");
        fbq("track", "PageView");
    </script>
    <noscript>
        <img height="1" width="1" style="display: none;" src="https://www.facebook.com/tr?id=620464097560166&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KCB3SXKF');
    </script>
    <!-- End Google Tag Manager -->

    <meta name="app-url" content="{{ route('campaign', $campaign_data->slug) }}" />
    <meta name="robots" content="index, follow" />
    <meta name="description" content="{{ Str::limit(strip_tags($campaign_data->short_description ?: $campaign_data->description ?: $product->description ?: $campaign_data->name), 160) }}" />
    <meta name="keywords" content="{{ $campaign_data->slug }}, {{ $campaign_data->name }}, {{ $product->name }}" />

    <!-- Open Graph data for Facebook Ads & Social Sharing -->
    <meta property="og:title" content="{{ $campaign_data->name }} | {{ $generalsetting->name }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('campaign', $campaign_data->slug) }}" />
    <meta property="og:image" content="{{ asset($campaign_data->image_one ?: ($product->image ? $product->image->image : '')) }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($campaign_data->short_description ?: $campaign_data->description ?: $product->description ?: $campaign_data->name), 160) }}" />
    <meta property="og:site_name" content="{{ $generalsetting->name }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $campaign_data->name }} | {{ $generalsetting->name }}" />
    <meta name="twitter:image" content="{{ asset($campaign_data->image_one ?: ($product->image ? $product->image->image : '')) }}" />

    <style>
        /* ========================================================
           HIGH-CONVERTING LUXURY CAMPAIGN LANDING PAGE STYLES
           Optimized for Facebook Ads (Exact Aspect Ratios, Fast UX)
           ======================================================== */
        :root {
            --tea-dark: #0a211b;
            --tea-forest: #173f2c;
            --tea-emerald: #1e4d35;
            --tea-light-green: #f4f8f2;
            --tea-border-green: #c9dec4;
            --tea-gold: #cdb06a;
            --tea-gold-light: #f7f1e1;
            --roselle-ruby: #9b111e;
            --roselle-crimson: #c53030;
            --roselle-glow: rgba(197, 48, 48, 0.35);
            --bg-creme: #fcfbf9;
            --text-main: #1f2937;
            --text-muted: #6b7280;
        }

        * {
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body, input, button, select, textarea, p, h1, h2, h3, h4, h5, h6, a, label, span:not(.fa):not(.fas):not(.fab):not(.far):not([class*="fa-"]) {
            font-family: 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', 'Plus Jakarta Sans', sans-serif;
        }

        .fa, .fas, .fa-solid, [class*="fa-"] {
            font-family: "Font Awesome 6 Free", "FontAwesome" !important;
            font-weight: 900 !important;
            font-style: normal !important;
        }
        .fab, .fa-brands {
            font-family: "Font Awesome 6 Brands", "FontAwesome" !important;
            font-weight: 400 !important;
            font-style: normal !important;
        }
        .far, .fa-regular {
            font-family: "Font Awesome 6 Free", "FontAwesome" !important;
            font-weight: 400 !important;
            font-style: normal !important;
        }

        body {
            background-color: var(--bg-creme);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Top Bar */
        .camp-topbar {
            background: linear-gradient(90deg, #0a211b 0%, #173f2c 50%, #0a211b 100%);
            color: #ffffff;
            font-size: 13.5px;
            padding: 8px 12px;
            text-align: center;
            border-bottom: 1px solid rgba(205, 176, 106, 0.4);
            font-weight: 500;
        }
        .camp-topbar span {
            color: #e2cf9c;
            font-weight: 700;
        }

        /* Header */
        .camp-header {
            background: #ffffff;
            box-shadow: 0 4px 20px -4px rgba(10, 33, 27, 0.06);
            padding: 14px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .camp-header-inner {
            max-width: 980px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .camp-logo img {
            max-height: 48px;
            width: auto;
            object-fit: contain;
        }
        .camp-header-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--roselle-ruby) 0%, var(--roselle-crimson) 100%);
            color: #ffffff !important;
            padding: 9px 18px;
            border-radius: 24px;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 14px var(--roselle-glow);
            transition: all 0.25s ease;
        }
        .camp-header-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(197, 48, 48, 0.5);
        }

        /* Wrapper Container */
        .camp-container {
            max-width: 940px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* Hero Section */
        .camp-hero-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e8e4dc;
            box-shadow: 0 12px 36px -8px rgba(10, 33, 27, 0.06);
            padding: 32px 28px;
            margin-top: 24px;
            margin-bottom: 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .camp-hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #cdb06a, #c53030, #173f2c);
        }

        .camp-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fdf5f5;
            border: 1px solid #fed7d7;
            color: var(--roselle-crimson);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 16px;
            letter-spacing: 0.2px;
        }
        .camp-badge-pill i {
            color: #e53e3e;
            animation: pulseIcon 1.6s infinite;
        }
        @keyframes pulseIcon {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.25); }
        }

        .camp-main-title {
            font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
            font-size: 32px;
            font-weight: 800;
            color: var(--tea-dark);
            line-height: 1.3;
            margin-bottom: 12px;
        }
        .camp-subtitle {
            font-size: 16px;
            color: #4b5563;
            max-width: 720px;
            margin: 0 auto 24px;
            line-height: 1.65;
        }

        /* 16:9 Hero Banner Aspect Ratio Container */
        .camp-slider-aspect-16-9 {
            width: 100%;
            aspect-ratio: 16 / 9;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 24px -4px rgba(10, 33, 27, 0.12);
            background: #f5f3ef;
            margin-bottom: 24px;
            position: relative;
        }
        .camp-slider-aspect-16-9 .slider-item,
        .camp-slider-aspect-16-9 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Value Props Grid */
        .camp-props-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
            text-align: center;
        }
        .camp-prop-box {
            background: #fcfbf9;
            border: 1px solid #ebd0a0;
            border-radius: 18px;
            padding: 22px 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            text-align: center;
            gap: 12px;
            transition: all 0.25s ease;
        }
        .camp-prop-box:hover {
            transform: translateY(-2px);
            border-color: var(--tea-forest);
            background: #ffffff;
            box-shadow: 0 6px 18px -4px rgba(10, 33, 27, 0.08);
        }
        .camp-prop-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fdf5f5;
            color: var(--roselle-crimson);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin: 0 auto;
            flex-shrink: 0;
            border: 1.5px solid #fecaca;
        }
        .camp-prop-text {
            width: 100%;
            text-align: center;
        }
        .camp-prop-text h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--tea-dark);
            margin: 0 0 6px 0;
            text-align: center;
        }
        .camp-prop-text p {
            font-size: 12.5px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.45;
            text-align: center;
        }

        /* Primary Jump Order Button */
        .camp-jump-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--roselle-ruby) 0%, var(--roselle-crimson) 100%);
            color: #ffffff !important;
            font-size: 18px;
            font-weight: 800;
            padding: 16px 36px;
            border-radius: 36px;
            text-decoration: none;
            box-shadow: 0 10px 28px var(--roselle-glow);
            transition: all 0.25s ease;
            animation: pulseButton 2s infinite ease-in-out;
        }
        @keyframes pulseButton {
            0%, 100% {
                box-shadow: 0 8px 24px var(--roselle-glow);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 14px 34px rgba(197, 48, 48, 0.55);
                transform: scale(1.02);
            }
        }
        .camp-jump-btn:hover {
            transform: translateY(-2px);
        }

        /* ========================================================
           FACEBOOK AD IMAGE RATIO SHOWCASE
           Strict preservation of 1:1, 9:16, 4:5 ratios
           ======================================================== */
        .camp-section-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .camp-section-tag {
            display: inline-block;
            background: var(--tea-light-green);
            color: var(--tea-forest);
            border: 1px solid var(--tea-border-green);
            font-size: 12px;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .camp-section-title {
            font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--tea-dark);
            margin: 0 0 6px 0;
        }
        .camp-section-desc {
            font-size: 14.5px;
            color: var(--text-muted);
            margin: 0;
        }

        .camp-media-showcase {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e8e4dc;
            padding: 28px 24px;
            box-shadow: 0 10px 30px -8px rgba(10, 33, 27, 0.05);
            margin-bottom: 32px;
        }

        .camp-media-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            align-items: stretch;
        }

        .camp-media-card {
            background: #fcfbf9;
            border: 1px solid #e8e4dc;
            border-radius: 20px;
            padding: 16px 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            transition: all 0.28s ease;
        }
        .camp-media-card:hover {
            transform: translateY(-4px);
            border-color: var(--tea-gold);
            box-shadow: 0 12px 28px -6px rgba(10, 33, 27, 0.1);
        }
        .camp-media-card > div:first-child {
            width: 100%;
            text-align: center;
        }

        .camp-media-badge {
            align-self: center;
            margin: 0 auto 12px auto;
            background: rgba(10, 33, 27, 0.85);
            color: #e2cf9c;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* 1:1 Square Wrapper */
        .aspect-box-1-1 {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 14px;
            overflow: hidden;
            background: #f4f2ee;
            margin-bottom: 12px;
        }
        .aspect-box-1-1 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .camp-media-card:hover .aspect-box-1-1 img {
            transform: scale(1.06);
        }

        /* 9:16 Story/Portrait Wrapper */
        .aspect-box-9-16 {
            width: 100%;
            aspect-ratio: 9 / 16;
            max-height: 480px;
            border-radius: 16px;
            overflow: hidden;
            background: #f4f2ee;
            margin-bottom: 12px;
        }
        .aspect-box-9-16 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .camp-media-card:hover .aspect-box-9-16 img {
            transform: scale(1.05);
        }

        /* 4:5 Portrait Wrapper */
        .aspect-box-4-5 {
            width: 100%;
            aspect-ratio: 4 / 5;
            border-radius: 14px;
            overflow: hidden;
            background: #f4f2ee;
            margin-bottom: 12px;
        }
        .aspect-box-4-5 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .camp-media-card:hover .aspect-box-4-5 img {
            transform: scale(1.06);
        }

        .camp-media-info {
            width: 100%;
            text-align: center;
            padding-top: 4px;
        }
        .camp-media-info h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--tea-dark);
            margin: 0 0 6px 0;
            text-align: center;
        }
        .camp-media-info p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.5;
            text-align: center;
        }

        /* Video Showcase */
        .camp-video-wrapper {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e8e4dc;
            padding: 28px 24px;
            box-shadow: 0 10px 30px -8px rgba(10, 33, 27, 0.05);
            margin-bottom: 32px;
        }
        .camp-video-aspect-16-9 {
            width: 100%;
            aspect-ratio: 16 / 9;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 32px -6px rgba(0, 0, 0, 0.2);
            background: #000000;
        }
        .camp-video-aspect-16-9 iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Comparison Section */
        .camp-compare-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e8e4dc;
            padding: 32px 28px;
            box-shadow: 0 10px 30px -8px rgba(10, 33, 27, 0.05);
            margin-bottom: 32px;
        }
        .camp-compare-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }
        .camp-compare-col {
            border-radius: 18px;
            padding: 24px 20px;
        }
        .camp-compare-good {
            background: #f4f8f2;
            border: 2px solid #b7dcaf;
        }
        .camp-compare-bad {
            background: #fdf5f5;
            border: 2px solid #fed7d7;
        }
        .camp-compare-header {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 8px;
            padding-bottom: 12px;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.12);
        }
        .camp-compare-good .camp-compare-header { color: #173f2c; }
        .camp-compare-bad .camp-compare-header { color: #9b1c1c; }

        .camp-compare-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .camp-compare-list li {
            font-size: 14px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .camp-compare-good li i { color: #10b981; font-size: 16px; margin-top: 2px; }
        .camp-compare-bad li i { color: #ef4444; font-size: 16px; margin-top: 2px; }

        /* Recipe / How to Drink Steps */
        .camp-recipe-section {
            background: linear-gradient(135deg, #0a211b 0%, #173f2c 100%);
            color: #ffffff;
            border-radius: 24px;
            padding: 36px 28px;
            box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.25);
            margin-bottom: 32px;
            border: 1px solid rgba(205, 176, 106, 0.35);
        }
        .camp-recipe-title {
            font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            text-align: center;
            margin-bottom: 24px;
        }
        .camp-recipe-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .camp-recipe-step {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(205, 176, 106, 0.3);
            border-radius: 16px;
            padding: 20px 16px;
            text-align: center;
            backdrop-filter: blur(4px);
        }
        .camp-step-num {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #cdb06a;
            color: #0a211b;
            font-weight: 800;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }
        .camp-step-desc {
            font-size: 13.5px;
            color: #e5e7eb;
            margin: 0;
            line-height: 1.5;
        }

        /* Reviews Carousel */
        .camp-reviews-section {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e8e4dc;
            padding: 32px 24px;
            box-shadow: 0 10px 30px -8px rgba(10, 33, 27, 0.05);
            margin-bottom: 32px;
        }
        .camp-review-aspect-1-1 {
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }
        .camp-review-aspect-1-1 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* FAQ Accordion */
        .camp-faq-section {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e8e4dc;
            padding: 32px 28px;
            box-shadow: 0 10px 30px -8px rgba(10, 33, 27, 0.05);
            margin-bottom: 32px;
        }
        .camp-faq-item {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            margin-bottom: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .camp-faq-item:hover {
            border-color: var(--tea-border-green);
        }
        .camp-faq-button {
            width: 100%;
            background: #fdfcf9;
            padding: 16px 20px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 15.5px;
            font-weight: 700;
            color: var(--tea-dark);
            text-align: left;
            cursor: pointer;
            gap: 12px;
        }
        .camp-faq-button:not(.collapsed) {
            background: #f4f8f2;
            color: var(--tea-forest);
            border-bottom: 1px solid #e5e7eb;
        }
        .camp-faq-button i {
            color: var(--tea-gold);
            font-size: 14px;
            transition: transform 0.2s ease;
        }
        .camp-faq-button:not(.collapsed) i {
            transform: rotate(90deg);
        }
        .camp-faq-body {
            padding: 18px 20px;
            font-size: 14.5px;
            color: #374151;
            line-height: 1.7;
            background: #ffffff;
        }
        .camp-faq-body p { margin-bottom: 8px; }
        .camp-faq-body span, .camp-faq-body h4 { font-family: inherit !important; }

        /* ========================================================
           HIGH CONVERTING CHECKOUT FORM SECTION
           ======================================================== */
        .camp-checkout-card {
            background: #ffffff;
            border-radius: 24px;
            border: 2px solid var(--tea-forest);
            box-shadow: 0 16px 48px -10px rgba(10, 33, 27, 0.15);
            padding: 36px 28px;
            margin-bottom: 40px;
            position: relative;
        }
        .camp-form-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .camp-form-title {
            font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--tea-dark);
            margin: 0 0 6px 0;
        }
        .camp-form-sub {
            font-size: 14.5px;
            color: var(--roselle-crimson);
            font-weight: 600;
            margin: 0;
        }

        .camp-checkout-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 32px;
        }

        /* Form Inputs */
        .camp-field-group {
            margin-bottom: 18px;
        }
        .camp-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 700;
            color: var(--tea-dark);
            margin-bottom: 8px;
        }
        .camp-input {
            width: 100%;
            height: 48px;
            border: 1.5px solid #d1d5db;
            border-radius: 12px;
            padding: 0 16px;
            font-size: 14.5px;
            color: #111827;
            background: #ffffff;
            outline: none;
            transition: all 0.2s ease;
        }
        .camp-input:focus {
            border-color: var(--tea-forest);
            box-shadow: 0 0 0 3px rgba(23, 63, 44, 0.12);
        }

        /* Delivery Area Selector */
        .camp-area-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 8px;
            margin-bottom: 20px;
        }
        .camp-area-card {
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 12px;
            cursor: pointer;
            background: #fdfcf9;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 10px;
        }
        .camp-area-card.selected,
        .camp-area-card:has(input:checked) {
            border-color: var(--tea-forest);
            background: #f4f8f2;
            box-shadow: 0 4px 12px rgba(23, 63, 44, 0.1);
        }
        .camp-area-radio {
            accent-color: var(--tea-forest);
            width: 18px;
            height: 18px;
            cursor: pointer;
            flex-shrink: 0;
        }
        .camp-area-info {
            text-align: center;
        }
        .camp-area-info h5 {
            font-size: 14px;
            font-weight: 700;
            color: var(--tea-dark);
            margin: 0 0 2px 0;
            text-align: center;
        }
        .camp-area-info span {
            font-size: 13px;
            font-weight: 800;
            color: var(--roselle-crimson);
            display: block;
            text-align: center;
        }

        /* Package Option Tiles */
        .camp-packages-section {
            margin-bottom: 24px;
        }
        .camp-package-tile {
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 10px;
            cursor: pointer;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }
        .camp-package-tile.selected,
        .camp-package-tile:has(input:checked) {
            border-color: var(--tea-forest);
            background: #f4f8f2;
            box-shadow: 0 4px 12px rgba(23, 63, 44, 0.08);
        }
        .camp-pkg-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .camp-pkg-radio {
            accent-color: var(--tea-forest);
            width: 18px;
            height: 18px;
        }
        .camp-pkg-label {
            font-size: 14.5px;
            font-weight: 700;
            color: var(--tea-dark);
            margin: 0;
        }
        .camp-pkg-sub {
            font-size: 12px;
            color: var(--text-muted);
        }
        .camp-pkg-price {
            font-size: 17px;
            font-weight: 800;
            color: var(--tea-forest);
            text-align: right;
        }

        /* Sticky Summary */
        .camp-summary-card {
            background: #fcfbf9;
            border: 1px solid #e8e4dc;
            border-radius: 20px;
            padding: 24px;
            position: sticky;
            top: 90px;
        }
        .camp-summary-title {
            font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--tea-dark);
            margin: 0 0 16px 0;
            padding-bottom: 10px;
            border-bottom: 1.5px solid #e8e4dc;
            text-align: center;
        }

        .camp-sum-prod {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }
        .camp-sum-thumb {
            width: 64px;
            height: 64px;
            aspect-ratio: 1 / 1;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            background: #ffffff;
            flex-shrink: 0;
        }
        .camp-sum-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .camp-sum-prod-info {
            flex-grow: 1;
        }
        .camp-sum-prod-name {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--tea-dark);
            margin: 0 0 6px 0;
            line-height: 1.35;
        }

        /* Stepper */
        .camp-stepper {
            display: inline-flex;
            align-items: center;
            border: 1.5px solid #d1d5db;
            border-radius: 16px;
            overflow: hidden;
            background: #ffffff;
            height: 34px;
        }
        .camp-step-btn {
            width: 32px;
            height: 100%;
            border: none;
            background: #f3f4f6;
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s ease;
        }
        .camp-step-btn:hover { background: #e5e7eb; }
        .camp-step-input {
            width: 38px;
            height: 100%;
            border: none;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            background: transparent;
            outline: none;
        }

        /* Calc Breakdown */
        .camp-sum-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 8px;
        }
        .camp-sum-row.total-row {
            font-size: 18px;
            font-weight: 800;
            color: var(--tea-dark);
            border-top: 1.5px solid #e8e4dc;
            padding-top: 12px;
            margin-top: 12px;
            margin-bottom: 16px;
        }
        .camp-grand-total {
            color: var(--roselle-crimson);
            font-size: 22px;
        }

        .camp-cod-badge {
            background: #f4f8f2;
            border: 1px solid #c9dec4;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 12.5px;
            color: #173f2c;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .camp-submit-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--roselle-ruby) 0%, var(--roselle-crimson) 100%);
            color: #ffffff;
            border: none;
            border-radius: 16px;
            padding: 16px;
            font-size: 17px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 10px 24px var(--roselle-glow);
            transition: all 0.25s ease;
        }
        .camp-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 32px rgba(197, 48, 48, 0.45);
        }

        /* Guarantees */
        .camp-guarantee-row {
            display: flex;
            justify-content: space-around;
            border-top: 1px solid #e8e4dc;
            margin-top: 24px;
            padding-top: 16px;
            text-align: center;
        }
        .camp-guarantee-item {
            font-size: 11.5px;
            color: #6b7280;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        .camp-guarantee-item i {
            color: var(--tea-gold);
            font-size: 16px;
        }

        /* Footer */
        .camp-footer {
            background: var(--tea-dark);
            color: #d1d5db;
            text-align: center;
            padding: 30px 16px 90px;
            font-size: 13.5px;
            border-top: 1px solid rgba(205, 176, 106, 0.3);
        }
        .camp-footer a {
            color: #e2cf9c;
            text-decoration: none;
        }

        /* Floating Concierge Action Buttons */
        .camp-floating-actions {
            position: fixed;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: calc(100% - 32px);
            max-width: 500px;
            background: rgba(10, 33, 27, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(205, 176, 106, 0.4);
            border-radius: 40px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 14px 36px rgba(0, 0, 0, 0.35);
        }
        .camp-floating-call,
        .camp-floating-wa {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .camp-floating-call { background: #2563eb; }
        .camp-floating-wa { background: #25d366; }
        .camp-floating-order-btn {
            flex-grow: 1;
            margin: 0 10px;
            background: linear-gradient(135deg, var(--roselle-ruby) 0%, var(--roselle-crimson) 100%);
            color: #ffffff !important;
            font-size: 14.5px;
            font-weight: 800;
            padding: 10px 16px;
            border-radius: 24px;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            box-shadow: 0 4px 14px var(--roselle-glow);
        }

        /* Responsive Breakpoints */
        @media (max-width: 991px) {
            .camp-props-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .camp-recipe-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .camp-checkout-grid {
                grid-template-columns: 1fr;
            }
            .camp-summary-card {
                position: static;
            }
        }

        /* Product Details / Benefits Card */
        .camp-details-card {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid #e8e4dc;
            box-shadow: 0 12px 36px -8px rgba(10, 33, 27, 0.06);
            padding: 36px 32px;
            margin-bottom: 32px;
            position: relative;
            overflow: hidden;
        }
        .camp-details-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #173f2c, #cdb06a, #c53030);
        }
        .camp-details-body {
            color: #2d3748;
            font-size: 15.5px;
            line-height: 1.8;
        }
        .camp-html-content h1, .camp-html-content h2, .camp-html-content h3, 
        .camp-html-content h4, .camp-html-content h5, .camp-html-content h6 {
            color: #173f2c;
            font-weight: 700;
            margin-top: 18px;
            margin-bottom: 10px;
        }
        .camp-html-content ul, .camp-html-content ol {
            padding-left: 20px;
            margin-bottom: 16px;
        }
        .camp-html-content li {
            margin-bottom: 8px;
        }
        .camp-html-content img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            margin: 12px 0;
        }
        .camp-html-content iframe {
            max-width: 100%;
            border-radius: 12px;
            margin: 16px 0;
        }
        .camp-color-tile {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .camp-color-tile:hover {
            border-color: #cbd5e1;
            background: #f1f5f9;
        }
        .camp-color-tile.selected {
            border-color: #173f2c;
            background: #f4f8f2;
            color: #173f2c;
        }

        @media (max-width: 767px) {
            .camp-main-title {
                font-size: 24px;
            }
            .camp-subtitle {
                font-size: 14px;
            }
            .camp-hero-card {
                padding: 22px 16px;
                border-radius: 18px;
            }
            .camp-details-card {
                padding: 22px 16px;
                border-radius: 18px;
            }
            .camp-media-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .camp-compare-grid {
                grid-template-columns: 1fr;
            }
            .camp-checkout-card {
                padding: 24px 16px;
                border-radius: 18px;
            }
            .camp-props-grid {
                grid-template-columns: 1fr;
            }
            .camp-recipe-grid {
                grid-template-columns: 1fr;
            }
            .camp-jump-btn {
                width: 100%;
                font-size: 16px;
                padding: 14px 20px;
            }
            .camp-section-title {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KCB3SXKF" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>

    @php
        $isRoselle = str_contains(strtolower($campaign_data->slug . ' ' . $campaign_data->name), 'roselle') || str_contains($campaign_data->name, 'রোজেলা');
        $isTea = $isRoselle || str_contains(strtolower($campaign_data->slug . ' ' . $campaign_data->name), 'tea') || str_contains($campaign_data->name, 'চা');
    @endphp

    <!-- Top Announcement Bar -->
    <div class="camp-topbar">
        <span>🌿 ১০০% খাঁটি ও গুণগত মানের {{ $campaign_data->name }}</span> | 🚚 সারা দেশে দ্রুত ক্যাশ অন ডেলিভারি | 📞 সরাসরি কল: <strong>{{ $contact->phone ?? '01850945080' }}</strong>
    </div>

    <!-- Header -->
    <header class="camp-header">
        <div class="camp-header-inner">
            <a href="{{ url('/') }}" class="camp-logo">
                <img src="{{ asset($generalsetting->white_logo ?? $generalsetting->logo) }}" alt="{{ $generalsetting->name }}" />
            </a>
            <a href="#order_form" class="camp-header-cta">
                <i class="fas fa-shopping-bag"></i> এখনই অর্ডার করুন
            </a>
        </div>
    </header>

    <main class="camp-container">
        <!-- ==================== HERO SECTION ==================== -->
        <section class="camp-hero-card">
            <div class="camp-badge-pill">
                <i class="fas fa-fire"></i>
                <span>{{ $campaign_data->banner_title ?: 'বিশেষ অফার - ১০০% প্রিমিয়াম ও অরিজিনাল কোয়ালিটি' }}</span>
            </div>

            <h1 class="camp-main-title">
                {{ $campaign_data->name }}
            </h1>

            @if(!empty($campaign_data->short_description))
                <div class="camp-subtitle">
                    {!! $campaign_data->short_description !!}
                </div>
            @elseif(!empty($campaign_data->description))
                <p class="camp-subtitle">
                    {{ Str::limit(strip_tags($campaign_data->description), 220) }}
                </p>
            @elseif(!empty($product->description))
                <p class="camp-subtitle">
                    {{ Str::limit(strip_tags($product->description), 220) }}
                </p>
            @else
                <p class="camp-subtitle">
                    সরাসরি সেরা বাগান ও বিশ্বস্ত সোর্স থেকে সংগৃহীত প্রিমিয়াম মানের {{ $campaign_data->name }}। ক্যাশ অন ডেলিভারিতে আজই অর্ডার করুন।
                </p>
            @endif

            <!-- 16:9 Banner Slider Container (Facebook Ads Widescreen Standard) -->
            @php
                $landingBanners = App\Models\LandingBanner::where('campaign_id', $campaign_data->id)->get();
            @endphp

            <div class="camp-slider-aspect-16-9">
                @if($landingBanners->count() > 0)
                    <div class="owl-carousel camp-hero-slider">
                        @foreach($landingBanners as $banner)
                            <div class="slider-item">
                                <img src="{{ asset($banner->image) }}" alt="{{ $campaign_data->name }} Banner" loading="eager" />
                            </div>
                        @endforeach
                    </div>
                @elseif($campaign_data->image_one)
                    <img src="{{ asset($campaign_data->image_one) }}" alt="{{ $campaign_data->name }}" loading="eager" />
                @elseif($product->image)
                    <img src="{{ asset($product->image->image) }}" alt="{{ $campaign_data->name }}" loading="eager" />
                @endif
            </div>

            <!-- Value Props Grid -->
            <div class="camp-props-grid">
                @if($isRoselle)
                    <div class="camp-prop-box">
                        <div class="camp-prop-icon"><i class="fas fa-heartbeat"></i></div>
                        <div class="camp-prop-text">
                            <h4>ব্লাড প্রেশার নিয়ন্ত্রণ</h4>
                            <p>প্রাকৃতিকভাবে হাই ব্লাড প্রেশার কমাতে কার্যকর ভূমিকা রাখে।</p>
                        </div>
                    </div>
                    <div class="camp-prop-box">
                        <div class="camp-prop-icon"><i class="fas fa-fire-alt"></i></div>
                        <div class="camp-prop-text">
                            <h4>মেদ ও ওজন নিয়ন্ত্রণ</h4>
                            <p>প্রচুর অ্যান্টিঅক্সিডেন্ট মেটাবলিজম বাড়িয়ে মেদ ঝরাতে সহায়ক।</p>
                        </div>
                    </div>
                    <div class="camp-prop-box">
                        <div class="camp-prop-icon"><i class="fas fa-leaf"></i></div>
                        <div class="camp-prop-text">
                            <h4>১০০% আস্ত পাহাড়ি পাপড়ি</h4>
                            <p>পাহাড়ে রোদে শুকানো বিষমুক্ত ও রাসায়নিকবিহীন অক্ষত ফুল।</p>
                        </div>
                    </div>
                    <div class="camp-prop-box">
                        <div class="camp-prop-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="camp-prop-text">
                            <h4>ভিটামিন সি ও রোগ প্রতিরোধ</h4>
                            <p>ত্বক সতেজ রাখে এবং শরীরের ইমিউনিটি বহুগুণ বাড়িয়ে তোলে।</p>
                        </div>
                    </div>
                @else
                    <div class="camp-prop-box">
                        <div class="camp-prop-icon"><i class="fas fa-leaf"></i></div>
                        <div class="camp-prop-text">
                            <h4>১০০% বিশুদ্ধ ও প্রাকৃতিক</h4>
                            <p>কোনো প্রকার ক্ষতিকর কেমিক্যাল, কৃত্রিম রঙ বা ভেজাল নেই।</p>
                        </div>
                    </div>
                    <div class="camp-prop-box">
                        <div class="camp-prop-icon"><i class="fas fa-coffee"></i></div>
                        <div class="camp-prop-text">
                            <h4>কড়া লিকার ও চমৎকার স্বাদ</h4>
                            <p>প্রতিটি কাপে অসাধারণ সতেজতা, মন মাতানো ঘ্রাণ ও আসল তৃপ্তি।</p>
                        </div>
                    </div>
                    <div class="camp-prop-box">
                        <div class="camp-prop-icon"><i class="fas fa-award"></i></div>
                        <div class="camp-prop-text">
                            <h4>বাছাইকৃত সেরা গ্রেড</h4>
                            <p>সেরা বাগান ও বিশ্বস্ত সোর্স থেকে নির্বাচিত শতভাগ তাজা কালেকশন।</p>
                        </div>
                    </div>
                    <div class="camp-prop-box">
                        <div class="camp-prop-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="camp-prop-text">
                            <h4>স্বাস্থ্যকর ও সতেজতাদায়ক</h4>
                            <p>প্রাকৃতিক অ্যান্টিঅক্সিডেন্টে ভরপুর যা শরীর ও মনে তাৎক্ষণিক চনমনে ভাব আনে।</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Hero CTA -->
            <a href="#order_form" class="camp-jump-btn">
                <i class="fas fa-shopping-cart"></i> এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)
            </a>
        </section>

        <!-- ==================== MEDIA SHOWCASE ==================== -->
        @if($campaign_data->image_one || $campaign_data->image_two || $campaign_data->image_three)
            <section class="camp-media-showcase">
                <div class="camp-section-header">
                    <span class="camp-section-tag">প্রোডাক্ট গ্যালারি</span>
                    <h2 class="camp-section-title">আমাদের আসল {{ $campaign_data->name }} এর ছবি</h2>
                    <p class="camp-section-desc">কোনো এডিটিং ছাড়াই আসল পণ্যের প্যাকেজিং ও বাস্তব রূপ দেখে নিন</p>
                </div>

                <div class="camp-media-grid">
                    @if($campaign_data->image_one)
                        <div class="camp-media-card">
                            <div>
                                <span class="camp-media-badge"><i class="fas fa-camera"></i> রিয়েল ভিউ ১</span>
                                <div class="aspect-box-1-1">
                                    <img src="{{ asset($campaign_data->image_one) }}" alt="{{ $campaign_data->name }}" loading="lazy" />
                                </div>
                            </div>
                            <div class="camp-media-info">
                                <h4>{{ $isRoselle ? '১০০% আস্ত পাপড়ির ফুল' : 'বাছাইকৃত প্রিমিয়াম কোয়ালিটি' }}</h4>
                                <p>{{ $isRoselle ? 'পাপড়িগুলো ভাঙা বা গুঁড়া নয়, একদম আস্ত ও নিখুঁতভাবে রোদে শুকানো।' : '১০০% খাঁটি ও সেরা মান নিশ্চিত করে সরাসরি সংগ্রহ করা হয়।' }}</p>
                            </div>
                        </div>
                    @endif

                    @if($campaign_data->image_two)
                        <div class="camp-media-card">
                            <div>
                                <span class="camp-media-badge"><i class="fas fa-mobile-alt"></i> রিয়েল ভিউ ২</span>
                                <div class="aspect-box-9-16">
                                    <img src="{{ asset($campaign_data->image_two) }}" alt="{{ $campaign_data->name }}" loading="lazy" />
                                </div>
                            </div>
                            <div class="camp-media-info">
                                <h4>{{ $isRoselle ? 'আকর্ষণীয় লাল টকটকে লিকার' : 'প্রাকৃতিক স্বাদ ও সতেজতা' }}</h4>
                                <p>{{ $isRoselle ? '৪-৫টি পাপড়ি গরম পানিতে দিলেই পাবেন চমৎকার টক-মিষ্টি লাল লিকার।' : 'অতুলনীয় স্বাদ ও মন মাতানো ফ্লেভার যা প্রতিটি কাপে আনবে দারুণ সতেজতা।' }}</p>
                            </div>
                        </div>
                    @endif

                    @if($campaign_data->image_three)
                        <div class="camp-media-card">
                            <div>
                                <span class="camp-media-badge"><i class="fas fa-image"></i> রিয়েল ভিউ ৩</span>
                                <div class="aspect-box-4-5">
                                    <img src="{{ asset($campaign_data->image_three) }}" alt="{{ $campaign_data->name }}" loading="lazy" />
                                </div>
                            </div>
                            <div class="camp-media-info">
                                <h4>{{ $isRoselle ? 'নিরাপদ ও হাইজিনিক প্যাক' : 'নিরাপদ ও অক্ষত প্যাকেজিং' }}</h4>
                                <p>{{ $isRoselle ? 'সরাসরি পাহাড় থেকে সংগ্রহ করে স্বাস্থ্যসম্মত জিপলক ও পলি প্যাকে সরবরাহ।' : 'পণ্যের সতেজতা ও প্রাকৃতিক গুণাগুণ দীর্ঘস্থায়ী রাখতে হাইজিনিক প্যাকেজিং।' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- ==================== VIDEO DEMO SHOWCASE ==================== -->
        @if($campaign_data->video)
            <section class="camp-video-wrapper">
                <div class="camp-section-header">
                    <span class="camp-section-tag">ভিডিও ডেমো</span>
                    <h2 class="camp-section-title">{{ $campaign_data->name }} এর ভিডিও রিভিউ</h2>
                    <p class="camp-section-desc">ভিডিওতে সরাসরি দেখে নিন পণ্যের মান ও আকর্ষণীয় উপস্থাপনা</p>
                </div>

                <div class="camp-video-aspect-16-9">
                    <iframe src="https://www.youtube.com/embed/{{ $campaign_data->video }}?rel=0&modestbranding=1"
                            title="{{ $campaign_data->name }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                </div>
            </section>
        @endif

        <!-- ==================== PRODUCT DETAILS & BENEFITS ==================== -->
        @if(!empty($campaign_data->description) || !empty($product->description))
            <section class="camp-details-card">
                <div class="camp-section-header">
                    <span class="camp-section-tag">বিস্তারিত তথ্য ও উপকারিতা</span>
                    <h2 class="camp-section-title">কেন আমাদের {{ $campaign_data->name }} সেরা?</h2>
                    <p class="camp-section-desc">পণ্যটির বিশেষ বৈশিষ্ট্য, পুষ্টিগুণ ও উপকারিতা সম্পর্কে জেনে নিন</p>
                </div>

                <div class="camp-details-body">
                    @if(!empty($campaign_data->description))
                        <div class="camp-html-content mb-4">
                            {!! $campaign_data->description !!}
                        </div>
                    @endif

                    @if(!empty($product->description))
                        <div class="camp-html-content">
                            {!! $product->description !!}
                        </div>
                    @endif
                </div>

                <div class="text-center mt-4">
                    <a href="#order_form" class="camp-jump-btn">
                        <i class="fas fa-shopping-cart"></i> এখনই অর্ডার করুন (ক্যাশ অন ডেলিভারি)
                    </a>
                </div>
            </section>
        @endif

        <!-- ==================== COMPARISON SECTION ==================== -->
        <section class="camp-compare-card">
            <div class="camp-section-header">
                <span class="camp-section-tag">সঠিক পণ্য চিনুন</span>
                <h2 class="camp-section-title">
                    {{ $isRoselle ? 'পাহাড়ি রোজেলা বনাম সাধারণ / ইন্ডিয়ান রোজেলা' : 'আমাদের ' . $campaign_data->name . ' বনাম সাধারণ বাজারজাত পণ্য' }}
                </h2>
                <p class="camp-section-desc">
                    {{ $isRoselle ? 'কেন আমাদের পার্বত্য চট্টগ্রামের রোজেলা বাজারে সেরা ও অনন্য' : 'কেন আমাদের পণ্যটি বাজারের সাধারণ পণ্যের চেয়ে সেরা ও সম্পূর্ণ আলাদা' }}
                </p>
            </div>

            <div class="camp-compare-grid">
                <!-- Good -->
                <div class="camp-compare-col camp-compare-good">
                    <div class="camp-compare-header">
                        <i class="fas fa-check-circle"></i> {{ $isRoselle ? 'আমাদের পাহাড়ি রোজেলা' : 'আমাদের ' . $campaign_data->name }}
                    </div>
                    <ul class="camp-compare-list">
                        @if($isRoselle)
                            <li>
                                <i class="fas fa-check"></i>
                                <span><strong>১০০% আস্ত পাপড়ি:</strong> ভাঙা গুঁড়া নয়, আস্ত সুন্দর পাপড়ি পাওয়া যায়।</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span><strong>টাটকা নতুন হার্ভেস্ট:</strong> এই বছরের তাজা ফসল, তাই দারুণ সুবাস ও ফ্লেভার।</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span><strong>লাল টকটকে লিকার:</strong> প্রাকৃতিক গাঢ় লাল ও আকর্ষণীয় রুবিরঙা লিকার।</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span><strong>বিষমুক্ত পাহাড়ি চাষ:</strong> বান্দরবান ও খাগড়াছড়ির প্রাকৃতিকভাবে বেড়ে ওঠা ফসল।</span>
                            </li>
                        @else
                            <li>
                                <i class="fas fa-check"></i>
                                <span><strong>১০০% খাঁটি ও নির্ভেজাল:</strong> কৃত্রিম রঙ বা কেমিক্যাল ছাড়া সম্পূর্ণ প্রাকৃতিক ও নিরাপদ।</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span><strong>বাছাইকৃত সেরা গ্রেড:</strong> সেরা বাগান ও উৎস থেকে সংগৃহীত শতভাগ তাজা পণ্য।</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span><strong>কড়া লিকার ও মন মাতানো সুবাস:</strong> প্রতিটি কাপে দারুণ স্বাদ ও পরিপূর্ণ তৃপ্তি।</span>
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                <span><strong>ফুড-গ্রেড প্যাকেজিং:</strong> সতেজতা ও গুণাগুণ অটুট রাখতে উন্নত হাইজিনিক প্যাক।</span>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Bad -->
                <div class="camp-compare-col camp-compare-bad">
                    <div class="camp-compare-header">
                        <i class="fas fa-times-circle"></i> {{ $isRoselle ? 'সাধারণ / ইন্ডিয়ান রোজেলা' : 'সাধারণ বা নিম্নমানের খোলা পণ্য' }}
                    </div>
                    <ul class="camp-compare-list">
                        @if($isRoselle)
                            <li>
                                <i class="fas fa-times"></i>
                                <span><strong>কাটা ও ভাঙা পাপড়ি:</strong> বেশিরভাগ ক্ষেত্রে ভাঙাচোরা পাপড়ি পাওয়া যায়।</span>
                            </li>
                            <li>
                                <i class="fas fa-times"></i>
                                <span><strong>কালচে লালচে লিকার:</strong> ফুটানোর পর লিকার কালচে হয়ে যায়।</span>
                            </li>
                            <li>
                                <i class="fas fa-times"></i>
                                <span><strong>কম ফ্লেভার ও কম স্বাদ:</strong> প্রাকৃতিক সতেজতার অভাব থাকে।</span>
                            </li>
                            <li>
                                <i class="fas fa-times"></i>
                                <span><strong>পুরানো স্টকের ঝুঁকি:</strong> কেমিক্যাল ও দীর্ঘদিনের সংরক্ষণের আশঙ্কা।</span>
                            </li>
                        @else
                            <li>
                                <i class="fas fa-times"></i>
                                <span><strong>ভেজাল ও ডাস্ট মিশ্রিত:</strong> নিম্নমানের উপাদান ও ধুলোবালি মেশানো থাকে।</span>
                            </li>
                            <li>
                                <i class="fas fa-times"></i>
                                <span><strong>পুরানো ও বাসি স্টক:</strong> গুদামে দীর্ঘদিন পড়ে থেকে স্বাভাবিক স্বাদ নষ্ট হয়ে যায়।</span>
                            </li>
                            <li>
                                <i class="fas fa-times"></i>
                                <span><strong>কৃত্রিম রঙ ও ফ্লেভার:</strong> কেমিক্যাল দিয়ে কৃত্রিম রঙ ও গন্ধ তৈরির চেষ্টা করা হয়।</span>
                            </li>
                            <li>
                                <i class="fas fa-times"></i>
                                <span><strong>খোলা ও অস্বাস্থ্যকর প্যাক:</strong> ধুলাবালি এবং ক্ষতিকর জীবাণুর ঝুঁকি থাকে।</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </section>

        <!-- ==================== HOW TO PREPARE / STEPS ==================== -->
        <section class="camp-recipe-section">
            @if($isRoselle)
                <h2 class="camp-recipe-title">
                    <i class="fas fa-mug-hot text-warning"></i> রোজেলা চা তৈরির সহজ ৪টি ধাপ
                </h2>

                <div class="camp-recipe-grid">
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">১</div>
                        <p class="camp-step-desc">এক কাপ ফুটন্ত গরম পানিতে ৪ থেকে ৫টি শুকনো রোজেলা পাপড়ি দিন।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">২</div>
                        <p class="camp-step-desc">৫-১০ মিনিট ঢেকে রাখুন যাতে সম্পূর্ণ লাল লিকার ও পুষ্টিগুণ পানিতে মিশে যায়।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">৩</div>
                        <p class="camp-step-desc">স্বাদ বাড়াতে এক চামচ খাঁটি মধু, সামান্য লেবুর রস বা বিট লবণ মেশাতে পারেন।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">৪</div>
                        <p class="camp-step-desc">গরম গরম অথবা বরফ কুচি দিয়ে রিফ্রেশিং আইসড চা হিসেবে উপভোগ করুন!</p>
                    </div>
                </div>
            @elseif($isTea)
                <h2 class="camp-recipe-title">
                    <i class="fas fa-mug-hot text-warning"></i> সেরা স্বাদের চা তৈরির সহজ ৪টি ধাপ
                </h2>

                <div class="camp-recipe-grid">
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">১</div>
                        <p class="camp-step-desc">প্রথমে পরিচ্ছন্ন পাত্রে প্রয়োজনীয় পরিমাণ পানি ভালো করে ফুটিয়ে নিন।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">২</div>
                        <p class="camp-step-desc">ফুটন্ত পানিতে পরিমাণমতো চা পাতা দিন এবং ২-৩ মিনিট ফুটান কড়া লিকারের জন্য।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">৩</div>
                        <p class="camp-step-desc">দুধ চা করতে ঘন দুধ ও পরিমাণমতো চিনি মেশান, অথবা লাল চা হিসেবে উপভোগ করুন।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">৪</div>
                        <p class="camp-step-desc">ছাঁকনি দিয়ে কাপে ঢেলে পরিবেশন করুন ধোঁয়া ওঠা অতুলনীয় স্বাদের চা!</p>
                    </div>
                </div>
            @else
                <h2 class="camp-recipe-title">
                    <i class="fas fa-shield-alt text-warning"></i> ঘরে বসে অর্ডার করার সহজ ৪টি ধাপ
                </h2>

                <div class="camp-recipe-grid">
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">১</div>
                        <p class="camp-step-desc">নিচের ফর্ম থেকে আপনার পছন্দসই প্যাকেজটি নির্বাচন করুন।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">২</div>
                        <p class="camp-step-desc">আপনার নাম, মোবাইল নাম্বার এবং পূর্ণ ডেলিভারি ঠিকানা দিন।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">৩</div>
                        <p class="camp-step-desc">'অর্ডার সম্পন্ন করুন' বাটনে ক্লিক করে অর্ডারটি কনফার্ম করুন।</p>
                    </div>
                    <div class="camp-recipe-step">
                        <div class="camp-step-num">৪</div>
                        <p class="camp-step-desc">পণ্য হাতে পেয়ে চেক করে সম্পূর্ণ নিশ্চিত হয়ে মূল্য পরিশোধ করুন।</p>
                    </div>
                </div>
            @endif
        </section>

        <!-- ==================== CUSTOMER REVIEWS ==================== -->
        @php
            $campaignReviews = App\Models\CampaignReview::where('campaign_id', $campaign_data->id)->get();
        @endphp
        @if($campaignReviews->count() > 0)
            <section class="camp-reviews-section">
                <div class="camp-section-header">
                    <span class="camp-section-tag">গ্রাহকদের মতামত</span>
                    <h2 class="camp-section-title">সন্তুষ্ট গ্রাহকদের রিয়েল রিভিউ</h2>
                    <p class="camp-section-desc">আমাদের {{ $campaign_data->name }} ব্যবহার করে সম্মানিত গ্রাহকরা কী বলছেন দেখে নিন</p>
                </div>

                <div class="owl-carousel camp-reviews-slider">
                    @foreach($campaignReviews as $review)
                        <div class="camp-review-aspect-1-1">
                            <img src="{{ asset($review->image) }}" alt="{{ $campaign_data->name }} Customer Review" loading="lazy" />
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- ==================== FAQ ACCORDION ==================== -->
        @if($campaign_data->faq_question_one || $campaign_data->faq_question_two || $campaign_data->faq_question_three || $campaign_data->faq_question_four || $campaign_data->faq_question_five)
            <section class="camp-faq-section">
                <div class="camp-section-header">
                    <span class="camp-section-tag">সাধারণ জিজ্ঞাসা</span>
                    <h2 class="camp-section-title">{{ $campaign_data->name }} সম্পর্কিত প্রশ্নোত্তর</h2>
                    <p class="camp-section-desc">আপনার মনের সব প্রশ্নের নির্ভরযোগ্য ও পরিষ্কার উত্তর</p>
                </div>

                <div class="accordion" id="campFaqAccordion">
                    @if($campaign_data->faq_question_one)
                        <div class="camp-faq-item">
                            <button class="camp-faq-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqColOne" aria-expanded="true">
                                <span><i class="fas fa-chevron-right me-2"></i> {{ $campaign_data->faq_question_one }}</span>
                                <i class="fas fa-angle-right"></i>
                            </button>
                            <div id="faqColOne" class="collapse show" data-bs-parent="#campFaqAccordion">
                                <div class="camp-faq-body">
                                    {!! $campaign_data->faq_answar_one !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($campaign_data->faq_question_two)
                        <div class="camp-faq-item">
                            <button class="camp-faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqColTwo" aria-expanded="false">
                                <span><i class="fas fa-chevron-right me-2"></i> {{ $campaign_data->faq_question_two }}</span>
                                <i class="fas fa-angle-right"></i>
                            </button>
                            <div id="faqColTwo" class="collapse" data-bs-parent="#campFaqAccordion">
                                <div class="camp-faq-body">
                                    {!! $campaign_data->faq_answar_two !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($campaign_data->faq_question_three)
                        <div class="camp-faq-item">
                            <button class="camp-faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqColThree" aria-expanded="false">
                                <span><i class="fas fa-chevron-right me-2"></i> {{ $campaign_data->faq_question_three }}</span>
                                <i class="fas fa-angle-right"></i>
                            </button>
                            <div id="faqColThree" class="collapse" data-bs-parent="#campFaqAccordion">
                                <div class="camp-faq-body">
                                    {!! $campaign_data->faq_answar_three !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($campaign_data->faq_question_four)
                        <div class="camp-faq-item">
                            <button class="camp-faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqColFour" aria-expanded="false">
                                <span><i class="fas fa-chevron-right me-2"></i> {{ $campaign_data->faq_question_four }}</span>
                                <i class="fas fa-angle-right"></i>
                            </button>
                            <div id="faqColFour" class="collapse" data-bs-parent="#campFaqAccordion">
                                <div class="camp-faq-body">
                                    {!! $campaign_data->faq_answar_four !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($campaign_data->faq_question_five)
                        <div class="camp-faq-item">
                            <button class="camp-faq-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqColFive" aria-expanded="false">
                                <span><i class="fas fa-chevron-right me-2"></i> {{ $campaign_data->faq_question_five }}</span>
                                <i class="fas fa-angle-right"></i>
                            </button>
                            <div id="faqColFive" class="collapse" data-bs-parent="#campFaqAccordion">
                                <div class="camp-faq-body">
                                    {!! $campaign_data->faq_answar_five !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- ==================== HIGH-CONVERTING ORDER FORM ==================== -->
        <section class="camp-checkout-card" id="order_form">
            <div class="camp-form-header">
                <h2 class="camp-form-title">অর্ডার করতে নিচের ফর্মে আপনার সঠিক তথ্য দিন</h2>
                <p class="camp-form-sub">
                    <i class="fas fa-hand-holding-usd"></i> কোনো অগ্রিম টাকা লাগবে না, পণ্য হাতে পেয়ে মূল্য পরিশোধ করবেন
                </p>
            </div>

            <form action="{{ route('landingpage.ordersave') }}" method="POST" id="checkout_form">
                @csrf
                <div class="camp-checkout-grid">
                    <!-- Left: Customer Information & Delivery Area -->
                    <div>
                        <!-- Full Name -->
                        <div class="camp-field-group">
                            <label class="camp-label">
                                <i class="fas fa-user text-muted"></i> আপনার পুরো নাম লিখুন <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="camp-input" placeholder="যেমন: মোহাম্মদ আব্দুল্লাহ" required />
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="camp-field-group">
                            <label class="camp-label">
                                <i class="fas fa-phone-alt text-muted"></i> আপনার মোবাইল নাম্বার লিখুন <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="phone" class="camp-input" placeholder="01XXXXXXXXX" pattern="[0-9]{11}" required />
                            @error('phone')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="camp-field-group">
                            <label class="camp-label">
                                <i class="fas fa-map-marker-alt text-muted"></i> আপনার সম্পূর্ণ ডেলিভারি ঠিকানা <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="address" class="camp-input" placeholder="বাসা/হোল্ডিং নং, রোড নং, থানা, জেলা" required />
                            @error('address')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Delivery Charge Area -->
                        <div class="camp-field-group">
                            <label class="camp-label">
                                <i class="fas fa-truck text-muted"></i> ডেলিভারি এরিয়া সিলেক্ট করুন <span class="text-danger">*</span>
                            </label>
                            <div class="camp-area-options">
                                @foreach($shippingcharge as $key => $charge)
                                    <label class="camp-area-card {{ $loop->first ? 'selected' : '' }}">
                                        <input type="radio" name="shipping" class="camp-area-radio"
                                               value="{{ $charge->amount }}"
                                               data-amount="{{ $charge->amount }}"
                                               {{ $loop->first ? 'checked' : '' }} />
                                        <div class="camp-area-info">
                                            <h5>{{ $charge->name }}</h5>
                                            <span>৳ {{ $charge->amount }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Color Selection if multiple colors available -->
                        @if($productcolors->count() > 1)
                            <div class="camp-field-group mb-3">
                                <label class="camp-label">
                                    <i class="fas fa-palette text-muted"></i> কালার / ভ্যারিয়েন্ট পছন্দ করুন <span class="text-danger">*</span>
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($productcolors as $key => $color)
                                        <label class="camp-color-tile {{ $loop->first ? 'selected' : '' }}">
                                            <input type="radio" name="color" value="{{ $color->color }}" {{ $loop->first ? 'checked' : '' }} class="d-none" />
                                            <span>{{ $color->color }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="color" value="{{ $productcolors->first()->color ?? 'General' }}" />
                        @endif

                        <!-- Package Selection -->
                        <div class="camp-packages-section">
                            <label class="camp-label">
                                <i class="fas fa-box-open text-muted"></i> প্যাকেজ পছন্দ করুন <span class="text-danger">*</span>
                            </label>

                            @if($product->type == 1 && $productsizes->count() > 0)
                                @foreach($productsizes as $key => $value)
                                    <label class="camp-package-tile {{ $loop->first ? 'selected' : '' }}" for="pkg_{{ $key }}">
                                        <div class="camp-pkg-left">
                                            <input type="radio" name="package" id="pkg_{{ $key }}" class="camp-pkg-radio"
                                                   value="{{ $value->size }}"
                                                   data-price="{{ $value->SalePrice }}"
                                                   {{ $loop->first ? 'checked' : '' }} />
                                            <div>
                                                <p class="camp-pkg-label">{{ $product->name }} – {{ $value->size }}</p>
                                                <span class="camp-pkg-sub">
                                                    @if($loop->first)
                                                        <span class="badge bg-success">সবচেয়ে জনপ্রিয়</span>
                                                    @endif
                                                    রেগুলার প্রাইস: <del>৳{{ $value->RegularPrice ?? $product->old_price }}</del>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="camp-pkg-price">
                                            ৳ {{ $value->SalePrice }}
                                        </div>
                                    </label>
                                @endforeach
                            @else
                                <label class="camp-package-tile selected" for="pkg_single">
                                    <div class="camp-pkg-left">
                                        <input type="radio" name="package" id="pkg_single" class="camp-pkg-radio"
                                               value="{{ $product->id }}"
                                               data-price="{{ $product->new_price }}"
                                               checked />
                                        <div>
                                            <p class="camp-pkg-label">{{ $product->name }}</p>
                                            <span class="camp-pkg-sub">রেগুলার প্রাইস: <del>৳{{ $product->old_price }}</del></span>
                                        </div>
                                    </div>
                                    <div class="camp-pkg-price">
                                        ৳ {{ $product->new_price }}
                                    </div>
                                </label>
                            @endif
                        </div>

                        <!-- Hidden Form Inputs for Backend Controller -->
                        @php
                            $defaultPackage = ($product->type == 1 && isset($productsizes[0]))
                                ? $productsizes[0]
                                : (object) ['SalePrice' => $product->new_price];
                            $defaultShipping = isset($shippingcharge[0])
                                ? $shippingcharge[0]
                                : (object) ['amount' => 0];
                            $initialTotal = $defaultPackage->SalePrice + $defaultShipping->amount;
                        @endphp

                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        <input type="hidden" name="product_name" value="{{ $product->name }}" />
                        <input type="hidden" name="product_price" id="inputProductPrice" value="{{ $defaultPackage->SalePrice }}" />
                        <input type="hidden" name="subtotal" id="inputSubtotal" value="{{ $defaultPackage->SalePrice }}" />
                        <input type="hidden" name="total" id="inputTotal" value="{{ $initialTotal }}" />
                    </div>

                    <!-- Right: Sticky Order Summary & Submit -->
                    <div>
                        <div class="camp-summary-card">
                            <h3 class="camp-summary-title">অর্ডার সামারি (Your Order)</h3>

                            <!-- Product Info -->
                            <div class="camp-sum-prod">
                                <div class="camp-sum-thumb">
                                    <img src="{{ asset($product->image ? $product->image->image : 'public/uploads/default.png') }}" alt="{{ $product->name }}" />
                                </div>
                                <div class="camp-sum-prod-info">
                                    <h4 class="camp-sum-prod-name">{{ $product->name }}</h4>
                                    <!-- Stepper -->
                                    <div class="camp-stepper">
                                        <button type="button" class="camp-step-btn" id="decreaseQty">-</button>
                                        <input type="text" id="quantity" name="quantity" class="camp-step-input" value="1" readonly />
                                        <button type="button" class="camp-step-btn" id="increaseQty">+</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Cost Breakdown -->
                            <div class="camp-sum-row">
                                <span>পণ্যের মূল্য (Subtotal):</span>
                                <span>৳ <strong id="productSubtotalDisplay">{{ $defaultPackage->SalePrice }}</strong></span>
                            </div>

                            <div class="camp-sum-row">
                                <span>ডেলিভারি চার্জ (Delivery):</span>
                                <span>৳ <strong id="shippingDisplay">{{ $defaultShipping->amount }}</strong></span>
                            </div>

                            <div class="camp-sum-row total-row">
                                <span>সর্বমোট মূল্য (Total):</span>
                                <span class="camp-grand-total">৳ <strong id="totalDisplay">{{ $initialTotal }}</strong></span>
                            </div>

                            <!-- COD Note -->
                            <div class="camp-cod-badge">
                                <i class="fas fa-shield-alt fa-lg text-success"></i>
                                <div>
                                    <strong>ক্যাশ অন ডেলিভারি:</strong>
                                    <div>পণ্য হাতে পেয়ে চেক করে ডেলিভারি ম্যানকে টাকা পরিশোধ করবেন।</div>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" class="camp-submit-btn">
                                <i class="fas fa-lock"></i>
                                <span>অর্ডার সম্পন্ন করুন ৳<span id="btnTotalText">{{ $initialTotal }}</span></span>
                            </button>

                            <!-- Trust Seals -->
                            <div class="camp-guarantee-row">
                                <div class="camp-guarantee-item">
                                    <i class="fas fa-medal"></i>
                                    <span>১০০% খাঁটি পণ্য</span>
                                </div>
                                <div class="camp-guarantee-item">
                                    <i class="fas fa-truck-fast"></i>
                                    <span>দ্রুত হোম ডেলিভারি</span>
                                </div>
                                <div class="camp-guarantee-item">
                                    <i class="fas fa-rotate-left"></i>
                                    <span>সহজ রিটার্ন পলিসি</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer class="camp-footer">
        <div class="camp-container">
            <p class="mb-1">
                © {{ date('Y') }} <strong>{{ $generalsetting->name }}</strong> | সর্বস্বত্ব সংরক্ষিত।
            </p>
            <p class="small text-muted mb-0">
                বিশুদ্ধ ও প্রিমিয়াম কোয়ালিটি খাদ্যপণ্যের বিশ্বস্ত অনলাইন শপ।
            </p>
        </div>
    </footer>

    <!-- Fixed Floating Mobile Concierge Bar -->
    <div class="camp-floating-actions">
        <a href="tel:{{ $contact->phone ?? '01850945080' }}" class="camp-floating-call" title="কল করুন">
            <i class="fas fa-phone-alt"></i>
        </a>
        <a href="#order_form" class="camp-floating-order-btn">
            <i class="fas fa-shopping-bag"></i> অর্ডার করুন
        </a>
        <a href="https://wa.me/+88{{ $contact->phone ?? '01850945080' }}?text={{ rawurlencode($campaign_data->name . ' অর্ডার করতে চাই') }}" target="_blank" class="camp-floating-wa" title="হোয়াটসঅ্যাপে চ্যাট">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('public/frontEnd/campaign/js') }}/jquery-2.1.4.min.js"></script>
    <script src="{{ asset('public/frontEnd/campaign/js') }}/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('public/frontEnd/campaign/js') }}/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Hero 16:9 Banner Slider
            $(".camp-hero-slider").owlCarousel({
                items: 1,
                loop: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
                smartSpeed: 900,
                nav: false,
                margin: 0
            });

            // Reviews 1:1 Slider
            $(".camp-reviews-slider").owlCarousel({
                loop: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                smartSpeed: 800,
                margin: 16,
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    992: { items: 3 }
                }
            });

            // Delivery Area Visual Card Selection
            $('input[name="shipping"]').on('change', function() {
                $('.camp-area-card').removeClass('selected');
                $(this).closest('.camp-area-card').addClass('selected');
                recalculateTotals();
            });

            // Package Visual Card Selection
            $('input[name="package"]').on('change', function() {
                $('.camp-package-tile').removeClass('selected');
                $(this).closest('.camp-package-tile').addClass('selected');
                recalculateTotals();
            });

            // Color Tile Visual Selection
            $('.camp-color-tile').on('click', function() {
                $('.camp-color-tile').removeClass('selected');
                $(this).addClass('selected');
                $(this).find('input[name="color"]').prop('checked', true);
            });

            // Quantity Stepper
            $('#increaseQty').on('click', function() {
                var $qty = $('#quantity');
                var val = parseInt($qty.val()) || 1;
                $qty.val(val + 1);
                recalculateTotals();
            });

            $('#decreaseQty').on('click', function() {
                var $qty = $('#quantity');
                var val = parseInt($qty.val()) || 1;
                if (val > 1) {
                    $qty.val(val - 1);
                    recalculateTotals();
                }
            });

            // Live Calculation Function
            function recalculateTotals() {
                var packagePrice = parseFloat($('input[name="package"]:checked').data('price')) || parseFloat('{{ $product->new_price }}');
                var shippingAmount = parseFloat($('input[name="shipping"]:checked').data('amount')) || 0;
                var qty = parseInt($('#quantity').val()) || 1;

                var subtotal = packagePrice * qty;
                var grandTotal = subtotal + shippingAmount;

                // Update UI Display
                $('#productSubtotalDisplay').text(subtotal);
                $('#shippingDisplay').text(shippingAmount);
                $('#totalDisplay').text(grandTotal);
                $('#btnTotalText').text(grandTotal);

                // Update Form Hidden Fields for Backend
                $('#inputProductPrice').val(packagePrice);
                $('#inputSubtotal').val(subtotal);
                $('#inputTotal').val(grandTotal);
            }

            // Smooth Scroll for Internal Anchors
            $('a[href^="#"]').on('click', function(e) {
                var target = $(this.getAttribute('href'));
                if(target.length) {
                    e.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 600);
                }
            });

            // Run initial calculation
            recalculateTotals();
        });
    </script>
</body>
</html>
