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
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('deposit.create') }}" class="btn btn-primary rounded-pill">Create</a>
                    </div>
                    <h4 class="page-title">Deposit Manage</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <!-- summary widgets -->
        <div class="row">
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
                                    <h3 class="text-dark mt-1">৳ {{ number_format($data->sum('amount'), 2) }}</h3>
                                    <p class="text-muted mb-1 text-truncate">Total Deposits</p>
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
                                    <h3 class="text-dark mt-1">৳ {{ number_format($data->where('status', 1)->sum('amount'), 2) }}</h3>
                                    <p class="text-muted mb-1 text-truncate">Active Deposits ({{ $data->where('status', 1)->count() }})</p>
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
                                    <h3 class="text-dark mt-1">{{ $data->count() }}</h3>
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
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
                                                    <img src="{{ asset($value->file) }}" class="backend-image" alt="Receipt" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                </a>
                                            @elseif($value->file)
                                                <a href="{{ asset($value->file) }}" target="_blank" title="View Voucher">
                                                    <img src="{{ asset($value->file) }}" class="backend-image" alt="Receipt" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
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
                                        <td>
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
@endsection
