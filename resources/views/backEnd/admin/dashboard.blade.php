@extends('backEnd.layouts.master')
@section('title', 'Admin Dashboard')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
    <style>
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 22px;
        }
        .dashboard-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .filter-card {
            background: #ffffff;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .breakdown-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed var(--slate-200);
        }
        .breakdown-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .inventory-badge-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: var(--slate-50);
            border: 1px solid var(--slate-200);
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            margin: 4px;
            transition: all 0.15s ease;
        }
        .inventory-badge-chip:hover {
            border-color: var(--primary);
            background: var(--primary-soft);
            color: var(--primary);
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="dashboard-header mt-3">
        <div>
            <h4 class="page-title mb-1">Dashboard Overview</h4>
            <p class="text-muted mb-0" style="font-size: 13.5px;">
                Welcome back, <strong>{{ Auth::user()->name }}</strong>. Here is your store's latest activity and performance.
            </p>
        </div>
        <div class="dashboard-actions">
            <a href="{{ route('admin.orders', ['slug' => 'all']) }}" class="btn btn-primary btn-sm">
                <i class="fe-shopping-bag"></i> All Orders
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
                <i class="fe-plus-circle"></i> Add Product
            </a>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                <i class="fe-globe"></i> Visit Store
            </a>
        </div>
    </div>

    <!-- Accounts Date Filter Card -->
    <div class="filter-card">
        <form action="{{ route('deposit.filtering') }}" method="GET" class="row align-items-end g-2">
            <div class="col-md-4">
                <label class="form-label mb-1 text-muted fw-bold" style="font-size: 12px; text-transform: uppercase;">
                    <i class="fe-calendar me-1"></i> Start Date
                </label>
                <input type="date" value="{{ request()->get('start_date', now()->startOfMonth()->toDateString()) }}"
                    class="form-control" name="start_date">
            </div>
            <div class="col-md-4">
                <label class="form-label mb-1 text-muted fw-bold" style="font-size: 12px; text-transform: uppercase;">
                    <i class="fe-calendar me-1"></i> End Date
                </label>
                <input type="date" value="{{ request()->get('end_date', now()->endOfMonth()->toDateString()) }}"
                    class="form-control" name="end_date">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100" style="height: 38px;">
                    <i class="fe-filter me-1"></i> Filter Accounts
                </button>
            </div>
        </form>
    </div>

    <!-- Top KPI Stat Cards -->
    <div class="row">
        <!-- Account Balance -->
        <div class="col-md-6 col-xl-3">
            <div class="stat-widget">
                <div class="stat-widget-content">
                    <div class="stat-widget-label">Account Balance</div>
                    <div class="stat-widget-value text-primary">
                        ৳<span data-plugin="counterup">{{ number_format($account_balance, 0) }}</span>
                    </div>
                    <small class="text-muted" style="font-size: 11.5px;">Net available funds</small>
                </div>
                <div class="stat-widget-icon stat-icon-primary">
                    <i class="fe-credit-card"></i>
                </div>
            </div>
        </div>

        <!-- Total Inflow -->
        <div class="col-md-6 col-xl-3">
            <div class="stat-widget">
                <div class="stat-widget-content">
                    <div class="stat-widget-label">Total Deposits / Inflow</div>
                    <div class="stat-widget-value text-success">
                        ৳<span data-plugin="counterup">{{ number_format($total_payment, 0) }}</span>
                    </div>
                    <small class="text-muted" style="font-size: 11.5px;">Courier + Office receipts</small>
                </div>
                <div class="stat-widget-icon stat-icon-success">
                    <i class="fe-trending-up"></i>
                </div>
            </div>
        </div>

        <!-- Total Expenses -->
        <div class="col-md-6 col-xl-3">
            <div class="stat-widget">
                <div class="stat-widget-content">
                    <div class="stat-widget-label">Total Expenses</div>
                    <div class="stat-widget-value text-danger">
                        ৳<span data-plugin="counterup">{{ number_format($total_cost, 0) }}</span>
                    </div>
                    <small class="text-muted" style="font-size: 11.5px;">Boost, office & shipping</small>
                </div>
                <div class="stat-widget-icon stat-icon-danger">
                    <i class="fe-trending-down"></i>
                </div>
            </div>
        </div>

        <!-- Today & Total Orders -->
        <div class="col-md-6 col-xl-3">
            <div class="stat-widget">
                <div class="stat-widget-content">
                    <div class="stat-widget-label">Today's Orders</div>
                    <div class="stat-widget-value text-info">
                        <span data-plugin="counterup">{{ $today_order }}</span>
                        <span style="font-size: 14px; color: var(--slate-500); font-weight: normal;"> / {{ $total_order }} total</span>
                    </div>
                    <small class="text-muted" style="font-size: 11.5px;">{{ $total_delivery }} Delivered overall</small>
                </div>
                <div class="stat-widget-icon stat-icon-info">
                    <i class="fe-shopping-bag"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Fulfillment Pipeline -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="m-0"><i class="fe-truck text-primary"></i> Order Pipeline & Fulfillment Status</h3>
            <span class="badge bg-light text-dark">{{ $total_order }} Total Orders</span>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <!-- Pending -->
                <div class="col-6 col-md-4 col-xl">
                    <a href="{{ route('admin.orders', ['slug' => 'pending']) }}" class="pipeline-card">
                        <div class="pipeline-card-inner">
                            <span class="pipeline-card-title">
                                <i class="fe-clock text-warning"></i> Pending
                            </span>
                            <span class="pipeline-card-badge bg-warning bg-opacity-10 text-warning">
                                {{ $pending_order }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Processing -->
                <div class="col-6 col-md-4 col-xl">
                    <a href="{{ route('admin.orders', ['slug' => 'processing']) }}" class="pipeline-card">
                        <div class="pipeline-card-inner">
                            <span class="pipeline-card-title">
                                <i class="fe-loader text-info"></i> Processing
                            </span>
                            <span class="pipeline-card-badge bg-info bg-opacity-10 text-info">
                                {{ $confirm_order }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- In Courier -->
                <div class="col-6 col-md-4 col-xl">
                    <a href="{{ route('admin.orders', ['slug' => 'in-courier']) }}" class="pipeline-card">
                        <div class="pipeline-card-inner">
                            <span class="pipeline-card-title">
                                <i class="fe-truck text-purple"></i> In Courier
                            </span>
                            <span class="pipeline-card-badge bg-purple bg-opacity-10 text-purple" style="color: #8b5cf6;">
                                {{ $shipped_courier }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Delivery Done -->
                <div class="col-6 col-md-4 col-xl">
                    <a href="{{ route('admin.orders', ['slug' => 'completed']) }}" class="pipeline-card">
                        <div class="pipeline-card-inner">
                            <span class="pipeline-card-title">
                                <i class="fe-check-circle text-success"></i> Delivered
                            </span>
                            <span class="pipeline-card-badge bg-success bg-opacity-10 text-success">
                                {{ $delivery_done_order }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Pre-Order -->
                <div class="col-6 col-md-4 col-xl">
                    <a href="{{ route('admin.orders', ['slug' => 'on-the-way']) }}" class="pipeline-card">
                        <div class="pipeline-card-inner">
                            <span class="pipeline-card-title">
                                <i class="fe-calendar text-secondary"></i> Pre Order
                            </span>
                            <span class="pipeline-card-badge bg-secondary bg-opacity-10 text-secondary">
                                {{ $pre_order }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Return -->
                <div class="col-6 col-md-4 col-xl">
                    <a href="{{ route('admin.orders', ['slug' => 'return']) }}" class="pipeline-card">
                        <div class="pipeline-card-inner">
                            <span class="pipeline-card-title">
                                <i class="fe-rotate-ccw text-warning"></i> Return
                            </span>
                            <span class="pipeline-card-badge bg-warning bg-opacity-10 text-warning">
                                {{ $return_order }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Cancel -->
                <div class="col-6 col-md-4 col-xl">
                    <a href="{{ route('admin.orders', ['slug' => 'on-hold']) }}" class="pipeline-card">
                        <div class="pipeline-card-inner">
                            <span class="pipeline-card-title">
                                <i class="fe-x-circle text-danger"></i> Cancelled
                            </span>
                            <span class="pipeline-card-badge bg-danger bg-opacity-10 text-danger">
                                {{ $total_cancel_order }}
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Charts Row -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title m-0"><i class="fe-bar-chart-2 text-primary"></i> 30-Day Sales & Revenue Trend</h4>
                    <span class="text-muted font-12">Net revenue per day</span>
                </div>
                <div class="card-body">
                    <div id="sales-analytics" class="apex-charts" data-colors="#4f46e5,#10b981" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title m-0"><i class="fe-pie-chart text-success"></i> Delivery Performance</h4>
                </div>
                <div class="card-body">
                    <div id="total-revenue" class="apex-charts" data-colors="#10b981" style="min-height: 220px;"></div>
                    <div class="mt-3">
                        <div class="breakdown-row">
                            <span class="text-muted"><i class="fe-check text-success me-1"></i> Today's Deliveries:</span>
                            <strong>{{ $today_delivery }} orders</strong>
                        </div>
                        <div class="breakdown-row">
                            <span class="text-muted"><i class="fe-calendar text-info me-1"></i> Last Week:</span>
                            <strong>{{ $last_week }} orders</strong>
                        </div>
                        <div class="breakdown-row">
                            <span class="text-muted"><i class="fe-clock text-warning me-1"></i> Last Month:</span>
                            <strong>{{ $last_month }} orders</strong>
                        </div>
                        <div class="breakdown-row">
                            <span class="text-muted"><i class="fe-check-circle text-primary me-1"></i> Total Completed:</span>
                            <strong>{{ $total_delivery }} orders</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Breakdown Cards -->
    <div class="row">
        <!-- Deposits Breakdown -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title m-0">
                        <i class="fe-download text-success"></i> Deposits & Inflow Breakdown
                    </h4>
                    <span class="badge bg-success">৳{{ number_format($total_payment, 0) }} Total</span>
                </div>
                <div class="card-body">
                    <div class="breakdown-row">
                        <span class="text-muted"><i class="fe-truck text-primary me-1"></i> Courier Payment</span>
                        <strong class="text-dark">৳{{ number_format($courier_payment, 2) }}</strong>
                    </div>
                    <div class="breakdown-row">
                        <span class="text-muted"><i class="fe-home text-success me-1"></i> Office Sale Payment</span>
                        <strong class="text-dark">৳{{ number_format($officesale_payment, 2) }}</strong>
                    </div>
                    <div class="breakdown-row">
                        <span class="text-muted"><i class="fe-more-horizontal text-secondary me-1"></i> Other Deposits</span>
                        <strong class="text-dark">৳{{ number_format($expense_others, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="fw-bold">Total Inflow</span>
                        <span class="fw-bold text-success font-16">৳{{ number_format($total_payment, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Breakdown -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title m-0">
                        <i class="fe-upload text-danger"></i> Operating Expenses Breakdown
                    </h4>
                    <span class="badge bg-danger">৳{{ number_format($total_cost, 0) }} Total</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="breakdown-row">
                                <span class="text-muted"><i class="fe-zap text-warning me-1"></i> Facebook / Ads Boost</span>
                                <strong class="text-dark">৳{{ number_format($boost_cost, 2) }}</strong>
                            </div>
                            <div class="breakdown-row">
                                <span class="text-muted"><i class="fe-home text-info me-1"></i> Office Cost</span>
                                <strong class="text-dark">৳{{ number_format($office_cost, 2) }}</strong>
                            </div>
                            <div class="breakdown-row">
                                <span class="text-muted"><i class="fe-package text-secondary me-1"></i> Packaging Cost</span>
                                <strong class="text-dark">৳{{ number_format($packaging_cost, 2) }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="breakdown-row">
                                <span class="text-muted"><i class="fe-truck text-primary me-1"></i> Transport Cost</span>
                                <strong class="text-dark">৳{{ number_format($transport_cost, 2) }}</strong>
                            </div>
                            <div class="breakdown-row">
                                <span class="text-muted"><i class="fe-credit-card text-success me-1"></i> Bank Deposit</span>
                                <strong class="text-dark">৳{{ number_format($bank_deposit, 2) }}</strong>
                            </div>
                            <div class="breakdown-row">
                                <span class="text-muted"><i class="fe-more-horizontal text-muted me-1"></i> Others Cost</span>
                                <strong class="text-dark">৳{{ number_format($others_expense_cost, 2) }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="fw-bold">Total Outflow</span>
                        <span class="fw-bold text-danger font-16">৳{{ number_format($total_cost, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Stock by Category -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="header-title m-0">
                <i class="fe-database text-primary"></i> Inventory Stock by Category
            </h4>
            <span class="badge bg-primary">{{ $total_product }} Total Products</span>
        </div>
        <div class="card-body">
            <div class="d-flex flex-wrap">
                @foreach ($categories as $category)
                    <div class="inventory-badge-chip">
                        <span>{{ $category->name }}</span>
                        <span class="badge bg-primary rounded-pill">
                            {{ $category->homeproducts ? $category->homeproducts->sum('stock') : 0 }} pcs
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Orders & Recent Customers -->
    <div class="row">
        <!-- Latest 5 Orders -->
        <div class="col-xl-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title m-0"><i class="fe-shopping-bag text-primary"></i> Latest Orders</h4>
                    <a href="{{ route('admin.orders', ['slug' => 'all']) }}" class="btn btn-sm btn-outline-primary">
                        View All Orders <i class="fe-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latest_order as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('admin.order.invoice', ['invoice_id' => $order->invoice_id]) }}" class="fw-bold text-primary">
                                                #{{ $order->invoice_id }}
                                            </a>
                                            <div class="text-muted" style="font-size: 11px;">
                                                {{ $order->created_at ? $order->created_at->format('d M, h:i A') : '' }}
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $order->customer ? $order->customer->name : ($order->shipping ? $order->shipping->name : 'N/A') }}</strong>
                                            @if($order->customer && $order->customer->phone)
                                                <div class="text-muted" style="font-size: 11.5px;">{{ $order->customer->phone }}</div>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-dark">
                                            ৳{{ number_format($order->amount, 0) }}
                                        </td>
                                        <td>
                                            @php
                                                $statusName = $order->status ? $order->status->name : 'Status ' . $order->order_status;
                                                $statusClass = 'badge-status-pending';
                                                if (stripos($statusName, 'process') !== false || stripos($statusName, 'confirm') !== false) {
                                                    $statusClass = 'badge-status-processing';
                                                } elseif (stripos($statusName, 'courier') !== false || stripos($statusName, 'ship') !== false) {
                                                    $statusClass = 'badge-status-courier';
                                                } elseif (stripos($statusName, 'deliver') !== false || stripos($statusName, 'complete') !== false) {
                                                    $statusClass = 'badge-status-delivered';
                                                } elseif (stripos($statusName, 'cancel') !== false) {
                                                    $statusClass = 'badge-status-cancelled';
                                                } elseif (stripos($statusName, 'return') !== false) {
                                                    $statusClass = 'badge-status-returned';
                                                }
                                            @endphp
                                            <span class="badge-status {{ $statusClass }}">
                                                {{ $statusName }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="custom-btn-list justify-content-end">
                                                <a href="{{ route('admin.order.invoice', ['invoice_id' => $order->invoice_id]) }}" title="View Invoice">
                                                    <i class="fe-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.order.process', ['invoice_id' => $order->invoice_id]) }}" title="Process Order">
                                                    <i class="fe-settings"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No recent orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Customers -->
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="header-title m-0"><i class="fe-users text-info"></i> Latest Customers</h4>
                    <span class="badge bg-light text-dark">{{ $total_customer }} Registered</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latest_customer as $customer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fw-bold"
                                                     style="width: 32px; height: 32px; font-size: 13px;">
                                                    {{ strtoupper(substr($customer->name ?? 'C', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $customer->name ?? 'Customer' }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $customer->phone ?? 'N/A' }}</td>
                                        <td class="text-muted" style="font-size: 12px;">
                                            {{ $customer->created_at ? $customer->created_at->format('d M, Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No customers registered yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/selectize/js/standalone/selectize.min.js"></script>

    <script>
        $(document).ready(function() {
            // Delivery Radial Gauge
            var deliveryElement = document.querySelector("#total-revenue");
            if (deliveryElement) {
                var totalOrders = {{ $total_order > 0 ? $total_order : 1 }};
                var deliveredOrders = {{ $total_delivery }};
                var deliveryPercent = Math.min(100, Math.round((deliveredOrders / totalOrders) * 100));

                var radialOptions = {
                    chart: {
                        height: 220,
                        type: "radialBar"
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                size: "65%"
                            },
                            dataLabels: {
                                name: {
                                    fontSize: '14px',
                                    color: '#64748b',
                                    offsetY: -5
                                },
                                value: {
                                    fontSize: '22px',
                                    fontWeight: '700',
                                    color: '#0f172a',
                                    offsetY: 5,
                                    formatter: function (val) {
                                        return val + "%";
                                    }
                                }
                            }
                        }
                    },
                    colors: ["#10b981"],
                    series: [deliveryPercent],
                    labels: ["Delivered"]
                };
                var radialChart = new ApexCharts(deliveryElement, radialOptions);
                radialChart.render();
            }

            // Sales Analytics Chart
            var salesAnalyticsElement = document.querySelector("#sales-analytics");
            if (salesAnalyticsElement) {
                var saleAmounts = [
                    @foreach ($monthly_sale as $sale)
                        {{ $sale->amount }},
                    @endforeach
                ];

                var saleDates = [
                    @foreach ($monthly_sale as $sale)
                        "{{ date('d M', strtotime($sale->date)) }}",
                    @endforeach
                ];

                var lineOptions = {
                    series: [{
                        name: "Daily Revenue",
                        type: "area",
                        data: saleAmounts
                    }],
                    chart: {
                        height: 330,
                        type: "area",
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ["#4f46e5"],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: "smooth",
                        width: 2.5
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.35,
                            opacityTo: 0.05,
                            stops: [0, 95, 100]
                        }
                    },
                    xaxis: {
                        categories: saleDates,
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: "#64748b",
                                fontSize: "11px"
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: "#64748b",
                                fontSize: "11px"
                            },
                            formatter: function (val) {
                                return "৳" + val;
                            }
                        }
                    },
                    grid: {
                        borderColor: "#f1f5f9",
                        strokeDashArray: 3
                    },
                    tooltip: {
                        theme: "light",
                        y: {
                            formatter: function (val) {
                                return "৳" + val.toLocaleString();
                            }
                        }
                    }
                };

                var salesChart = new ApexCharts(salesAnalyticsElement, lineOptions);
                salesChart.render();
            }
        });
    </script>
@endsection
