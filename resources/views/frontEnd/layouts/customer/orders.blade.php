@extends('frontEnd.layouts.master')
@section('title', 'আমার অর্ডারসমূহ | My Orders')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CUSTOMER ORDERS STYLES
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
    .tea-orders-main-card {
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
    .tea-orders-header {
        padding: 24px 28px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tea-orders-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-orders-title i {
        color: #245a2d;
    }
    .tea-orders-subtitle {
        font-size: 13.5px;
        color: #6b7280;
        margin: 0;
    }

    /* Orders Table */
    .tea-orders-table-wrapper {
        padding: 8px 16px 20px;
    }
    .tea-orders-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .tea-orders-table th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #6b7280;
        font-weight: 600;
        padding: 14px 16px;
        background: #f8faf7;
        border-bottom: 1px solid #e8e4dc;
    }
    .tea-orders-table td {
        padding: 16px;
        border-bottom: 1px solid #f1ede6;
        font-size: 14px;
        color: #1f2937;
        vertical-align: middle;
    }
    .tea-orders-table tr:last-child td {
        border-bottom: none;
    }

    .tea-invoice-link {
        font-weight: 700;
        color: #173f2c;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: 'Playfair Display', serif;
        font-size: 15px;
    }
    .tea-invoice-link:hover {
        color: #cdb06a;
    }
    .tea-invoice-link i {
        font-size: 12px;
        color: #cdb06a;
    }

    /* Status Badges */
    .tea-order-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-badge-pending {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .status-badge-processing {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }
    .status-badge-courier {
        background: #f5f3ff;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }
    .status-badge-delivered {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }
    .status-badge-cancelled {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    /* Actions */
    .tea-order-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-btn-order-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: 1px solid #e8e4dc;
        background: #ffffff;
        color: #173f2c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-btn-order-action:hover {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
        transform: translateY(-1px);
    }
    .tea-btn-order-action.action-track {
        color: #245a2d;
    }
    .tea-btn-order-action.action-track:hover {
        background: #245a2d;
        color: #ffffff;
    }
    .tea-btn-order-action.action-note {
        color: #b45309;
    }
    .tea-btn-order-action.action-note:hover {
        background: #b45309;
        color: #ffffff;
    }

    /* Empty state */
    .tea-no-orders {
        padding: 50px 24px;
        text-align: center;
    }
    .tea-no-orders-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #f4f8f2;
        border: 2px solid #e2cf9c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #173f2c;
        font-size: 26px;
        margin-bottom: 16px;
    }
    .tea-no-orders-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 20px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 8px;
    }
    .tea-no-orders-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0 0 20px;
    }
    .tea-btn-shop-now {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #173f2c;
        color: #ffffff;
        border-radius: 24px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .tea-btn-shop-now:hover {
        background: #245a2d;
        color: #ffffff;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .tea-account-page {
            padding: 20px 12px 60px;
        }
        .tea-orders-header {
            padding: 18px;
        }
        .tea-orders-table-wrapper {
            padding: 4px 8px 16px;
        }
        .tea-orders-table td, 
        .tea-orders-table th {
            padding: 12px 8px;
            font-size: 13px;
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
            <span>আমার অর্ডারসমূহ</span>
        </div>

        <div class="row">
            <!-- Left Column: Customer Sidebar -->
            <div class="col-lg-4 col-md-5">
                @include('frontEnd.layouts.customer.sidebar')
            </div>

            <!-- Right Column: Orders Table -->
            <div class="col-lg-8 col-md-7">
                <div class="tea-orders-main-card">
                    <div class="tea-card-top-strip"></div>

                    <!-- Header -->
                    <div class="tea-orders-header">
                        <div>
                            <h2 class="tea-orders-title">
                                <i class="fa-solid fa-box-archive"></i> আমার অর্ডারসমূহ
                            </h2>
                            <p class="tea-orders-subtitle">আপনার পূর্ববর্তী সকল অর্ডারের তালিকা ও বর্তমান অবস্থা</p>
                        </div>
                    </div>

                    @if($orders->count() == 0)
                        <div class="tea-no-orders">
                            <div class="tea-no-orders-icon">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>
                            <h3 class="tea-no-orders-title">এখনও কোনো অর্ডার করেননি</h3>
                            <p class="tea-no-orders-subtitle">আমাদের ফ্রেশ ও প্রিমিয়াম চা কালেকশন থেকে আপনার পছন্দের চা বেছে নিন।</p>
                            <a href="{{ route('shop') }}" class="tea-btn-shop-now">
                                <i class="fa-solid fa-leaf"></i> চা শপ ঘুরে দেখুন
                            </a>
                        </div>
                    @else
                        <div class="tea-orders-table-wrapper table-responsive">
                            <table class="tea-orders-table">
                                <thead>
                                    <tr>
                                        <th>ইনভয়েস</th>
                                        <th>তারিখ</th>
                                        <th>মোট মূল্য</th>
                                        <th>অবস্থা (Status)</th>
                                        <th style="text-align: right;">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key => $value)
                                        @php
                                            $statusId = $value->order_status;
                                            $statusName = $value->status ? $value->status->name : 'Pending';

                                            $badgeClass = 'status-badge-pending';
                                            $badgeLabel = 'গৃহীত';
                                            if (in_array($statusId, [6, 12])) {
                                                $badgeClass = 'status-badge-delivered';
                                                $badgeLabel = 'ডেলিভার্ড';
                                            } elseif (in_array($statusId, [5, 11])) {
                                                $badgeClass = 'status-badge-courier';
                                                $badgeLabel = 'কুরিয়ারে';
                                            } elseif (in_array($statusId, [2, 3, 9, 10])) {
                                                $badgeClass = 'status-badge-processing';
                                                $badgeLabel = 'প্রসেসিং';
                                            } elseif (in_array($statusId, [4, 8, 14, 15, 16])) {
                                                $badgeClass = 'status-badge-cancelled';
                                                $badgeLabel = 'বাতিল';
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ route('customer.invoice', ['id' => $value->id]) }}" class="tea-invoice-link">
                                                    <i class="fa-solid fa-receipt"></i> #{{ $value->invoice_id }}
                                                </a>
                                            </td>
                                            <td style="color: #6b7280; font-size: 13px;">
                                                {{ $value->created_at->format('d M, Y') }}
                                            </td>
                                            <td>
                                                <strong style="color: #173f2c; font-family: 'Playfair Display', serif; font-size: 15.5px;">৳{{ number_format($value->amount) }}</strong>
                                            </td>
                                            <td>
                                                <span class="tea-order-status-badge {{ $badgeClass }}">
                                                    <i class="fa-solid fa-circle-dot" style="font-size: 9px;"></i> {{ $badgeLabel }} ({{ $statusName }})
                                                </span>
                                            </td>
                                            <td>
                                                <div class="tea-order-actions" style="justify-content: flex-end;">
                                                    <a href="{{ route('customer.invoice', ['id' => $value->id]) }}" 
                                                       class="tea-btn-order-action" 
                                                       title="ইনভয়েস দেখুন">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('customer.order_track_result', ['invoice_id' => $value->invoice_id]) }}" 
                                                       class="tea-btn-order-action action-track" 
                                                       title="ট্র্যাক করুন">
                                                        <i class="fa-solid fa-truck-fast"></i>
                                                    </a>
                                                    @if($value->admin_note)
                                                        <a href="{{ route('customer.order_note', ['id' => $value->id]) }}" 
                                                           class="tea-btn-order-action action-note" 
                                                           title="অর্ডার নোট দেখুন">
                                                            <i class="fa-solid fa-note-sticky"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection