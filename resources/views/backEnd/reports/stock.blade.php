@extends('backEnd.layouts.master')
@section('title', 'Stock Report')
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
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .container-fluid {
                width: 100% !important;
                padding: 0 !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
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
                font-size: 13px !important;
            }
            .table th, .table td {
                border: 1px solid #333 !important;
                padding: 6px 8px !important;
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
<div class="container-fluid">

    <!-- start page title -->
    <div class="row no-print">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Inventory Stock Report</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- Print Header -->
    <div class="print-header">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                <h2 class="m-0 fw-bold" style="color: #1e293b;">{{ $generalsetting->name ?? 'OnekkisuBD' }}</h2>
                <h4 class="m-0 text-muted" style="font-size: 16px;">Inventory & Stock Valuation Statement</h4>
            </div>
            <div class="text-end">
                <p class="m-0 small text-muted">Generated On: <strong>{{ date('d M, Y h:i A') }}</strong></p>
                <p class="m-0 small text-muted">Total Stock: <strong>{{ number_format($total_stock) }} Pcs</strong> | Total Value: <strong>৳ {{ number_format($total_price, 2) }}</strong></p>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2 pt-2 border-top small text-muted">
            @if(request('keyword')) <span><strong>Search:</strong> "{{ request('keyword') }}" &bull; </span> @endif
            @if(request('category_id'))
                @php $selCat = $categories->firstWhere('id', request('category_id')); @endphp
                <span><strong>Category:</strong> {{ $selCat->name ?? 'Selected' }} &bull; </span>
            @endif
            <span><strong>Date Range:</strong> {{ request('start_date') ? date('d M, Y', strtotime(request('start_date'))) : 'All Time' }} to {{ request('end_date') ? date('d M, Y', strtotime(request('end_date'))) : 'Present' }}</span>
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
                                <i class="fe-package font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">{{ number_format($total_stock) }}</h3>
                                <p class="text-muted mb-1 text-truncate">Total Stock (Pcs)</p>
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
                                <h3 class="text-dark mt-1">৳ {{ number_format($total_price, 0) }}</h3>
                                <p class="text-muted mb-1 text-truncate">Total Retail Value</p>
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
                                <i class="fe-shopping-cart font-22 avatar-title text-info"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">৳ {{ number_format($total_purchase, 0) }}</h3>
                                <p class="text-muted mb-1 text-truncate">Total Cost Value</p>
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
                                <i class="fe-trending-up font-22 avatar-title text-warning"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">৳ {{ number_format($total_price - $total_purchase, 0) }}</h3>
                                <p class="text-muted mb-1 text-truncate">Potential Margin</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="row no-print mb-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('admin.stock_report') }}" class="row g-2 align-items-end">
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label font-13 fw-semibold mb-1">Search Product</label>
                            <input type="text" value="{{ request('keyword') }}" class="form-control form-control-sm" name="keyword" placeholder="Product name...">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label font-13 fw-semibold mb-1">Category</label>
                            <select class="form-select form-select-sm" name="category_id">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label class="form-label font-13 fw-semibold mb-1">Start Date</label>
                            <input type="date" value="{{ request('start_date') }}" class="form-control form-control-sm" name="start_date">
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label class="form-label font-13 fw-semibold mb-1">End Date</label>
                            <input type="date" value="{{ request('end_date') }}" class="form-control form-control-sm" name="end_date">
                        </div>

                        <div class="col-md-2 col-sm-12 d-flex gap-1">
                            <button type="submit" class="btn btn-sm btn-primary flex-grow-1" title="Apply Filter">
                                <i class="fe-filter me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.stock_report') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filters">
                                <i class="fe-rotate-ccw"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3 no-print align-items-center">
                        <div class="col-sm-6">
                            {{ $products->links('pagination::bootstrap-4') }}
                        </div>
                        <div class="col-sm-6 text-end">
                            <button onclick="printFunction()" class="btn btn-sm btn-success me-1">
                                <i class="fe-printer me-1"></i> Print
                            </button>
                            <button id="export-excel-button" class="btn btn-sm btn-info">
                                <i class="fe-download me-1"></i> Export Excel
                            </button>
                        </div>
                    </div>

                    <div id="content-to-export" class="table-responsive">
                        <table class="table table-striped table-bordered nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">SL</th>
                                    <th>Product Name</th>
                                    <th>Size / Variant</th>
                                    <th>Category</th>
                                    <th>Unit Price</th>
                                    <th>Stock (Qty)</th>
                                    <th>Total Value</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $rowNum = ($products->currentPage() - 1) * $products->perPage();
                                    $pageStock = 0;
                                    $pageTotal = 0;
                                @endphp
                                @forelse ($products as $product)
                                    @if ($product->sizes && $product->sizes->count() > 0)
                                        @foreach ($product->sizes as $size)
                                            @php
                                                $rowNum++;
                                                $subtotal = $size->quantity * $size->SalePrice;
                                                $pageStock += $size->quantity;
                                                $pageTotal += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $rowNum }}</td>
                                                <td>
                                                    <a href="{{ route('products.edit', $product->id) }}" class="fw-semibold text-dark">
                                                        {{ $product->name }}
                                                    </a>
                                                </td>
                                                <td><span class="badge bg-soft-info text-info">{{ $size->size }}</span></td>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                <td>৳ {{ number_format($size->SalePrice, 2) }}</td>
                                                <td>
                                                    <span class="fw-bold {{ $size->quantity <= 5 ? 'text-danger' : 'text-dark' }}">
                                                        {{ $size->quantity }} Pcs
                                                    </span>
                                                </td>
                                                <td class="fw-bold text-success">৳ {{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @php
                                            $rowNum++;
                                            $subtotal = $product->stock * $product->new_price;
                                            $pageStock += $product->stock;
                                            $pageTotal += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $rowNum }}</td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="fw-semibold text-dark">
                                                    {{ $product->name }}
                                                </a>
                                            </td>
                                            <td><span class="badge bg-soft-secondary text-secondary">Standard</span></td>
                                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                                            <td>৳ {{ number_format($product->new_price, 2) }}</td>
                                            <td>
                                                <span class="fw-bold {{ $product->stock <= 5 ? 'text-danger' : 'text-dark' }}">
                                                    {{ $product->stock }} Pcs
                                                </span>
                                            </td>
                                            <td class="fw-bold text-success">৳ {{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fe-package font-22 d-block mb-1"></i>
                                            No products found matching the criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tfoot>
                                <tr class="tfoot-total bg-light">
                                    <td colspan="5" class="text-end fw-bold">Page Subtotal:</td>
                                    <td><strong class="text-dark">{{ number_format($pageStock) }} Pcs</strong></td>
                                    <td><strong class="text-success">৳ {{ number_format($pageTotal, 2) }}</strong></td>
                                </tr>
                                <tr class="tfoot-total bg-soft-primary">
                                    <td colspan="5" class="text-end fw-bold">Grand Overall Stock Total:</td>
                                    <td><strong class="text-primary font-16">{{ number_format($total_stock) }} Pcs</strong></td>
                                    <td><strong class="text-success font-16">৳ {{ number_format($total_price, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
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
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    function printFunction() {
        window.print();
    }

    $(document).ready(function() {
        $('#export-excel-button').on('click', function() {
            var contentToExport = $('#content-to-export').html();
            var tempElement = $('<div>');
            tempElement.html(contentToExport);
            tempElement.find('.table').table2excel({
                exclude: ".no-export",
                name: "Stock Report",
                filename: "Stock_Report_" + new Date().toISOString().slice(0, 10)
            });
        });
    });
</script>
@endsection
