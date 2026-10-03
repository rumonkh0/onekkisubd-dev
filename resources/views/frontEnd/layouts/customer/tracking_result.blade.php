@extends('frontEnd.layouts.master')
@section('title', 'অর্ডার ট্র্যাকিং ফলাফল | Order Tracking Result')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY ORDER TRACKING RESULT STYLES
       ======================================================== */
    .tea-track-result-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.06) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 40px 16px 80px;
    }
    .tea-result-container {
        max-width: 820px;
        margin: 0 auto;
    }

    /* Top Action Bar */
    .tea-result-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tea-btn-back-track {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        background: #ffffff;
        border: 1px solid #e8e4dc;
        border-radius: 30px;
        color: #173f2c;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 2px 8px rgba(10, 33, 27, 0.03);
    }
    .tea-btn-back-track:hover {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
        transform: translateX(-3px);
    }
    .tea-result-count-badge {
        font-size: 13.5px;
        color: #6b7280;
        background: #f4f6f3;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Card styling */
    .tea-order-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.08), 0 4px 16px rgba(10, 33, 27, 0.02);
        overflow: hidden;
        margin-bottom: 30px;
        transition: transform 0.25s ease;
    }
    .tea-card-top-strip {
        height: 5px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }

    /* Order Card Header */
    .tea-order-header {
        padding: 24px 28px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }
    .tea-order-header-left {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .tea-invoice-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: 'Playfair Display', serif;
        font-size: 19px;
        font-weight: 700;
        color: #0a211b;
    }
    .tea-invoice-pill i {
        color: #cdb06a;
        font-size: 16px;
    }
    .tea-order-meta-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        font-size: 13px;
        color: #6b7280;
    }
    .tea-order-meta-row span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .tea-payment-badge {
        background: #f4f8f2;
        color: #245a2d;
        border: 1px solid #c9dec4;
        padding: 2px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Status Badges */
    .tea-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }
    .status-pending {
        background: #fffbeb;
        color: #b45309;
        border: 1.5px solid #fde68a;
    }
    .status-processing {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1.5px solid #bfdbfe;
    }
    .status-courier {
        background: #f5f3ff;
        color: #6d28d9;
        border: 1.5px solid #ddd6fe;
    }
    .status-delivered {
        background: #ecfdf5;
        color: #047857;
        border: 1.5px solid #a7f3d0;
    }
    .status-cancel {
        background: #fef2f2;
        color: #b91c1c;
        border: 1.5px solid #fecaca;
    }

    /* Stepper Timeline */
    .tea-timeline-section {
        padding: 32px 28px 24px;
        background: #ffffff;
        border-bottom: 1px solid #f1ede6;
    }
    .tea-timeline-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #9ca3af;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-timeline-title i {
        color: #245a2d;
    }
    .tea-stepper {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        position: relative;
        margin: 0 10px;
    }
    .tea-stepper::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 30px;
        right: 30px;
        height: 3px;
        background: #e5e7eb;
        z-index: 1;
    }
    .tea-stepper-progress {
        position: absolute;
        top: 20px;
        left: 30px;
        height: 3px;
        background: linear-gradient(90deg, #173f2c, #245a2d);
        z-index: 2;
        transition: width 0.5s ease;
    }
    .tea-step-item {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 100px;
    }
    .tea-step-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        color: #9ca3af;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    .tea-step-item.completed .tea-step-circle {
        background: #173f2c;
        border-color: #173f2c;
        color: #ffffff;
    }
    .tea-step-item.active .tea-step-circle {
        background: #245a2d;
        border-color: #cdb06a;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(205, 176, 106, 0.25);
        animation: teaPulse 2s infinite;
    }
    @keyframes teaPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }
    .tea-step-label {
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        line-height: 1.35;
    }
    .tea-step-item.completed .tea-step-label,
    .tea-step-item.active .tea-step-label {
        color: #0a211b;
        font-weight: 700;
    }
    .tea-step-sub {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 2px;
    }

    /* Cancel banner */
    .tea-cancel-notice {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 16px 20px;
        margin: 20px 28px 0;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #991b1b;
        font-size: 14px;
        font-weight: 500;
    }
    .tea-cancel-notice i {
        font-size: 20px;
        color: #dc2626;
        flex-shrink: 0;
    }

    /* Middle Grid (Address & Summary) */
    .tea-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-bottom: 1px solid #f1ede6;
    }
    .tea-shipping-box {
        padding: 24px 28px;
        border-right: 1px solid #f1ede6;
        background: #fafbf9;
    }
    .tea-box-title {
        font-size: 13.5px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #173f2c;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-box-title i {
        color: #cdb06a;
    }
    .tea-info-row {
        font-size: 13.5px;
        color: #4b5563;
        margin-bottom: 8px;
        line-height: 1.5;
    }
    .tea-info-row strong {
        color: #111827;
        font-weight: 600;
    }

    /* Payment & Summary Box */
    .tea-summary-box {
        padding: 24px 28px;
        background: #ffffff;
    }
    .tea-pricing-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13.5px;
        color: #4b5563;
        margin-bottom: 8px;
    }
    .tea-pricing-row.total-row {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px dashed #e8e4dc;
        font-size: 16px;
        font-weight: 700;
        color: #0a211b;
    }
    .tea-total-amount {
        color: #245a2d;
        font-size: 19px;
        font-family: 'Playfair Display', serif;
    }

    /* Items Table Section */
    .tea-items-section {
        padding: 24px 28px 10px;
    }
    .tea-items-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .tea-items-table th {
        font-size: 12.5px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #6b7280;
        font-weight: 600;
        padding: 10px 12px;
        background: #f8faf7;
        border-bottom: 1px solid #e8e4dc;
    }
    .tea-items-table th:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    .tea-items-table th:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        text-align: right;
    }
    .tea-items-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #f1ede6;
        font-size: 14px;
        color: #1f2937;
        vertical-align: middle;
    }
    .tea-items-table tr:last-child td {
        border-bottom: none;
    }
    .tea-product-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .tea-prod-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e8e4dc;
        background: #fbfbfb;
        flex-shrink: 0;
    }
    .tea-prod-thumb-fallback {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: #f4f8f2;
        border: 1px solid #c9dec4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #245a2d;
        font-size: 18px;
        flex-shrink: 0;
    }
    .tea-prod-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .tea-prod-name {
        font-weight: 600;
        color: #0a211b;
        line-height: 1.35;
    }
    .tea-prod-spec {
        font-size: 12px;
        color: #6b7280;
    }

    /* Card Footer Actions */
    .tea-card-footer {
        padding: 18px 28px;
        background: #fafbf9;
        border-top: 1px solid #f1ede6;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tea-card-footer-left {
        font-size: 13.5px;
        color: #4b5563;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tea-whatsapp-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #25d366;
        color: #ffffff;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .tea-whatsapp-btn:hover {
        background: #1ebe5d;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .tea-track-result-page {
            padding: 24px 12px 60px;
        }
        .tea-order-header {
            padding: 20px 18px;
            flex-direction: column;
            align-items: flex-start;
        }
        .tea-details-grid {
            grid-template-columns: 1fr;
        }
        .tea-shipping-box {
            border-right: none;
            border-bottom: 1px solid #f1ede6;
            padding: 18px;
        }
        .tea-summary-box {
            padding: 18px;
        }
        .tea-timeline-section {
            padding: 24px 14px 20px;
        }
        .tea-items-section {
            padding: 18px 14px 10px;
        }
        .tea-card-footer {
            padding: 16px 18px;
            flex-direction: column;
            align-items: stretch;
            text-align: center;
        }
        .tea-card-footer-left {
            justify-content: center;
        }
        .tea-whatsapp-btn {
            justify-content: center;
        }
        .tea-stepper {
            margin: 0;
        }
        .tea-step-item {
            width: 75px;
        }
        .tea-step-circle {
            width: 36px;
            height: 36px;
            font-size: 13px;
        }
        .tea-step-label {
            font-size: 11.5px;
        }
        .tea-step-sub {
            display: none;
        }
    }
