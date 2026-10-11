@extends('backEnd.layouts.master')
@section('title', 'Pending Reviews')
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
                    <div class="page-title-right d-flex gap-2">
                        <a href="{{ route('reviews.index') }}" class="btn btn-outline-primary rounded-pill">
                            <i class="fe-list me-1"></i> All Reviews
                        </a>
                        <a href="{{ route('reviews.create') }}" class="btn btn-primary rounded-pill">
                            <i class="fe-plus me-1"></i> Create Review
                        </a>
                    </div>
                    <h4 class="page-title">Pending Reviews (Moderation Queue)</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @if($data->count() == 0)
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-3">
                <i class="fe-check-circle font-22 me-2"></i>
                <div>
                    <strong>All Caught Up!</strong> There are no pending reviews requiring moderation at this time.
                </div>
            </div>
        @else
            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-3">
                <i class="fe-alert-triangle font-22 me-2"></i>
                <div>
                    <strong>{{ $data->count() }} Customer {{ Str::plural('Review', $data->count()) }} Waiting:</strong>
                    Review and approve customer feedback before it is published on the storefront.
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Photo</th>
                                    <th>Submitted Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($value->product)
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($value->product->image && $value->product->image->image)
                                                        <img src="{{ asset($value->product->image->image) }}" alt="Product" style="width: 34px; height: 34px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                    @endif
                                                    <div>
                                                        <a href="{{ route('products.edit', $value->product->id) }}" class="fw-semibold text-dark text-truncate d-inline-block" style="max-width: 170px;" title="{{ $value->product->name }}">
                                                            {{ $value->product->name }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted small">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $value->name }}</div>
                                            <small class="text-muted">{{ $value->email ?: 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <div class="text-warning font-14">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $value->ratting)
                                                        <i class="mdi mdi-star"></i>
                                                    @else
                                                        <i class="mdi mdi-star-outline text-muted"></i>
                                                    @endif
                                                @endfor
                                                <span class="badge bg-soft-warning text-dark font-11 ms-1">{{ $value->ratting }}★</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span title="{{ $value->review }}" style="max-width: 220px; display: inline-block; white-space: normal;">
                                                {{ Str::limit($value->review, 70) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($value->image && file_exists(public_path(str_replace('public/', '', $value->image))))
                                                <a href="{{ asset($value->image) }}" target="_blank" title="View Attachment">
                                                    <img src="{{ asset($value->image) }}" alt="Attachment" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                </a>
                                            @elseif($value->image)
                                                <a href="{{ asset($value->image) }}" target="_blank" title="View Attachment">
                                                    <img src="{{ asset($value->image) }}" alt="Attachment" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                </a>
                                            @else
                                                <span class="text-muted small">No photo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $value->created_at ? date('d M, Y', strtotime($value->created_at)) : 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <div class="button-list">
                                                <form method="post" action="{{ route('reviews.active') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" value="{{ $value->id }}" name="hidden_id">
                                                    <button type="submit" class="btn btn-xs btn-success waves-effect waves-light" title="Approve & Publish">
                                                        <i class="fe-check me-1"></i> Approve
                                                    </button>
                                                </form>

                                                <a href="{{ route('reviews.edit', $value->id) }}"
                                                    class="btn btn-xs btn-primary waves-effect waves-light" title="Edit">
                                                    <i class="fe-edit-1"></i>
                                                </a>

                                                <form method="post" action="{{ route('reviews.destroy') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" value="{{ $value->id }}" name="hidden_id">
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