@extends('frontEnd.layouts.master')
@section('title', 'Order Placed Successfully - ' . $order->invoice_id)

@push('css')
<style>
    :root {
        --tea-dark: #0a211b;
        --tea-green: #173f2c;
        --tea-light-green: #245a2d;
        --tea-accent: #2e7d32;
        --tea-gold: #cdb06a;
        --tea-light-gold: #e2cf9c;
        --tea-cream: #faf8f5;
        --tea-border: #e8e4dc;
        --font-serif: 'Playfair Display', 'Hind Siliguri', Georgia, serif;
        --font-sans: 'Poppins', 'Hind Siliguri', sans-serif;
    }

    .success-page-wrapper {
        background: #fbf9f5;
        padding: 40px 0 70px;
        min-height: 85vh;
        font-family: var(--font-sans);
        color: #1f2937;
    }

    /* Hero Banner Card */
    .tea-success-hero {
        background: linear-gradient(135deg, #0a211b 0%, #173f2c 60%, #245a2d 100%);
        border-radius: 24px;
        padding: 42px 30px;
        color: #ffffff;
        text-align: center;
        box-shadow: 0 16px 40px rgba(10, 33, 27, 0.22);
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }
    .tea-success-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(205, 176, 106, 0.25) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .tea-success-hero::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .tea-success-icon-wrap {
        width: 82px;
        height: 82px;
        margin: 0 auto 20px;
        background: rgba(226, 207, 156, 0.16);
        border: 2px solid rgba(226, 207, 156, 0.45);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 0 0 8px rgba(226, 207, 156, 0.08);
        animation: successPulse 2.4s ease-in-out infinite;
    }
    @keyframes successPulse {
        0%, 100% { box-shadow: 0 0 0 8px rgba(226, 207, 156, 0.08); }
        50% { box-shadow: 0 0 0 16px rgba(226, 207, 156, 0.18); }
    }
    .tea-success-icon-wrap i {
        font-size: 40px;
        color: var(--tea-light-gold);
    }

    .tea-success-title {
        font-family: var(--font-serif);
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #ffffff;
        letter-spacing: -0.3px;
    }
    .tea-success-subtitle {
        font-size: 15px;
        color: #d1fae5;
        max-width: 600px;
        margin: 0 auto 18px;
        line-height: 1.6;
    }

    .tea-hero-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(8px);
        padding: 7px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        color: #fef3c7;
        border: 1px solid rgba(254, 243, 199, 0.25);
    }

    /* Quick Metrics Ribbon */
    .tea-metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }
    .tea-metric-card {
        background: #ffffff;
        border: 1.5px solid var(--tea-border);
        border-radius: 16px;
        padding: 18px 16px;
        box-shadow: 0 4px 16px rgba(10, 33, 27, 0.04);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .tea-metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(10, 33, 27, 0.08);
    }
    .tea-metric-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f4f8f2;
        color: var(--tea-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .tea-metric-icon.gold {
        background: #fbf7ee;
        color: #b8963e;
    }
    .tea-metric-label {
        font-size: 11.5px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 600;
        letter-spacing: 0.4px;
        margin-bottom: 2px;
    }
    .tea-metric-val {
        font-size: 15px;
        font-weight: 700;
        color: var(--tea-dark);
        margin: 0;
        line-height: 1.2;
    }

    /* Content Cards */
    .tea-card {
        background: #ffffff;
        border: 1.5px solid var(--tea-border);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(10, 33, 27, 0.05);
        margin-bottom: 24px;
    }
    .tea-card-header {
        background: linear-gradient(to right, #faf8f5, #ffffff);
        padding: 16px 22px;
        border-bottom: 1.5px solid var(--tea-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .tea-card-header h5 {
        margin: 0;
        font-family: var(--font-serif);
        font-size: 17px;
        font-weight: 700;
        color: var(--tea-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-card-header h5 i {
        color: var(--tea-green);
        font-size: 16px;
    }
    .tea-card-body {
        padding: 22px;
    }

    /* Product Item Table */
    .tea-order-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .tea-order-table th {
        background: #f9fafb;
        color: #4b5563;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 14px;
        border-bottom: 1.5px solid #e5e7eb;
    }
    .tea-order-table td {
        padding: 16px 14px;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;
        font-size: 14px;
    }
    .tea-order-table tr:last-child td {
        border-bottom: 0;
    }

    .order-prod-thumb {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        background: #faf8f5;
        border: 1px solid #e5e7eb;
        flex-shrink: 0;
    }
    .order-prod-name {
        font-family: var(--font-serif);
        font-size: 14.5px;
        font-weight: 700;
        color: var(--tea-dark);
        text-decoration: none;
        display: block;
        line-height: 1.35;
        margin-bottom: 3px;
        transition: color 0.2s;
    }
    .order-prod-name:hover {
        color: var(--tea-green);
    }
    .order-variant-chip {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        background: #f4f8f2;
        color: #245a2d;
        padding: 2px 8px;
        border-radius: 6px;
        margin-right: 4px;
        margin-top: 2px;
    }
    .order-qty-pill {
        display: inline-block;
        background: #f3f4f6;
        color: #111827;
        font-size: 13px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 12px;
    }

    /* Price Summary Rows */
    .tea-price-table {
        width: 100%;
        margin-top: 14px;
    }
    .tea-price-table td {
        padding: 8px 14px;
        font-size: 14px;
        color: #4b5563;
    }
    .tea-price-table td.val {
        text-align: right;
        font-weight: 600;
        color: #111827;
    }
    .tea-price-table tr.grand-total-row td {
        background: #f4f8f2;
        border-top: 1.5px solid #c9dec4;
        padding: 14px;
        font-size: 16px;
        font-weight: 700;
        color: var(--tea-dark);
        border-radius: 10px;
    }
    .tea-price-table tr.grand-total-row td.val {
        font-size: 20px;
        color: var(--tea-green);
    }

    /* Shipping Card Detail List */
    .tea-detail-item {
        display: flex;
        gap: 12px;
        margin-bottom: 14px;
        align-items: flex-start;
    }
    .tea-detail-item:last-child {
        margin-bottom: 0;
    }
    .tea-detail-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f4f8f2;
        color: var(--tea-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .tea-detail-text h6 {
        margin: 0 0 2px 0;
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }
    .tea-detail-text p {
        margin: 0;
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        line-height: 1.4;
    }

    /* Action Buttons */
    .tea-action-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }
    .tea-btn-primary {
        background: linear-gradient(135deg, #173f2c 0%, #0a211b 100%);
        color: #ffffff !important;
        font-weight: 700;
        font-size: 15px;
        padding: 14px 22px;
        border-radius: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(10, 33, 27, 0.22);
        transition: transform 0.2s, box-shadow 0.2s;
        border: 0;
        cursor: pointer;
    }
    .tea-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(10, 33, 27, 0.3);
        color: #ffffff !important;
    }
    .tea-btn-secondary {
        background: #ffffff;
        color: var(--tea-dark) !important;
        font-weight: 600;
        font-size: 14px;
        padding: 12px 20px;
        border-radius: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 1.5px solid var(--tea-border);
        transition: background 0.2s, border-color 0.2s;
        cursor: pointer;
    }
    .tea-btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: var(--tea-green) !important;
    }

    /* Support Call Card */
    .tea-support-card {
        background: linear-gradient(135deg, #fbf7ee 0%, #faf8f5 100%);
        border: 1.5px dashed var(--tea-gold);
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 20px;
    }
    .tea-support-icon {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--tea-dark);
        color: var(--tea-light-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .tea-support-content h6 {
        margin: 0 0 2px;
        font-size: 14px;
        font-weight: 700;
        color: var(--tea-dark);
    }
    .tea-support-content p {
        margin: 0;
        font-size: 12.5px;
        color: #6b7280;
    }
    .tea-support-phone {
        font-weight: 700;
        color: var(--tea-green);
        text-decoration: none;
    }
    .tea-support-phone:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .tea-metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .success-page-wrapper {
            padding: 20px 0 50px;
        }
        .tea-success-hero {
            padding: 30px 18px;
            border-radius: 18px;
        }
        .tea-success-title {
            font-size: 22px;
        }
        .tea-metrics-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .tea-card-body {
            padding: 16px;
        }
        .order-prod-thumb {
            width: 48px;
            height: 48px;
        }
        .order-prod-name {
            font-size: 13.5px;
        }
    }

    /* Print View */
    @media print {
        header, footer, .tea-action-buttons, .tea-support-card, .site-header, .site-footer {
            display: none !important;
        }
        .success-page-wrapper {
            background: #ffffff !important;
            padding: 0 !important;
        }
        .tea-success-hero {
            background: none !important;
            color: #000000 !important;
            padding: 20px 0 !important;
            box-shadow: none !important;
            border-bottom: 2px solid #000 !important;
        }
        .tea-success-title, .tea-success-subtitle, .tea-hero-pill {
            color: #000000 !important;
        }
        .tea-card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@section('content')
@php
    $payments = App\Models\Payment::where('order_id', $order->id)->first();
    $contact = App\Models\Contact::first();
    $contact_phone = $contact && !empty($contact->phone) ? $contact->phone : '01850945080';
    $subtotal_amount = $order->amount - $order->shipping_charge + ($order->discount ?? 0);
@endphp

<div class="success-page-wrapper">
    <div class="container" style="max-width: 1120px;">

        <!-- Top Celebration Hero -->
        <div class="tea-success-hero">
            <div class="tea-success-icon-wrap">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="tea-success-title">ধন্যবাদ! আপনার অর্ডারটি নিশ্চিত করা হয়েছে</h1>
            <p class="tea-success-subtitle">
                আমাদের প্রতিনিধি শীঘ্রই আপনার সাথে ফোনে যোগাযোগ করে ডেলিভারির অগ্রগতি জানাবেন।
            </p>
            <div class="tea-hero-pill">
                <i class="fa-solid fa-bell"></i>
                <span>ইনভয়েস আইডি: <strong>#{{ $order->invoice_id }}</strong></span>
            </div>
        </div>

        <!-- Quick 4-Fact Metrics Grid -->
        <div class="tea-metrics-grid">
            <div class="tea-metric-card">
                <div class="tea-metric-icon">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <div class="tea-metric-label">ইনভয়েস আইডি</div>
                    <p class="tea-metric-val">#{{ $order->invoice_id }}</p>
                </div>
            </div>

            <div class="tea-metric-card">
                <div class="tea-metric-icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <div>
                    <div class="tea-metric-label">অর্ডারের তারিখ</div>
                    <p class="tea-metric-val">{{ $order->created_at->format('d M, Y') }}</p>
                </div>
            </div>

            <div class="tea-metric-card">
                <div class="tea-metric-icon gold">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <div class="tea-metric-label">পেমেন্ট মাধ্যম</div>
                    <p class="tea-metric-val">{{ $payments ? $payments->payment_method : 'Cash On Delivery' }}</p>
                </div>
            </div>

            <div class="tea-metric-card">
                <div class="tea-metric-icon gold">
                    <i class="fa-solid fa-coins"></i>
                </div>
                <div>
                    <div class="tea-metric-label">সর্বমোট প্রদেয়</div>
                    <p class="tea-metric-val" style="color: var(--tea-green);">৳ {{ number_format($order->amount) }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Ordered Items & Cost Summary -->
            <div class="col-lg-8 col-md-12">
                <!-- Products Card -->
                <div class="tea-card">
                    <div class="tea-card-header">
                        <h5>
                            <i class="fa-solid fa-bag-shopping"></i>
                            অর্ডারকৃত পণ্যসমূহ (Purchased Products)
                        </h5>
                        <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 12px;">
                            মোট {{ $order->orderdetails->count() }} টি আইটেম
                        </span>
                    </div>
                    <div class="tea-card-body p-0">
                        <div class="table-responsive">
                            <table class="tea-order-table">
                                <thead>
                                    <tr>
                                        <th style="width: 55%;">পণ্য (Product)</th>
                                        <th style="width: 20%; text-align: center;">পরিমাণ</th>
                                        <th style="width: 25%; text-align: right;">মূল্য (Price)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderdetails as $key => $value)
                                        @php
                                            $prod = App\Models\Product::find($value->product_id);
                                            $prod_image = $value->image ? $value->image->image : ($prod && $prod->image ? $prod->image->image : 'public/uploads/default.png');
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ asset($prod_image) }}" alt="{{ $value->product_name }}" class="order-prod-thumb" />
                                                    <div>
                                                        @if ($prod)
                                                            <a href="{{ route('product', $prod->slug) }}" class="order-prod-name">
                                                                {{ $value->product_name }}
                                                            </a>
                                                        @else
                                                            <span class="order-prod-name">{{ $value->product_name }}</span>
                                                        @endif

                                                        @if ($value->product_size)
                                                            <span class="order-variant-chip">সাইজ: {{ $value->product_size }}</span>
                                                        @endif
                                                        @if ($value->product_color)
                                                            <span class="order-variant-chip">রঙ: {{ $value->product_color }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="order-qty-pill">× {{ $value->qty }}</span>
                                            </td>
                                            <td style="text-align: right;">
                                                <strong style="color: var(--tea-dark);">৳ {{ number_format($value->sale_price * $value->qty) }}</strong>
                                                @if ($value->qty > 1)
                                                    <div style="font-size: 11.5px; color: #6b7280;">(৳ {{ number_format($value->sale_price) }} / পিস)</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Price Breakdown Card -->
                <div class="tea-card">
                    <div class="tea-card-header">
                        <h5>
                            <i class="fa-solid fa-calculator"></i>
                            মূল্য তালিকা (Cost Summary)
                        </h5>
                    </div>
                    <div class="tea-card-body pt-2 pb-3">
                        <table class="tea-price-table">
                            <tbody>
                                <tr>
                                    <td>সাবটোটাল (Subtotal)</td>
                                    <td class="val">৳ {{ number_format($subtotal_amount) }}</td>
                                </tr>
                                <tr>
                                    <td>ডেলিভারি চার্জ (Delivery Charge)</td>
                                    <td class="val">৳ {{ number_format($order->shipping_charge) }}</td>
                                </tr>
                                @if (!empty($order->discount) && $order->discount > 0)
                                    <tr>
                                        <td>ডিসকাউন্ট (Discount)</td>
                                        <td class="val" style="color: #16a34a;">-৳ {{ number_format($order->discount) }}</td>
                                    </tr>
                                @endif
                                <tr class="grand-total-row">
                                    <td>সর্বমোট প্রদেয় (Grand Total)</td>
                                    <td class="val">৳ {{ number_format($order->amount) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @if (!empty($order->note))
                    <!-- Order Note Card -->
                    <div class="tea-card">
                        <div class="tea-card-header">
                            <h5>
                                <i class="fa-solid fa-clipboard-list"></i>
                                ডেলিভারি নোট (Special Instructions)
                            </h5>
                        </div>
                        <div class="tea-card-body">
                            <p class="mb-0 text-muted fst-italic" style="font-size: 14px; line-height: 1.6;">
                                "{{ $order->note }}"
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Shipping Details, Help, & Action Buttons -->
            <div class="col-lg-4 col-md-12">
                <!-- Shipping Address Card -->
                <div class="tea-card">
                    <div class="tea-card-header">
                        <h5>
                            <i class="fa-solid fa-location-dot"></i>
                            ডেলিভারি ঠিকানা
                        </h5>
                    </div>
                    <div class="tea-card-body">
                        <div class="tea-detail-item">
                            <div class="tea-detail-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="tea-detail-text">
                                <h6>প্রাপক (Recipient)</h6>
                                <p>{{ $order->shipping ? $order->shipping->name : 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="tea-detail-item">
                            <div class="tea-detail-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="tea-detail-text">
                                <h6>ফোন নম্বর</h6>
                                <p>{{ $order->shipping ? $order->shipping->phone : 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="tea-detail-item">
                            <div class="tea-detail-icon">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <div class="tea-detail-text">
                                <h6>ঠিকানা</h6>
                                <p>{{ $order->shipping ? $order->shipping->address : 'N/A' }}</p>
                            </div>
                        </div>

                        @if ($order->shipping && !empty($order->shipping->area))
                            <div class="tea-detail-item">
                                <div class="tea-detail-icon">
                                    <i class="fa-solid fa-truck"></i>
                                </div>
                                <div class="tea-detail-text">
                                    <h6>ডেলিভারি এলাকা</h6>
                                    <p>{{ $order->shipping->area }}</p>
                                </div>
                            </div>
                        @endif

                        @php
                            $order_postal = !empty($order->postal_code) ? $order->postal_code : ($order->shipping ? $order->shipping->postal_code : '');
                        @endphp
                        @if (!empty($order_postal))
                            <div class="tea-detail-item">
                                <div class="tea-detail-icon">
                                    <i class="fa-solid fa-mail-bulk"></i>
                                </div>
                                <div class="tea-detail-text">
                                    <h6>পোস্টকোড</h6>
                                    <p>{{ $order_postal }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action CTA Buttons -->
                <div class="tea-action-buttons">
                    <a href="{{ route('home') }}" class="tea-btn-primary">
                        <i class="fa-solid fa-leaf"></i>
                        <span>আরও কেনাকাটা করুন (Shop More)</span>
                    </a>

                    <a href="{{ route('customer.order_track') }}" class="tea-btn-secondary">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>অর্ডার ট্র্যাক করুন (Track Order)</span>
                    </a>

                    <button type="button" onclick="window.print()" class="tea-btn-secondary">
                        <i class="fa-solid fa-print"></i>
                        <span>রসিদ প্রিন্ট করুন (Print Invoice)</span>
                    </button>
                </div>

                <!-- Support Call Card -->
                <div class="tea-support-card">
                    <div class="tea-support-icon">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div class="tea-support-content">
                        <h6>যেকোনো তথ্যের জন্য কল করুন</h6>
                        <p>
                            আমাদের হটলাইন:
                            <a href="tel:{{ $contact_phone }}" class="tea-support-phone">+88{{ $contact_phone }}</a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    @php
        $postal_code = '';
        if (!empty($order->postal_code)) {
            $postal_code = $order->postal_code;
        } elseif ($order->shipping && !empty($order->shipping->postal_code)) {
            $postal_code = $order->shipping->postal_code;
        } elseif ($order->shipping && !empty($order->shipping->address)) {
            if (preg_match('/\b[0-9]{4}\b/', $order->shipping->address, $matches)) {
                $postal_code = $matches[0];
            }
        }
    @endphp

    // Clear the previous ecommerce object.
    window.dataLayer = window.dataLayer || [];
    dataLayer.push({ ecommerce: null });

    // Push the purchase event to dataLayer with user data, IP, and user agent.
    dataLayer.push({
        event: "purchase",
        client_ip_address: "{{ request()->ip() }}",
        client_user_agent: navigator.userAgent,
        user_data: {
            phone_number: "{{ $order->shipping ? $order->shipping->phone : '' }}",
            address: {
                first_name: "{{ $order->shipping ? $order->shipping->name : '' }}",
                street: "{{ $order->shipping ? $order->shipping->address : '' }}",
                city: "{{ $order->city ?? '' }}",
                postal_code: "{{ $postal_code }}",
                country: "BD"
            }
        },
        ecommerce: {
            currency: "BDT",
            value: Number("<?php echo $order->amount ?>"),
            shipping: "<?php echo $order->shipping_charge ?>",
            tax: 0,
            coupon: "",
            affiliation: "",
            external_id: "<?php echo $order->id ?>",
            transaction_id: "<?php echo 'TRXLR' . $order->id ?>",
            items: [@foreach ($order->orderdetails as $cartInfo)
                {
                    item_name: "{{$cartInfo->product_name}}",
                    item_id: Number("{{$cartInfo->product_id}}"),
                    price: Number("{{$cartInfo->sale_price}}"),
                    item_size: "{{$cartInfo->product_size}}",
                    item_color: "{{$cartInfo->product_color}}",
                    currency: "BDT",
                    quantity: {{$cartInfo->qty ?? 0}}
                },
            @endforeach],
            more: [
                {
                    Customer_Name: "{{ $order->shipping ? $order->shipping->name : '' }}",
                    Customer_Address: "{{ $order->shipping ? $order->shipping->address : '' }}",
                    Customer_Phone_Number: "{{ $order->shipping ? $order->shipping->phone : '' }}",
                    Customer_Country: 'Bangladesh',
                    Customer_Postal_Code: "{{ $postal_code }}",
                    Customer_IP: "{{ request()->ip() }}",
                    Customer_User_Agent: navigator.userAgent,
                    Customer_Visitor_ID: "{{ $order->shipping ? $order->shipping->id : '' }}",
                    payment_method: "{{ $payments ? $payments->payment_method : '' }}",
                }
            ]
        }
    });
</script>
@endpush
