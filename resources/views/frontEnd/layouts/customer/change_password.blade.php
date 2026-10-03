@extends('frontEnd.layouts.master')
@section('title', 'পাসওয়ার্ড পরিবর্তন | Change Password')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CUSTOMER CHANGE PASSWORD STYLES
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
    .tea-pass-main-card {
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
    .tea-pass-header {
        padding: 24px 28px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
    }
    .tea-pass-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .tea-pass-title i {
        color: #245a2d;
    }
    .tea-pass-subtitle {
        font-size: 13.5px;
        color: #6b7280;
        margin: 0;
    }

    /* Form Body */
    .tea-pass-body {
        padding: 28px;
        max-width: 580px;
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
    .tea-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .tea-input-icon {
        position: absolute;
        left: 14px;
        color: #9ca3af;
        font-size: 15px;
        pointer-events: none;
        display: flex;
        align-items: center;
        transition: color 0.2s ease;
    }
    .tea-pass-input {
        width: 100%;
        height: 48px;
        padding: 0 42px 0 42px;
        font-size: 14.5px;
        color: #111827;
        background: #fbfbfb;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.22s ease;
        font-family: inherit;
    }
    .tea-pass-input:focus {
        border-color: #245a2d;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(36, 90, 45, 0.12);
        outline: none;
    }
    .tea-pass-input:focus ~ .tea-input-icon,
    .tea-input-wrapper:focus-within .tea-input-icon {
        color: #245a2d;
    }

    .tea-pwd-toggle {
        position: absolute;
        right: 12px;
        background: transparent;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        padding: 6px 8px;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
    }
    .tea-pwd-toggle:hover {
        color: #173f2c;
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
        margin-top: 8px;
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
    .parsley-errors-list {
        list-style: none;
        padding: 0;
        margin: 6px 0 0;
        color: #dc2626;
        font-size: 12.5px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .tea-account-page {
            padding: 20px 12px 60px;
        }
        .tea-pass-header {
            padding: 20px 18px;
        }
        .tea-pass-body {
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
            <span>পাসওয়ার্ড পরিবর্তন</span>
        </div>

        <div class="row">
            <!-- Left Column: Customer Sidebar -->
            <div class="col-lg-4 col-md-5">
                @include('frontEnd.layouts.customer.sidebar')
            </div>

            <!-- Right Column: Change Password Form -->
            <div class="col-lg-8 col-md-7">
                <div class="tea-pass-main-card">
                    <div class="tea-card-top-strip"></div>

                    <!-- Header -->
                    <div class="tea-pass-header">
                        <h2 class="tea-pass-title">
                            <i class="fa-solid fa-key"></i> পাসওয়ার্ড পরিবর্তন করুন
                        </h2>
                        <p class="tea-pass-subtitle">অ্যাকাউন্টের সুরক্ষার জন্য শক্তিশালী পাসওয়ার্ড ব্যবহার করুন</p>
                    </div>

                    <!-- Form Body -->
                    <div class="tea-pass-body">
                        <form action="{{ route('customer.password_update') }}" method="POST" data-parsley-validate="" id="customer_password_form">
                            @csrf

                            <!-- Old Password -->
                            <div class="tea-form-group">
                                <label for="old_password" class="tea-form-label">
                                    বর্তমান পাসওয়ার্ড <span class="sub-en">(Current Password)</span> <span class="text-danger">*</span>
                                </label>
                                <div class="tea-input-wrapper">
                                    <span class="tea-input-icon"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" 
                                           id="old_password" 
                                           class="tea-pass-input @error('old_password') is-invalid @enderror" 
                                           name="old_password" 
                                           value="{{ old('old_password') }}" 
                                           placeholder="বর্তমান পাসওয়ার্ড লিখুন" 
                                           required 
                                           data-parsley-required-message="বর্তমান পাসওয়ার্ড প্রদান করুন">
                                    <button type="button" 
                                            class="tea-pwd-toggle" 
                                            onclick="togglePasswordVisibility('old_password', this)" 
                                            tabindex="-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                                @error('old_password')
                                    <span class="tea-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="tea-form-group">
                                <label for="new_password" class="tea-form-label">
                                    নতুন পাসওয়ার্ড <span class="sub-en">(New Password - Min 6 chars)</span> <span class="text-danger">*</span>
                                </label>
                                <div class="tea-input-wrapper">
                                    <span class="tea-input-icon"><i class="fa-solid fa-shield-halved"></i></span>
                                    <input type="password" 
                                           id="new_password" 
                                           class="tea-pass-input @error('new_password') is-invalid @enderror" 
                                           name="new_password" 
                                           value="{{ old('new_password') }}" 
                                           placeholder="কমপক্ষে ৬ ডিজিটের নতুন পাসওয়ার্ড" 
                                           required 
                                           minlength="6"
                                           data-parsley-minlength="6"
                                           data-parsley-required-message="নতুন পাসওয়ার্ড প্রদান করুন"
                                           data-parsley-minlength-message="পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে">
                                    <button type="button" 
                                            class="tea-pwd-toggle" 
                                            onclick="togglePasswordVisibility('new_password', this)" 
                                            tabindex="-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <span class="tea-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="tea-form-group">
                                <label for="confirm_password" class="tea-form-label">
                                    পাসওয়ার্ড নিশ্চিত করুন <span class="sub-en">(Confirm Password)</span> <span class="text-danger">*</span>
                                </label>
                                <div class="tea-input-wrapper">
                                    <span class="tea-input-icon"><i class="fa-solid fa-circle-check"></i></span>
                                    <input type="password" 
                                           id="confirm_password" 
                                           class="tea-pass-input @error('confirm_password') is-invalid @enderror" 
                                           name="confirm_password" 
                                           value="{{ old('confirm_password') }}" 
                                           placeholder="নতুন পাসওয়ার্ড পুনরায় লিখুন" 
                                           required 
                                           data-parsley-equalto="#new_password"
                                           data-parsley-required-message="পাসওয়ার্ড নিশ্চিত করুন"
                                           data-parsley-equalto-message="দুটি পাসওয়ার্ড একই হতে হবে">
                                    <button type="button" 
                                            class="tea-pwd-toggle" 
                                            onclick="togglePasswordVisibility('confirm_password', this)" 
                                            tabindex="-1">
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                </div>
                                @error('confirm_password')
                                    <span class="tea-invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="tea-btn-save">
                                <i class="fa-solid fa-lock"></i>
                                <span>পাসওয়ার্ড আপডেট করুন</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, btn) {
        var input = document.getElementById(inputId);
        var icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endsection

@push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
@endpush