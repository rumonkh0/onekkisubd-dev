@extends('frontEnd.layouts.master')
@section('title', $page->title . ' - OnekkisuBD')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY STATIC / POLICY PAGE STYLES
       ======================================================== */
    .tea-cms-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.05) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-cms-container {
        max-width: 960px;
        margin: 0 auto;
    }

    /* Common Menu Nav */
    .tea-cmn-menu-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 32px;
    }
    .tea-cmn-menu-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        background: #ffffff;
        border: 1px solid #e8e4dc;
        border-radius: 24px;
        font-size: 13.5px;
        font-weight: 600;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.22s ease;
        box-shadow: 0 2px 6px rgba(10, 33, 27, 0.02);
    }
    .tea-cmn-menu-link:hover {
        background: #f4f8f2;
        color: #173f2c;
        border-color: #c9dec4;
    }
    .tea-cmn-menu-link.active {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.2);
    }

    /* Article Card */
    .tea-cms-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 44px -10px rgba(10, 33, 27, 0.07);
        overflow: hidden;
    }
    .tea-cms-top-strip {
        height: 5px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }

    /* Header */
    .tea-cms-header {
        padding: 36px 40px 24px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1.5px solid #f1ede6;
        text-align: center;
    }
    .tea-cms-emblem {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #f4f8f2;
        border: 2px solid #e2cf9c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #173f2c;
        font-size: 22px;
        margin-bottom: 14px;
    }
    .tea-cms-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 30px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 6px;
        letter-spacing: -0.3px;
    }

    /* Article Body */
    .tea-cms-body {
        padding: 40px 48px 50px;
        font-size: 15.5px;
        line-height: 1.85;
        color: #374151;
    }
    .tea-cms-body h1, .tea-cms-body h2, .tea-cms-body h3, .tea-cms-body h4 {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        color: #0a211b;
        margin-top: 28px;
        margin-bottom: 14px;
        font-weight: 700;
    }
    .tea-cms-body p {
        margin-bottom: 18px;
    }
    .tea-cms-body ul, .tea-cms-body ol {
        margin-bottom: 20px;
        padding-left: 24px;
    }
    .tea-cms-body li {
        margin-bottom: 8px;
    }
    .tea-cms-body a {
        color: #245a2d;
        font-weight: 600;
        text-decoration: underline;
    }
    .tea-cms-body a:hover {
        color: #cdb06a;
    }

    @media (max-width: 768px) {
        .tea-cms-page {
            padding: 20px 12px 60px;
        }
        .tea-cms-header {
            padding: 24px 20px 18px;
        }
        .tea-cms-title {
            font-size: 24px;
        }
        .tea-cms-body {
            padding: 24px 20px 32px;
            font-size: 14.5px;
        }
    }
</style>

<div class="tea-cms-page">
    <div class="tea-cms-container">
        <!-- Common Policy / CMS Menu Links -->
        @if(isset($cmnmenu) && $cmnmenu->count() > 0)
            <div class="tea-cmn-menu-nav">
                @foreach($cmnmenu as $key => $value)
                    <a href="{{ route('page', $value->slug) }}" class="tea-cmn-menu-link {{ request()->is('page/'.$value->slug) ? 'active' : '' }}">
                        {{ $value->name }}
                    </a>
                @endforeach
                <a href="{{ route('contact') }}" class="tea-cmn-menu-link">
                    <i class="fa-solid fa-envelope"></i> যোগাযোগ (Contact Us)
                </a>
            </div>
        @endif

        <!-- Article Card -->
        <article class="tea-cms-card">
            <div class="tea-cms-top-strip"></div>

            <div class="tea-cms-header">
                <div class="tea-cms-emblem">
                    <i class="fa-solid fa-feather-pointed"></i>
                </div>
                <h1 class="tea-cms-title">{{ $page->title }}</h1>
            </div>

            <div class="tea-cms-body">
                {!! $page->description !!}
            </div>
        </article>
    </div>
</div>
@endsection
