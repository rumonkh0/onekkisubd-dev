@extends('backEnd.layouts.master')
@section('title', 'Order Report')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <style>
        .print-header {
            display: none;
        }
        @media print {
            header,
            footer,
            .left-side-menu,
            .navbar-custom,
            .page-title-box,
            .no-print,
            .dataTables_filter,
            .dataTables_length,
            .dataTables_info,
            .dataTables_paginate,
            .pagination,
            .export-print,
            .btn {
                display: none !important;
            }
            .content-page {
                margin: 0 !important;
                padding: 0 !important;
                min-height: 0 !important;
            }
            html,
            body,
            #wrapper,
            .content-page,
            .content,
            .container-fluid,
            .table-responsive {
                display: block !important;
                position: static !important;
                overflow: visible !important;
                height: auto !important;
                width: 100% !important;
            }
            .row,
            .card,
            .card-body {
                display: block !important;
                position: static !important;
                overflow: visible !important;
                height: auto !important;
            }
            .col-12 {
                width: 100% !important;
                max-width: 100% !important;
                flex: none !important;
                padding: 0 !important;
            }
            .container-fluid {
                padding: 0 !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .card-body {
                padding: 0 !important;
            }
            .print-header {
                display: block !important;
                margin-bottom: 20px !important;
                border-bottom: 2px solid #222 !important;
                padding-bottom: 10px !important;
            }
            .table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 10px !important;
                white-space: normal !important;
            }
            .table thead {
                display: table-header-group;
            }
            .table tfoot {
                display: table-row-group;
            }
            .table tr {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            .table th, .table td {
                border: 1px solid #333 !important;
                padding: 5px 6px !important;
                color: #000 !important;
            }
            .table th {
                background-color: #f1f5f9 !important;
                font-weight: 700 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .tfoot-total {
                background-color: #f8fafc !important;
                font-weight: 700 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
@endsection

@section('content')
@php
    $order_statuses = $order_statuses ?? \App\Models\OrderStatus::where('status', 1)->get();
    $users = $users ?? \App\Models\User::where('status', 1)->get();
    $totalPurchase = $totalPurchase ?? 0;
    $total_item = $total_item ?? 0;
    $total_sales = $total_sales ?? 0;
    $discounts = $discounts ?? 0;
    $startDate = request('start_date');
    $endDate = request('end_date');
    $isDateFiltered = !empty($startDate) || !empty($endDate);
@endphp
<div class="container-fluid">

    <!-- start page title -->
    <div class="row no-print">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Order Sales & Profit Report</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Print Header -->
    <div class="print-header">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h2 class="m-0 fw-bold" style="color: #1e293b;">{{ $generalsetting->name ?? 'OnekkisuBD' }}</h2>
                <h4 class="m-0 text-muted" style="font-size: 16px;">Order Sales & Profit Statement</h4>
            </div>
            <div class="text-end">
                <p class="m-0 small text-muted">Generated On: <strong>{{ date('d M, Y h:i A') }}</strong></p>
                <p class="m-0 small text-muted">Net Sales: <strong>৳ {{ number_format($total_sales - $discounts, 2) }}</strong> | Total Profit: <strong>৳ {{ number_format($total_sales - $totalPurchase - $discounts, 2) }}</strong></p>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2 pt-2 border-top small text-muted">
            @if(request('keyword')) <span><strong>Search:</strong> "{{ request('keyword') }}" &bull; </span> @endif
            @php
                $reqStatus = request('order_status', 'delivered_completed');
                $selSt = $order_statuses->firstWhere('id', $reqStatus);
                $statusLabel = $reqStatus == 'all'
                    ? 'All Statuses'
                    : ($reqStatus == 'delivered_completed' ? 'Completed & Delivered' : ($selSt->name ?? 'Completed & Delivered'));
            @endphp
            <span><strong>Status:</strong> {{ $statusLabel }} &bull; </span>
            @if(request('user_id'))
                @php $selUsr = $users->firstWhere('id', request('user_id')); @endphp
                <span><strong>Assigned:</strong> {{ $selUsr->name ?? 'Selected' }} &bull; </span>
            @endif
            <span><strong>Date Range:</strong> {{ $startDate ? date('d M, Y', strtotime($startDate)) : 'All Time' }} to {{ $endDate ? date('d M, Y', strtotime($endDate)) : 'Present' }}</span>
        </div>
    </div>

    <!-- Summary KPI Stat Cards -->
    <div class="row no-print">
        <div class="col-md-3 col-sm-6">
            <div class="card widget-rounded-circle">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fe-shopping-bag font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1"><span data-plugin="counterup">{{ number_format($total_item) }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Items Sold</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card widget-rounded-circle">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                <i class="fe-dollar-sign font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">৳<span data-plugin="counterup">{{ number_format($total_sales - $discounts, 2) }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Net Sales (Post-Discount)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card widget-rounded-circle">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                <i class="fe-archive font-22 avatar-title text-warning"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">৳<span data-plugin="counterup">{{ number_format($totalPurchase, 2) }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Total Purchase Cost</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card widget-rounded-circle">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                <i class="fe-trending-up font-22 avatar-title text-info"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                @php $netProfit = $total_sales - $totalPurchase - $discounts; @endphp
                                <h3 class="mt-1 {{ $netProfit >= 0 ? 'text-success' : 'text-danger' }}">৳<span data-plugin="counterup">{{ number_format($netProfit, 2) }}</span></h3>
                                <p class="text-muted mb-1 text-truncate">Estimated Net Profit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="row no-print">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @php
                        $todayStr = now()->toDateString();
                        $last7Str = now()->subDays(6)->toDateString();
                        $monthStartStr = now()->startOfMonth()->toDateString();
                        $monthEndStr = now()->endOfMonth()->toDateString();
                        $lastMonthStartStr = now()->subMonth()->startOfMonth()->toDateString();
                        $lastMonthEndStr = now()->subMonth()->endOfMonth()->toDateString();
                        $baseParams = array_filter(request()->only(['keyword', 'order_status', 'user_id']), fn($v) => $v !== null && $v !== '');
                    @endphp
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 pb-2 border-bottom">
                        <span class="fw-semibold text-dark small"><i class="fe-calendar text-primary me-1"></i> Quick Date Filter:</span>
                        <div class="d-flex flex-wrap gap-1">
                            <a href="{{ route('admin.order_report', array_merge($baseParams, ['start_date' => $todayStr, 'end_date' => $todayStr])) }}"
                               class="btn btn-xs {{ ($startDate === $todayStr && $endDate === $todayStr) ? 'btn-primary' : 'btn-outline-secondary' }}">Today</a>
                            <a href="{{ route('admin.order_report', array_merge($baseParams, ['start_date' => $last7Str, 'end_date' => $todayStr])) }}"
                               class="btn btn-xs {{ ($startDate === $last7Str && $endDate === $todayStr) ? 'btn-primary' : 'btn-outline-secondary' }}">Last 7 Days</a>
                            <a href="{{ route('admin.order_report', array_merge($baseParams, ['start_date' => $monthStartStr, 'end_date' => $monthEndStr])) }}"
                               class="btn btn-xs {{ ($startDate === $monthStartStr && $endDate === $monthEndStr) ? 'btn-primary' : 'btn-outline-secondary' }}">This Month</a>
                            <a href="{{ route('admin.order_report', array_merge($baseParams, ['start_date' => $lastMonthStartStr, 'end_date' => $lastMonthEndStr])) }}"
                               class="btn btn-xs {{ ($startDate === $lastMonthStartStr && $endDate === $lastMonthEndStr) ? 'btn-primary' : 'btn-outline-secondary' }}">Last Month</a>
                            <a href="{{ route('admin.order_report', $baseParams) }}"
                               class="btn btn-xs {{ !$isDateFiltered ? 'btn-primary' : 'btn-outline-secondary' }}">All Time</a>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('admin.order_report') }}" class="no-print">
                        <div class="row align-items-end g-2">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="keyword" class="form-label fw-semibold">Search Keyword</label>
                                    <input type="text" value="{{ request('keyword') }}" class="form-control"
                                        id="keyword" name="keyword" placeholder="Invoice, Product, Customer, Phone...">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <div class="form-group">
                                    <label for="order_status" class="form-label fw-semibold">Order Status</label>
                                    <select class="form-control select2" id="order_status" name="order_status">
                                        <option value="delivered_completed" {{ request('order_status', 'delivered_completed') == 'delivered_completed' ? 'selected' : '' }}>Completed & Delivered (Default)</option>
                                        <option value="all" {{ request('order_status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                        @foreach ($order_statuses->unique('name') as $status)
                                            <option value="{{ $status->id }}" {{ (string) request('order_status') === (string) $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <div class="form-group">
                                    <label for="user_id" class="form-label fw-semibold">Assign User</label>
                                    <select class="form-control select2" id="user_id" name="user_id">
                                        <option value="">All Users</option>
                                        @foreach ($users as $value)
                                            <option value="{{ $value->id }}" {{ request('user_id') == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <div class="form-group">
                                    <label for="start_date" class="form-label fw-semibold">Start Date</label>
                                    <input type="date" value="{{ $startDate }}"
                                        class="form-control" id="start_date" name="start_date">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <div class="form-group">
                                    <label for="end_date" class="form-label fw-semibold">End Date</label>
                                    <input type="date" value="{{ $endDate }}"
                                        class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-12 d-flex gap-1">
                                <button type="submit" class="btn btn-primary w-100" title="Apply Filter"><i class="fe-search"></i></button>
                                <a href="{{ route('admin.order_report') }}" class="btn btn-secondary" title="Reset Filters"><i class="fe-rotate-ccw"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3 align-items-center no-print">
                        <div class="col-sm-6">
                            <span class="text-muted">Showing <strong>{{ $orders->firstItem() ?? 0 }}</strong> to <strong>{{ $orders->lastItem() ?? 0 }}</strong> of <strong>{{ $orders->total() }}</strong> entries</span>
                        </div>
                        <div class="col-sm-6 text-end">
                            <a href="{{ route('admin.order_report', array_merge(request()->query(), ['print' => 1])) }}" class="btn btn-success me-1"><i class="fe-printer me-1"></i> Print All ({{ $orders->total() }})</a>
                            <button id="export-excel-button" class="btn btn-info"><i class="fe-download me-1"></i> Export Excel</button>
                        </div>
                    </div>

                    <div id="content-to-export">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover nowrap w-100 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 4%;">#</th>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Product Name</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Purchase</th>
                                        <th class="text-end">Sale Price</th>
                                        <th class="text-end">Item Total</th>
                                        <th class="text-end">Profit</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Order Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $key => $value)
                                        @php
                                            $order = $value->order;
                                            $unitPurchase = ($value->purchase_price && $value->purchase_price > 0)
                                                ? (float) $value->purchase_price
                                                : (float) ($value->product->purchase_price ?? 0);
                                            $unitSale = (float) ($value->sale_price ?? 0);
                                            $qty = (int) ($value->qty ?? 1);
                                            $itemTotal = $qty * $unitSale;
                                            $itemPurchaseTotal = $qty * $unitPurchase;
                                            $itemProfit = $itemTotal - $itemPurchaseTotal;
                                            $customerName = $value->shipping ? $value->shipping->name : ($order && $order->customer ? $order->customer->name : 'N/A');
                                            $customerPhone = $value->shipping ? $value->shipping->phone : ($order && $order->customer ? $order->customer->phone : 'N/A');
                                            $customerAddress = $value->shipping ? $value->shipping->address : ($order && $order->customer ? $order->customer->address : 'N/A');
                                            $statusName = ($order && $order->status) ? $order->status->name : null;
                                            $statusIdVal = $order ? (int) $order->order_status : 0;
                                            $badgeClass = match($statusIdVal) {
                                                6, 12 => 'bg-soft-success text-success border-success',
                                                1 => 'bg-soft-warning text-warning border-warning',
                                                2, 5, 10, 11, 13 => 'bg-soft-info text-info border-info',
                                                4, 8, 14, 15, 16 => 'bg-soft-danger text-danger border-danger',
                                                default => 'bg-soft-primary text-primary border-primary',
                                            };
                                        @endphp
                                        <tr>
                                            <td>{{ $orders->firstItem() + $loop->index }}</td>
                                            <td>
                                                @if($order)
                                                    <a href="{{ route('admin.order.invoice', ['invoice_id' => $order->invoice_id]) }}" class="fw-bold text-primary" target="_blank">
                                                        #{{ $order->invoice_id }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $value->created_at ? $value->created_at->format('d M, Y') : ($order && $order->created_at ? $order->created_at->format('d M, Y') : '') }}</td>
                                            <td class="fw-semibold text-dark">{{ $customerName }}</td>
                                            <td>{{ $customerPhone }}</td>
                                            <td style="max-width: 180px; white-space: normal;">{{ Str::limit($customerAddress, 45) }}</td>
                                            <td>
                                                <span class="fw-semibold text-dark">{{ $value->product_name }}</span>
                                                @if($value->product_size || $value->product_color)
                                                    <small class="text-muted d-block">
                                                        {{ implode(' / ', array_filter([$value->product_size, $value->product_color])) }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center fw-bold">{{ $qty }}</td>
                                            <td class="text-end text-muted">৳{{ number_format($unitPurchase, 2) }}</td>
                                            <td class="text-end">৳{{ number_format($unitSale, 2) }}</td>
                                            <td class="text-end fw-bold">৳{{ number_format($itemTotal, 2) }}</td>
                                            <td class="text-end fw-semibold {{ $itemProfit >= 0 ? 'text-success' : 'text-danger' }}">৳{{ number_format($itemProfit, 2) }}</td>
                                            <td class="text-center">
                                                @if($statusName)
                                                    <span class="badge {{ $badgeClass }} border px-2 py-1">{{ $statusName }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Unknown</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">{{ $order && $order->order_type ? ucfirst($order->order_type) : 'Online' }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center py-4 text-muted">
                                                <i class="fe-inbox font-24 d-block mb-1"></i>
                                                No order records found matching the specified criteria.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="tfoot-total bg-light">
                                        <th colspan="7" class="text-end fw-bold">Total Items Sold:</th>
                                        <th class="text-center fw-bold">{{ number_format($total_item) }}</th>
                                        <th class="text-end fw-bold">Cost: ৳{{ number_format($totalPurchase, 2) }}</th>
                                        <th colspan="2" class="text-end fw-bold">Gross Sales: ৳{{ number_format($total_sales, 2) }}</th>
                                        <th colspan="3" class="text-center fw-bold">Discount: ৳{{ number_format($discounts, 2) }}</th>
                                    </tr>
                                    <tr class="tfoot-total bg-soft-success">
                                        <th colspan="8" class="text-end fw-bold">Net Sales (Revenue):</th>
                                        <th colspan="3" class="fw-bold text-success">৳{{ number_format($total_sales - $discounts, 2) }}</th>
                                        <th colspan="2" class="text-end fw-bold">Total Net Profit:</th>
                                        <th class="fw-bold text-success text-center">৳{{ number_format($total_sales - $totalPurchase - $discounts, 2) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-3 no-print align-items-center">
                        <div class="col-sm-6 text-muted">
                            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                        </div>
                        <div class="col-sm-6 d-flex justify-content-end">
                            {{ $orders->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-table2excel@1.1.1/dist/jquery.table2excel.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();

        @if(request()->boolean('print'))
            window.addEventListener('load', function() {
                window.print();
            });
        @endif

        $('#export-excel-button').on('click', function() {
            var filename = "Order-Report-" + new Date().toISOString().slice(0, 10);
            if ($.fn.table2excel) {
                var contentToExport = $('#content-to-export').html();
                var tempElement = $('<div>').html(contentToExport);
                tempElement.find('.table').table2excel({
                    exclude: ".no-export",
                    name: "Order Report",
                    filename: filename + ".xls"
                });
            } else {
                var tableHtml = $('#content-to-export').find('table')[0].outerHTML;
                var blob = new Blob(['\ufeff', tableHtml], { type: 'application/vnd.ms-excel' });
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = filename + '.xls';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
        });
    });
</script>
@endsection
