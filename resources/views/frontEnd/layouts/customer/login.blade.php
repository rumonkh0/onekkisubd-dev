@extends('frontEnd.layouts.master')
@section('title', 'কাস্টমার লগইন | Customer Login')

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
        padding: 30px 28px 20px;
        text-align: center;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
    }
    .tea-auth-emblem {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #f4f8f2;
        border: 2px solid #e2cf9c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        color: #173f2c;
        font-size: 22px;
        box-shadow: 0 4px 14px rgba(23, 63, 44, 0.08);
        transition: transform 0.3s ease;
    }
    .tea-auth-card:hover .tea-auth-emblem {
        transform: scale(1.06) rotate(-4deg);
    }
    .tea-auth-title {
        font-family: 'Playfair Display', 'SolaimanLipi', 'Solaiman Lipi', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 6px;
        letter-spacing: -0.3px;
    }
    .tea-auth-subtitle {
        font-size: 13.5px;
        color: #6b7280;
        margin: 0;
        line-height: 1.5;
    }

    /* Switch tabs */
    .tea-auth-switch-tabs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #f3f5f2;
        padding: 4px;
        border-radius: 12px;
        margin: 20px 28px 0;
        gap: 6px;
        border: 1px solid #e7ebe4;
    }
    .tea-switch-tab {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 9px;
        font-size: 14px;
        font-weight: 600;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .tea-switch-tab.active {
        background: #173f2c;
        color: #ffffff;
        box-shadow: 0 3px 10px rgba(23, 63, 44, 0.22);
    }
    .tea-switch-tab:not(.active):hover {
        color: #173f2c;
        background: rgba(255, 255, 255, 0.8);
    }

    /* Form body */
    .tea-auth-body {
        padding: 24px 28px 28px;
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

    /* Extras line */
    .tea-auth-extras {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-bottom: 22px;
        margin-top: -6px;
    }
    .tea-forgot-link {
        font-size: 13px;
        color: #245a2d;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }
    .tea-forgot-link:hover {
        color: #cdb06a;
        text-decoration: underline;
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
    }
    .tea-btn-submit:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        box-shadow: 0 12px 24px rgba(23, 63, 44, 0.3);
        transform: translateY(-2px);
        color: #ffffff;
    }
    .tea-btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.2);
    }

    /* Footer switch prompt */
    .tea-auth-footer-prompt {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #f0ede6;
        text-align: center;
        font-size: 14px;
        color: #6b7280;
    }
    .tea-auth-footer-prompt a {
        color: #173f2c;
        font-weight: 700;
        text-decoration: none;
        margin-left: 4px;
        transition: color 0.2s ease;
    }
    .tea-auth-footer-prompt a:hover {
        color: #cdb06a;
        text-decoration: underline;
    }

    /* Trust indicators */
    .tea-auth-trust {
        margin-top: 24px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        padding: 0 8px;
    }
    .tea-trust-item {
        background: #ffffff;
        border: 1px solid #e8e4dc;
        border-radius: 12px;
        padding: 10px 8px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }
    .tea-trust-item i {
        color: #245a2d;
        font-size: 15px;
        margin-bottom: 4px;
        display: block;
    }
    .tea-trust-item span {
        font-size: 11px;
        font-weight: 600;
        color: #4b5563;
        display: block;
        line-height: 1.3;
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
        .tea-auth-switch-tabs {
            margin: 16px 18px 0;
        }
        .tea-auth-body {
            padding: 20px 18px 24px;
        }
        .tea-auth-title {
            font-size: 21px;
        }
    }
</style>

<div class="tea-auth-page">
    <div class="tea-auth-container">
        <div class="tea-auth-card">
            <div class="tea-auth-top-strip"></div>

            <div class="tea-auth-header">
                <div class="tea-auth-emblem">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <h1 class="tea-auth-title">স্বাগতম</h1>
                <p class="tea-auth-subtitle">আপনার অ্যাকাউন্টে লগইন করে প্রিমিয়াম চায়ের অভিজ্ঞতা নিন</p>
            </div>

            <!-- Tab Switcher -->
            <div class="tea-auth-switch-tabs">
                <a href="{{ route('customer.login') }}" class="tea-switch-tab active">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> লগইন
                </a>
                <a href="{{ route('customer.register') }}" class="tea-switch-tab">
                    <i class="fa-solid fa-user-plus"></i> রেজিস্ট্রেশন
                </a>
            </div>

            <div class="tea-auth-body">
                <form action="{{ route('customer.signin') }}" method="POST" data-parsley-validate="" id="customer_login_form">
                    @csrf

                    <!-- Phone Field -->
                    <div class="tea-form-group">
                        <label for="phone" class="tea-form-label">
                            <span>মোবাইল নম্বর <span class="text-danger">*</span></span>
                            <span class="sub-en">Phone Number</span>
                        </label>
                        <div class="tea-input-wrapper">
                            <span class="tea-input-icon"><i class="fa-solid fa-phone"></i></span>
                            <input type="number" 
                                   id="phone" 
                                   class="tea-auth-input @error('phone') is-invalid @enderror" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="০১XXXXXXXXX" 
                                   required 
                                   data-parsley-required-message="মোবাইল নম্বর প্রদান করুন">
                        </div>
                        @error('phone')
                            <span class="tea-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="tea-form-group">
                        <label for="password" class="tea-form-label">
                            <span>পাসওয়ার্ড <span class="text-danger">*</span></span>
                            <span class="sub-en">Password</span>
                        </label>
                        <div class="tea-input-wrapper">
                            <span class="tea-input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" 
                                   id="password" 
                                   class="tea-auth-input @error('password') is-invalid @enderror" 
                                   name="password" 
                                   value="{{ old('password') }}" 
                                   placeholder="••••••••" 
                                   required 
                                   data-parsley-required-message="পাসওয়ার্ড প্রদান করুন">
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

                    <!-- Forgot Password Link -->
                    <div class="tea-auth-extras">
                        <a href="{{ route('customer.forgot.password') }}" class="tea-forgot-link">
                            <i class="fa-solid fa-key"></i> পাসওয়ার্ড ভুলে গেছেন?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="tea-btn-submit">
                        <span>লগইন করুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <!-- Footer Switch Prompt -->
                <div class="tea-auth-footer-prompt">
                    অ্যাকাউন্ট নেই? 
                    <a href="{{ route('customer.register') }}">নতুন অ্যাকাউন্ট তৈরি করুন</a>
                </div>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="tea-auth-trust">
            <div class="tea-trust-item">
                <i class="fa-solid fa-shield-halved"></i>
                <span>১০০% নিরাপদ লগইন</span>
            </div>
            <div class="tea-trust-item">
                <i class="fa-solid fa-truck-fast"></i>
                <span>দ্রুত হোম ডেলিভারি</span>
            </div>
            <div class="tea-trust-item">
                <i class="fa-solid fa-leaf"></i>
                <span>খাঁটি প্রিমিয়াম চা</span>
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