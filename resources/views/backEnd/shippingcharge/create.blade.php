@extends('backEnd.layouts.master') 
@section('title','Shipping Charge Create') 
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('shippingcharges.index') }}" class="btn btn-primary rounded-pill">
                        <i class="fe-list me-1"></i> Manage Shipping Charges
                    </a>
                </div>
                <h4 class="page-title">Create Shipping Charge</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shippingcharges.store') }}" method="POST" class="row">
                        @csrf                        
                        <div class="col-md-6 col-12 mb-3">
                            <label for="name" class="form-label fw-semibold">Delivery Area / Zone Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" placeholder="e.g. Inside Dhaka, Outside Dhaka" required />
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="amount" class="form-label fw-semibold">Delivery Charge Amount (৳) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number" step="any" min="0" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" id="amount" placeholder="e.g. 120" required />
                            </div>
                            @error('amount')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label for="status" class="d-block form-label fw-semibold">Status (Active = Available on Checkout)</label>
                            <label class="switch">
                                <input type="checkbox" value="1" name="status" {{ old('status', '1') == '1' ? 'checked' : '' }} />
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="col-12 pt-2 border-top">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fe-check me-1"></i> Save Shipping Charge
                            </button>
                            <a href="{{ route('shippingcharges.index') }}" class="btn btn-secondary ms-1">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
</div>
@endsection 
