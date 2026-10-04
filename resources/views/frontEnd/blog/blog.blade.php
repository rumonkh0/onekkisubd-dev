@extends('frontEnd.layouts.master')
@section('title', $blog->b_title . ' | Tea Journal & Articles')

@section('content')
<style>
    /* ========================================================
       LUXURY DARK TEA BLOG & JOURNAL PAGE
       ======================================================== */
    .tea-blog-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.05) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-blog-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .tea-blog-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .tea-blog-breadcrumb a {
        color: #173f2c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .tea-blog-breadcrumb a:hover {
        color: #cdb06a;
    }
    .tea-blog-breadcrumb i {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Main Grid */
    .tea-blog-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 32px;
        align-items: start;
    }

    /* Article Card */
    .tea-article-card {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 10px 30px -8px rgba(10, 33, 27, 0.05);
        overflow: hidden;
        padding: 36px;
    }

    /* Meta Badges */
    .tea-article-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }
    .tea-article-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f4f8f2;
        color: #173f2c;
        border: 1px solid #c9dec4;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 12px;
    }
    .tea-article-date {
        font-size: 13px;
        color: #6b7280;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Article Title */
    .tea-article-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 30px;
        font-weight: 800;
        color: #0a211b;
        margin: 0 0 24px 0;
        line-height: 1.35;
    }

    /* Hero Image */
    .tea-article-image-wrap {
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 8px 24px -6px rgba(10, 33, 27, 0.1);
        background: #fdfcf9;
        max-height: 480px;
    }
    .tea-article-image-wrap img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* Summary Highlight */
    @if(!empty($blog->b_short_des))
    .tea-article-summary {
        background: #f4f8f2;
        border-left: 4px solid #173f2c;
        border-radius: 0 14px 14px 0;
        padding: 18px 22px;
        margin-bottom: 28px;
        font-size: 16px;
        font-weight: 500;
        color: #173f2c;
        line-height: 1.65;
    }
    @endif

    /* Article Body Typography */
    .tea-article-body {
        font-size: 16px;
        line-height: 1.85;
        color: #374151;
        word-break: break-word;
    }
    .tea-article-body p {
        margin-bottom: 20px;
    }
    .tea-article-body h2,
    .tea-article-body h3,
    .tea-article-body h4 {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        color: #0a211b;
        margin: 32px 0 16px;
        font-weight: 700;
    }
    .tea-article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 14px;
        margin: 20px 0;
    }
    .tea-article-body blockquote {
        margin: 28px 0;
        padding: 18px 24px;
        background: #fbf9f5;
        border-left: 4px solid #cdb06a;
        font-style: italic;
        color: #4b5563;
        border-radius: 0 12px 12px 0;
    }

    /* Share Section */
    .tea-article-share {
        border-top: 1px solid #e8e4dc;
        margin-top: 40px;
        padding-top: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .tea-share-label {
        font-size: 14px;
        font-weight: 700;
        color: #0a211b;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .tea-share-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-share-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #ffffff !important;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-share-btn:hover {
        transform: translateY(-2px);
    }
    .tea-share-fb { background: #1877f2; }
    .tea-share-wa { background: #25d366; }
    .tea-share-tw { background: #1da1f2; }
    .tea-share-copy {
        background: #173f2c;
        border: none;
        cursor: pointer;
    }

    /* Prev / Next Article Navigation */
    .tea-post-navigation {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e8e4dc;
    }
    .tea-nav-post {
        display: flex;
        flex-direction: column;
        padding: 16px 18px;
        background: #fbf9f5;
        border: 1px solid #e8e4dc;
        border-radius: 16px;
        text-decoration: none;
        transition: all 0.22s ease;
    }
    .tea-nav-post:hover {
        border-color: #cdb06a;
        background: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(10, 33, 27, 0.06);
    }
    .tea-nav-next {
        text-align: right;
    }
    .tea-nav-direction {
        font-size: 12px;
        font-weight: 700;
        color: #173f2c;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .tea-nav-next .tea-nav-direction {
        justify-content: flex-end;
    }
    .tea-nav-title {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        line-height: 1.4;
    }
    @media (max-width: 640px) {
        .tea-post-navigation {
            grid-template-columns: 1fr;
        }
        .tea-nav-next {
            text-align: left;
        }
        .tea-nav-next .tea-nav-direction {
            justify-content: flex-start;
        }
    }

    /* Sidebar */
    .tea-blog-sidebar {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    .tea-sidebar-widget {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 8px 24px -6px rgba(10, 33, 27, 0.04);
        padding: 24px;
    }
    .tea-widget-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 18px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 18px 0;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid #f4f8f2;
        padding-bottom: 12px;
    }
    .tea-widget-title i {
        color: #cdb06a;
    }

    /* Recent Posts List */
    .tea-recent-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .tea-recent-item {
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        padding-bottom: 14px;
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }
    .tea-recent-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .tea-recent-thumb {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
        background: #fdfcf9;
        border: 1px solid #e8e4dc;
    }
    .tea-recent-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .tea-recent-item:hover .tea-recent-thumb img {
        transform: scale(1.08);
    }
    .tea-recent-info {
        flex-grow: 1;
    }
    .tea-recent-title {
        font-size: 13.5px;
        font-weight: 600;
        color: #111827;
        margin: 0 0 6px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color 0.2s ease;
    }
    .tea-recent-item:hover .tea-recent-title {
        color: #173f2c;
    }
    .tea-recent-date {
        font-size: 11.5px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Promo Card */
    .tea-promo-widget {
        background: linear-gradient(135deg, #0a211b 0%, #173f2c 100%);
        border-radius: 20px;
        padding: 28px 24px;
        color: #ffffff;
        border: 1px solid rgba(205, 176, 106, 0.35);
        box-shadow: 0 10px 28px -6px rgba(10, 33, 27, 0.2);
        text-align: center;
    }
    .tea-promo-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: rgba(205, 176, 106, 0.16);
        color: #e2cf9c;
        border: 1px solid rgba(205, 176, 106, 0.4);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 16px;
    }
    .tea-promo-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 20px;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 8px 0;
    }
    .tea-promo-desc {
        font-size: 13.5px;
        color: #d1d5db;
        line-height: 1.6;
        margin: 0 0 20px 0;
    }
    .tea-promo-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #cdb06a;
        color: #0a211b;
        font-weight: 700;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-promo-btn:hover {
        background: #e2cf9c;
        color: #0a211b;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .tea-blog-layout {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 767px) {
        .tea-blog-page {
            padding: 20px 12px 60px;
        }
        .tea-article-card {
            padding: 20px 16px;
            border-radius: 18px;
        }
        .tea-article-title {
            font-size: 22px;
            margin-bottom: 16px;
        }
        .tea-article-body {
            font-size: 15px;
            line-height: 1.75;
        }
    }
</style>

<div class="tea-blog-page">
    <div class="tea-blog-container">
        <!-- Breadcrumb -->
        <div class="tea-blog-breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> হোম</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('blog_list') }}">চা জার্নাল ও নিবন্ধ</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ Str::limit($blog->b_title, 35) }}</span>
        </div>

        <div class="tea-blog-layout">
            <!-- Left: Main Article -->
            <article class="tea-article-card">
                <!-- Meta tags -->
                <div class="tea-article-meta">
                    <span class="tea-article-pill">
                        <i class="fas fa-leaf"></i> চা ও জীবনধারা
                    </span>
                    <span class="tea-article-date">
                        <i class="far fa-calendar-alt"></i>
                        {{ date('d M, Y', strtotime($blog->b_date ?? $blog->created_at)) }}
                    </span>
                    @if($blog->b_author)
                        <span class="tea-article-date">
                            <i class="far fa-user"></i> {{ $blog->b_author }}
                        </span>
                    @endif
                </div>

                <!-- Title -->
                <h1 class="tea-article-title">{{ $blog->b_title }}</h1>

                <!-- Featured Image -->
                @if($blog->b_image)
                    <div class="tea-article-image-wrap">
                        <img src="{{ asset($blog->b_image) }}" alt="{{ $blog->b_title }}" />
                    </div>
                @endif

                <!-- Short summary highlight -->
                @if(!empty($blog->b_short_des))
                    <div class="tea-article-summary">
                        {{ $blog->b_short_des }}
                    </div>
                @endif

                <!-- Long Description / Body -->
                <div class="tea-article-body">
                    {!! $blog->b_long_des !!}
                </div>

                <!-- Social Share Bar -->
                <div class="tea-article-share">
                    <div class="tea-share-label">
                        <i class="fas fa-share-alt"></i> আর্টিকেলটি শেয়ার করুন:
                    </div>
                    <div class="tea-share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                           target="_blank" class="tea-share-btn tea-share-fb" title="Facebook-এ শেয়ার করুন">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($blog->b_title . ' ' . request()->fullUrl()) }}"
                           target="_blank" class="tea-share-btn tea-share-wa" title="WhatsApp-এ শেয়ার করুন">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->b_title) }}&url={{ urlencode(request()->fullUrl()) }}"
                           target="_blank" class="tea-share-btn tea-share-tw" title="Twitter-এ শেয়ার করুন">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <button type="button" class="tea-share-btn tea-share-copy" onclick="copyArticleUrl()" title="লিঙ্ক কপি করুন">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- Prev / Next Article Navigation -->
                @if($prevPost || $nextPost)
                    <div class="tea-post-navigation">
                        @if($prevPost)
                            <a href="{{ route('single_blog', $prevPost->id) }}" class="tea-nav-post tea-nav-prev">
                                <span class="tea-nav-direction"><i class="fas fa-arrow-left"></i> পূর্ববর্তী আর্টিকেল</span>
                                <span class="tea-nav-title">{{ Str::limit($prevPost->b_title, 45) }}</span>
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextPost)
                            <a href="{{ route('single_blog', $nextPost->id) }}" class="tea-nav-post tea-nav-next">
                                <span class="tea-nav-direction">পরবর্তী আর্টিকেল <i class="fas fa-arrow-right"></i></span>
                                <span class="tea-nav-title">{{ Str::limit($nextPost->b_title, 45) }}</span>
                            </a>
                        @endif
                    </div>
                @endif
            </article>

            <!-- Right: Sidebar -->
            <aside class="tea-blog-sidebar">
                <!-- Recent Posts Widget -->
                <div class="tea-sidebar-widget">
                    <h3 class="tea-widget-title">
                        <i class="fas fa-feather-alt"></i> সাম্প্রতিক নিবন্ধ
                    </h3>
                    <div class="tea-recent-list">
                        @foreach($resentpost as $post)
                            <a href="{{ route('single_blog', $post->id) }}" class="tea-recent-item">
                                <div class="tea-recent-thumb">
                                    <img src="{{ asset($post->b_image ? $post->b_image : 'public/uploads/default.png') }}"
                                         alt="{{ $post->b_title }}" />
                                </div>
                                <div class="tea-recent-info">
                                    <h4 class="tea-recent-title">{{ $post->b_title }}</h4>
                                    <span class="tea-recent-date">
                                        <i class="far fa-clock"></i> {{ date('d M, Y', strtotime($post->b_date ?? $post->created_at)) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Tea Store Promo Widget -->
                <div class="tea-promo-widget">
                    <div class="tea-promo-icon">
                        <i class="fas fa-mug-hot"></i>
                    </div>
                    <h3 class="tea-promo-title">তাজা বাগানের খাঁটি চা</h3>
                    <p class="tea-promo-desc">
                        প্রকৃতির বিশুদ্ধতায় সমৃদ্ধ শ্রেষ্ঠ চা পাতার প্রতিটি চুমুকে উপভোগ করুন আসল সতেজতা ও অনন্য স্বাদ।
                    </p>
                    <a href="{{ route('shop') }}" class="tea-promo-btn">
                        <i class="fas fa-shopping-basket"></i> চা কালেকশন দেখুন
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    function copyArticleUrl() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            if (typeof toastr !== 'undefined') {
                toastr.success('আর্টিকেলের লিঙ্ক কপি করা হয়েছে!');
            } else {
                alert('লিঙ্ক কপি করা হয়েছে!');
            }
        });
    }
</script>
@endpush
