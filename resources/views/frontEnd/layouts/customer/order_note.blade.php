@extends('frontEnd.layouts.master')
@section('title', 'অর্ডার নোট | Order Note')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CUSTOMER ORDER NOTE STYLES
       ======================================================== */
    .tea-account-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.06) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-account-container {
        max-width: 1140px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .tea-account-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 24px;
    }
    .tea-account-breadcrumb a {
        color: #173f2c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .tea-account-breadcrumb a:hover {
        color: #cdb06a;
    }
    .tea-account-breadcrumb i {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Card */
    .tea-note-main-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 12px 32px -10px rgba(10, 33, 27, 0.06);
        overflow: hidden;
    }
    .tea-card-top-strip {
        height: 4px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }

    /* Header */
    .tea-note-header {
        padding: 24px 28px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tea-note-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 22px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-note-title i {
        color: #cdb06a;
    }
    .tea-btn-back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border: 1px solid #e8e4dc;
        background: #ffffff;
        border-radius: 20px;
        color: #173f2c;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-btn-back-link:hover {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
    }

    /* Body */
    .tea-note-body {
        padding: 28px;
    }
    .tea-note-box {
        background: #fbfbf9;
        border-left: 4px solid #173f2c;
        border-radius: 0 14px 14px 0;
        padding: 24px;
        font-size: 15px;
        line-height: 1.7;
        color: #374151;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    @media (max-width: 768px) {
        .tea-account-page {
            padding: 20px 12px 60px;
        }
        .tea-note-header {
            padding: 20px 18px;
        }
        .tea-note-body {
            padding: 20px 18px;
        }
    }
</style>

<div class="tea-account-page">
    <div class="tea-account-container">
        <!-- Breadcrumb -->
        <div class="tea-account-breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('customer.account') }}">অ্যাকাউন্ট</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('customer.orders') }}">অর্ডারসমূহ</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>অর্ডার নোট</span>
        </div>

        <div class="row">
            <!-- Left Column: Customer Sidebar -->
            <div class="col-lg-4 col-md-5">
                @include('frontEnd.layouts.customer.sidebar')
            </div>

            <!-- Right Column: Note Card -->
            <div class="col-lg-8 col-md-7">
                <div class="tea-note-main-card">
                    <div class="tea-card-top-strip"></div>

                    <div class="tea-note-header">
                        <div>
                            <h2 class="tea-note-title">
                                <i class="fa-solid fa-note-sticky"></i> অর্ডার নোট [ইনভয়েস #{{ $order->invoice_id }}]
                            </h2>
                            <p style="font-size: 13px; color: #6b7280; margin: 0;">অ্যাডমিন বা কাস্টমার সার্ভিস থেকে প্রেরিত নির্দেশনা</p>
                        </div>
                        <a href="{{ route('customer.orders') }}" class="tea-btn-back-link">
                            <i class="fa-solid fa-arrow-left"></i> অর্ডার তালিকায় ফিরুন
                        </a>
                    </div>

                    <div class="tea-note-body">
                        <div class="tea-note-box">
                            {!! $order->admin_note !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection