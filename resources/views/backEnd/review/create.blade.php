@extends('backEnd.layouts.master')
@section('title', 'Review Create')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('reviews.index') }}" class="btn btn-primary rounded-pill">
                            <i class="fe-list me-1"></i> Manage Reviews
                        </a>
                    </div>
                    <h4 class="page-title">Create Customer Review</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('reviews.store') }}" method="POST" class="row" enctype="multipart/form-data">
                            @csrf

                            <!-- Product Selection -->
                            <div class="col-md-6 col-12 mb-3">
                                <label for="product_id" class="form-label fw-semibold">Product <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error('product_id') is-invalid @enderror"
                                    name="product_id" id="product_id" required>
                                    <option value="">Choose Product...</option>
                                    @foreach ($products as $value)
                                        <option value="{{ $value->id }}" {{ old('product_id') == $value->id ? 'selected' : '' }}>
                                            {{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Optional Customer Select -->
                            <div class="col-md-6 col-12 mb-3">
                                <label for="customer_id" class="form-label fw-semibold">Existing Customer (Optional)</label>
                                <select class="form-control select2" name="customer_id" id="customer_id" onchange="autoFillCustomer(this)">
                                    <option value="">Select Existing Customer to Autofill...</option>
                                    @foreach ($customers as $cust)
                                        <option value="{{ $cust->id }}" data-name="{{ $cust->name }}" data-email="{{ $cust->email }}">
                                            {{ $cust->name }} ({{ $cust->phone ?: $cust->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Customer Name -->
                            <div class="col-md-6 col-12 mb-3">
                                <label for="name" class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="customer_name_input" value="{{ old('name') }}" placeholder="Enter reviewer name" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Customer Email -->
                            <div class="col-md-6 col-12 mb-3">
                                <label for="email" class="form-label fw-semibold">Customer Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="customer_email_input" value="{{ old('email') }}" placeholder="customer@example.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Rating -->
                            <div class="col-md-6 col-12 mb-3">
                                <label for="ratting" class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                                <select class="form-select @error('ratting') is-invalid @enderror" name="ratting" id="ratting" required>
                                    <option value="">Select Rating Stars...</option>
                                    <option value="5" {{ old('ratting', '5') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars (Excellent)</option>
                                    <option value="4" {{ old('ratting') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Stars (Very Good)</option>
                                    <option value="3" {{ old('ratting') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 Stars (Average)</option>
                                    <option value="2" {{ old('ratting') == '2' ? 'selected' : '' }}>⭐⭐ 2 Stars (Below Average)</option>
                                    <option value="1" {{ old('ratting') == '1' ? 'selected' : '' }}>⭐ 1 Star (Poor)</option>
                                </select>
                                @error('ratting')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="col-md-6 col-12 mb-3">
                                <label for="image" class="form-label fw-semibold">Customer Photo / Attachment</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="image_preview_box" class="mt-2 d-none">
                                    <img id="image_preview" src="" alt="Preview" style="max-height: 80px; border-radius: 6px; border: 1px solid #dee2e6;">
                                </div>
                            </div>

                            <!-- Review Text -->
                            <div class="col-12 mb-3">
                                <label for="review" class="form-label fw-semibold">Review Text <span class="text-danger">*</span></label>
                                <textarea name="review" id="review" rows="4" class="form-control @error('review') is-invalid @enderror" placeholder="Write the customer's feedback or testimonial..." required>{{ old('review') }}</textarea>
                                @error('review')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 col-12 mb-3">
                                <label for="status" class="form-label fw-semibold d-block">Status (Active = Visible on Store)</label>
                                <label class="switch">
                                    <input type="checkbox" value="1" name="status" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 pt-2 border-top">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fe-check me-1"></i> Submit Review
                                </button>
                                <a href="{{ route('reviews.index') }}" class="btn btn-secondary ms-1">Cancel</a>
                            </div>

                        </form>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        function autoFillCustomer(select) {
            var selectedOption = select.options[select.selectedIndex];
            var name = selectedOption.getAttribute('data-name');
            var email = selectedOption.getAttribute('data-email');
            if (name) {
                document.getElementById('customer_name_input').value = name;
            }
            if (email) {
                document.getElementById('customer_email_input').value = email;
            }
        }

        function previewImage(input) {
            var box = document.getElementById('image_preview_box');
            var img = document.getElementById('image_preview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    box.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                box.classList.add('d-none');
            }
        }
    </script>
@endsection
