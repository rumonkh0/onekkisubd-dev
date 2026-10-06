@extends('backEnd.layouts.master')
@section('title', $order_status->name . ' Order')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <style>
        .filter-panel {
            background: #ffffff;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .filter-preset-pill {
            display: inline-block;
            padding: 3px 12px;
            font-size: 12px;
            border-radius: 20px;
            border: 1px solid var(--slate-300);
            background: var(--slate-50);
            color: var(--slate-700);
            text-decoration: none !important;
            margin-right: 6px;
            margin-bottom: 6px;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .filter-preset-pill:hover, .filter-preset-pill.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff !important;
        }
        .selection-banner {
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            border-radius: 8px;
            padding: 10px 16px;
            margin-bottom: 14px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }
        .selection-counter-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            background: var(--slate-100);
            color: var(--slate-800);
            border: 1px solid var(--slate-300);
        }
        .selection-dropdown-btn {
            border: 1px solid var(--slate-300);
            background: #ffffff;
            border-radius: 6px;
            padding: 2px 6px;
            font-size: 11px;
            line-height: 1;
        }
        @media print {
            header, footer, .no-print, .left-side-menu, .navbar-custom, .filter-panel, .page-title-box, .action2-btn {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Title & Header Toolbar -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h4 class="page-title mb-0">
                        {{ $order_status->name }} Orders 
                        <span class="badge bg-primary rounded-pill font-13 ms-1">{{ $total_filtered }} matching</span>
                    </h4>
                    <p class="text-muted mb-0 font-13">Filter, select across pages, and batch-process orders</p>
                </div>
                @php
                    $filterKeys = ['keyword', 'start_date', 'end_date', 'phone', 'invoice_id', 'status_id', 'user_id', 'order_type', 'due_status', 'area', 'amount_min', 'amount_max'];
                    $activeFilterCount = 0;
                    foreach($filterKeys as $fKey) {
                        if (request()->filled($fKey)) {
                            $activeFilterCount++;
                        }
                    }
                @endphp
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleFilterBtn">
                        <i class="fe-filter"></i> Filters 
                        @if($activeFilterCount > 0)
                            <span class="badge bg-primary ms-1">{{ $activeFilterCount }}</span>
                        @endif
                    </button>
                    @if($activeFilterCount > 0)
                        <a href="{{ route('admin.orders', ['slug' => $slug]) }}" class="btn btn-outline-danger btn-sm">
                            <i class="fe-rotate-ccw"></i> Reset Filters
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filter Panel (Collapsible) -->
    <div class="filter-panel" id="filterPanel" style="display: {{ $activeFilterCount > 0 ? 'block' : 'none' }};">
        <form method="GET" action="{{ route('admin.orders', ['slug' => $slug]) }}" id="advancedFilterForm">
            <!-- Quick Date Presets -->
            <div class="d-flex align-items-center flex-wrap mb-3 pb-2 border-bottom">
                <span class="text-muted fw-bold font-12 me-2 text-uppercase">Quick Date:</span>
                <span class="filter-preset-pill" data-preset="all">All Time</span>
                <span class="filter-preset-pill" data-preset="today">Today</span>
                <span class="filter-preset-pill" data-preset="yesterday">Yesterday</span>
                <span class="filter-preset-pill" data-preset="7days">Last 7 Days</span>
                <span class="filter-preset-pill" data-preset="this_month">This Month</span>
            </div>

            <!-- Main Filter Grid -->
            <div class="row g-2">
                <!-- Date Range -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Start Date</label>
                    <input type="date" name="start_date" id="filter_start_date" class="form-control form-control-sm"
                        value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">End Date</label>
                    <input type="date" name="end_date" id="filter_end_date" class="form-control form-control-sm"
                        value="{{ request('end_date') }}">
                </div>

                <!-- Customer Phone / Name / Invoice Search -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Keyword / Invoice / Phone</label>
                    <input type="text" name="keyword" class="form-control form-control-sm"
                        placeholder="Search invoice, phone, name..." value="{{ request('keyword') }}">
                </div>

                <!-- Amount Range -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Amount Range (৳)</label>
                    <div class="input-group input-group-sm">
                        <input type="number" name="amount_min" class="form-control" placeholder="Min ৳" value="{{ request('amount_min') }}">
                        <span class="input-group-text">-</span>
                        <input type="number" name="amount_max" class="form-control" placeholder="Max ৳" value="{{ request('amount_max') }}">
                    </div>
                </div>

                <!-- Order Status (Multi-Select Tick Dropdown) -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Order Status</label>
                    <div class="dropdown filter-multi-dropdown" data-placeholder="All Statuses">
                        <button class="btn btn-outline-light form-control form-control-sm dropdown-toggle d-flex justify-content-between align-items-center text-start" 
                                type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <span class="dropdown-label text-truncate">All Statuses</span>
                            <i class="fe-chevron-down font-12 text-muted ms-1 flex-shrink-0"></i>
                        </button>
                        <div class="dropdown-menu p-2 shadow border w-100" style="min-width: 200px;">
                            <div class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                                <span class="font-11 text-muted text-uppercase fw-semibold">Select Statuses</span>
                                <a href="javascript:void(0);" class="font-11 text-danger clear-filter-dropdown">Clear</a>
                            </div>
                            <div class="dropdown-items-list" style="max-height: 200px; overflow-y: auto;">
                                @foreach ($orderstatuses as $st)
                                    <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                        <input type="checkbox" name="status_id[]" value="{{ $st->id }}" 
                                               class="form-check-input m-0 filter-tick-check"
                                               {{ in_array($st->id, (array) request('status_id', [])) ? 'checked' : '' }}>
                                        <span class="filter-tick-text font-13">{{ $st->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assigned Staff (Multi-Select Tick Dropdown) -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Assigned Staff</label>
                    <div class="dropdown filter-multi-dropdown" data-placeholder="All Staff">
                        <button class="btn btn-outline-light form-control form-control-sm dropdown-toggle d-flex justify-content-between align-items-center text-start" 
                                type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <span class="dropdown-label text-truncate">All Staff</span>
                            <i class="fe-chevron-down font-12 text-muted ms-1 flex-shrink-0"></i>
                        </button>
                        <div class="dropdown-menu p-2 shadow border w-100" style="min-width: 200px;">
                            <div class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                                <span class="font-11 text-muted text-uppercase fw-semibold">Select Staff</span>
                                <a href="javascript:void(0);" class="font-11 text-danger clear-filter-dropdown">Clear</a>
                            </div>
                            <div class="dropdown-items-list" style="max-height: 200px; overflow-y: auto;">
                                <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                    <input type="checkbox" name="user_id[]" value="unassigned" 
                                           class="form-check-input m-0 filter-tick-check"
                                           {{ in_array('unassigned', (array) request('user_id', [])) ? 'checked' : '' }}>
                                    <span class="filter-tick-text font-13 text-danger fw-semibold">-- Unassigned Orders --</span>
                                </label>
                                @foreach ($users as $user)
                                    <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                        <input type="checkbox" name="user_id[]" value="{{ $user->id }}" 
                                               class="form-check-input m-0 filter-tick-check"
                                               {{ in_array($user->id, (array) request('user_id', [])) ? 'checked' : '' }}>
                                        <span class="filter-tick-text font-13">{{ $user->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Area (Multi-Select Tick Dropdown) -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Delivery Area</label>
                    <div class="dropdown filter-multi-dropdown" data-placeholder="All Delivery Areas">
                        <button class="btn btn-outline-light form-control form-control-sm dropdown-toggle d-flex justify-content-between align-items-center text-start" 
                                type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <span class="dropdown-label text-truncate">All Delivery Areas</span>
                            <i class="fe-chevron-down font-12 text-muted ms-1 flex-shrink-0"></i>
                        </button>
                        <div class="dropdown-menu p-2 shadow border w-100" style="min-width: 200px;">
                            <div class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                                <span class="font-11 text-muted text-uppercase fw-semibold">Select Areas</span>
                                <a href="javascript:void(0);" class="font-11 text-danger clear-filter-dropdown">Clear</a>
                            </div>
                            <div class="dropdown-items-list" style="max-height: 200px; overflow-y: auto;">
                                @foreach ($shippingcharges as $charge)
                                    <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                        <input type="checkbox" name="area[]" value="{{ $charge->name }}" 
                                               class="form-check-input m-0 filter-tick-check"
                                               {{ in_array($charge->name, (array) request('area', [])) ? 'checked' : '' }}>
                                        <span class="filter-tick-text font-13">{{ $charge->name }} (৳{{ $charge->amount }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Type (Multi-Select Tick Dropdown) -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Order Type</label>
                    <div class="dropdown filter-multi-dropdown" data-placeholder="All Order Types">
                        <button class="btn btn-outline-light form-control form-control-sm dropdown-toggle d-flex justify-content-between align-items-center text-start" 
                                type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <span class="dropdown-label text-truncate">All Order Types</span>
                            <i class="fe-chevron-down font-12 text-muted ms-1 flex-shrink-0"></i>
                        </button>
                        <div class="dropdown-menu p-2 shadow border w-100" style="min-width: 200px;">
                            <div class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                                <span class="font-11 text-muted text-uppercase fw-semibold">Select Order Types</span>
                                <a href="javascript:void(0);" class="font-11 text-danger clear-filter-dropdown">Clear</a>
                            </div>
                            <div class="dropdown-items-list" style="max-height: 200px; overflow-y: auto;">
                                <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                    <input type="checkbox" name="order_type[]" value="Online" 
                                           class="form-check-input m-0 filter-tick-check"
                                           {{ in_array('Online', (array) request('order_type', [])) ? 'checked' : '' }}>
                                    <span class="filter-tick-text font-13">Online</span>
                                </label>
                                <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                    <input type="checkbox" name="order_type[]" value="POS" 
                                           class="form-check-input m-0 filter-tick-check"
                                           {{ in_array('POS', (array) request('order_type', [])) ? 'checked' : '' }}>
                                    <span class="filter-tick-text font-13">POS</span>
                                </label>
                                <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                    <input type="checkbox" name="order_type[]" value="Campaign" 
                                           class="form-check-input m-0 filter-tick-check"
                                           {{ in_array('Campaign', (array) request('order_type', [])) ? 'checked' : '' }}>
                                    <span class="filter-tick-text font-13">Landing Page / Campaign</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Due & Partial Payment Status (Multi-Select Tick Dropdown) -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Payment / Due Status</label>
                    <div class="dropdown filter-multi-dropdown" data-placeholder="All Payment Statuses">
                        <button class="btn btn-outline-light form-control form-control-sm dropdown-toggle d-flex justify-content-between align-items-center text-start" 
                                type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <span class="dropdown-label text-truncate">All Payment Statuses</span>
                            <i class="fe-chevron-down font-12 text-muted ms-1 flex-shrink-0"></i>
                        </button>
                        <div class="dropdown-menu p-2 shadow border w-100" style="min-width: 200px;">
                            <div class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                                <span class="font-11 text-muted text-uppercase fw-semibold">Select Statuses</span>
                                <a href="javascript:void(0);" class="font-11 text-danger clear-filter-dropdown">Clear</a>
                            </div>
                            <div class="dropdown-items-list" style="max-height: 200px; overflow-y: auto;">
                                <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                    <input type="checkbox" name="due_status[]" value="has_due" 
                                           class="form-check-input m-0 filter-tick-check"
                                           {{ in_array('has_due', (array) request('due_status', [])) ? 'checked' : '' }}>
                                    <span class="filter-tick-text font-13">Has Due Balance</span>
                                </label>
                                <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                    <input type="checkbox" name="due_status[]" value="partial" 
                                           class="form-check-input m-0 filter-tick-check"
                                           {{ in_array('partial', (array) request('due_status', [])) ? 'checked' : '' }}>
                                    <span class="filter-tick-text font-13">Has Partial Payment</span>
                                </label>
                                <label class="dropdown-item d-flex align-items-center gap-2 py-1 px-2 rounded cursor-pointer mb-0">
                                    <input type="checkbox" name="due_status[]" value="paid" 
                                           class="form-check-input m-0 filter-tick-check"
                                           {{ in_array('paid', (array) request('due_status', [])) ? 'checked' : '' }}>
                                    <span class="filter-tick-text font-13">Zero Due / Fully Paid</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Per Page -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label mb-1">Show Per Page</label>
                    <select name="per_page" class="form-select form-select-sm">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Per Page</option>
                        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 Per Page</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Per Page</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Per Page</option>
                        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Show All Matching</option>
                    </select>
                </div>

                <!-- Submit & Clear Buttons with Results Count -->
                <div class="col-md-6 col-sm-12 d-flex justify-content-between align-items-center flex-wrap gap-2 mt-auto pb-1">
                    <span class="text-muted font-13">
                        <i class="fe-check-circle text-success me-1"></i> Found: <strong class="text-primary font-14">{{ $total_filtered }}</strong> orders
                        @if(isset($total_filtered_amount) && $total_filtered_amount > 0)
                            <span class="text-muted font-12 ms-1">(৳{{ number_format($total_filtered_amount) }})</span>
                        @endif
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('admin.orders', ['slug' => $slug]) }}" class="btn btn-light btn-sm">Clear</a>
                        <button type="submit" class="btn btn-primary btn-sm px-3">
                            <i class="fe-check me-1"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Orders Card -->
    <div class="row order_page">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Prominent Filter Results Counter Bar -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 p-2 px-3 rounded bg-light border">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="fw-bold text-dark font-14">
                                <i class="fe-check-circle text-success me-1"></i> Total Results:
                                <span class="badge bg-primary font-14 px-2 py-1 ms-1">{{ $total_filtered }}</span> Orders
                            </span>
                            @if(isset($total_filtered_amount) && $total_filtered_amount > 0)
                                <span class="badge bg-success-subtle text-success font-12 border border-success-subtle">
                                    Total Amount: ৳{{ number_format($total_filtered_amount) }}
                                </span>
                            @endif
                            @if($total_filtered > 0)
                                <span class="text-muted font-12">
                                    (Showing {{ $show_data->firstItem() }} - {{ $show_data->lastItem() }} of {{ $total_filtered }})
                                </span>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @if(request()->hasAny(['keyword', 'start_date', 'end_date', 'phone', 'invoice_id', 'status_id', 'user_id', 'order_type', 'due_status', 'area', 'amount_min', 'amount_max']))
                                <span class="badge  text-black font-12 border border-warning-subtle">
                                    <i class="fe-sliders font-11 me-1 text-black"></i> Filter Active
                                </span>
                                <a href="{{ route('admin.orders', ['slug' => $slug]) }}" class="btn btn-xs btn-outline-danger font-11 py-0 px-2">
                                    <i class="fe-rotate-ccw font-10 me-1"></i> Reset Filters
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Action Toolbar & Selection Variations -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div class="d-flex align-items-center flex-wrap gap-1">
                            <!-- Selection variations dropdown -->
                            <div class="dropdown me-2">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fe-check-square me-1"></i> Select Options
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);" id="selOptionPage"><i class="fe-file text-muted me-1"></i> Select Current Page ({{ $show_data->count() }})</a></li>
                                    <li><a class="dropdown-item fw-bold text-primary" href="javascript:void(0);" id="selOptionAll"><i class="fe-check-circle text-primary me-1"></i> Select All Matching ({{ $total_filtered }})</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" id="selOptionUnassigned"><i class="fe-user-x text-muted me-1"></i> Select Unassigned on this page</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" id="selOptionDue"><i class="fe-dollar-sign text-muted me-1"></i> Select Due Orders on this page</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="javascript:void(0);" id="selOptionClear"><i class="fe-x text-danger me-1"></i> Clear All Selection</a></li>
                                </ul>
                            </div>

                            <span id="selectionCounter" class="selection-counter-badge d-none me-2">
                                <span id="selectionCountNum">0</span> selected
                            </span>

                            <!-- Bulk Action Buttons -->
                            <ul class="action2-btn mb-0">
                                <li>
                                    <a data-bs-toggle="modal" data-bs-target="#asignUser" class="btn btn-sm btn-outline-success">
                                        <i class="fe-user-plus"></i> Assign User
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="modal" data-bs-target="#changeStatus" class="btn btn-sm btn-outline-primary">
                                        <i class="fe-tag"></i> Change Status
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.order.order_print') }}" class="btn btn-sm btn-outline-info multi_order_print">
                                        <i class="fe-printer"></i> Print Invoices
                                    </a>
                                </li>
                                <li class="dropdown d-inline-block">
                                    <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fe-download"></i> Export <i class="fe-chevron-down font-10 ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow border">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2 btn-export-trigger" href="javascript:void(0);" data-format="xlsx">
                                                <i class="fe-file-text text-success me-2 font-16"></i>
                                                <div>
                                                    <span class="d-block fw-semibold font-13">Excel Workbook (.xlsx)</span>
                                                    <small class="text-muted font-11">Native formatted spreadsheet</small>
                                                </div>
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center py-2 btn-export-trigger" href="javascript:void(0);" data-format="csv">
                                                <i class="fe-file text-primary me-2 font-16"></i>
                                                <div>
                                                    <span class="d-block fw-semibold font-13">CSV File (.csv)</span>
                                                    <small class="text-muted font-11">Fast stream with UTF-8 BOM</small>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                @if($steadfast)
                                <li>
                                    <a href="{{ route('admin.bulk_courier', 'steadfast') }}" class="btn btn-sm btn-outline-warning multi_order_courier">
                                        <i class="fe-truck"></i> Steadfast
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ route('admin.bulk_courier', 'pathao') }}" class="btn btn-sm btn-outline-info multi_pathao">
                                        <i class="fe-truck"></i> Pathao
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.order.bulk_destroy') }}" class="btn btn-sm btn-outline-danger order_delete">
                                        <i class="fe-trash-2"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Cross-Page Smart Selection Banner (Gmail / Shopify Style) -->
                    <div id="selectionBanner" class="selection-banner d-none">
                        <div>
                            <i class="fe-info me-1"></i>
                            <span id="selectionBannerText">All {{ $show_data->count() }} orders on this page are selected.</span>
                            <a href="javascript:void(0);" id="btnSelectAllMatching" class="fw-bold text-decoration-underline ms-2">
                                Select all {{ $total_filtered }} orders matching current filter
                            </a>
                        </div>
                        <a href="javascript:void(0);" id="btnClearBannerSelection" class="text-danger fw-bold">
                            Clear selection
                        </a>
                    </div>

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table id="ordersTable" class="table table-hover table-centered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 38px;">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkall" id="checkall">
                                            <label class="form-check-label" for="checkall"></label>
                                        </div>
                                    </th>
                                    <th style="width: 45px;">SL</th>
                                    <th style="width: 105px;">Action</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Customer & Shipping</th>
                                    <th>Phone / Fraud</th>
                                    <th>Assignee</th>
                                    <th>Order Type</th>
                                    <th>Total</th>
                                    <th>Partial</th>
                                    <th>Due</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($show_data as $key => $value)
                                    @php
                                        $dueAmount = $value->amount - ($value->paid_partial_payment_amount ?? 0);
                                    @endphp
                                    <tr data-id="{{ $value->id }}" data-assigned="{{ $value->user_id ? '1' : '0' }}" data-due="{{ $dueAmount > 0 ? '1' : '0' }}">
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input checkbox" value="{{ $value->id }}" id="chk_{{ $value->id }}">
                                                <label class="form-check-label" for="chk_{{ $value->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="custom-btn-list">
                                                <a href="{{ route('admin.order.invoice', ['invoice_id' => $value->invoice_id]) }}" title="View Invoice">
                                                    <i class="fe-eye text-primary"></i>
                                                </a>
                                                <a href="{{ route('admin.order.process', ['invoice_id' => $value->invoice_id]) }}" title="Process Order">
                                                    <i class="fe-settings text-info"></i>
                                                </a>
                                                <a href="{{ route('admin.order.edit', ['invoice_id' => $value->invoice_id]) }}" title="Edit Order">
                                                    <i class="fe-edit text-warning"></i>
                                                </a>
                                                <form method="post" action="{{ route('admin.order.destroy') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" value="{{ $value->id }}" name="id">
                                                    <button type="submit" title="Delete Order" class="delete-confirm">
                                                        <i class="fe-trash-2 text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.order.invoice', ['invoice_id' => $value->invoice_id]) }}" class="fw-bold text-primary">
                                                #{{ $value->invoice_id }}
                                            </a>
                                            @if($value->note)
                                                <div class="text-muted font-11 text-truncate" style="max-width: 120px;" title="{{ $value->note }}">
                                                    Note: {{ $value->note }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-12">{{ $value->created_at ? $value->created_at->format('d-m-Y') : '' }}</span><br>
                                            <span class="text-muted font-11">{{ $value->created_at ? $value->created_at->format('h:i A') : '' }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark font-13">{{ $value->shipping ? $value->shipping->name : 'N/A' }}</div>
                                            <div class="text-muted font-12 text-truncate" style="max-width: 170px;" title="{{ $value->shipping ? $value->shipping->address : '' }}">
                                                {{ $value->shipping ? $value->shipping->address : '' }}
                                            </div>
                                            @if($value->shipping && $value->shipping->area)
                                                <span class="badge bg-light text-dark font-11">{{ $value->shipping->area }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="font-13 fw-semibold">{{ $value->shipping ? $value->shipping->phone : '' }}</span><br>
                                            <button class="btn btn-xs btn-outline-success checkfraud-btn mt-1"
                                                style="font-size: 11px; padding: 2px 8px; border-radius: 12px;"
                                                data-num="{{ $value->shipping ? $value->shipping->phone : '' }}"
                                                data-inv="{{ $value->invoice_id }}">
                                                <i class="fe-shield"></i> Check Fraud
                                            </button>
                                        </td>
                                        <td>
                                            @if($value->user)
                                                <span class="badge bg-light text-dark font-12"><i class="fe-user me-1"></i>{{ $value->user->name }}</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-muted font-11">Unassigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $value->order_type }}</span>
                                        </td>
                                        <td class="fw-bold font-14">৳{{ number_format($value->amount, 0) }}</td>
                                        <td>
                                            @if ($value->paid_partial_payment_amount)
                                                <span class="text-success fw-bold font-12">৳{{ number_format($value->paid_partial_payment_amount, 0) }}</span>
                                            @else
                                                <span class="text-muted font-12">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($dueAmount > 0)
                                                <span class="text-danger fw-bold font-13">৳{{ number_format($dueAmount, 0) }}</span>
                                            @else
                                                <span class="text-success fw-bold font-12"><i class="fe-check"></i> Paid</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $stName = $value->status ? $value->status->name : 'N/A';
                                                $stClass = 'badge-status-pending';
                                                if (stripos($stName, 'process') !== false || stripos($stName, 'confirm') !== false) {
                                                    $stClass = 'badge-status-processing';
                                                } elseif (stripos($stName, 'courier') !== false || stripos($stName, 'ship') !== false) {
                                                    $stClass = 'badge-status-courier';
                                                } elseif (stripos($stName, 'deliver') !== false || stripos($stName, 'complete') !== false) {
                                                    $stClass = 'badge-status-delivered';
                                                } elseif (stripos($stName, 'cancel') !== false) {
                                                    $stClass = 'badge-status-cancelled';
                                                } elseif (stripos($stName, 'return') !== false) {
                                                    $stClass = 'badge-status-returned';
                                                }
                                            @endphp
                                            <span class="badge-status {{ $stClass }}">
                                                {{ $stName }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center py-4 text-muted">
                                            <i class="fe-alert-circle font-20 text-muted d-block mb-1"></i>
                                            No orders match the current filter criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="custom-paginate mt-3">
                        {{ $show_data->links('pagination::bootstrap-4') }}
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>

<!-- Assign User Modal -->
<div class="modal fade" id="asignUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Orders to Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.order.assign') }}" id="order_assign">
                <div class="modal-body">
                    <p class="text-muted font-13 mb-2" id="assignModalTargetNote">Target: Selected orders</p>
                    <div class="form-group">
                        <label class="form-label">Select Staff Member</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">Choose Staff Member...</option>
                            @foreach ($users as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Assign Orders</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Status Modal -->
<div class="modal fade" id="changeStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.order.status') }}" id="order_status_form">
                <div class="modal-body">
                    <p class="text-muted font-13 mb-2" id="statusModalTargetNote">Target: Selected orders</p>
                    <div class="form-group">
                        <label class="form-label">Select New Status</label>
                        <select name="order_status" id="order_status" class="form-select" required>
                            <option value="">Choose Order Status...</option>
                            @foreach ($orderstatuses as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Pathao Modal -->
<div class="modal fade" id="pathao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pathao Courier Dispatch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.order.pathao') }}" id="order_sendto_pathao">
                <div class="modal-body">
                    <input type="hidden" name="order_ids" id="orids">
                    <div class="form-group mb-2">
                        <label for="pathaostore" class="form-label">Store</label>
                        <select name="pathaostore" id="pathaostore" class="form-select">
                            <option value="">Select Store...</option>
                            @if (isset($pathaostore['data']['data']))
                                @foreach ($pathaostore['data']['data'] as $store)
                                    <option value="{{ $store['store_id'] }}">{{ $store['store_name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="pathaocity" class="form-label">City</label>
                        <select name="pathaocity" id="pathaocity" class="form-select">
                            <option value="">Select City...</option>
                            @if (isset($pathaocities['data']['data']))
                                @foreach ($pathaocities['data']['data'] as $city)
                                    <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Zone</label>
                        <select name="pathaozone" id="pathaozone" class="form-select pathaozone"></select>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Area</label>
                        <select name="pathaoarea" id="pathaoarea" class="form-select pathaoarea"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Dispatch to Pathao</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fraud Check Modal -->
<div class="modal fade" id="froudcheck" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">Fraud Report for: <span class="text-danger" id="cusnum"></span></h5>
                    <small class="text-muted">Invoice: #<span id="invnum"></span></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="auto-load text-center" style="display: none;">
                    <div class="spinner-border text-primary my-3" role="status"></div>
                </div>
                <div id="cuslist"></div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
@endsection

@section('script')
<script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>

<script>
    $(document).ready(function() {
        const totalFiltered = {{ $total_filtered }};
        const currentSlug = "{{ $slug }}";
        const csrfToken = $('#token').val();
        let isAllMatchingSelected = false;

        // Multi-Tick Dropdown Label Handler
        function updateMultiDropdownLabel($dropdown) {
            const defaultPlaceholder = $dropdown.data('placeholder') || 'Select options';
            const checked = $dropdown.find('input.filter-tick-check:checked');
            const $label = $dropdown.find('.dropdown-label');

            if (checked.length === 0) {
                $label.text(defaultPlaceholder).css('color', '#64748b').css('font-weight', '400');
            } else if (checked.length === 1) {
                const text = checked.closest('label').find('.filter-tick-text').text().trim();
                $label.text(text).css('color', '#0f172a').css('font-weight', '500');
            } else if (checked.length === 2) {
                const texts = checked.map(function() {
                    return $(this).closest('label').find('.filter-tick-text').text().trim();
                }).get();
                $label.text(texts.join(', ')).css('color', '#0f172a').css('font-weight', '500');
            } else {
                $label.text(checked.length + ' Selected').css('color', 'var(--primary)').css('font-weight', '600');
            }
        }

        // Initialize multi-tick dropdown labels on load
        $('.filter-multi-dropdown').each(function() {
            updateMultiDropdownLabel($(this));
        });

        // Update label whenever checkbox changes
        $(document).on('change', '.filter-multi-dropdown input.filter-tick-check', function() {
            const $dropdown = $(this).closest('.filter-multi-dropdown');
            updateMultiDropdownLabel($dropdown);
        });

        // Clear all checkboxes in a dropdown
        $(document).on('click', '.clear-filter-dropdown', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const $dropdown = $(this).closest('.filter-multi-dropdown');
            $dropdown.find('input.filter-tick-check').prop('checked', false);
            updateMultiDropdownLabel($dropdown);
        });

        // Initialize Select2 if any elements use it outside the filter
        if ($('.select2').length > 0) {
            $('.select2').select2({ width: '100%' });
        }

        // Toggle Filter Panel
        $('#toggleFilterBtn').on('click', function() {
            $('#filterPanel').slideToggle(200);
        });

        // Quick Date Presets
        $('.filter-preset-pill').on('click', function() {
            $('.filter-preset-pill').removeClass('active');
            $(this).addClass('active');

            const preset = $(this).data('preset');
            const today = new Date();
            const formatDate = (d) => d.toISOString().split('T')[0];

            if (preset === 'today') {
                const dateStr = formatDate(today);
                $('#filter_start_date').val(dateStr);
                $('#filter_end_date').val(dateStr);
            } else if (preset === 'yesterday') {
                const yest = new Date();
                yest.setDate(yest.getDate() - 1);
                const dateStr = formatDate(yest);
                $('#filter_start_date').val(dateStr);
                $('#filter_end_date').val(dateStr);
            } else if (preset === '7days') {
                const past7 = new Date();
                past7.setDate(past7.getDate() - 7);
                $('#filter_start_date').val(formatDate(past7));
                $('#filter_end_date').val(formatDate(today));
            } else if (preset === 'this_month') {
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                $('#filter_start_date').val(formatDate(firstDay));
                $('#filter_end_date').val(formatDate(today));
            } else if (preset === 'all') {
                $('#filter_start_date').val('');
                $('#filter_end_date').val('');
            }
        });

        // Smart Selection Logic
        function updateSelectionUI() {
            const checkedCount = $('input.checkbox:checked').length;
            const pageRowsCount = $('input.checkbox').length;

            if (isAllMatchingSelected) {
                $('#selectionCounter').removeClass('d-none');
                $('#selectionCountNum').text(totalFiltered + ' (All matching filter)');
                $('#selectionBanner').removeClass('d-none');
                $('#selectionBannerText').text('All ' + totalFiltered + ' orders matching current filter are selected.');
                $('#btnSelectAllMatching').addClass('d-none');
                $('#assignModalTargetNote').text('Target: All ' + totalFiltered + ' orders matching current filter');
                $('#statusModalTargetNote').text('Target: All ' + totalFiltered + ' orders matching current filter');
            } else if (checkedCount > 0) {
                $('#selectionCounter').removeClass('d-none');
                $('#selectionCountNum').text(checkedCount + ' selected');

                if (checkedCount === pageRowsCount && totalFiltered > pageRowsCount) {
                    $('#selectionBanner').removeClass('d-none');
                    $('#selectionBannerText').text('All ' + checkedCount + ' orders on this page are selected.');
                    $('#btnSelectAllMatching').removeClass('d-none').text('Select all ' + totalFiltered + ' orders matching current filter');
                } else {
                    $('#selectionBanner').addClass('d-none');
                }
                $('#assignModalTargetNote').text('Target: ' + checkedCount + ' selected orders');
                $('#statusModalTargetNote').text('Target: ' + checkedCount + ' selected orders');
            } else {
                $('#selectionCounter').addClass('d-none');
                $('#selectionBanner').addClass('d-none');
                $('#assignModalTargetNote').text('Target: Selected orders');
                $('#statusModalTargetNote').text('Target: Selected orders');
            }
        }

        // Header Checkbox Toggle
        $('.checkall').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('input.checkbox').prop('checked', isChecked);
            isAllMatchingSelected = false;
            updateSelectionUI();
        });

        // Individual Checkbox Change
        $(document).on('change', 'input.checkbox', function() {
            isAllMatchingSelected = false;
            const allChecked = $('input.checkbox:checked').length === $('input.checkbox').length;
            $('.checkall').prop('checked', allChecked);
            updateSelectionUI();
        });

        // Selection Variation Options
        $('#selOptionPage').on('click', function() {
            $('input.checkbox').prop('checked', true);
            $('.checkall').prop('checked', true);
            isAllMatchingSelected = false;
            updateSelectionUI();
        });

        $('#selOptionAll, #btnSelectAllMatching').on('click', function() {
            $('input.checkbox').prop('checked', true);
            $('.checkall').prop('checked', true);
            isAllMatchingSelected = true;
            updateSelectionUI();
        });

        $('#selOptionUnassigned').on('click', function() {
            isAllMatchingSelected = false;
            $('input.checkbox').prop('checked', false);
            $('tr[data-assigned="0"] input.checkbox').prop('checked', true);
            $('.checkall').prop('checked', false);
            updateSelectionUI();
        });

        $('#selOptionDue').on('click', function() {
            isAllMatchingSelected = false;
            $('input.checkbox').prop('checked', false);
            $('tr[data-due="1"] input.checkbox').prop('checked', true);
            $('.checkall').prop('checked', false);
            updateSelectionUI();
        });

        $('#selOptionClear, #btnClearBannerSelection').on('click', function() {
            $('input.checkbox').prop('checked', false);
            $('.checkall').prop('checked', false);
            isAllMatchingSelected = false;
            updateSelectionUI();
        });

        // Helper: Collect Selection and Filter Payload
        function getActionPayload() {
            const payload = {
                _token: csrfToken,
                slug: currentSlug
            };

            // Collect all current filter parameters (handles multi-select arrays and single values)
            const filterData = $('#advancedFilterForm').serializeArray();
            filterData.forEach(function(item) {
                if (!item.value) return;
                let key = item.name;
                const isArray = key.endsWith('[]');
                if (isArray) {
                    key = key.substring(0, key.length - 2);
                    if (!payload[key]) {
                        payload[key] = [item.value];
                    } else if (Array.isArray(payload[key])) {
                        payload[key].push(item.value);
                    } else {
                        payload[key] = [payload[key], item.value];
                    }
                } else {
                    payload[key] = item.value;
                }
            });

            if (isAllMatchingSelected) {
                payload.all_matching = 1;
            } else {
                const ids = $('input.checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                payload.order_ids = ids;
            }
            return payload;
        }

        // Export to CSV or Excel (.xlsx)
        $(document).on('click', '.btn-export-trigger', function(e) {
            e.preventDefault();
            const format = $(this).data('format') || 'xlsx';
            const payload = getActionPayload();
            payload.export_format = format;

            if (!isAllMatchingSelected && (!payload.order_ids || payload.order_ids.length === 0)) {
                // If nothing is selected, default to exporting all matching current filter
                payload.all_matching = 1;
            }

            // Create a temporary hidden form to initiate browser download
            const form = $('<form>', {
                action: "{{ route('admin.order.export') }}",
                method: 'POST',
                target: '_blank'
            });

            for (const key in payload) {
                if (Array.isArray(payload[key])) {
                    payload[key].forEach(function(val) {
                        form.append($('<input>', { type: 'hidden', name: key + '[]', value: val }));
                    });
                } else {
                    form.append($('<input>', { type: 'hidden', name: key, value: payload[key] }));
                }
            }
            $('body').append(form);
            form.submit();
            form.remove();
        });

        // Multi Print
        $(document).on('click', '.multi_order_print', function(e) {
            e.preventDefault();
            const payload = getActionPayload();

            if (!isAllMatchingSelected && (!payload.order_ids || payload.order_ids.length === 0)) {
                toastr.error('Please select at least one order to print!');
                return;
            }

            toastr.info('Preparing print invoices...');
            $.ajax({
                type: 'GET',
                url: "{{ route('admin.order.order_print') }}",
                data: payload,
                success: function(res) {
                    if (res.status === 'success') {
                        const printWindow = window.open("", "_blank");
                        printWindow.document.write(res.view);
                    } else {
                        toastr.error(res.message || 'Failed to generate print view');
                    }
                },
                error: function() {
                    toastr.error('Error generating print invoices');
                }
            });
        });

        // Assign User Submit
        $(document).on('submit', '#order_assign', function(e) {
            e.preventDefault();
            const payload = getActionPayload();
            payload.user_id = $('#user_id').val();

            if (!isAllMatchingSelected && (!payload.order_ids || payload.order_ids.length === 0)) {
                toastr.error('Please select at least one order first!');
                return;
            }

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.order.assign') }}",
                data: payload,
                success: function(res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        window.location.reload();
                    } else {
                        toastr.error(res.message || 'Failed to assign user');
                    }
                }
            });
        });

        // Order Status Change Submit
        $(document).on('submit', '#order_status_form', function(e) {
            e.preventDefault();
            const payload = getActionPayload();
            payload.order_status = $('#order_status').val();

            if (!isAllMatchingSelected && (!payload.order_ids || payload.order_ids.length === 0)) {
                toastr.error('Please select at least one order first!');
                return;
            }

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.order.status') }}",
                data: payload,
                success: function(res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        window.location.reload();
                    } else {
                        toastr.error(res.message || 'Failed to change order status');
                    }
                }
            });
        });

        // Bulk Delete
        $(document).on('click', '.order_delete', function(e) {
            e.preventDefault();
            const payload = getActionPayload();

            if (!isAllMatchingSelected && (!payload.order_ids || payload.order_ids.length === 0)) {
                toastr.error('Please select at least one order first!');
                return;
            }

            const confirmMsg = isAllMatchingSelected 
                ? 'Are you sure you want to delete ALL ' + totalFiltered + ' matching orders?'
                : 'Are you sure you want to delete the selected orders?';

            if (!confirm(confirmMsg)) return;

            $.ajax({
                type: 'GET',
                url: "{{ route('admin.order.bulk_destroy') }}",
                data: payload,
                success: function(res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        window.location.reload();
                    } else {
                        toastr.error(res.message || 'Failed to delete orders');
                    }
                }
            });
        });

        // Bulk Steadfast Courier
        $(document).on('click', '.multi_order_courier', function(e) {
            e.preventDefault();
            const payload = getActionPayload();
            payload.filter_slug = currentSlug;

            if (!isAllMatchingSelected && (!payload.order_ids || payload.order_ids.length === 0)) {
                toastr.error('Please select at least one order first!');
                return;
            }

            toastr.info('Sending orders to Steadfast courier...');
            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                data: payload,
                success: function(res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        window.location.reload();
                    } else {
                        toastr.error(res.message || 'Failed to place orders to Steadfast');
                    }
                }
            });
        });

        // Bulk Pathao Courier
        $(document).on('click', '.multi_pathao', function(e) {
            e.preventDefault();
            const payload = getActionPayload();
            payload.filter_slug = currentSlug;

            if (!isAllMatchingSelected && (!payload.order_ids || payload.order_ids.length === 0)) {
                toastr.error('Please select at least one order first!');
                return;
            }

            toastr.info('Sending orders to Pathao courier...');
            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                data: payload,
                success: function(res) {
                    if (res.status === 'success') {
                        toastr.success(res.message);
                        window.location.reload();
                    } else {
                        toastr.error(res.message || 'Failed to place orders to Pathao');
                    }
                }
            });
        });

        // Fraud Check
        $(document).on('click', '.checkfraud-btn', function(e) {
            e.preventDefault();
            const number = $(this).data('num');
            const inv = $(this).data('inv');
            $('#froudcheck').modal('show');
            $('#cuslist').empty();
            $('.auto-load').css('display', 'block');
            $('#cusnum').html(number);
            $('#invnum').html(inv);

            $.ajax({
                type: "GET",
                url: "https://supersalebd24.com/api/fraud-check-data",
                data: {
                    number: number,
                    _token: csrfToken
                },
                success: function(response) {
                    $('.auto-load').css('display', 'none');
                    $('#cuslist').empty().append(response);
                },
                error: function() {
                    $('.auto-load').css('display', 'none');
                    $('#cuslist').html('<p class="text-danger">Failed to retrieve fraud data.</p>');
                }
            });
        });

        // Pathao City / Zone Cascade
        $('.pathaocity').change(function() {
            const id = $(this).val();
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/pathao-city') }}?city_id=" + id,
                    success: function(res) {
                        if (res && res.data && res.data.data) {
                            $(".pathaozone").empty().append('<option value="">Select..</option>');
                            $.each(res.data.data, function(index, zone) {
                                $(".pathaozone").append('<option value="' + zone.zone_id + '">' + zone.zone_name + '</option>');
                            });
                        }
                    }
                });
            }
        });

        $('.pathaozone').change(function() {
            const id = $(this).val();
            if (id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/pathao-zone') }}?zone_id=" + id,
                    success: function(res) {
                        if (res && res.data && res.data.data) {
                            $(".pathaoarea").empty().append('<option value="">Select..</option>');
                            $.each(res.data.data, function(index, area) {
                                $(".pathaoarea").append('<option value="' + area.area_id + '">' + area.area_name + '</option>');
                            });
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
