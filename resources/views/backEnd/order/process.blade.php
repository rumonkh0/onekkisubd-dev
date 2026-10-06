@extends('backEnd.layouts.master')
@section('title', 'Process Order #' . $data->invoice_id)
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        .order-summary-box {
            background: var(--slate-50);
            border: 1px solid var(--slate-200);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
        }
        .order-summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13.5px;
        }
        .order-summary-item:last-child {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h4 class="page-title mb-0">Order Process [Invoice: #{{ $data->invoice_id }}]</h4>
                    <p class="text-muted mb-0 font-13">Update order status, delivery area, and shipping information</p>
                </div>
                <div>
                    <a href="{{ route('admin.orders', ['slug' => 'all']) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fe-arrow-left"></i> Back to Orders
                    </a>
                    <a href="{{ route('admin.order.invoice', ['invoice_id' => $data->invoice_id]) }}" class="btn btn-info btn-sm">
                        <i class="fe-printer"></i> View Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row justify-content-center">
        <!-- Products in Order -->
        <div class="col-lg-5 col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title m-0"><i class="fe-shopping-bag text-primary"></i> Order Items</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-centered m-0">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->orderdetails as $key => $product)
                                    <tr>
                                        <td style="width: 50px;">
                                            <img src="{{ asset($product->image ? $product->image->image : 'public/frontEnd/images/no-image.png') }}"
                                                 class="rounded border" height="45" width="45" alt="" onerror="this.src='{{ asset('public/frontEnd/images/no-image.png') }}'">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark font-13">{{ $product->product_name }}</div>
                                            <small class="text-muted">৳{{ $product->sale_price }} × {{ $product->qty }}</small>
                                        </td>
                                        <td>
                                            @if($product->product_size)
                                                <span class="badge bg-light text-dark font-11">Size: {{ $product->product_size }}</span>
                                            @endif
                                            @if($product->product_color)
                                                <span class="badge bg-light text-dark font-11">Color: {{ $product->product_color }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="order-summary-box">
                        <div class="order-summary-item">
                            <span class="text-muted">Order Date:</span>
                            <strong>{{ $data->created_at ? $data->created_at->format('d M, Y h:i A') : 'N/A' }}</strong>
                        </div>
                        <div class="order-summary-item">
                            <span class="text-muted">Order Type:</span>
                            <span class="badge bg-light text-dark">{{ $data->order_type }}</span>
                        </div>
                        <div class="order-summary-item">
                            <span class="text-muted">Total Amount:</span>
                            <strong class="text-primary font-15">৳{{ number_format($data->amount, 0) }}</strong>
                        </div>
                        @if($data->paid_partial_payment_amount)
                            <div class="order-summary-item">
                                <span class="text-muted">Paid Partial:</span>
                                <strong class="text-success">৳{{ number_format($data->paid_partial_payment_amount, 0) }}</strong>
                            </div>
                            <div class="order-summary-item">
                                <span class="text-muted">Due Balance:</span>
                                <strong class="text-danger">৳{{ number_format($data->amount - $data->paid_partial_payment_amount, 0) }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information & Processing Form -->
        <div class="col-lg-7 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title m-0"><i class="fe-edit text-success"></i> Customer & Fulfillment Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.order_change') }}" method="POST" class="row g-3" data-parsley-validate="" name="editForm">
                        @csrf
                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="col-md-6">
                            <label for="name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                value="{{ old('name', $data->shipping ? $data->shipping->name : '') }}" placeholder="Enter Customer Name">
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">Customer Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone"
                                value="{{ old('phone', $data->shipping ? $data->shipping->phone : '') }}" placeholder="Enter Phone Number">
                            @error('phone')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Customer Address</label>
                            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                placeholder="Full shipping address...">{{ old('address', $data->shipping ? $data->shipping->address : '') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="area" class="form-label">Delivery Area <span class="text-danger">*</span></label>
                            <select id="area" class="form-select @error('area') is-invalid @enderror" name="area" required>
                                <option value="">Select Delivery Area...</option>
                                @foreach($shippingcharge as $key => $value)
                                    <option @if(($data->shipping ? $data->shipping->area : '') == $value->name) selected @endif value="{{ $value->id }}">
                                        {{ $value->name }} (৳{{ $value->amount }})
                                    </option>
                                @endforeach
                            </select>
                            @error('area')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="order_status_select" class="form-label">Order Status <span class="text-danger">*</span></label>
                            <select id="order_status_select" class="form-select select2 @error('status') is-invalid @enderror" name="status" required>
                                <option value="">Select Status...</option>
                                @foreach($orderstatus as $value)
                                    <option value="{{ $value->id }}" @if($data->order_status == $value->id) selected @endif>
                                        {{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-12 mt-4 pt-2 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.orders', ['slug' => 'all']) }}" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fe-check me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection