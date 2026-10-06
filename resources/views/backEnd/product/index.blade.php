@extends('backEnd.layouts.master')
@section('title', 'Product Manage')
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h4 class="page-title mb-0">Product Management</h4>
                        <p class="text-muted mb-0 font-13">View, filter, and manage all your catalog products</p>
                    </div>
                    <div>
                        <a href="{{ route('products.create') }}" class="btn btn-success btn-rounded-modern">
                            <i class="fe-plus-circle"></i> Add New Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Toolbar & Filters -->
                        <div class="row align-items-center mb-3">
                            <div class="col-md-7 mb-2 mb-md-0">
                                <ul class="action2-btn mb-0">
                                    <li>
                                        <a href="{{ route('products.update_deals', ['status' => 1]) }}"
                                            class="btn btn-sm btn-outline-success hotdeal_update">
                                            <i class="fe-zap"></i> Set Deal
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('products.update_deals', ['status' => 0]) }}"
                                            class="btn btn-sm btn-outline-secondary hotdeal_update">
                                            <i class="fe-slash"></i> Remove Deal
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('products.update_status', ['status' => 1]) }}"
                                            class="btn btn-sm btn-outline-primary update_status">
                                            <i class="fe-check-circle"></i> Mark Active
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('products.update_status', ['status' => 0]) }}"
                                            class="btn btn-sm btn-outline-warning update_status">
                                            <i class="fe-x-circle"></i> Mark Inactive
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <form class="custom_form" method="GET" action="{{ route('products.index') }}">
                                    <div class="form-group">
                                        <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Search products...">
                                        <button type="submit" class="btn btn-primary"><i class="fe-search"></i> Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Product Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-centered w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input checkall" id="checkall">
                                                <label class="form-check-label" for="checkall"></label>
                                            </div>
                                        </th>
                                        <th style="width: 45px;">SL</th>
                                        <th style="width: 110px;">Action</th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $key => $value)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input checkbox" value="{{ $value->id }}" id="chk_{{ $value->id }}">
                                                    <label class="form-check-label" for="chk_{{ $value->id }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="custom-btn-list">
                                                    @if ($value->status == 1)
                                                        <form method="post" action="{{ route('products.inactive') }}" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" value="{{ $value->id }}" name="hidden_id">
                                                            <button type="button" class="change-confirm" title="Deactivate Product">
                                                                <i class="fe-eye-off text-warning"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="post" action="{{ route('products.active') }}" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" value="{{ $value->id }}" name="hidden_id">
                                                            <button type="button" class="change-confirm" title="Activate Product">
                                                                <i class="fe-eye text-success"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <a href="{{ route('products.edit', $value->id) }}" title="Edit Product">
                                                        <i class="fe-edit text-primary"></i>
                                                    </a>

                                                    <form method="post" action="{{ route('products.destroy') }}" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $value->id }}" name="hidden_id">
                                                        <button type="submit" class="delete-confirm" title="Delete Product">
                                                            <i class="fe-trash-2 text-danger"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $value->name }}</div>
                                                <small class="text-muted">ID: #{{ $value->id }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark font-12">
                                                    {{ $value->category ? $value->category->name : 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td>
                                                <img src="{{ asset($value->image ? $value->image->image : 'public/frontEnd/images/no-image.png') }}"
                                                    class="backend-image" alt="{{ $value->name }}" onerror="this.src='{{ asset('public/frontEnd/images/no-image.png') }}'">
                                            </td>
                                            <td>
                                                <div class="fw-bold text-primary font-14">৳{{ number_format($value->new_price, 0) }}</div>
                                                @if($value->old_price && $value->old_price > $value->new_price)
                                                    <small class="text-muted text-decoration-line-through">৳{{ number_format($value->old_price, 0) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($value->stock > 10)
                                                    <span class="badge bg-soft-success text-success">{{ $value->stock }} in stock</span>
                                                @elseif($value->stock > 0)
                                                    <span class="badge bg-soft-warning text-warning">{{ $value->stock }} low stock</span>
                                                @else
                                                    <span class="badge bg-soft-danger text-danger">Out of stock</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($value->status == 1)
                                                    <span class="badge-status badge-status-active">Active</span>
                                                @else
                                                    <span class="badge-status badge-status-inactive">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4 text-muted">No products found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="custom-paginate mt-3">
                            {{ $data->links('pagination::bootstrap-4') }}
                        </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".checkall").on('change', function() {
                $(".checkbox").prop('checked', $(this).is(":checked"));
            });

            $(document).on('click', '.hotdeal_update', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var product = $('input.checkbox:checked').map(function() {
                    return $(this).val();
                });
                var product_ids = product.get();
                if (product_ids.length == 0) {
                    toastr.error('Please Select A Product First !');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        product_ids
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });

            $(document).on('click', '.update_status', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var product = $('input.checkbox:checked').map(function() {
                    return $(this).val();
                });
                var product_ids = product.get();
                if (product_ids.length == 0) {
                    toastr.error('Please Select A Product First !');
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        product_ids
                    },
                    success: function(res) {
                        if (res.status == 'success') {
                            toastr.success(res.message);
                            window.location.reload();
                        } else {
                            toastr.error('Failed something wrong');
                        }
                    }
                });
            });
        });
    </script>
@endsection
