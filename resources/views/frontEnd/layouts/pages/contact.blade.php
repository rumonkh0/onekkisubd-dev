@extends('frontEnd.layouts.master')
@section('title', 'যোগাযোগ | Contact Us')

@section('content')
<style>
    /* ========================================================
       TEA LUXURY CONTACT PAGE STYLES
       ======================================================== */
    .tea-contact-page {
        background: #fbf9f5 radial-gradient(circle at 50% 0%, rgba(36, 90, 45, 0.06) 0%, rgba(251, 249, 245, 0) 70%);
        min-height: calc(100vh - 220px);
        padding: 36px 16px 80px;
    }
    .tea-contact-container {
        max-width: 1140px;
        margin: 0 auto;
    }

    /* Policy / Common Menu Nav Chips */
    .tea-cmn-menu-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 36px;
    }
    .tea-cmn-menu-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        background: #ffffff;
        border: 1px solid #e8e4dc;
        border-radius: 24px;
        font-size: 13.5px;
        font-weight: 600;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.22s ease;
        box-shadow: 0 2px 6px rgba(10, 33, 27, 0.02);
    }
    .tea-cmn-menu-link:hover {
        background: #f4f8f2;
        color: #173f2c;
        border-color: #c9dec4;
    }
    .tea-cmn-menu-link.active {
        background: #173f2c;
        color: #ffffff;
        border-color: #173f2c;
        box-shadow: 0 4px 12px rgba(23, 63, 44, 0.2);
    }

    /* Hero Header */
    .tea-contact-hero {
        text-align: center;
        max-width: 650px;
        margin: 0 auto 36px;
    }
    .tea-contact-emblem {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #f4f8f2;
        border: 2px solid #e2cf9c;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #173f2c;
        font-size: 24px;
        margin-bottom: 14px;
        box-shadow: 0 4px 14px rgba(23, 63, 44, 0.08);
    }
    .tea-contact-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 32px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 8px;
    }
    .tea-contact-subtitle {
        font-size: 14.5px;
        color: #6b7280;
        margin: 0;
        line-height: 1.6;
    }

    /* Cards Grid */
    .tea-contact-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 36px;
    }
    .tea-contact-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 10px 30px -8px rgba(10, 33, 27, 0.05);
        padding: 26px 22px;
        text-align: center;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .tea-contact-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 36px -8px rgba(10, 33, 27, 0.1);
        border-color: #cdb06a;
    }
    .tea-card-icon-circle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 14px;
    }
    .icon-phone-box {
        background: #eaf4eb;
        color: #173f2c;
        border: 1px solid #c9dec4;
    }
    .icon-wa-box {
        background: #e9fbf0;
        color: #25d366;
        border: 1px solid #a7f3d0;
    }
    .icon-loc-box {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .tea-contact-card-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 17px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 6px;
    }
    .tea-contact-card-text {
        font-size: 13.5px;
        color: #6b7280;
        margin-bottom: 14px;
        line-height: 1.5;
    }
    .tea-btn-contact-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        background: #f4f6f3;
        border-radius: 20px;
        font-size: 13.5px;
        font-weight: 600;
        color: #173f2c;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-top: auto;
    }
    .tea-btn-contact-action:hover {
        background: #173f2c;
        color: #ffffff;
    }

    /* Message Form Card */
    .tea-form-card {
        background: #ffffff;
        border-radius: 22px;
        border: 1px solid #e8e4dc;
        box-shadow: 0 16px 40px -10px rgba(10, 33, 27, 0.07);
        overflow: hidden;
        max-width: 860px;
        margin: 0 auto;
    }
    .tea-card-top-strip {
        height: 5px;
        background: linear-gradient(90deg, #173f2c 0%, #cdb06a 50%, #245a2d 100%);
    }
    .tea-form-card-header {
        padding: 26px 32px 20px;
        background: linear-gradient(180deg, #fafbf9 0%, #ffffff 100%);
        border-bottom: 1px solid #f1ede6;
        text-align: center;
    }
    .tea-form-card-title {
        font-family: 'Playfair Display', 'Hind Siliguri', serif;
        font-size: 24px;
        font-weight: 700;
        color: #0a211b;
        margin: 0 0 6px;
    }
    .tea-form-card-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }
    .tea-form-card-body {
        padding: 32px;
    }
    .tea-field-group {
        margin-bottom: 20px;
    }
    .tea-field-label {
        display: block;
        font-size: 13.5px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 7px;
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
    .tea-textarea-ctrl {
        width: 100%;
        height: 120px;
        padding: 14px 16px;
        font-size: 14.5px;
        color: #111827;
        background: #fbfbfb;
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        transition: all 0.22s ease;
        font-family: inherit;
        resize: vertical;
    }
    .tea-textarea-ctrl:focus {
        border-color: #245a2d;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(36, 90, 45, 0.12);
        outline: none;
    }

    /* Submit CTA */
    .tea-btn-send {
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
    }
    .tea-btn-send:hover {
        background: linear-gradient(135deg, #0f2e20 0%, #1c4b24 100%);
        box-shadow: 0 12px 24px rgba(23, 63, 44, 0.3);
        transform: translateY(-2px);
        color: #ffffff;
    }

    .tea-invalid-feedback {
        display: block;
        margin-top: 6px;
        font-size: 12.5px;
        color: #dc2626;
        font-weight: 500;
    }

    @media (max-width: 991px) {
        .tea-contact-cards-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 576px) {
        .tea-contact-page {
            padding: 20px 12px 60px;
        }
        .tea-form-card-header {
            padding: 20px 18px;
        }
        .tea-form-card-body {
            padding: 20px 18px;
        }
        .tea-contact-title {
            font-size: 26px;
        }
    }
</style>

<div class="tea-contact-page">
    <div class="tea-contact-container">
        <!-- Common Policy / CMS Menu Links -->
        @if(isset($cmnmenu) && $cmnmenu->count() > 0)
            <div class="tea-cmn-menu-nav">
                @foreach($cmnmenu as $key => $value)
                    <a href="{{ route('page', $value->slug) }}" class="tea-cmn-menu-link">
                        {{ $value->name }}
                    </a>
                @endforeach
                <a href="{{ route('contact') }}" class="tea-cmn-menu-link active">
                    <i class="fa-solid fa-envelope"></i> যোগাযোগ (Contact Us)
                </a>
            </div>
        @endif

        <!-- Hero Header -->
        <div class="tea-contact-hero">
            <div class="tea-contact-emblem">
                <i class="fa-solid fa-comments"></i>
            </div>
            <h1 class="tea-contact-title">যোগাযোগ ও সহায়তা</h1>
            <p class="tea-contact-subtitle">
                আমাদের খাঁটি চা পাতা, অর্ডার প্রক্রিয়া কিংবা যেকোনো প্রশ্নের জন্য নির্দ্বিধায় যোগাযোগ করুন। আমরা সবসময় আপনার সহায়তায় প্রস্তুত।
            </p>
        </div>

        <!-- 3 Contact Information Cards -->
        <div class="tea-contact-cards-grid">
            <!-- Card 1: Phone / Hotline -->
            <div class="tea-contact-card">
                <div class="tea-card-icon-circle icon-phone-box">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <h3 class="tea-contact-card-title">হটলাইন ও ফোন</h3>
                <p class="tea-contact-card-text">
                    সরাসরি কল দিয়ে অর্ডার করতে অথবা তথ্যের জন্য যোগাযোগ করুন।
                </p>
                <a href="tel:{{ $contact->hotline ?? $contact->phone }}" class="tea-btn-contact-action">
                    <i class="fa-solid fa-phone"></i> {{ $contact->hotline ?? $contact->phone }}
                </a>
            </div>

            <!-- Card 2: WhatsApp Concierge -->
            <div class="tea-contact-card">
                <div class="tea-card-icon-circle icon-wa-box">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 class="tea-contact-card-title">হোয়াটসঅ্যাপ সহায়তা</h3>
                <p class="tea-contact-card-text">
                    যেকোনো সময় সরাসরি টেক্সট বা ছবি পাঠিয়ে দ্রুত সহায়তা পান।
                </p>
                <a href="https://wa.me/+88{{ $contact->phone ?? '01850945080' }}?text=Hello%20OnekkisuBD" target="_blank" class="tea-btn-contact-action" style="background:#25d366; color:#ffffff;">
                    <i class="fa-brands fa-whatsapp"></i> চ্যাট শুরু করুন
                </a>
            </div>

            <!-- Card 3: Address / Location -->
            <div class="tea-contact-card">
                <div class="tea-card-icon-circle icon-loc-box">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3 class="tea-contact-card-title">অফিস ও ইমেইল</h3>
                <p class="tea-contact-card-text">
                    {{ $contact->address ?? 'যশোর, বাংলাদেশ' }}<br>
                    <span style="font-size:12.5px; color:#173f2c; font-weight:600;">{{ $contact->email ?? '' }}</span>
                </p>
                <a href="mailto:{{ $contact->email }}" class="tea-btn-contact-action">
                    <i class="fa-regular fa-envelope"></i> ইমেইল পাঠান
                </a>
            </div>
        </div>

        <!-- Contact Message Form -->
        <div class="tea-form-card">
            <div class="tea-card-top-strip"></div>

            <div class="tea-form-card-header">
                <h2 class="tea-form-card-title">আমাদের বার্তা পাঠান</h2>
                <p class="tea-form-card-subtitle">নিচের ফর্মটি পূরণ করে পাঠান, আমরা দ্রুত আপনার সাথে যোগাযোগ করব</p>
            </div>

            <div class="tea-form-card-body">
                <form action="{{ route('home') }}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="" id="contact_message_form">
                    @csrf

                    <!-- Full Name -->
                    <div class="col-md-6">
                        <div class="tea-field-group">
                            <label for="name" class="tea-field-label">আপনার পূর্ণ নাম <span class="text-danger">*</span></label>
                            <input type="text" 
                                   id="name" 
                                   class="tea-input-ctrl @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="নাম লিখুন" 
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
                        <div class="tea-field-group">
                            <label for="phone" class="tea-field-label">মোবাইল নম্বর <span class="text-danger">*</span></label>
                            <input type="number" 
                                   id="phone" 
                                   class="tea-input-ctrl @error('phone') is-invalid @enderror" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="০১XXXXXXXXX" 
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
                        <div class="tea-field-group">
                            <label for="email" class="tea-field-label">ইমেইল ঠিকানা <span class="text-danger">*</span></label>
                            <input type="email" 
                                   id="email" 
                                   class="tea-input-ctrl @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="example@mail.com" 
                                   required 
                                   data-parsley-required-message="সঠিক ইমেইল ঠিকানা দিন">
                            @error('email')
                                <span class="tea-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="col-md-6">
                        <div class="tea-field-group">
                            <label for="subject" class="tea-field-label">বিষয় (Subject) <span class="text-danger">*</span></label>
                            <input type="text" 
                                   id="subject" 
                                   class="tea-input-ctrl @error('subject') is-invalid @enderror" 
                                   name="subject" 
                                   value="{{ old('subject') }}" 
                                   placeholder="বার্তার মূল বিষয়" 
                                   required 
                                   data-parsley-required-message="বিষয় লিখুন">
                            @error('subject')
                                <span class="tea-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="col-12">
                        <div class="tea-field-group">
                            <label for="message" class="tea-field-label">আপনার বার্তা বা মন্তব্য <span class="text-danger">*</span></label>
                            <textarea id="message" 
                                      class="tea-textarea-ctrl @error('message') is-invalid @enderror" 
                                      name="message" 
                                      placeholder="এখানে আপনার বিস্তারিত বার্তা বা প্রশ্ন লিখুন..." 
                                      required 
                                      data-parsley-required-message="বার্তা লিখুন">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="tea-invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button type="submit" class="tea-btn-send">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>বার্তা পাঠান (Send Message)</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
<script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
@endpush
