@extends('backEnd.layouts.master')
@section('title', 'All Reviews')
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
                        @if($pending_reviews > 0)
                            <a href="{{ route('reviews.pending') }}" class="btn btn-warning rounded-pill">
                                <i class="fe-clock me-1"></i> Pending Reviews ({{ $pending_reviews }})
                            </a>
                        @endif
                        <a href="{{ route('reviews.create') }}" class="btn btn-primary rounded-pill">
                            <i class="fe-plus me-1"></i> Create Review
                        </a>
                    </div>
                    <h4 class="page-title">All Customer Reviews</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- summary stat widgets -->
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="card widget-rounded-circle">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                    <i class="fe-message-square font-22 avatar-title text-primary"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">{{ $total_reviews }}</h3>
                                    <p class="text-muted mb-1 text-truncate">Total Reviews</p>
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
                                    <i class="fe-check-circle font-22 avatar-title text-success"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">{{ $active_reviews }}</h3>
                                    <p class="text-muted mb-1 text-truncate">Active / Approved</p>
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
                                    <i class="fe-clock font-22 avatar-title text-warning"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">{{ $pending_reviews }}</h3>
                                    <p class="text-muted mb-1 text-truncate">Pending Moderation</p>
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
                                    <i class="fe-star font-22 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="text-end">
                                    <h3 class="text-dark mt-1">{{ number_format($avg_rating, 1) }} / 5</h3>
                                    <p class="text-muted mb-1 text-truncate">Average Rating</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3">
                        <form method="GET" action="{{ route('reviews.index') }}" class="row g-2 align-items-end">
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">Product</label>
                                <select class="form-select form-select-sm" name="product_id">
                                    <option value="">All Products</option>
                                    @foreach($products as $prod)
                                        <option value="{{ $prod->id }}" {{ request('product_id') == $prod->id ? 'selected' : '' }}>
                                            {{ Str::limit($prod->name, 40) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">Status</label>
                                <select class="form-select form-select-sm" name="status">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">Rating</label>
                                <select class="form-select form-select-sm" name="ratting">
                                    <option value="">All Ratings</option>
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}" {{ request('ratting') == $i ? 'selected' : '' }}>
                                            {{ $i }} Stars (★)
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label class="form-label font-13 fw-semibold mb-1">Search Keyword</label>
                                <input type="text" class="form-control form-control-sm" name="keyword" value="{{ request('keyword') }}" placeholder="Customer name, email or review text...">
                            </div>
                            <div class="col-md-2 col-sm-6 d-flex gap-1">
                                <button type="submit" class="btn btn-sm btn-primary flex-grow-1" title="Filter Records">
                                    <i class="fe-filter me-1"></i> Filter
                                </button>
                                <a href="{{ route('reviews.index') }}" class="btn btn-sm btn-outline-secondary" title="Reset Filters">
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
                        <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($show_data as $key => $value)
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
                                            <span title="{{ $value->review }}" style="max-width: 200px; display: inline-block; white-space: normal;">
                                                {{ Str::limit($value->review, 60) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($value->image && file_exists(public_path(str_replace('public/', '', $value->image))))
                                                <a href="{{ asset($value->image) }}" target="_blank" title="View Attachment">
                                                    <img src="{{ asset($value->image) }}" alt="Review Attachment" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                </a>
                                            @elseif($value->image)
                                                <a href="{{ asset($value->image) }}" target="_blank" title="View Attachment">
                                                    <img src="{{ asset($value->image) }}" alt="Review Attachment" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6;">
                                                </a>
                                            @else
                                                <span class="text-muted small">No photo</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->status == 'active')
                                                <span class="badge bg-soft-success text-success">Active</span>
                                            @else
                                                <span class="badge bg-soft-warning text-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $value->created_at ? date('d M, Y', strtotime($value->created_at)) : 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <div class="button-list">
                                                @if ($value->status == 'active')
                                                    <form method="post" action="{{ route('reviews.inactive') }}" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $value->id }}" name="hidden_id">
                                                        <button type="submit" class="btn btn-xs btn-secondary waves-effect waves-light" title="Set to Pending">
                                                            <i class="fe-thumbs-down"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form method="post" action="{{ route('reviews.active') }}" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $value->id }}" name="hidden_id">
                                                        <button type="submit" class="btn btn-xs btn-success waves-effect waves-light" title="Approve Review">
                                                            <i class="fe-thumbs-up"></i>
                                                        </button>
                                                    </form>
                                                @endif

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
