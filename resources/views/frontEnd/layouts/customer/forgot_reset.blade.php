@extends('frontEnd.layouts.master')
@section('title', 'পাসওয়ার্ড রিসেট | Reset Password')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CUSTOMER AUTHENTICATION SYSTEM
       ======================================================== */
    .tea-auth-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.08) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 48px 16px 72px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .tea-auth-container {
        width: 100%;
        max-width: 460px;
        margin: 0 auto;
    }
    .tea-auth-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.08), 0 4px 16px rgba(10, 33, 27, 0.03);
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .tea-auth-top-strip {
        height: 5px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }
    .tea-auth-header {
        padding: 32px 28px 22px;
        text-align: center;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
    }
    .tea-auth-emblem {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #f4f8f2;
        border: 2px solid #e2cf9c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        color: #173f2c;
        font-size: 24px;
        box-shadow: 0 4px 14px rgba(23, 63, 44, 0.08);
        transition: transform 0.3s ease;
    }
    .tea-auth-card:hover .tea-auth-emblem {
        transform: scale(1.06) rotate(-4deg);
    }
    .tea-auth-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 23px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 8px;
        letter-spacing: -0.3px;
    }
    .tea-auth-subtitle {
        font-size: 13.5px;
        color: #6b7280;
        margin: 0;
        line-height: 1.5;
    }

    /* Form body */
    .tea-auth-body {
        padding: 26px 28px 28px;
    }
    .tea-form-group {
        margin-bottom: 20px;
        position: relative;
    }
    .tea-form-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
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
    .tea-auth-input {
        width: 100%;
        height: 48px;
        padding: 0 16px 0 42px;
        font-size: 14.5px;
        color: #111827;
        background: #fbfbfb;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.25s ease;
        font-family: inherit;
    }
    .tea-auth-input:focus {
        border-color: #245a2d;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(36, 90, 45, 0.12);
        outline: none;
    }
    .tea-auth-input:focus ~ .tea-input-icon,
    .tea-input-wrapper:focus-within .tea-input-icon {
        color: #245a2d;
    }
    .tea-auth-input.is-invalid {
        border-color: #ef4444 !important;
        background: #fffafa;
    }

    /* Password toggle button */
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
    .tea-btn-submit {
        width: 100%;
        height: 50px;
        background: linear-gradient(135deg, #173f2c 0%, #245a2d 100%);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 15.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(23, 63, 44, 0.22);
        transition: all 0.25s ease;
        letter-spacing: 0.3px;
        margin-top: 10px;
    }
    .tea-btn-submit:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        box-shadow: 0 12px 24px rgba(23, 63, 44, 0.3);
        transform: translateY(-2px);
        color: #ffffff;
    }

    /* Resend OTP area */
    .tea-resend-area {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px dashed #e8e4dc;
        text-align: center;
    }
    .tea-btn-resend {
        background: none;
        border: none;
        color: #245a2d;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .tea-btn-resend:hover {
        background: #f4f8f2;
        color: #cdb06a;
    }

    /* Footer prompt */
    .tea-auth-footer-prompt {
        margin-top: 16px;
        text-align: center;
        font-size: 14px;
        color: #6b7280;
    }
    .tea-auth-footer-prompt a {
        color: #173f2c;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }
    .tea-auth-footer-prompt a:hover {
        color: #cdb06a;
        text-decoration: underline;
    }

    /* Error feedback */
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

    @media (max-width: 576px) {
        .tea-auth-page {
            padding: 24px 12px 50px;
        }
        .tea-auth-header {
            padding: 24px 18px 16px;
        }
        .tea-auth-body {
            padding: 20px 18px 24px;
        }
        .tea-auth-title {
            font-size: 20px;
        }
    }
</style>

<div class="tea-auth-page">
    <div class="tea-auth-container">
        <div class="tea-auth-card">
            <div class="tea-auth-top-strip"></div>

            <div class="tea-auth-header">
                <div class="tea-auth-emblem">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h1 class="tea-auth-title">পাসওয়ার্ড রিসেট করুন</h1>
                <p class="tea-auth-subtitle">আপনার মোবাইলে পাঠানো ওটিপি কোড এবং নতুন পাসওয়ার্ড দিন</p>
            </div>

            <div class="tea-auth-body">
                <form action="{{ route('customer.forgot.store') }}" method="POST" data-parsley-validate="" id="customer_reset_form">
                    @csrf

                    <!-- OTP Field -->
                    <div class="tea-form-group">
                        <label for="otp" class="tea-form-label">
                            <span>ওটিপি কোড (OTP) <span class="text-danger">*</span></span>
                            <span class="sub-en">Verification Code</span>
                        </label>
                        <div class="tea-input-wrapper">
                            <span class="tea-input-icon"><i class="fa-solid fa-hashtag"></i></span>
                            <input type="number" 
                                   id="otp" 
                                   class="tea-auth-input @error('otp') is-invalid @enderror" 
                                   name="otp" 
                                   value="{{ old('otp') }}" 
                                   placeholder="৪ সংখ্যার ওটিপি লিখুন" 
                                   required 
                                   data-parsley-required-message="ওটিপি কোড প্রদান করুন">
                        </div>
                        @error('otp')
                            <span class="tea-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- New Password Field -->
                    <div class="tea-form-group">
                        <label for="password" class="tea-form-label">
                            <span>নতুন পাসওয়ার্ড <span class="text-danger">*</span></span>
                            <span class="sub-en">Min 6 characters</span>
                        </label>
                        <div class="tea-input-wrapper">
                            <span class="tea-input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" 
                                   id="password" 
                                   class="tea-auth-input @error('password') is-invalid @enderror" 
                                   name="password" 
                                   value="{{ old('password') }}" 
                                   placeholder="কমপক্ষে ৬ ডিজিটের নতুন পাসওয়ার্ড" 
                                   required 
                                   minlength="6"
                                   data-parsley-minlength="6"
                                   data-parsley-required-message="নতুন পাসওয়ার্ড প্রদান করুন"
                                   data-parsley-minlength-message="পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে">
                            <button type="button" 
                                    class="tea-pwd-toggle" 
                                    onclick="togglePasswordVisibility('password', this)" 
                                    title="পাসওয়ার্ড দেখুন/লুকান" 
                                    tabindex="-1">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="tea-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="tea-btn-submit">
                        <span>পাসওয়ার্ড পরিবর্তন সম্পন্ন করুন</span>
                        <i class="fa-solid fa-check"></i>
                    </button>
                </form>

                <!-- Resend OTP Area -->
                <div class="tea-resend-area">
                    <form action="{{ route('customer.forgot.resendotp') }}" method="POST">
                        @csrf
                        <button type="submit" class="tea-btn-resend">
                            <i class="fa-solid fa-rotate-right"></i> ওটিপি আসেনি? কোড পুনরায় পাঠান
                        </button>
                    </form>
                </div>

                <!-- Footer Prompt -->
                <div class="tea-auth-footer-prompt">
                    <a href="{{ route('customer.login') }}">
                        <i class="fa-solid fa-arrow-left"></i> লগইন পেজে ফিরে যান
                    </a>
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