</style>

<div class="tea-track-result-page">
    <div class="tea-result-container">
        <!-- Action Bar -->
        <div class="tea-result-topbar">
            <a href="{{ route('customer.order_track') }}" class="tea-btn-back-track">
                <i class="fa-solid fa-arrow-left"></i>
                <span>অন্য অর্ডার ট্র্যাক করুন</span>
            </a>
            <span class="tea-result-count-badge">
                <i class="fa-solid fa-box-open"></i> মোট {{ $order->count() }}টি অর্ডার পাওয়া গেছে
            </span>
        </div>

        @php
            $contact = App\Models\Contact::first();
        @endphp

        <!-- Orders Loop -->
        @foreach($order as $key => $value)
            @php
                $statusObj = App\Models\Orderstatus::find($value->order_status);
                $statusId = $value->order_status;
                $statusName = $statusObj ? $statusObj->name : 'Pending';

                // Stepper calculation:
                // Step 1: Placed (Pending = 1)
                // Step 2: Processing (2, 3, 9, 10)
                // Step 3: In Courier (5, 11)
                // Step 4: Delivered (6, 12)
                // Cancelled / Return (4, 8, 14, 15, 16)
                $isCancelled = in_array($statusId, [4, 8, 14, 15, 16]);
                
                $stepNumber = 1;
                $progressWidth = '0%';
                if (in_array($statusId, [6, 12])) {
                    $stepNumber = 4;
                    $progressWidth = '100%';
                } elseif (in_array($statusId, [5, 11])) {
                    $stepNumber = 3;
                    $progressWidth = '66%';
                } elseif (in_array($statusId, [2, 3, 9, 10])) {
                    $stepNumber = 2;
                    $progressWidth = '33%';
                } elseif ($statusId == 1) {
                    $stepNumber = 1;
                    $progressWidth = '0%';
                }

                // Status badge class
                $badgeClass = 'status-pending';
                $badgeBengali = 'অর্ডার গৃহীত';
                if (in_array($statusId, [6, 12])) {
                    $badgeClass = 'status-delivered';
                    $badgeBengali = 'ডেলিভারি সম্পন্ন';
                } elseif (in_array($statusId, [5, 11])) {
                    $badgeClass = 'status-courier';
                    $badgeBengali = 'ডেলিভারির পথে';
                } elseif (in_array($statusId, [2, 3, 9, 10])) {
                    $badgeClass = 'status-processing';
                    $badgeBengali = 'প্রসেসিং চলছে';
                } elseif ($isCancelled) {
                    $badgeClass = 'status-cancel';
                    $badgeBengali = 'বাতিলকৃত / রিটার্ন';
                }
            @endphp

            <div class="tea-order-card">
                <div class="tea-card-top-strip"></div>

                <!-- Header -->
                <div class="tea-order-header">
                    <div class="tea-order-header-left">
                        <span class="tea-invoice-pill">
                            <i class="fa-solid fa-receipt"></i> ইনভয়েস #{{ $value->invoice_id }}
                        </span>
                        <div class="tea-order-meta-row">
                            <span>
                                <i class="fa-regular fa-calendar-check"></i>
                                {{ \Carbon\Carbon::parse($value->created_at)->format('d M, Y • h:i A') }}
                            </span>
                            <span class="tea-payment-badge">
                                <i class="fa-solid fa-wallet"></i> {{ $value->order_type ?? 'Cash On Delivery' }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <span class="tea-status-badge {{ $badgeClass }}">
                            <i class="fa-solid fa-circle-dot"></i> {{ $badgeBengali }} ({{ $statusName }})
                        </span>
                    </div>
                </div>

                <!-- Stepper Timeline -->
                @if(!$isCancelled)
                    <div class="tea-timeline-section">
                        <div class="tea-timeline-title">
                            <i class="fa-solid fa-route"></i> অর্ডারের সার্বিক অগ্রগতি
                        </div>
                        <div class="tea-stepper">
                            <div class="tea-stepper-progress" style="width: {{ $progressWidth }};"></div>

                            <!-- Step 1 -->
                            <div class="tea-step-item {{ $stepNumber >= 1 ? ($stepNumber == 1 ? 'active' : 'completed') : '' }}">
                                <div class="tea-step-circle">
                                    @if($stepNumber > 1)
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        <i class="fa-solid fa-file-invoice"></i>
                                    @endif
                                </div>
                                <span class="tea-step-label">অর্ডার নিশ্চিত</span>
                                <span class="tea-step-sub">Confirmed</span>
                            </div>

                            <!-- Step 2 -->
                            <div class="tea-step-item {{ $stepNumber >= 2 ? ($stepNumber == 2 ? 'active' : 'completed') : '' }}">
                                <div class="tea-step-circle">
                                    @if($stepNumber > 2)
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        <i class="fa-solid fa-box-archive"></i>
                                    @endif
                                </div>
                                <span class="tea-step-label">প্রসেসিং</span>
                                <span class="tea-step-sub">Packaging</span>
                            </div>

                            <!-- Step 3 -->
                            <div class="tea-step-item {{ $stepNumber >= 3 ? ($stepNumber == 3 ? 'active' : 'completed') : '' }}">
                                <div class="tea-step-circle">
                                    @if($stepNumber > 3)
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        <i class="fa-solid fa-truck-fast"></i>
                                    @endif
                                </div>
                                <span class="tea-step-label">কুরিয়ারে</span>
                                <span class="tea-step-sub">On The Way</span>
                            </div>

                            <!-- Step 4 -->
                            <div class="tea-step-item {{ $stepNumber >= 4 ? 'active' : '' }}">
                                <div class="tea-step-circle">
                                    <i class="fa-solid fa-house-chimney-user"></i>
                                </div>
                                <span class="tea-step-label">ডেলিভারি</span>
                                <span class="tea-step-sub">Delivered</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="tea-cancel-notice">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>
                            এই অর্ডারটি বাতিল বা ফেরত করা হয়েছে। বিস্তারিত জানতে অনুগ্রহ করে আমাদের হটলাইনে যোগাযোগ করুন।
                        </div>
                    </div>
                @endif

                <!-- Shipping & Pricing Grid -->
                <div class="tea-details-grid">
                    <!-- Shipping Info -->
                    <div class="tea-shipping-box">
                        <div class="tea-box-title">
                            <i class="fa-solid fa-location-dot"></i> ডেলিভারি ঠিকানা
                        </div>
                        <div class="tea-info-row">
                            <strong>প্রাপক:</strong> {{ $value->shipping_name ?? 'কাস্টমার' }}
                        </div>
                        <div class="tea-info-row">
                            <strong>ফোন:</strong> {{ $value->shipping_phone ?? 'N/A' }}
                        </div>
                        <div class="tea-info-row">
                            <strong>ঠিকানা:</strong> {{ $value->shipping_address ?? 'N/A' }}
                        </div>
                        @if(!empty($value->shipping_area))
                            <div class="tea-info-row">
                                <strong>এরিয়া:</strong> {{ $value->shipping_area }}
                            </div>
                        @endif
                    </div>

                    <!-- Payment & Financial Summary -->
                    @php
                        $subtotal = $value->amount - $value->shipping_charge + $value->discount;
                    @endphp
                    <div class="tea-summary-box">
                        <div class="tea-box-title">
                            <i class="fa-solid fa-file-invoice-dollar"></i> পেমেন্ট সারাংশ
                        </div>
                        <div class="tea-pricing-row">
                            <span>পণ্যগুলোর মোট মূল্য:</span>
                            <strong>৳{{ number_format($subtotal) }}</strong>
                        </div>
                        <div class="tea-pricing-row">
                            <span>ডেলিভারি চার্জ:</span>
                            <strong>৳{{ number_format($value->shipping_charge) }}</strong>
                        </div>
                        @if($value->discount > 0)
                            <div class="tea-pricing-row" style="color: #047857;">
                                <span>ডিসকাউন্ট:</span>
                                <strong>-৳{{ number_format($value->discount) }}</strong>
                            </div>
                        @endif
                        <div class="tea-pricing-row total-row">
                            <span>সর্বমোট পরিশোধযোগ্য:</span>
                            <span class="tea-total-amount">৳{{ number_format($value->amount) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Ordered Items Table -->
                @php
                    $orderdetails = App\Models\OrderDetails::where('order_id', $value->id)->get();
                @endphp
                <div class="tea-items-section">
                    <div class="tea-box-title">
                        <i class="fa-solid fa-leaf"></i> অর্ডারকৃত পণ্যসমূহ ({{ $orderdetails->count() }})
                    </div>
                    <div class="table-responsive">
                        <table class="tea-items-table">
                            <thead>
                                <tr>
                                    <th>পণ্য</th>
                                    <th style="text-align: center;">পরিমাণ</th>
                                    <th style="text-align: right;">একক মূল্য</th>
                                    <th style="text-align: right;">মোট মূল্য</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderdetails as $product)
                                    @php
                                        $prodModel = App\Models\Product::with('image')->find($product->product_id);
                                        $imageSrc = $prodModel && $prodModel->image ? asset($prodModel->image->image) : null;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="tea-product-cell">
                                                @if($imageSrc)
                                                    <img src="{{ $imageSrc }}" alt="{{ $product->product_name }}" class="tea-prod-thumb">
                                                @else
                                                    <div class="tea-prod-thumb-fallback">
                                                        <i class="fa-solid fa-leaf"></i>
                                                    </div>
                                                @endif
                                                <div class="tea-prod-details">
                                                    <span class="tea-prod-name">{{ $product->product_name }}</span>
                                                    @if(!empty($product->product_size))
                                                        <span class="tea-prod-spec"><i class="fa-solid fa-weight-scale"></i> {{ $product->product_size }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center; font-weight: 600;">
                                            {{ $product->qty }}টি
                                        </td>
                                        <td style="text-align: right; color: #4b5563;">
                                            ৳{{ number_format($product->sale_price) }}
                                        </td>
                                        <td style="text-align: right; font-weight: 700; color: #173f2c;">
                                            ৳{{ number_format($product->sale_price * $product->qty) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Footer Support Action -->
                <div class="tea-card-footer">
                    <div class="tea-card-footer-left">
                        <i class="fa-solid fa-headset text-muted"></i>
                        <span>অর্ডার সংক্রান্ত যেকোনো সহায়তায় আমাদের সাথে যোগাযোগ করুন</span>
                    </div>
                    <div>
                        <a href="https://wa.me/+88{{ $contact->phone ?? '01850945080' }}?text=Hello,%20I%20want%20to%20know%20about%20my%20order%20%23{{ $value->invoice_id }}" 
                           target="_blank" 
                           class="tea-whatsapp-btn">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>হোয়াটসঅ্যাপে সহায়তা নিন</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection