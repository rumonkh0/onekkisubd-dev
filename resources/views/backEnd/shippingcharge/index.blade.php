@extends('backEnd.layouts.master') 
@section('title','Shipping Charge Manage') 
@section('css')
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection 

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('shippingcharges.create') }}" class="btn btn-primary rounded-pill">
                        <i class="fe-plus me-1"></i> Create Shipping Charge
                    </a>
                </div>
                <h4 class="page-title">Shipping Charges & Delivery Zones</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- summary stat widgets -->
    <div class="row">
        <div class="col-md-4 col-xl-4">
            <div class="card widget-rounded-circle">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                <i class="fe-truck font-22 avatar-title text-primary"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">{{ $total_charges }}</h3>
                                <p class="text-muted mb-1 text-truncate">Total Shipping Zones</p>
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
                            <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                                <i class="fe-check-circle font-22 avatar-title text-success"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">{{ $active_charges }}</h3>
                                <p class="text-muted mb-1 text-truncate">Active Delivery Zones</p>
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
                            <div class="avatar-lg rounded-circle bg-soft-secondary border-secondary border">
                                <i class="fe-pause-circle font-22 avatar-title text-secondary"></i>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="text-end">
                                <h3 class="text-dark mt-1">{{ $inactive_charges }}</h3>
                                <p class="text-muted mb-1 text-truncate">Inactive Zones</p>
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
                                <th style="width: 80px;">SL</th>
                                <th>Delivery Area / Zone</th>
                                <th>Shipping Charge (৳)</th>
                                <th>Status</th>
                                <th style="width: 130px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($show_data as $key=>$value)
                            <tr style="vertical-align: middle;">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">
                                        <i class="fe-map-pin text-primary me-1"></i> {{ $value->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold font-16 text-success">
                                        ৳ {{ number_format($value->amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    @if($value->status == 1)
                                        <span class="badge bg-soft-success text-success">Active</span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="button-list">
                                        @if($value->status == 1)
                                        <form method="post" action="{{ route('shippingcharges.inactive') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" value="{{ $value->id }}" name="hidden_id" />
                                            <button type="submit" class="btn btn-xs btn-secondary waves-effect waves-light" title="Deactivate Zone">
                                                <i class="fe-thumbs-down"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form method="post" action="{{ route('shippingcharges.active') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" value="{{ $value->id }}" name="hidden_id" />
                                            <button type="submit" class="btn btn-xs btn-success waves-effect waves-light" title="Activate Zone">
                                                <i class="fe-thumbs-up"></i>
                                            </button>
                                        </form>
                                        @endif

                                        <a href="{{ route('shippingcharges.edit', $value->id) }}" class="btn btn-xs btn-primary waves-effect waves-light" title="Edit">
                                            <i class="fe-edit-1"></i>
                                        </a>

                                        <form method="post" action="{{ route('shippingcharges.destroy') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" value="{{ $value->id }}" name="hidden_id" />
                                            <button type="submit" class="btn btn-xs btn-danger waves-effect waves-light delete-confirm" title="Delete">
                                                <i class="mdi mdi-close"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->
    </div>
</div>
@endsection 

@section('script')
<!-- third party js -->
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/js/pages/datatables.init.js"></script>
<!-- third party js ends -->
@endsection
