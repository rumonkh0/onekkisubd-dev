@extends('backEnd.layouts.master')
@section('title', 'Order Invoice #' . $order->invoice_id)
@section('content')
<style>
    .customer-invoice {
        margin: 25px 0;
    }
    .invoice_btn {
        margin-bottom: 15px;
    }
    .invoice-card {
        width: 800px;
        max-width: 100%;
        margin: 0 auto;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .invoice-header-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 24px;
        margin-bottom: 24px;
    }
    .invoice-badge-title {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        text-transform: uppercase;
        margin: 0;
    }
    .invoice-meta-item {
        font-size: 13.5px;
        color: #475569;
        margin-bottom: 4px;
    }
    .invoice-meta-item strong {
        color: #0f172a;
    }
    .invoice-address-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }
    .invoice-address-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px;
    }
    .invoice-address-box h6 {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.04em;
        margin-bottom: 10px;
    }
    .invoice-table {
        width: 100%;
        margin-bottom: 24px;
        border-collapse: collapse;
    }
    .invoice-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 12px 14px;
        border-bottom: 1px solid #e2e8f0;
    }
    .invoice-table td {
        padding: 12px 14px;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }
    .invoice-summary-table {
        width: 320px;
        margin-left: auto;
        border-collapse: collapse;
    }
    .invoice-summary-table td {
        padding: 8px 12px;
        font-size: 13.5px;
    }
    .invoice-summary-table .final-total {
        background: #4f46e5;
        color: #ffffff;
        font-weight: 700;
        font-size: 15px;
        border-radius: 6px;
    }
    .invoice-footer {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        text-align: center;
        color: #94a3b8;
        font-size: 12px;
    }

    @media print {
        @page {
            margin: 15mm;
        }
        body {
            background: #ffffff !important;
        }
        header, footer, .no-print, .left-side-menu, .navbar-custom, .page-title-box {
            display: none !important;
        }
        .content-page {
            margin: 0 !important;
            padding: 0 !important;
        }
        .invoice-card {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            width: 100% !important;
        }
    }
</style>

