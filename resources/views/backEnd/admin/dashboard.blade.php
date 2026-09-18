@extends('backEnd.layouts.master')
@section('title', 'Dashboard')
@section('css')
    <!-- Plugins css -->
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet"
        type="text/css" />
    <style>
        .card-bg {
            background: #f3f3f3;
        }
    </style>

@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="card">
            <div class="card-header">
                <h3>Accounts Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                            <i class="fe-dollar-sign font-22 avatar-title text-warning"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $account_balance }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Account Balance

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->
                </div>

                <form action="{{ route('deposit.filtering') }}" method="GET">
                    <div class="row mb-3">
                        <div class="col-sm-5"></div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" value="{{ request()->get('start_date') }}"
                                    class="form-control flatdate" name="start_date">
                            </div>
                        </div>
                        <!--col-sm-3-->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" value="{{ request()->get('end_date') }}" class="form-control flatdate"
                                    name="end_date">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="fe-credit-card font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $courier_payment }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Courier Payment

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                            <i class="fe-tag font-22 avatar-title text-success"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $officesale_payment }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Office Payment

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                            <i class="fe-pocket font-22 avatar-title text-warning"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $expense_others }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Others Payment

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="fe-dollar-sign font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $total_payment }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Total Payment

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->
                </div>
                <!-- end row-->

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                            <i class="fe-pocket font-22 avatar-title text-warning"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $boost_cost }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Boost Cost

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $office_cost }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Office Cost

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="fe-credit-card font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $bank_deposit }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Bank Deposit

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="fe-credit-card font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $packaging_cost }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Packaging Cost

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="fe-credit-card font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $transport_cost }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Transport Cost

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="fe-credit-card font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $others_expense_cost }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Others

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="fe-dollar-sign font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1">৳<span
                                                    data-plugin="counterup">{{ $total_cost }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Total Cost

                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->
                </div>
                <!-- end row-->
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Orders Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $total_order }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Total Order</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                            <i class="fe-shopping-bag font-22 avatar-title text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $today_order }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Today's Order</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="fe-database font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $total_product }}</span>
                                            </h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Products</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                            <i class="fe-user font-22 avatar-title text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $total_customer }}</span></h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Customer</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $pending_order }}</span></h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Pending Order</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $confirm_order }}</span></h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Processing Order</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-secondary border-secondary border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-secondary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $pre_order }}</span></h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Pre Order</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $shipped_courier }}</span></h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">In Courier</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $return_order }}</span></h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Return Order</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $delivery_done_order }}</span></h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Delivery Done</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card card-bg">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="avatar-lg rounded-circle bg-soft-warning border-warning border">
                                            <i class="fe-shopping-cart font-22 avatar-title text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="text-end">
                                            <h3 class="text-dark mt-1"><span
                                                    data-plugin="counterup">{{ $total_cancel_order }}</span></h3>
                                            <p class="text-dark fw-bold mb-1 text-truncate">Total Cancel Order</p>
                                        </div>
                                    </div>
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->
                </div>
                <!-- end row-->
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Inverntory Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($categories as $category)
                        <div class="col-md-6 col-xl-3">
                            <div class="widget-rounded-circle card card-bg">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                                <i class="fe-shopping-cart font-22 avatar-title text-primary"></i>
                                            </div>
                                        </div>

                                        <div class="col-8">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span
                                                        data-plugin="counterup">{{ $category->homeproducts->sum('stock') }}</span>
                                                    Pics
                                                </h3>
                                                <p class="text-dark fw-bold mb-1 text-truncate">{{ $category->name }}

                                                </p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div>
                            </div> <!-- end widget-rounded-circle-->
                        </div> <!-- end col-->
                    @endforeach
                </div>
                <!-- end row-->
            </div>
        </div>


        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>

                        <h4 class="header-title mb-3">Latest 5 Orders</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless table-hover table-nowrap table-centered m-0">

                                <thead class="table-light">
                                    <tr>
                                        <th colspan="2">Id</th>
                                        <th>Invoice</th>
                                        <th>Amount</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latest_order as $order)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td style="width: 36px;">
                                                <img src="{{ asset($order->product ? $order->product->image->image : '') }}"
                                                    alt="contact-img" title="contact-img"
                                                    class="rounded-circle avatar-sm" />
                                            </td>

                                            <td>
                                                {{ $order->invoice_id }}
                                            </td>

                                            <td>
                                                {{ $order->amount }}
                                            </td>

                                            <td>
                                                {{ $order->customer ? $order->customer->name : '' }}
                                            </td>
                                            <td>
                                                {{ $order->order_status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Edit Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>

                        <h4 class="header-title mb-3">Latest Customers</h4>

                        <div class="table-responsive">
                            <table class="table table-borderless table-nowrap table-hover table-centered m-0">

                                <thead class="table-light">
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latest_customer as $customer)
                                        <tr>
                                            <td>
                                                <h5 class="m-0 fw-normal">{{ $loop->iteration }}</h5>
                                            </td>

                                            <td>
                                                {{ $customer->name }}
                                            </td>

                                            <td>
                                                {{ $customer->phone }}
                                            </td>

                                            <td>
                                                {{ $customer->created_at->format('d-m-Y') }}
                                            </td>

                                            <td>
                                                {{ $customer->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end .table-responsive-->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
    <!-- Plugins js-->
    <script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/selectize/js/standalone/selectize.min.js"></script>

    <script>
        var colors = ["#f1556c"],
            dataColors = $("#total-revenue").data("colors");
        dataColors && (colors = dataColors.split(","));
        var options = {

                chart: {
                    height: 242,
                    type: "radialBar"
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: "65%"
                        }
                    }
                },
                colors: colors,
                labels: ["Delivery"]
            },
            chart = new ApexCharts(document.querySelector("#total-revenue"), options);
        chart.render();
        colors = ["#1abc9c", "#4a81d4"];
        (dataColors = $("#sales-analytics").data("colors")) && (colors = dataColors.split(","));
        options = {
            series: [{
                name: "Revenue",
                type: "column",
                data: [
                    @foreach ($monthly_sale as $sale)
                        {{ $sale->amount }},
                    @endforeach
                ]
            }, {
                name: "Sales",
                type: "line",
                data: [
                    @foreach ($monthly_sale as $sale)
                        {{ $sale->amount }},
                    @endforeach
                ]
            }],
            chart: {
                height: 378,
                type: "line",
            },
            stroke: {
                width: [2, 3]
            },
            plotOptions: {
                bar: {
                    columnWidth: "50%"
                }
            },
            colors: colors,
            dataLabels: {
                enabled: !0,
                enabledOnSeries: [1]
            },
            labels: [
                @foreach ($monthly_sale as $sale)
                    {{ date('d', strtotime($sale->date)) }} + '-' + {{ date('m', strtotime($sale->date)) }} +
                        '-' + {{ date('Y', strtotime($sale->date)) }},
                @endforeach
            ],
            legend: {
                offsetY: 7
            },
            grid: {
                padding: {
                    bottom: 20
                }
            },
            fill: {
                type: "gradient",
                gradient: {
                    shade: "light",
                    type: "horizontal",
                    shadeIntensity: .25,
                    gradientToColors: void 0,
                    inverseColors: !0,
                    opacityFrom: .75,
                    opacityTo: .75,
                    stops: [0, 0, 0]
                }
            },
            yaxis: [{
                title: {
                    text: "Net Revenue"
                }
            }]
        };
        (chart = new ApexCharts(document.querySelector("#sales-analytics"), options)).render(), $("#dash-daterange")
            .flatpickr({
                altInput: !0,
                mode: "range",
            });
    </script>
@endsection
