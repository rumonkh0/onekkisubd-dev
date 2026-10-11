@extends('backEnd.layouts.master')
@section('title', 'Deposit Manage')
@section('css')
    <link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
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
            .dt-buttons,
            .action-col {
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
                margin-bottom: 0 !important;
                padding: 0 !important;
            }
            .card-body {
                padding: 0 !important;
            }
            .print-header {
                display: block !important;
                margin-bottom: 18px !important;
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
            .badge {
                border: 1px solid #666 !important;
                color: #000 !important;
                background: transparent !important;
                font-weight: 600 !important;
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
                    <div class="page-title-right">
                        <a href="{{ route('deposit.create') }}" class="btn btn-primary rounded-pill">
                            <i class="fe-plus me-1"></i> Create Deposit
                        </a>
                    </div>
                    <h4 class="page-title">Deposit Manage</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Print Header -->
        <div class="print-header">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h2 class="m-0 fw-bold" style="color: #1e293b;">{{ $generalsetting->name ?? 'OnekkisuBD' }}</h2>
                    <h4 class="m-0 text-muted" style="font-size: 16px;">Deposit & Revenue Statement</h4>
                </div>
                <div class="text-end">
                    <p class="m-0 small text-muted">Generated On: <strong>{{ date('d M, Y h:i A') }}</strong></p>
                    <p class="m-0 small text-muted">Total Filtered: <strong>৳ {{ number_format($total_amount, 2) }}</strong> (Active: <strong>৳ {{ number_format($active_amount, 2) }}</strong>)</p>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 pt-2 border-top small text-muted">
                <span><strong>Date Range:</strong> {{ request('start_date') ? date('d M, Y', strtotime(request('start_date'))) : 'All Time' }} to {{ request('end_date') ? date('d M, Y', strtotime(request('end_date'))) : 'Present' }}</span>
                @if(request('deposit_type'))
                    <span>&bull; <strong>Type:</strong> @if(request('deposit_type') == 1) Courier @elseif(request('deposit_type') == 2) Office @else Others @endif</span>
                @endif
                @if(request('payment_type'))
                    <span>&bull; <strong>Method:</strong> @if(request('payment_type') == 1) Cash @elseif(request('payment_type') == 2) Bkash @elseif(request('payment_type') == 3) Nagad @elseif(request('payment_type') == 4) Rocket @endif</span>
                @endif
                @if(request('status') !== null && request('status') !== '')
                    <span>&bull; <strong>Status:</strong> {{ request('status') == 1 ? 'Active' : 'Inactive' }}</span>
                @endif
                <span>&bull; <strong>Total Records:</strong> {{ $total_count }}</span>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="row no-print mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form method="GET" action="{{ route('deposit.index') }}" class="row g-2 align-items-end">
                            <div class="col-md-2 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">Start Date</label>
                                <input type="date" class="form-control form-control-sm" name="start_date" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">End Date</label>
                                <input type="date" class="form-control form-control-sm" name="end_date" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">Deposit Type</label>
                                <select class="form-select form-select-sm" name="deposit_type">
                                    <option value="">All Types</option>
                                    <option value="1" {{ request('deposit_type') == '1' ? 'selected' : '' }}>Courier</option>
                                    <option value="2" {{ request('deposit_type') == '2' ? 'selected' : '' }}>Office</option>
                                    <option value="3" {{ request('deposit_type') == '3' ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">Payment Method</label>
                                <select class="form-select form-select-sm" name="payment_type">
                                    <option value="">All Methods</option>
                                    <option value="1" {{ request('payment_type') == '1' ? 'selected' : '' }}>Cash</option>
                                    <option value="2" {{ request('payment_type') == '2' ? 'selected' : '' }}>Bkash</option>
                                    <option value="3" {{ request('payment_type') == '3' ? 'selected' : '' }}>Nagad</option>
                                    <option value="4" {{ request('payment_type') == '4' ? 'selected' : '' }}>Rocket</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">Status</label>
                                <select class="form-select form-select-sm" name="status">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 d-flex gap-1">
                                <button type="submit" class="btn btn-sm btn-primary flex-grow-1" title="Filter Records">
                                    <i class="fe-filter me-1"></i> Filter
                                </button>
                                <a href="{{ route('deposit.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filters">
                                    <i class="fe-rotate-ccw"></i>
                                </a>
                                <button type="button" onclick="printReport()" class="btn btn-sm btn-success" title="Print Report">
                                    <i class="fe-printer me-1"></i> Print
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- summary widgets -->
        <div class="row no-print">
            <div class="col-md-4 col-xl-4">
                <div class="card widget-rounded-circle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                    <i class="fe-arrow-down-left font-22 avatar-title text-success"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">৳ {{ number_format($total_amount, 2) }}</h3>
                                    <p class="text-muted mb-1 text-truncate">
                                        Total Deposits
                                        @if(request()->filled('start_date') || request()->filled('end_date') || request()->filled('deposit_type') || request()->filled('payment_type') || request()->filled('status'))
                                            <span class="badge bg-soft-info text-info font-11">Filtered</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="card widget-rounded-circle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                    <i class="fe-check-circle font-22 avatar-title text-primary"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">৳ {{ number_format($active_amount, 2) }}</h3>
                                    <p class="text-muted mb-1 text-truncate">Active Deposits ({{ $active_count }})</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="card widget-rounded-circle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                    <i class="fe-database font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">{{ $total_count }}</h3>
                                    <p class="text-muted mb-1 text-truncate">Total Transactions</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Deposit Type</th>
                                    <th>Payment Type</th>
                                    <th>Receipt</th>
                                    <th>Status</th>
                                    <th class="action-col no-print">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->date ? date('d M, Y', strtotime($value->date)) : date('d M, Y', strtotime($value->created_at)) }}</td>
                                        <td><span class="fw-semibold text-dark">{{ $value->title }}</span></td>
                                        <td><span class="fw-bold text-success">৳ {{ number_format($value->amount, 2) }}</span></td>

                                        <td>
                                            @if ($value->deposit_type == 1)
                                                <span class="badge bg-soft-info text-info">Courier</span>
                                            @elseif ($value->deposit_type == 2)
                                                <span class="badge bg-soft-primary text-primary">Office</span>
                                            @elseif ($value->deposit_type == 3)
                                                <span class="badge bg-soft-secondary text-secondary">Others</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-secondary">N/A</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($value->payment_type == 1)
                                                <span class="badge bg-soft-success text-success">Cash</span>
                                            @elseif ($value->payment_type == 2)
                                                <span class="badge bg-soft-danger text-danger">Bkash</span>
                                            @elseif ($value->payment_type == 3)
                                                <span class="badge bg-soft-warning text-warning">Nagad</span>
                                            @elseif ($value->payment_type == 4)
                                                <span class="badge bg-soft-info text-info">Rocket</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-secondary">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->file && file_exists(public_path(str_replace('public/', '', $value->file))))
                                                <a href="{{ asset($value->file) }}" target="_blank" title="View Voucher">
                                                    <img src="{{ asset($value->file) }}" class="backend-image" alt="Receipt" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                </a>
                                            @elseif($value->file)
                                                <a href="{{ asset($value->file) }}" target="_blank" title="View Voucher">
                                                    <img src="{{ asset($value->file) }}" class="backend-image" alt="Receipt" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                </a>
                                            @else
                                                <span class="text-muted small">No file</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->status == 1)
                                                <span class="badge bg-soft-success text-success">Active</span>
                                            @else
                                                <span class="badge bg-soft-danger text-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="action-col no-print">
                                            <div class="button-list">
                                                <a href="{{ route('deposit.edit', $value->id) }}"
                                                    class="btn btn-xs btn-primary waves-effect waves-light" title="Edit"><i
                                                        class="fe-edit-1"></i></a>
                                                <form method="post" action="{{ route('deposit.destroy', $value->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-xs btn-danger waves-effect waves-light delete-confirm" title="Delete">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="tfoot-total">
                                    <th colspan="3" class="text-end fw-bold">Total Filtered:</th>
                                    <th class="fw-bold text-success">৳ {{ number_format($total_amount, 2) }}</th>
                                    <th colspan="4" class="fw-bold text-muted small">Active Sum: ৳ {{ number_format($active_amount, 2) }} ({{ $active_count }}/{{ $total_count }} active)</th>
                                    <th class="action-col no-print"></th>
                                </tr>
                            </tfoot>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
@endsection


@section('script')
    <!-- third party js -->
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js">
    </script>
    <script
        src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js">
    </script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js">
    </script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js">
    </script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
    <script src="{{ asset('/public/backEnd/') }}/assets/js/pages/datatables.init.js"></script>
    <!-- third party js ends -->

    <script>
        function printReport() {
            var table = $('#datatable-buttons').DataTable();
            var origLen = table.page.len();
            table.page.len(-1).draw();
            setTimeout(function() {
                window.print();
                setTimeout(function() {
                    table.page.len(origLen).draw();
                }, 500);
            }, 300);
        }
    </script>
@endsection