<section class="customer-invoice">
    <div class="container">
        <!-- Action Toolbar -->
        <div class="row mb-3 no-print">
            <div class="col-sm-6 d-flex align-items-center">
                <a href="{{ route('admin.orders', ['slug' => 'all']) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fe-arrow-left me-1"></i> Back to Orders
                </a>
                <a href="{{ route('admin.order.process', ['invoice_id' => $order->invoice_id]) }}" class="btn btn-outline-primary btn-sm ms-2">
                    <i class="fe-settings me-1"></i> Process Order
                </a>
            </div>
            <div class="col-sm-6 text-end">
                <button onclick="printFunction()" class="btn btn-primary btn-sm">
                    <i class="fe-printer me-1"></i> Print Invoice
                </button>
            </div>
        </div>

        <!-- Invoice Document -->
        <div class="invoice-card">
            <!-- Header -->
            <div class="invoice-header-row">
                <div>
                    <img src="{{ asset($generalsetting->dark_logo ?? $generalsetting->white_logo) }}"
                         alt="{{ $generalsetting->name }}" style="max-height: 50px; max-width: 200px;"
                         onerror="this.style.display='none'">
                    <h5 class="mt-2 mb-0 fw-bold">{{ $generalsetting->name }}</h5>
                    <p class="text-muted mb-0 font-12">{{ $contact->phone ?? '' }} | {{ $contact->email ?? '' }}</p>
                </div>
                <div class="text-end">
                    <h2 class="invoice-badge-title">INVOICE</h2>
                    <div class="invoice-meta-item mt-2">
                        Invoice ID: <strong>#{{ $order->invoice_id }}</strong>
                    </div>
                    <div class="invoice-meta-item">
                        Date: <strong>{{ $order->created_at ? $order->created_at->format('d M, Y') : '' }}</strong>
                    </div>
                    <div class="invoice-meta-item">
                        Payment: <strong class="text-uppercase">{{ $order->payment ? $order->payment->payment_method : 'COD' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Address Grid -->
            <div class="invoice-address-grid">
                <div class="invoice-address-box">
                    <h6>Billed & Shipped From</h6>
                    <strong>{{ $generalsetting->name }}</strong>
                    <div class="font-13 text-muted mt-1">{{ $contact->address ?? '' }}</div>
                    <div class="font-13 text-muted">Phone: {{ $contact->phone ?? '' }}</div>
                    <div class="font-13 text-muted">Email: {{ $contact->email ?? '' }}</div>
                </div>

                <div class="invoice-address-box">
                    <h6>Customer / Delivery To</h6>
                    <strong>{{ $order->shipping ? $order->shipping->name : 'Valued Customer' }}</strong>
                    <div class="font-13 text-muted mt-1">{{ $order->shipping ? $order->shipping->address : '' }}</div>
                    @if($order->shipping && $order->shipping->area)
                        <div class="font-13 text-muted">Area: {{ $order->shipping->area }}</div>
                    @endif
                    <div class="font-13 text-muted">Phone: {{ $order->shipping ? $order->shipping->phone : 'N/A' }}</div>
                </div>
            </div>

            <!-- Items Table -->
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Item & Description</th>
                        <th class="text-center" style="width: 90px;">Price</th>
                        <th class="text-center" style="width: 60px;">Qty</th>
                        <th class="text-end" style="width: 100px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotalCalc = 0; @endphp
                    @foreach($order->orderdetails as $key => $value)
                        @php
                            $lineTotal = $value->sale_price * $value->qty;
                            $subtotalCalc += $lineTotal;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $value->product_name }}</strong>
                                @if($value->product_size || $value->product_color)
                                    <div class="text-muted font-12">
                                        @if($value->product_size) Size: {{ $value->product_size }} @endif
                                        @if($value->product_color) | Color: {{ $value->product_color }} @endif
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">৳{{ number_format($value->sale_price, 0) }}</td>
                            <td class="text-center">{{ $value->qty }}</td>
                            <td class="text-end fw-bold">৳{{ number_format($lineTotal, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals Summary -->
            <div class="d-flex justify-content-end">
                <table class="invoice-summary-table">
                    <tbody>
                        <tr>
                            <td class="text-muted">SubTotal:</td>
                            <td class="text-end fw-bold">৳{{ number_format($subtotalCalc, 0) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Shipping Charge (+):</td>
                            <td class="text-end fw-bold">৳{{ number_format($order->shipping_charge ?? 0, 0) }}</td>
                        </tr>
                        @if($order->discount && $order->discount > 0)
                            <tr>
                                <td class="text-muted">Discount (-):</td>
                                <td class="text-end text-success fw-bold">৳{{ number_format($order->discount, 0) }}</td>
                            </tr>
                        @endif
                        <tr class="final-total">
                            <td>Grand Total:</td>
                            <td class="text-end">৳{{ number_format($order->amount, 0) }}</td>
                        </tr>
                        @if($order->paid_partial_payment_amount && $order->paid_partial_payment_amount > 0)
                            <tr>
                                <td class="text-muted pt-2">Paid Partial:</td>
                                <td class="text-end text-success fw-bold pt-2">৳{{ number_format($order->paid_partial_payment_amount, 0) }}</td>
                            </tr>
                            <tr>
                                <td class="text-danger fw-bold">Due Balance:</td>
                                <td class="text-end text-danger fw-bold">৳{{ number_format($order->amount - $order->paid_partial_payment_amount, 0) }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Footer note -->
            <div class="invoice-footer">
                <p class="mb-1">Thank you for your business!</p>
                <small>* This is a computer-generated invoice and requires no physical signature.</small>
            </div>
        </div>
    </div>
</section>

<script>
    function printFunction() {
        window.print();
    }
</script>
@endsection
