@extends('frontEnd.layouts.master')
@section('title', 'প্রোফাইল পরিবর্তন | Edit Profile')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CUSTOMER PROFILE EDIT STYLES
       ======================================================== */
    .tea-account-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.06) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-account-container {
        max-width: 1140px;
        margin: 0 auto;
    }

    /* Breadcrumb */
    .tea-account-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 24px;
    }
    .tea-account-breadcrumb a {
        color: #173f2c;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .tea-account-breadcrumb a:hover {
        color: #cdb06a;
    }
    .tea-account-breadcrumb i {
        font-size: 11px;
        color: #9ca3af;
    }

    /* Main Content Card */
    .tea-profile-main-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 12px 32px -10px rgba(10, 33, 27, 0.06);
        overflow: hidden;
    }
    .tea-card-top-strip {
        height: 4px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }

    /* Header */
    .tea-profile-header {
        padding: 24px 28px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
    }
    .tea-profile-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-profile-title i {
        color: #245a2d;
    }
    .tea-profile-subtitle {
        font-size: 13.5px;
        color: #6b7280;
        margin: 0;
    }

    /* Form Body */
    .tea-profile-body {
        padding: 28px;
    }
    .tea-form-group {
        margin-bottom: 20px;
        position: relative;
    }
    .tea-form-label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 7px;
    }
    .tea-form-label .sub-en {
        font-size: 12px;
        color: #9ca3af;
        font-weight: 400;
    }
    .tea-input-ctrl {
        width: 100%;
        height: 48px;
        padding: 0 16px;
        font-size: 14.5px;
        color: #111827;
        background: #fbfbfb;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.22s ease;
        font-family: inherit;
    }
    .tea-input-ctrl:focus {
        border-color: #245a2d;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(36, 90, 45, 0.12);
        outline: none;
    }

    /* Avatar Upload */
    .tea-avatar-upload-box {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 16px;
        background: #fbfbf9;
        border: 1.5px dashed #d1d5db;
        border-radius: 16px;
        margin-top: 6px;
    }
    .tea-current-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2cf9c;
        flex-shrink: 0;
    }
    .tea-avatar-file-input {
        font-size: 13.5px;
        color: #4b5563;
    }

    /* Select2 overrides */
    .select2-container--default .select2-selection--single {
        height: 48px !important;
        border: 1.5px solid #e5e7eb !important;
        border-radius: 12px !important;
        background: #fbfbfb !important;
        display: flex !important;
        align-items: center !important;
        padding: 0 8px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 46px !important;
        font-size: 14.5px !important;
        color: #111827 !important;
        padding-left: 6px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px !important;
        right: 12px !important;
    }

    /* Submit CTA */
    .tea-btn-save {
        height: 50px;
        padding: 0 32px;
        background: linear-gradient(135deg, #173f2c 0%, #245a2d 100%);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 15.5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(23, 63, 44, 0.22);
        transition: all 0.25s ease;
    }
    .tea-btn-save:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        transform: translateY(-2px);
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(23, 63, 44, 0.3);
    }

    .tea-invalid-feedback {
        display: block;
        margin-top: 6px;
        font-size: 12.5px;
        color: #dc2626;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .tea-account-page {
            padding: 20px 12px 60px;
        }
        .tea-profile-header {
            padding: 20px 18px;
        }
        .tea-profile-body {
            padding: 20px 18px;
        }
    }
</style>

