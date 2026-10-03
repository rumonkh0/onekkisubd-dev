@extends('frontEnd.layouts.master')
@section('title', 'ইনভয়েস #' . $order->invoice_id . ' | Invoice')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CUSTOMER INVOICE STYLES
       ======================================================== */
    .tea-invoice-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.05) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-invoice-container {
        max-width: 860px;
        margin: 0 auto;
    }

    /* Top Action Bar */
    .tea-invoice-actions-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .tea-btn-back-orders {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        background: #ffffff;
        border: 1px solid #e8e4dc;
        border-radius: 30px;
        color: #173f2c;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(10, 33, 27, 0.03);
    }
    .tea-btn-back-orders:hover {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
        transform: translateX(-2px);
    }
    .tea-btn-print {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 22px;
        background: linear-gradient(135deg, #173f2c 0%, #245a2d 100%);
        color: #ffffff;
        border: none;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(23, 63, 44, 0.22);
    }
    .tea-btn-print:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        color: #ffffff;
        transform: translateY(-2px);
    }

    /* Invoice Paper Card */
    .tea-invoice-paper {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 44px -10px rgba(10, 33, 27, 0.08);
        padding: 44px;
        position: relative;
    }
    .tea-invoice-top-bar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }

    /* Header */
    .tea-invoice-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding-bottom: 28px;
        border-bottom: 1.5px solid #f1ede6;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 20px;
    }
    .tea-invoice-logo {
        height: 52px;
        width: auto;
        object-fit: contain;
        margin-bottom: 10px;
        display: block;
    }
    .tea-invoice-brand-name {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 2px;
    }
    .tea-invoice-brand-slogan {
        font-size: 12.5px;
        color: #cdb06a;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .tea-invoice-doc-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        font-weight: 800;
        color: #173f2c;
        margin: 0 0 6px;
        text-align: right;
        letter-spacing: 1px;
    }
    .tea-invoice-meta {
        text-align: right;
        font-size: 13.5px;
        color: #4b5563;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .tea-invoice-meta strong {
        color: #111827;
    }

    /* Parties Section (From & To) */
    .tea-parties-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
        padding: 20px;
        background: #fafbf9;
        border-radius: 14px;
        border: 1px solid #f1ede6;
    }
    .tea-party-col-title {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #173f2c;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .tea-party-col-title i {
        color: #cdb06a;
    }
    .tea-party-info {
        font-size: 13.5px;
        color: #4b5563;
        line-height: 1.6;
    }
    .tea-party-info strong {
        color: #0a211b;
        font-size: 14.5px;
        display: block;
        margin-bottom: 2px;
    }

    /* Table */
    .tea-invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 28px;
    }
    .tea-invoice-table th {
        background: #173f2c;
        color: #ffffff;
        font-size: 13px;
        font-weight: 600;
        padding: 12px 16px;
        letter-spacing: 0.5px;
    }
    .tea-invoice-table th:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    .tea-invoice-table th:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        text-align: right;
    }
    .tea-invoice-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1ede6;
        font-size: 14px;
        color: #1f2937;
        vertical-align: middle;
    }
    .tea-invoice-table tr:last-child td {
        border-bottom: 2px solid #e8e4dc;
    }

    /* Financials */
    .tea-invoice-bottom-grid {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
    }
    .tea-payment-note-box {
        max-width: 380px;
        font-size: 13px;
        color: #6b7280;
        line-height: 1.6;
        padding: 14px 18px;
        background: #fbfbf9;
        border-left: 3px solid #cdb06a;
        border-radius: 0 10px 10px 0;
    }
    .tea-payment-note-box strong {
        color: #173f2c;
        display: block;
        margin-bottom: 4px;
    }

    .tea-totals-box {
        width: 280px;
    }
    .tea-totals-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 14px;
        color: #4b5563;
        margin-bottom: 8px;
    }
    .tea-totals-row.grand-total {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 2px dashed #cdb06a;
        font-size: 16px;
        font-weight: 700;
        color: #0a211b;
    }
    .tea-total-sum {
        color: #173f2c;
        font-size: 20px;
        font-family: 'Playfair Display', serif;
    }

    /* Print styling */
    @page { 
        size: a4; 
        margin: 10mm; 
    }
    @media print {
        header, footer, #claude-header, #claude-header-spacer, .tea-invoice-actions-top, .no-print {
            display: none !important;
        }
        body, html, .tea-invoice-page {
            background: #ffffff !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .tea-invoice-paper {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
        }
        .tea-invoice-top-bar {
            display: none !important;
        }
    }

    @media (max-width: 768px) {
        .tea-invoice-page {
            padding: 20px 12px 60px;
        }
        .tea-invoice-paper {
            padding: 24px 18px;
        }
        .tea-invoice-doc-title, .tea-invoice-meta {
            text-align: left;
        }
        .tea-parties-grid {
            grid-template-columns: 1fr;
            padding: 16px;
        }
        .tea-totals-box {
            width: 100%;
        }
    }
</style>

