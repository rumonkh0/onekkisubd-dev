@extends('frontEnd.layouts.master')
@section('title', 'চা জার্নাল ও গল্প সম্ভার (Tea Journal & Stories) | ' . ($generalsetting->name ?? 'OnekkisuBD'))

@section('content')
<style>
    /* ========================================================
       LUXURY DARK TEA BLOG & JOURNAL LISTING PAGE
       ======================================================== */
    :root {
        --tea-dark: #0a211b;
        --tea-forest: #173f2c;
        --tea-gold: #cdb06a;
        --tea-gold-light: #e8d7a8;
        --roselle-crimson: #c53030;
    }

    .tea-journal-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.05) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 200px);
        padding: 28px 16px 80px;
    }

    .tea-journal-container {
        max-width: 1240px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .tea-journal-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .tea-journal-breadcrumb a {
        color: var(--tea-forest);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .tea-journal-breadcrumb a:hover {
        color: var(--tea-gold);
    }
    .tea-journal-breadcrumb i {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Hero Header Banner */
    .tea-journal-hero {
        background: linear-gradient(135deg, #0a211b 0%, #173f2c 60%, #1f5038 100%);
        border-radius: 28px;
        padding: 48px 36px;
        color: #ffffff;
        position: relative;
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 16px 40px -12px rgba(10, 33, 27, 0.25);
        border: 1px solid rgba(205, 176, 106, 0.35);
        text-align: center;
    }
    .tea-journal-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(205, 176, 106, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }
    .tea-journal-hero::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(205, 176, 106, 0.16) 0%, transparent 70%);
        pointer-events: none;
    }

    .tea-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(205, 176, 106, 0.16);
        color: #e2cf9c;
        border: 1px solid rgba(205, 176, 106, 0.4);
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
    }

    .tea-hero-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 36px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 14px 0;
        line-height: 1.25;
    }

    .tea-hero-subtitle {
        font-size: 16px;
        color: #d1d5db;
        max-width: 680px;
        margin: 0 auto 28px;
        line-height: 1.65;
    }

    /* Search Bar in Hero */
    .tea-hero-search {
        max-width: 520px;
        margin: 0 auto;
        position: relative;
    }
    .tea-search-wrap {
        display: flex;
        align-items: center;
        background: #ffffff;
        border-radius: 36px;
        padding: 5px 6px 5px 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }
    .tea-search-wrap i {
        color: #9ca3af;
        font-size: 16px;
        margin-right: 10px;
    }
    .tea-search-input {
        border: none;
        outline: none;
        flex-grow: 1;
        font-size: 14.5px;
        color: #111827;
        background: transparent;
    }
    .tea-search-btn {
        background: linear-gradient(135deg, var(--tea-forest) 0%, var(--tea-dark) 100%);
        color: #e2cf9c;
        border: 1px solid rgba(205, 176, 106, 0.4);
        font-size: 14px;
        font-weight: 700;
        padding: 10px 22px;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .tea-search-btn:hover {
        background: #cdb06a;
        color: #0a211b;
        transform: scale(1.02);
    }

    /* Featured Article Card (Prominent Top Story) */
    .tea-featured-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #ebd0a0;
        box-shadow: 0 12px 36px -8px rgba(10, 33, 27, 0.08);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        margin-bottom: 44px;
        transition: all 0.3s ease;
    }
    .tea-featured-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 44px -8px rgba(10, 33, 27, 0.14);
        border-color: var(--tea-forest);
    }
    .tea-feat-img-box {
        position: relative;
        overflow: hidden;
        min-height: 320px;
        background: #f4f2ee;
    }
    .tea-feat-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .tea-featured-card:hover .tea-feat-img-box img {
        transform: scale(1.05);
    }
    .tea-feat-badge {
        position: absolute;
        top: 18px;
        left: 18px;
        background: rgba(10, 33, 27, 0.88);
        color: #e2cf9c;
        backdrop-filter: blur(6px);
        font-size: 11.5px;
        font-weight: 800;
        padding: 5px 14px;
        border-radius: 20px;
        border: 1px solid rgba(205, 176, 106, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .tea-feat-content {
        padding: 40px 36px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .tea-card-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12.5px;
        color: #6b7280;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }
    .tea-card-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .tea-feat-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 26px;
        font-weight: 800;
        color: var(--tea-dark);
        line-height: 1.35;
        margin: 0 0 14px 0;
    }
    .tea-feat-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .tea-feat-title a:hover {
        color: var(--tea-forest);
    }
    .tea-feat-excerpt {
        font-size: 15px;
        color: #4b5563;
        line-height: 1.65;
        margin-bottom: 24px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .tea-read-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, var(--tea-forest) 0%, var(--tea-dark) 100%);
        color: #ffffff !important;
        font-size: 14.5px;
        font-weight: 700;
        padding: 12px 24px;
        border-radius: 30px;
        text-decoration: none;
        align-self: flex-start;
        box-shadow: 0 6px 18px rgba(23, 63, 44, 0.15);
        transition: all 0.25s ease;
    }
    .tea-read-btn:hover {
        background: #cdb06a;
        color: #0a211b !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(205, 176, 106, 0.35);
    }

    /* Section Title */
    .tea-grid-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        border-bottom: 2px solid #e8e4dc;
        padding-bottom: 14px;
    }
    .tea-grid-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 800;
        color: var(--tea-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-grid-title i {
        color: var(--tea-gold);
    }
    .tea-grid-count {
        font-size: 13.5px;
        color: #6b7280;
        font-weight: 600;
    }

    /* 3-Column Articles Grid */
    .tea-articles-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        margin-bottom: 48px;
    }

    /* Individual Blog Card */
    .tea-blog-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 8px 24px -6px rgba(10, 33, 27, 0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }
    .tea-blog-card:hover {
        transform: translateY(-4px);
        border-color: var(--tea-gold);
        box-shadow: 0 14px 32px -8px rgba(10, 33, 27, 0.12);
    }

    .tea-card-thumb-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: #f4f2ee;
    }
    .tea-card-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    .tea-blog-card:hover .tea-card-thumb-wrap img {
        transform: scale(1.08);
    }

    .tea-card-date-badge {
        position: absolute;
        bottom: 12px;
        right: 12px;
        background: rgba(10, 33, 27, 0.85);
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .tea-card-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .tea-card-tag {
        display: inline-block;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--tea-forest);
        background: #f4f8f2;
        border: 1px solid #c9dec4;
        padding: 3px 10px;
        border-radius: 12px;
        margin-bottom: 10px;
        align-self: flex-start;
    }

    .tea-card-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--tea-dark);
        line-height: 1.4;
        margin: 0 0 10px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 50px;
    }
    .tea-card-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .tea-card-title a:hover {
        color: var(--tea-forest);
    }

    .tea-card-desc {
        font-size: 13.5px;
        color: #6b7280;
        line-height: 1.55;
        margin-bottom: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .tea-card-footer {
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .tea-card-author {
        font-size: 12px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .tea-card-link {
        font-size: 13px;
        font-weight: 700;
        color: var(--tea-forest);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .tea-blog-card:hover .tea-card-link {
        color: #cdb06a;
        transform: translateX(3px);
    }

    /* Empty State */
    .tea-empty-state {
        background: #ffffff;
        border-radius: 20px;
        border: 1px dashed #d1d5db;
        padding: 60px 24px;
        text-align: center;
        margin: 20px 0;
    }
    .tea-empty-icon {
        font-size: 48px;
        color: #cdb06a;
        margin-bottom: 16px;
    }
    .tea-empty-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--tea-dark);
        margin-bottom: 8px;
    }
    .tea-empty-desc {
        font-size: 14.5px;
        color: #6b7280;
        margin-bottom: 20px;
    }

    /* Bottom Discovery Strip */
    .tea-discovery-strip {
        background: linear-gradient(135deg, #0a211b 0%, #173f2c 100%);
        border-radius: 24px;
        padding: 36px 32px;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
        box-shadow: 0 12px 32px -8px rgba(10, 33, 27, 0.2);
        border: 1px solid rgba(205, 176, 106, 0.3);
    }
    .tea-discovery-info h3 {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 800;
        margin: 0 0 6px 0;
        color: #ffffff;
    }
    .tea-discovery-info p {
        font-size: 14px;
        color: #d1d5db;
        margin: 0;
    }
    .tea-discovery-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #cdb06a;
        color: #0a211b !important;
        font-weight: 800;
        font-size: 15px;
        padding: 12px 28px;
        border-radius: 30px;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 6px 18px rgba(205, 176, 106, 0.3);
    }
    .tea-discovery-btn:hover {
        background: #e2cf9c;
        transform: translateY(-2px);
    }

    /* Pagination Styling */
    .tea-pagination-wrap {
        display: flex;
        justify-content: center;
        margin-bottom: 44px;
    }
    .tea-pagination-wrap .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .tea-pagination-wrap .page-item .page-link {
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        color: var(--tea-forest);
        padding: 8px 16px;
        font-weight: 700;
        background: #ffffff;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-pagination-wrap .page-item.active .page-link {
        background: var(--tea-forest);
        border-color: var(--tea-forest);
        color: #ffffff;
    }
    .tea-pagination-wrap .page-item .page-link:hover {
        background: #f4f8f2;
        border-color: var(--tea-forest);
    }

    /* Responsive Breakpoints */
    @media (max-width: 991px) {
        .tea-featured-card {
            grid-template-columns: 1fr;
        }
        .tea-feat-img-box {
            min-height: 240px;
        }
        .tea-articles-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .tea-hero-title {
            font-size: 28px;
        }
    }

    @media (max-width: 640px) {
        .tea-articles-grid {
            grid-template-columns: 1fr;
        }
        .tea-journal-hero {
            padding: 32px 18px;
            border-radius: 20px;
        }
        .tea-hero-title {
            font-size: 22px;
        }
        .tea-hero-subtitle {
            font-size: 14px;
        }
        .tea-feat-content {
            padding: 24px 18px;
        }
        .tea-feat-title {
            font-size: 20px;
        }
        .tea-discovery-strip {
            padding: 24px 20px;
            text-align: center;
            justify-content: center;
        }
        .tea-discovery-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="tea-journal-page">
    <div class="tea-journal-container">
        <!-- Breadcrumb -->
        <nav class="tea-journal-breadcrumb" aria-label="breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> হোম</a>
            <i class="fas fa-chevron-right"></i>
            <span>চা জার্নাল ও গল্প সম্ভার</span>
            @if(request('search'))
                <i class="fas fa-chevron-right"></i>
                <span>অনুসন্ধান: "{{ request('search') }}"</span>
            @endif
        </nav>

        <!-- Hero Banner Header -->
        <header class="tea-journal-hero">
            <div class="tea-hero-badge">
                <i class="fas fa-leaf"></i> অনেককিছু টি জার্নাল
            </div>
            <h1 class="tea-hero-title">
                স্বাদ, সুবাস ও সতেজ জীবনের গল্প
            </h1>
            <p class="tea-hero-subtitle">
                পার্বত্য চট্টগ্রামের খাঁটি পাহাড়ি রোজেলা, অর্গানিক গ্রিন টি এবং শতাব্দীর ঐতিহ্যবাহী চা সংস্কৃতির অজানা ইতিহাস, স্বাস্থ্য উপকারিতা ও সুস্বাদু চা তৈরির রহস্য।
            </p>

            <!-- Search Bar -->
            <form action="{{ route('blog_list') }}" method="GET" class="tea-hero-search">
                <div class="tea-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="tea-search-input"
                           placeholder="চায়ের ইতিহাস, রোজেলা বা উপকারিতা খুঁজুন..."
                           value="{{ request('search') }}" />
                    <button type="submit" class="tea-search-btn">অনুসন্ধান</button>
                </div>
            </form>
        </header>

        <!-- Featured Top Story (Only show on first page when not searching) -->
        @if(!request('search') && $blogs->currentPage() == 1 && $featured)
            <div class="tea-featured-card">
                <div class="tea-feat-img-box">
                    <img src="{{ asset($featured->b_image ? $featured->b_image : 'public/uploads/default.png') }}"
                         alt="{{ $featured->b_title }}" loading="eager" />
                    <div class="tea-feat-badge">
                        <i class="fas fa-star"></i> ফিচার্ড আর্টিকেল
                    </div>
                </div>
                <div class="tea-feat-content">
                    <div class="tea-card-meta">
                        <span><i class="fas fa-tag text-success"></i> চা ও জীবনধারা</span>
                        <span><i class="far fa-calendar-alt"></i> {{ date('d M, Y', strtotime($featured->b_date ?? $featured->created_at)) }}</span>
                        @if($featured->b_author)
                            <span><i class="far fa-user"></i> {{ $featured->b_author }}</span>
                        @endif
                    </div>
                    <h2 class="tea-feat-title">
                        <a href="{{ route('single_blog', $featured->id) }}">{{ $featured->b_title }}</a>
                    </h2>
                    <p class="tea-feat-excerpt">
                        {{ $featured->b_short_des ?: Str::limit(strip_tags($featured->b_long_des), 180) }}
                    </p>
                    <a href="{{ route('single_blog', $featured->id) }}" class="tea-read-btn">
                        <span>সম্পূর্ণ পড়ুন</span> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endif

        <!-- Grid Section Header -->
        <div class="tea-grid-heading">
            <h2 class="tea-grid-title">
                <i class="fas fa-book-open"></i>
                @if(request('search'))
                    অনুসন্ধানের ফলাফল
                @else
                    সকল প্রকাশিত নিবন্ধ
                @endif
            </h2>
            <div class="tea-grid-count">
                মোট {{ $blogs->total() }}টি আর্টিকেল
            </div>
        </div>

        <!-- Articles Grid -->
        @if($blogs->count() > 0)
            <div class="tea-articles-grid">
                @foreach($blogs as $blog)
                    <article class="tea-blog-card">
                        <div class="tea-card-thumb-wrap">
                            <a href="{{ route('single_blog', $blog->id) }}" class="d-block h-100">
                                <img src="{{ asset($blog->b_image ? $blog->b_image : 'public/uploads/default.png') }}"
                                     alt="{{ $blog->b_title }}" loading="lazy" />
                            </a>
                            <div class="tea-card-date-badge">
                                <i class="far fa-calendar-alt"></i>
                                {{ date('d M, Y', strtotime($blog->b_date ?? $blog->created_at)) }}
                            </div>
                        </div>

                        <div class="tea-card-body">
                            <span class="tea-card-tag">চা ও স্বাস্থ্য</span>
                            <h3 class="tea-card-title">
                                <a href="{{ route('single_blog', $blog->id) }}" title="{{ $blog->b_title }}">
                                    {{ $blog->b_title }}
                                </a>
                            </h3>
                            <p class="tea-card-desc">
                                {{ $blog->b_short_des ?: Str::limit(strip_tags($blog->b_long_des), 110) }}
                            </p>

                            <div class="tea-card-footer">
                                <div class="tea-card-author">
                                    <i class="far fa-user"></i>
                                    <span>{{ $blog->b_author ?? 'OnekkisuBD' }}</span>
                                </div>
                                <a href="{{ route('single_blog', $blog->id) }}" class="tea-card-link">
                                    <span>পড়ুন</span> <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($blogs->hasPages())
                <div class="tea-pagination-wrap">
                    {{ $blogs->links() }}
                </div>
            @endif
        @else
            <div class="tea-empty-state">
                <div class="tea-empty-icon">
                    <i class="fas fa-feather-alt"></i>
                </div>
                <h3 class="tea-empty-title">কোনো আর্টিকেল পাওয়া যায়নি</h3>
                <p class="tea-empty-desc">
                    আপনার অনুসন্ধানের সাথে মিল রেখে কোনো ব্লগ পোস্ট খুঁজে পাওয়া যায়নি।
                </p>
                <a href="{{ route('blog_list') }}" class="tea-read-btn">
                    <span>সব নিবন্ধ দেখুন</span>
                </a>
            </div>
        @endif

        <!-- Bottom Tea Discovery Strip -->
        <section class="tea-discovery-strip">
            <div class="tea-discovery-info">
                <h3>পাহাড়ের খাঁটি চায়ে শুরু হোক আপনার প্রতিটি সকাল</h3>
                <p>আমাদের অর্গানিক পাহাড়ি রোজেলা ও নির্বাচিত প্রিমিয়াম ব্লেন্ডের সমাহার ঘরে বসেই অর্ডার করুন।</p>
            </div>
            <a href="{{ route('shop') }}" class="tea-discovery-btn">
                <i class="fas fa-shopping-bag"></i> চা সম্ভার দেখুন
            </a>
        </section>
    </div>
</div>
@endsection
