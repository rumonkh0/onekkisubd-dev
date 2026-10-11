@extends('backEnd.layouts.master')
@section('title','Coupon Manage')

@section('css')
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">               
                <h4 class="page-title">Coupon Management</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Coupon Name</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Available</th>
                            <th>Validity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach ($coupons as $index => $coupon)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <td><span class="badge bg-primary fs-12">{{ $coupon->coupon_name }}</span></td>
                                <td>{{ $coupon->coupon_type == 1 ? 'Solid (Flat)' : 'Percentage' }}</td>
                                <td>{{ $coupon->amount }} {{ $coupon->coupon_type == 1 ? '৳' : '%' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $coupon->count > 0 ? 'bg-info' : 'bg-danger' }}">
                                        {{ $coupon->count ?? '0' }}
                                    </span>
                                </td>
                                <td>
                                    @if (\Carbon\Carbon::now()->startOfDay() <= \Carbon\Carbon::parse($coupon->validity)->endOfDay())
                                    <button type="button" class="btn btn-success btn-sm">
                                        {{ ceil(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($coupon->validity)->endOfDay(), false)) }} days remaining
                                    </button>                                    
                                    @else
                                    <button type="button" class="btn btn-warning btn-sm">
                                        Expired
                                    </button>
                                    @endif                                
                                </td>
                                <td>
                                    <a href="{{ route('delete.coupon' , $coupon->id) }}" onclick="return confirm('Are you sure you want to delete this coupon?')">
                                        <button type="button" class="btn btn-danger btn-icon btn-xs" title="Delete Coupon">
                                            <i width="18px" height="18px" data-feather="trash"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
    <div class="col-lg-5 col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Create New Coupon</h5>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="forms-sample" method="POST" action="{{ route('coupon.store') }}">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="name" class="form-label">Coupon Name *</label>
                        <input type="text" class="form-control @error('coupon_name') is-invalid @enderror" id="name" autocomplete="off" placeholder="e.g. DISCOUNT10" name="coupon_name" value="{{ old('coupon_name') }}" required>
                        @error('coupon_name')
                            <span class="text-danger fs-12">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-label">Coupon Type *</label>
                        <select class="form-select @error('coupon_type') is-invalid @enderror" name="coupon_type" required>
                            <option value="" disabled {{ old('coupon_type') ? '' : 'selected' }}>Select coupon type</option>
                            <option value="1" {{ old('coupon_type') == '1' ? 'selected' : '' }}>Solid (Flat ৳ Amount)</option>
                            <option value="2" {{ old('coupon_type') == '2' ? 'selected' : '' }}>Percentage (%)</option>
                        </select>
                        @error('coupon_type')
                            <span class="text-danger fs-12">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="amount" class="form-label">Discount Amount *</label>
                        <input type="number" step="any" min="1" class="form-control @error('amount') is-invalid @enderror" id="amount" autocomplete="off" placeholder="e.g. 50 (or 10 for 10%)" name="amount" value="{{ old('amount') }}" required>
                        @error('amount')
                            <span class="text-danger fs-12">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="quantity" class="form-label">Available Usage Quantity *</label>
                        <input type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" id="quantity" autocomplete="off" placeholder="Total number of times coupon can be used" name="quantity" value="{{ old('quantity', 100) }}" required>
                        @error('quantity')
                            <span class="text-danger fs-12">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="validity" class="form-label">Validity Expiry Date *</label>
                        <input type="date" class="form-control @error('validity') is-invalid @enderror" id="validity" name="validity" value="{{ old('validity') }}" required>
                        @error('validity')
                            <span class="text-danger fs-12">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fe-check-circle"></i> Create Coupon</button>
                </form>
            </div>
        </div>
    </div>
   </div>
</div>
@endsection


@section('script')
<!-- third party js -->
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/js/pages/datatables.init.js"></script>
<!-- third party js ends -->
@endsection