<div class="tea-invoice-page">
    <div class="tea-invoice-container">
        <!-- Top Action Bar -->
        <div class="tea-invoice-actions-top no-print">
            <a href="{{ route('customer.orders') }}" class="tea-btn-back-orders">
                <i class="fa-solid fa-arrow-left"></i>
                <span>অর্ডার তালিকায় ফিরুন</span>
            </a>
            <button onclick="window.print()" class="tea-btn-print">
                <i class="fa-solid fa-print"></i>
                <span>প্রিন্ট / ডাউনলোড ইনভয়েস</span>
            </button>
        </div>

        @php
            $subtotal = $order->orderdetails->sum(function($item) {
                return $item->sale_price * $item->qty;
            });
        @endphp

        <!-- Printable Invoice Card -->
        <div class="tea-invoice-paper">
            <div class="tea-invoice-top-bar"></div>

            <!-- Header -->
            <div class="tea-invoice-header">
                <div>
                    @if(!empty($generalsetting->dark_logo))
                        <img src="{{ asset($generalsetting->dark_logo) }}" alt="{{ $generalsetting->name }}" class="tea-invoice-logo">
                    @elseif(!empty($generalsetting->white_logo))
                        <img src="{{ asset($generalsetting->white_logo) }}" alt="{{ $generalsetting->name }}" class="tea-invoice-logo" style="background:#0a211b; padding:4px 8px; border-radius:6px;">
                    @else
                        <h2 class="tea-invoice-brand-name">{{ $generalsetting->name ?? 'OnekkisuBD' }}</h2>
                    @endif
                    <div class="tea-invoice-brand-slogan">প্রিমিয়াম টি কালেকশন • এক কাপ খাঁটি চা</div>
                </div>

                <div>
                    <h1 class="tea-invoice-doc-title">INVOICE</h1>
                    <div class="tea-invoice-meta">
                        <div>ইনভয়েস নম্বর: <strong>#{{ $order->invoice_id }}</strong></div>
                        <div>তারিখ: <strong>{{ $order->created_at->format('d F, Y') }}</strong></div>
                        <div>পেমেন্ট মেথড: <strong style="text-transform: uppercase;">{{ $order->payment ? $order->payment->payment_method : ($order->order_type ?? 'Cash On Delivery') }}</strong></div>
                    </div>
                </div>
            </div>

            <!-- Parties Grid -->
            <div class="tea-parties-grid">
                <div>
                    <div class="tea-party-col-title">
                        <i class="fa-solid fa-building"></i> প্রেরক (Invoice From)
                    </div>
                    <div class="tea-party-info">
                        <strong>{{ $generalsetting->name }}</strong>
                        <div>হটলাইন: {{ $contact->phone ?? '' }}</div>
                        <div>ইমেইল: {{ $contact->email ?? '' }}</div>
                        <div>ঠিকানা: {{ $contact->address ?? '' }}</div>
                    </div>
                </div>

                <div>
                    <div class="tea-party-col-title">
                        <i class="fa-solid fa-user-check"></i> প্রাপক (Invoice To / Shipping)
                    </div>
                    <div class="tea-party-info">
                        <strong>{{ $order->shipping ? $order->shipping->name : (Auth::guard('customer')->user()->name ?? 'সম্মানিত কাস্টমার') }}</strong>
                        <div>ফোন: {{ $order->shipping ? $order->shipping->phone : (Auth::guard('customer')->user()->phone ?? 'N/A') }}</div>
                        <div>ঠিকানা: {{ $order->shipping ? $order->shipping->address : 'N/A' }}</div>
                        @if($order->shipping && !empty($order->shipping->area))
                            <div>এরিয়া: {{ $order->shipping->area }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive">
                <table class="tea-invoice-table">
                    <thead>
                        <tr>
                            <th style="width: 8%;">ক্র.নং</th>
                            <th style="width: 50%;">পণ্য বিবরণ</th>
                            <th style="width: 14%; text-align: right;">একক মূল্য</th>
                            <th style="width: 12%; text-align: center;">পরিমাণ</th>
                            <th style="width: 16%; text-align: right;">মোট মূল্য</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderdetails as $key => $value)
                            <tr>
                                <td style="color: #6b7280; font-weight: 500;">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    <strong style="color: #0a211b;">{{ $value->product_name }}</strong>
                                    @if(!empty($value->product_size))
                                        <div style="font-size: 12px; color: #6b7280; margin-top: 2px;">
                                            ওজন / সাইজ: {{ $value->product_size }}
                                        </div>
                                    @endif
                                </td>
                                <td style="text-align: right; color: #4b5563;">
                                    ৳{{ number_format($value->sale_price) }}
                                </td>
                                <td style="text-align: center; font-weight: 600;">
                                    {{ $value->qty }}টি
                                </td>
                                <td style="text-align: right; font-weight: 700; color: #173f2c;">
                                    ৳{{ number_format($value->sale_price * $value->qty) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Financials Bottom -->
            <div class="tea-invoice-bottom-grid">
                <div class="tea-payment-note-box">
                    <strong>গুরুত্বপূর্ণ তথ্য:</strong>
                    পণ্য রিসিভ করার সময় চেক করে রিসিভ করুন। যেকোনো সমস্যায় ডেলিভারির ২৪ ঘণ্টার মধ্যে আমাদের হেল্পলাইনে অবহিত করুন। OnekkisuBD বেছে নেওয়ার জন্য ধন্যবাদ!
                </div>

                <div class="tea-totals-box">
                    <div class="tea-totals-row">
                        <span>সাবটোটাল (Subtotal):</span>
                        <strong>৳{{ number_format($subtotal) }}</strong>
                    </div>
                    <div class="tea-totals-row">
                        <span>ডেলিভারি চার্জ (+):</span>
                        <strong>৳{{ number_format($order->shipping_charge) }}</strong>
                    </div>
                    @if($order->discount > 0)
                        <div class="tea-totals-row" style="color: #047857;">
                            <span>ডিসকাউন্ট (-):</span>
                            <strong>৳{{ number_format($order->discount) }}</strong>
                        </div>
                    @endif
                    <div class="tea-totals-row grand-total">
                        <span>সর্বমোট (Grand Total):</span>
                        <span class="tea-total-sum">৳{{ number_format($order->amount) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