<div class="tea-account-page">
    <div class="tea-account-container">
        <!-- Breadcrumb -->
        <div class="tea-account-breadcrumb">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('customer.account') }}">অ্যাকাউন্ট</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>প্রোফাইল পরিবর্তন</span>
        </div>

        <div class="row">
            <!-- Left Column: Customer Sidebar -->
            <div class="col-lg-4 col-md-5">
                @include('frontEnd.layouts.customer.sidebar')
            </div>

            <!-- Right Column: Profile Edit Form -->
            <div class="col-lg-8 col-md-7">
                <div class="tea-profile-main-card">
                    <div class="tea-card-top-strip"></div>

                    <!-- Header -->
                    <div class="tea-profile-header">
                        <h2 class="tea-profile-title">
                            <i class="fa-solid fa-user-pen"></i> প্রোফাইল তথ্য পরিবর্তন
                        </h2>
                        <p class="tea-profile-subtitle">আপনার ব্যক্তিগত নাম, যোগাযোগ ও ডেলিভারি ঠিকানা আপডেট করুন</p>
                    </div>

                    <!-- Form Body -->
                    <div class="tea-profile-body">
                        <form action="{{ route('customer.profile_update') }}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="" id="customer_profile_form">
                            @csrf

                            <!-- Full Name -->
                            <div class="col-md-6">
                                <div class="tea-form-group">
                                    <label for="name" class="tea-form-label">
                                        পূর্ণ নাম <span class="sub-en">(Full Name)</span> <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           class="tea-input-ctrl @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ $profile_edit->name }}" 
                                           required 
                                           data-parsley-required-message="আপনার নাম লিখুন">
                                    @error('name')
                                        <span class="tea-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6">
                                <div class="tea-form-group">
                                    <label for="phone" class="tea-form-label">
                                        মোবাইল নম্বর <span class="sub-en">(Phone Number)</span> <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           id="phone" 
                                           class="tea-input-ctrl @error('phone') is-invalid @enderror" 
                                           name="phone" 
                                           value="{{ $profile_edit->phone }}" 
                                           required 
                                           data-parsley-required-message="মোবাইল নম্বর লিখুন">
                                    @error('phone')
                                        <span class="tea-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="tea-form-group">
                                    <label for="email" class="tea-form-label">
                                        ইমেইল ঠিকানা <span class="sub-en">(Email Address)</span> <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           class="tea-input-ctrl @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ $profile_edit->email }}" 
                                           required 
                                           data-parsley-required-message="সঠিক ইমেইল লিখুন">
                                    @error('email')
                                        <span class="tea-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-md-6">
                                <div class="tea-form-group">
                                    <label for="address" class="tea-form-label">
                                        ডেলিভারি ঠিকানা <span class="sub-en">(Address)</span> <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="address" 
                                           class="tea-input-ctrl @error('address') is-invalid @enderror" 
                                           name="address" 
                                           value="{{ $profile_edit->address }}" 
                                           required 
                                           data-parsley-required-message="ডেলিভারি ঠিকানা দিন">
                                    @error('address')
                                        <span class="tea-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- District -->
                            <div class="col-md-6">
                                <div class="tea-form-group">
                                    <label for="district" class="tea-form-label">
                                        জেলা <span class="sub-en">(District)</span> <span class="text-danger">*</span>
                                    </label>
                                    <select id="district" class="tea-input-ctrl select2 district @error('district') is-invalid @enderror" name="district" required>
                                        <option value="">জেলা নির্বাচন করুন...</option>
                                        @foreach($districts as $key => $district)
                                            <option value="{{ $district->district }}" @if($profile_edit->district == $district->district) selected @endif>
                                                {{ $district->district }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district')
                                        <span class="tea-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Area -->
                            <div class="col-md-6">
                                <div class="tea-form-group">
                                    <label for="area" class="tea-form-label">
                                        এরিয়া / জোন <span class="sub-en">(Area)</span> <span class="text-danger">*</span>
                                    </label>
                                    <select id="area" class="tea-input-ctrl area select2 @error('area') is-invalid @enderror" name="area" required>
                                        <option value="">এরিয়া নির্বাচন করুন...</option>
                                        @foreach($areas as $key => $area)
                                            <option value="{{ $area->id }}" @if($profile_edit->area == $area->id) selected @endif>
                                                {{ $area->area_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('area')
                                        <span class="tea-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Avatar Upload -->
                            <div class="col-12">
                                <div class="tea-form-group">
                                    <label class="tea-form-label">
                                        প্রোফাইল ছবি <span class="sub-en">(Profile Photo)</span>
                                    </label>
                                    <div class="tea-avatar-upload-box">
                                        @if(!empty($profile_edit->image) && file_exists(public_path($profile_edit->image)))
                                            <img src="{{ asset($profile_edit->image) }}" alt="Avatar" class="tea-current-avatar">
                                        @else
                                            <img src="{{ asset('public/frontEnd/images/avatar.png') }}" onerror="this.src='{{ asset('public/uploads/settings/1740644407-onekkisu.webp') }}'" alt="Avatar" class="tea-current-avatar">
                                        @endif
                                        <div>
                                            <input type="file" id="image" class="tea-avatar-file-input @error('image') is-invalid @enderror" name="image">
                                            <small class="d-block text-muted mt-1">সুপারিশকৃত সাইজ: ৩০০ × ৩০০ পিক্সেল (JPG, PNG, WebP)</small>
                                        </div>
                                    </div>
                                    @error('image')
                                        <span class="tea-invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 mt-2">
                                <button type="submit" class="tea-btn-save">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>প্রোফাইল আপডেট করুন</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%'
        });
    });

    $('.district').on('change', function() {
        var id = $(this).val();
        $.ajax({
            type: "GET",
            data: { 'id': id },
            url: "{{ route('districts') }}",
            success: function(res) {               
                if (res) {
                    $(".area").empty();
                    $(".area").append('<option value="">এরিয়া নির্বাচন করুন..</option>');
                    $.each(res, function(key, value) {
                        $(".area").append('<option value="' + key + '">' + value + '</option>');
                    });
                } else {
                    $(".area").empty();
                }
            }
        });  
    });
</script>
@endpush