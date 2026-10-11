@extends('backEnd.layouts.master')
@section('title', 'Product Price & Stock Manage')
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('products.create') }}" class="btn btn-danger rounded-pill"><i class="fe-shopping-cart"></i> Add Product</a>
                </div>
                <h4 class="page-title">Product Price & Stock Manage</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 

    <!-- Filter & Search Card -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-body py-2">
                    <form action="{{ route('products.price_edit') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Search by product name..." value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">-- All Categories --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fe-search"></i> Filter</button>
                            @if(request('keyword') || request('category_id'))
                                <a href="{{ route('products.price_edit') }}" class="btn btn-secondary btn-sm"><i class="fe-refresh-cw"></i> Reset</a>
                            @endif
                        </div>
                        <div class="col-md-2 text-md-end text-muted fs-12">
                            Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('products.price_update') }}" method="POST">
                    @csrf
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted fs-13"><i class="fe-info"></i> Edit prices and stock below, then click <strong>Save & Update</strong>.</span>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fe-check-circle"></i> Save & Update Prices</button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;" class="text-center">SL</th>
                                        <th style="width: 35%;">Product Name</th>
                                        <th style="width: 15%;">Variant / Size</th>
                                        <th style="width: 15%;" class="text-center">Old / Regular Price (৳)</th>
                                        <th style="width: 15%;" class="text-center">New / Sale Price (৳)</th>
                                        <th style="width: 15%;" class="text-center">Stock (Qty)</th>
                                    </tr>
                                </thead>               
                                <tbody>
                                    @forelse($products as $key => $product)
                                        @if($product->prosizes && $product->prosizes->count() > 0)
                                            {{-- Variable Product: Row per variant --}}
                                            @foreach($product->prosizes as $sIndex => $size)
                                                <tr class="{{ $sIndex % 2 == 0 ? 'bg-light-subtle' : '' }}">
                                                    @if($sIndex == 0)
                                                        <td rowspan="{{ $product->prosizes->count() }}" class="text-center align-middle fw-bold">
                                                            {{ $products->firstItem() + $key }}
                                                        </td>
                                                        <td rowspan="{{ $product->prosizes->count() }}" class="align-middle">
                                                            <div class="fw-semibold text-dark">{{ $product->name }}</div>
                                                            <span class="badge bg-info-subtle text-info fs-11">Variable Product ({{ $product->prosizes->count() }} sizes)</span>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <input type="hidden" name="size_ids[]" value="{{ $size->id }}">
                                                        <span class="badge bg-primary fs-12 px-2 py-1"><i class="fe-tag"></i> {{ $size->size }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">৳</span>
                                                            <input type="number" step="any" min="0" class="form-control text-end" name="size_regular_price[]" value="{{ $size->RegularPrice }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">৳</span>
                                                            <input type="number" step="any" min="0" class="form-control text-end fw-bold text-success" name="size_sale_price[]" value="{{ $size->SalePrice }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" class="form-control form-control-sm text-end" name="size_quantity[]" value="{{ $size->quantity }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            {{-- Simple Product (No variants) --}}
                                            <tr>
                                                <td class="text-center fw-bold">{{ $products->firstItem() + $key }}</td>
                                                <td>
                                                    <input type="hidden" name="ids[]" value="{{ $product->id }}">
                                                    <div class="fw-semibold text-dark">{{ $product->name }}</div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary-subtle text-secondary fs-11">Default</span>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">৳</span>
                                                        <input type="number" step="any" min="0" class="form-control text-end" name="old_price[]" value="{{ $product->old_price }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text">৳</span>
                                                        <input type="number" step="any" min="0" class="form-control text-end fw-bold text-success" name="new_price[]" value="{{ $product->new_price }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" class="form-control form-control-sm text-end" name="stock[]" value="{{ $product->stock }}">
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="fe-alert-circle fs-24 d-block mb-1"></i>
                                                No active products found matching your search.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card body-->
                    <div class="card-footer bg-light d-flex justify-content-between align-items-center py-2">
                        <div>
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fe-check-circle"></i> Save & Update Prices</button>
                    </div>
                </form>
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
@endsection