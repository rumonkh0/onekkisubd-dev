@extends('frontEnd.layouts.master')
@section('title', 'আমার অ্যাকাউন্ট | My Account')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CUSTOMER ACCOUNT OVERVIEW STYLES
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

    /* Main Content Card */
    .tea-account-main-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 12px 32px -10px rgba(10, 33, 27, 0.06);
        overflow: hidden;
        margin-bottom: 24px;
    }
    .tea-card-top-strip {
        height: 4px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }

    /* Welcome Header */
    .tea-welcome-banner {
        padding: 24px 28px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .tea-welcome-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 4px;
    }
    .tea-welcome-subtitle {
        font-size: 13.5px;
        color: #6b7280;
        margin: 0;
    }
    .tea-btn-edit-profile {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        background: #173f2c;
        color: #ffffff;
        border-radius: 30px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.2);
    }
    .tea-btn-edit-profile:hover {
        background: #245a2d;
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Stat Cards */
    .tea-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        padding: 24px 28px;
        border-bottom: 1px solid #f1ede6;
        background: #fbfbf9;
    }
    .tea-stat-box {
        background: #ffffff;
        border: 1px solid #e8e4dc;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 4px 14px rgba(10, 33, 27, 0.02);
        transition: transform 0.2s ease;
    }
    .tea-stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(10, 33, 27, 0.06);
    }
    .tea-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .icon-orders {
        background: #eaf4eb;
        color: #173f2c;
        border: 1px solid #c9dec4;
    }
    .icon-completed {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .icon-spent {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .tea-stat-info {
        display: flex;
        flex-direction: column;
    }
    .tea-stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        color: #0a211b;
        line-height: 1.2;
    }
    .tea-stat-label {
        font-size: 12.5px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Details Section */
    .tea-info-section {
        padding: 28px;
    }
    .tea-section-heading {
        font-size: 16px;
        font-weight: 700;
        color: #173f2c;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-section-heading i {
        color: #cdb06a;
    }

    /* Info Grid */
    .tea-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .tea-info-card {
        background: #fbfbf9;
        border: 1px solid #f0ede6;
        border-radius: 14px;
        padding: 16px 20px;
    }
    .tea-info-card-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #9ca3af;
        font-weight: 600;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .tea-info-card-label i {
        font-size: 12px;
        color: #245a2d;
    }
    .tea-info-card-value {
        font-size: 14.5px;
        font-weight: 600;
        color: #1f2937;
    }

    /* Quick links strip */
    .tea-quick-strip {
        padding: 20px 28px;
        background: #fafbf9;
        border-top: 1px solid #f1ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tea-quick-text {
        font-size: 13.5px;
        color: #6b7280;
    }
    .tea-btn-quick-order {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #245a2d;
        font-weight: 700;
        font-size: 13.5px;
        text-decoration: none;
    }
    .tea-btn-quick-order:hover {
        color: #cdb06a;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .tea-account-page {
            padding: 20px 12px 60px;
        }
        .tea-stats-grid {
            grid-template-columns: 1fr;
            padding: 18px;
        }
        .tea-info-grid {
            grid-template-columns: 1fr;
        }
        .tea-welcome-banner {
            padding: 20px 18px;
        }
        .tea-info-section {
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
            <span>আমার অ্যাকাউন্ট</span>
        </div>

        @php
            $customer = \App\Models\Customer::with('cust_area')->find(Auth::guard('customer')->user()->id);
            $totalOrders = \App\Models\Order::where('customer_id', $customer->id)->count();
            $completedOrders = \App\Models\Order::where('customer_id', $customer->id)->whereIn('order_status', [6, 12])->count();
            $totalSpent = \App\Models\Order::where('customer_id', $customer->id)->sum('amount');
        @endphp

        <div class="row">
            <!-- Left Column: Customer Sidebar -->
            <div class="col-lg-4 col-md-5">
                @include('frontEnd.layouts.customer.sidebar')
            </div>

            <!-- Right Column: Account Overview -->
            <div class="col-lg-8 col-md-7">
                <div class="tea-account-main-card">
                    <div class="tea-card-top-strip"></div>

                    <!-- Welcome Header -->
                    <div class="tea-welcome-banner">
                        <div>
                            <h2 class="tea-welcome-title">আমার অ্যাকাউন্ট ওভারভিউ</h2>
                            <p class="tea-welcome-subtitle">আপনার প্রোফাইল তথ্য ও কেনাকাটার সার্বিক বিবরণ</p>
                        </div>
                        <a href="{{ route('customer.profile_edit') }}" class="tea-btn-edit-profile">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span>তথ্য পরিবর্তন করুন</span>
                        </a>
                    </div>

                    <!-- Stats Grid -->
                    <div class="tea-stats-grid">
                        <div class="tea-stat-box">
                            <div class="tea-stat-icon icon-orders">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>
                            <div class="tea-stat-info">
                                <span class="tea-stat-value">{{ $totalOrders }}</span>
                                <span class="tea-stat-label">মোট অর্ডারসমূহ</span>
                            </div>
                        </div>

                        <div class="tea-stat-box">
                            <div class="tea-stat-icon icon-completed">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div class="tea-stat-info">
                                <span class="tea-stat-value">{{ $completedOrders }}</span>
                                <span class="tea-stat-label">ডেলিভারি সম্পন্ন</span>
                            </div>
                        </div>

                        <div class="tea-stat-box">
                            <div class="tea-stat-icon icon-spent">
                                <i class="fa-solid fa-coins"></i>
                            </div>
                            <div class="tea-stat-info">
                                <span class="tea-stat-value">৳{{ number_format($totalSpent) }}</span>
                                <span class="tea-stat-label">মোট কেনাকাটা</span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Grid -->
                    <div class="tea-info-section">
                        <div class="tea-section-heading">
                            <i class="fa-solid fa-address-card"></i>
                            <span>ব্যক্তিগত ও ডেলিভারি বিবরণ</span>
                        </div>

                        <div class="tea-info-grid">
                            <div class="tea-info-card">
                                <div class="tea-info-card-label">
                                    <i class="fa-solid fa-user"></i> পূর্ণ নাম (Full Name)
                                </div>
                                <div class="tea-info-card-value">
                                    {{ $customer->name ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="tea-info-card">
                                <div class="tea-info-card-label">
                                    <i class="fa-solid fa-phone"></i> মোবাইল নম্বর (Phone)
                                </div>
                                <div class="tea-info-card-value">
                                    {{ $customer->phone ?? 'N/A' }}
                                </div>
                            </div>

                            <div class="tea-info-card">
                                <div class="tea-info-card-label">
                                    <i class="fa-solid fa-envelope"></i> ইমেইল ঠিকানা (Email)
                                </div>
                                <div class="tea-info-card-value">
                                    {{ $customer->email ?: 'যোগ করা হয়নি' }}
                                </div>
                            </div>

                            <div class="tea-info-card">
                                <div class="tea-info-card-label">
                                    <i class="fa-solid fa-map-location-dot"></i> জেলা (District)
                                </div>
                                <div class="tea-info-card-value">
                                    {{ $customer->district ?: 'N/A' }}
                                </div>
                            </div>

                            <div class="tea-info-card">
                                <div class="tea-info-card-label">
                                    <i class="fa-solid fa-route"></i> এরিয়া / জোন (Area)
                                </div>
                                <div class="tea-info-card-value">
                                    {{ $customer->cust_area ? $customer->cust_area->area_name : 'N/A' }}
                                </div>
                            </div>

                            <div class="tea-info-card">
                                <div class="tea-info-card-label">
                                    <i class="fa-solid fa-house"></i> পূর্ণ ঠিকানা (Address)
                                </div>
                                <div class="tea-info-card-value">
                                    {{ $customer->address ?: 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Action Bar -->
                    <div class="tea-quick-strip">
                        <span class="tea-quick-text">
                            নতুন চা পাতা অর্ডার করতে চান?
                        </span>
                        <a href="{{ route('shop') }}" class="tea-btn-quick-order">
                            <span>চা শপ ব্রাউজ করুন</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection