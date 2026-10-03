@extends('frontEnd.layouts.master')
@section('title', 'অর্ডার ট্র্যাকিং | Track Your Order')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY ORDER TRACKING STYLES
       ======================================================== */
    .tea-track-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.08) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 50px 16px 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .tea-track-container {
        width: 100%;
        max-width: 520px;
        margin: 0 auto;
    }
    .tea-track-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.08), 0 4px 16px rgba(10, 33, 27, 0.03);
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .tea-track-top-strip {
        height: 5px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }
    .tea-track-header {
        padding: 34px 30px 22px;
        text-align: center;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
    }
    .tea-track-emblem {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #f4f8f2;
        border: 2px solid #e2cf9c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        color: #173f2c;
        font-size: 26px;
        box-shadow: 0 4px 14px rgba(23, 63, 44, 0.08);
        transition: transform 0.3s ease;
    }
    .tea-track-card:hover .tea-track-emblem {
        transform: scale(1.06) rotate(-3deg);
    }
    .tea-track-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 25px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 8px;
        letter-spacing: -0.3px;
    }
    .tea-track-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
        line-height: 1.5;
    }

    /* Form Body */
    .tea-track-body {
        padding: 28px 30px 32px;
    }
    .tea-form-group {
        margin-bottom: 22px;
        position: relative;
    }
    .tea-form-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13.5px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
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
    .tea-track-input {
        width: 100%;
        height: 50px;
        padding: 0 16px 0 44px;
        font-size: 14.5px;
        color: #111827;
        background: #fbfbfb;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.25s ease;
        font-family: inherit;
    }
    .tea-track-input:focus {
        border-color: #245a2d;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(36, 90, 45, 0.12);
        outline: none;
    }
    .tea-track-input:focus ~ .tea-input-icon,
    .tea-input-wrapper:focus-within .tea-input-icon {
        color: #245a2d;
    }
    .tea-track-input.is-invalid {
        border-color: #ef4444 !important;
        background: #fffafa;
    }
    .tea-field-hint {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 5px;
        display: block;
    }

    /* Submit CTA */
    .tea-btn-track {
        width: 100%;
        height: 52px;
        background: linear-gradient(135deg, #173f2c 0%, #245a2d 100%);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(23, 63, 44, 0.22);
        transition: all 0.25s ease;
        letter-spacing: 0.3px;
        margin-top: 8px;
    }
    .tea-btn-track:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        box-shadow: 0 12px 24px rgba(23, 63, 44, 0.3);
        transform: translateY(-2px);
        color: #ffffff;
    }
    .tea-btn-track:active {
        transform: translateY(0);
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.2);
    }

    /* Help Strip */
    .tea-track-help {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px dashed #e8e4dc;
        text-align: center;
        font-size: 13.5px;
        color: #6b7280;
    }
    .tea-track-help a {
        color: #245a2d;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }
    .tea-track-help a:hover {
        color: #cdb06a;
        text-decoration: underline;
    }

    /* Trust indicators */
    .tea-track-trust {
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
        .tea-track-page {
            padding: 24px 12px 50px;
        }
        .tea-track-header {
            padding: 24px 18px 18px;
        }
        .tea-track-body {
            padding: 20px 18px 24px;
        }
        .tea-track-title {
            font-size: 21px;
        }
    }
</style>

<div class="tea-track-page">
    <div class="tea-track-container">
        <div class="tea-track-card">
            <div class="tea-track-top-strip"></div>

            <div class="tea-track-header">
                <div class="tea-track-emblem">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h1 class="tea-track-title">অর্ডার ট্র্যাকিং</h1>
                <p class="tea-track-subtitle">আপনার চায়ের পার্সেলটি কোথায় আছে রিয়েল-টাইমে ট্র্যাক করুন</p>
            </div>

            <div class="tea-track-body">
                <form action="{{ route('customer.order_track_result') }}" method="GET" data-parsley-validate="" id="order_track_form">
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
                                   class="tea-track-input @error('phone') is-invalid @enderror" 
                                   name="phone" 
                                   value="{{ old('phone', request('phone')) }}" 
                                   placeholder="০১XXXXXXXXX" 
                                   required 
                                   data-parsley-required-message="অর্ডারের মোবাইল নম্বর দিন">
                        </div>
                        <span class="tea-field-hint">অর্ডার করার সময় যে মোবাইল নম্বর দিয়েছেন</span>
                        @error('phone')
                            <span class="tea-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Invoice ID Field (Optional) -->
                    <div class="tea-form-group">
                        <label for="invoice_id" class="tea-form-label">
                            <span>ইনভয়েস আইডি (ঐচ্ছিক)</span>
                            <span class="sub-en">Invoice ID (Optional)</span>
                        </label>
                        <div class="tea-input-wrapper">
                            <span class="tea-input-icon"><i class="fa-solid fa-receipt"></i></span>
                            <input type="text" 
                                   id="invoice_id" 
                                   class="tea-track-input @error('invoice_id') is-invalid @enderror" 
                                   name="invoice_id" 
                                   value="{{ old('invoice_id', request('invoice_id')) }}" 
                                   placeholder="যেমন: 75508">
                        </div>
                        <span class="tea-field-hint">নির্দিষ্ট অর্ডার ট্র্যাক করতে ইনভয়েস নম্বর লিখুন</span>
                        @error('invoice_id')
                            <span class="tea-invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="tea-btn-track">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>অর্ডার ট্র্যাক করুন</span>
                    </button>
                </form>

                <!-- Help Link -->
                @php
                    $contact = App\Models\Contact::first();
                @endphp
                <div class="tea-track-help">
                    ইনভয়েস বা নম্বর খুঁজে পাচ্ছেন না? 
                    <a href="https://wa.me/+88{{ $contact->phone ?? '01850945080' }}" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i> সরাসরি সহায়তা নিন
                    </a>
                </div>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="tea-track-trust">
            <div class="tea-trust-item">
                <i class="fa-solid fa-box-archive"></i>
                <span>নিরাপদ প্যাকেজিং</span>
            </div>
            <div class="tea-trust-item">
                <i class="fa-solid fa-route"></i>
                <span>লাইভ আপডেট</span>
            </div>
            <div class="tea-trust-item">
                <i class="fa-solid fa-headset"></i>
                <span>২৪/৭ হেল্পলাইন</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
@endpush