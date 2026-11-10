@extends('backEnd.layouts.master')
@section('title','Landing Page Create')
@section('css')
    <link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />

    <link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/backEnd')}}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
@endsection
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{route('campaign.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                    </div>
                    <h4 class="page-title">Landing Page Create</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('campaign.store')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                            @csrf


                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Landing Page Title *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  id="name" required="">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="slug" class="form-label">URL Slug (e.g. rosella-tea)</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" id="slug" placeholder="e.g. rosella-tea">
                                    <small class="text-muted">ঐচ্ছিক — ফাঁকা রাখলে টাইটেল অনুযায়ী অটোমেটিক তৈরি হবে।</small>
                                    @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="banner_title" class="form-label">Banner Title *</label>
                                    <input type="text" class="form-control @error('banner_title') is-invalid @enderror" name="banner_title" value="{{ old('banner_title') }}"  id="banner_title" required="">
                                    @error('banner_title')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <!-- col-end -->

                            {{-- <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="banner" class="form-label">Banner Image *</label>
                                    <input type="file" class="form-control @error('banner') is-invalid @enderror " name="banner"  value="{{ old('banner') }}"  id="banner" required="">
                                    @error('banner')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="banner_img" class="form-label fw-bold">Hero Banner Images (Slider)</label>
                                    <p class="text-muted fs-13 mb-2">Multiple images can be selected for the top hero slider.</p>
                                    <input type="file" class="form-control @error('banner_img') is-invalid @enderror"
                                        name="banner_img[]" id="banner_img" multiple onchange="previewBannerImages(this)">
                                    <div id="banner_img_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                    @error('banner_img')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="video" class="form-label fw-bold">ভিডিও (YouTube Video Link বা ID)</label>
                                    <input type="text" class="form-control @error('video') is-invalid @enderror"
                                        name="video" value="{{ old('video') }}" id="video"
                                        placeholder="যেমন: dQw4w9WgXcQ অথবা https://www.youtube.com/watch?v=...">
                                    <small class="text-muted d-block mt-1">
                                        💡 পুরো YouTube লিংক, শেয়ার লিংক (youtu.be), শর্টস লিংক অথবা শুধু ১১ অক্ষরের ভিডিও আইডি দিলেও স্বয়ংক্রিয়ভাবে কাজ করবে।
                                    </small>
                                    @error('video')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <!-- Live YouTube Video Preview -->
                                    <div id="youtube_preview_wrap" class="mt-2 p-2 border rounded bg-light" style="display: none;">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <span class="fs-12 fw-bold text-primary"><i class="fe-video me-1"></i> লাইভ ভিডিও প্রিভিউ:</span>
                                            <span id="youtube_preview_status" class="badge bg-success">Active</span>
                                        </div>
                                        <div class="ratio ratio-16x9" style="max-width: 450px;">
                                            <iframe id="youtube_preview_iframe" src="" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- col-end -->


                            <!-- col-end -->

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="product_id" class="form-label">Products *</label>
                                    <select class="select2 form-control @error('product_id') is-invalid @enderror" value="{{ old('product_id') }}" name="product_id" data-placeholder="Choose ..." required>

                                        <option value="">Select..</option>
                                        @foreach($products as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach

                                    </select>
                                    @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->

                            <div class="col-sm-4 mb-3">
                                <div class="form-group border rounded p-2 bg-light">
                                    <label for="image_one" class="form-label fw-bold">Gallery Image 1 (রিয়েল ভিউ ১)*</label>
                                    <input type="file" class="form-control @error('image_one') is-invalid @enderror" name="image_one" value="{{ old('image_one') }}" id="image_one" required="" onchange="previewSingleImage(this, 'create_image_one_preview')">
                                    <div id="create_image_one_preview" class="mt-2"></div>
                                    @error('image_one')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4 mb-3">
                                <div class="form-group border rounded p-2 bg-light">
                                    <label for="image_two" class="form-label fw-bold">Gallery Image 2 (রিয়েল ভিউ ২)</label>
                                    <input type="file" class="form-control @error('image_two') is-invalid @enderror" name="image_two" value="{{ old('image_two') }}" id="image_two" onchange="previewSingleImage(this, 'create_image_two_preview')">
                                    <div id="create_image_two_preview" class="mt-2"></div>
                                    @error('image_two')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4 mb-3">
                                <div class="form-group border rounded p-2 bg-light">
                                    <label for="image_three" class="form-label fw-bold">Gallery Image 3 (রিয়েল ভিউ ৩)</label>
                                    <input type="file" class="form-control @error('image_three') is-invalid @enderror" name="image_three" value="{{ old('image_three') }}" id="image_three" onchange="previewSingleImage(this, 'create_image_three_preview')">
                                    <div id="create_image_three_preview" class="mt-2"></div>
                                    @error('image_three')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <!--<div class="col-sm-6">-->
                            <!--    <div class="form-group mb-3">-->
                            <!--        <label for="review" class="form-label">Review Images *</label>-->
                            <!--        <input type="text" class="form-control @error('review') is-invalid @enderror" name="review" value="{{ old('review') }}"  id="review" required="">-->
                            <!--        @error('review')-->
                            <!--            <span class="invalid-feedback" role="alert">-->
                            <!--                <strong>{{ $message }}</strong>-->
                            <!--            </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-sm-6 mb-3">-->
                            <!--    <label for="image">Review Image *</label>-->
                            <!--    <div class="clone hide" style="display: none;">-->
                            <!--        <div class="control-group input-group">-->
                            <!--            <input type="file" name="image" class="form-control" />-->
                            <!--            <div class="input-group-btn">-->
                            <!--                <button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--    <div class="input-group control-group increment">-->
                            <!--        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" />-->
                            <!--<div class="input-group-btn">-->
                            <!--    <button class="btn btn-success btn-increment" type="button"><i class="fa fa-plus"></i></button>-->
                            <!--</div>-->
                            <!--        @error('image')-->
                            <!--        <span class="invalid-feedback" role="alert">-->
                            <!--            <strong>{{ $message }}</strong>-->
                            <!--        </span>-->
                            <!--        @enderror-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!-- col end -->
                            <!-- col-end -->
                            {{-- <div class="col-sm-12 my-3">
                                <div class="form-group">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <textarea name="short_description"  rows="6" class="summernote form-control @error('short_description') is-invalid @enderror" ></textarea>
                                    @error('short_description')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- clone_price end -->
                            <div class="col-sm-12 my-3">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description"  rows="6" class="summernote form-control @error('description') is-invalid @enderror" ></textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <!-- 4 Steps Section -->
                            <div class="col-sm-12 my-3">
                                <div class="card border border-primary border-opacity-25 bg-light p-3 rounded">
                                    <h5 class="text-primary mb-2"><i class="fe-list me-1"></i> তৈরির সহজ ৪টি ধাপ (4-Step Recipe / Usage Section)</h5>
                                    <p class="text-muted fs-13 mb-3">ক্যাম্পেইন ল্যান্ডিং পেজে ৪টি ধাপের সেকশন কাস্টমাইজ করুন। ফাঁকা রাখলে ডিফল্ট লেখা দেখাবে।</p>

                                    <div class="mb-3">
                                        <label for="step_title" class="form-label fw-bold">সেকশন টাইটেল (Section Title)</label>
                                        <input type="text" class="form-control @error('step_title') is-invalid @enderror" 
                                               name="step_title" id="step_title" 
                                               value="{{ old('step_title') }}" 
                                               placeholder="সেরা স্বাদের চা তৈরির সহজ ৪টি ধাপ">
                                        @error('step_title')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-6 mb-2">
                                            <label for="step_one" class="form-label fw-semibold">ধাপ ১ (Step 1)</label>
                                            <textarea name="step_one" id="step_one" rows="2" class="form-control" 
                                                      placeholder="প্রথমে পরিচ্ছন্ন পাত্রে প্রয়োজনীয় পরিমাণ পানি ভালো করে ফুটিয়ে নিন।">{{ old('step_one') }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="step_two" class="form-label fw-semibold">ধাপ ২ (Step 2)</label>
                                            <textarea name="step_two" id="step_two" rows="2" class="form-control" 
                                                      placeholder="ফুটন্ত পানিতে পরিমাণমতো চা পাতা দিন এবং ২-৩ মিনিট ফুটান কড়া লিকারের জন্য।">{{ old('step_two') }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="step_three" class="form-label fw-semibold">ধাপ ৩ (Step 3)</label>
                                            <textarea name="step_three" id="step_three" rows="2" class="form-control" 
                                                      placeholder="দুধ চা করতে ঘন দুধ ও পরিমাণমতো চিনি মেশান, অথবা লাল চা হিসেবে উপভোগ করুন।">{{ old('step_three') }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="step_four" class="form-label fw-semibold">ধাপ ৪ (Step 4)</label>
                                            <textarea name="step_four" id="step_four" rows="2" class="form-control" 
                                                      placeholder="ছাঁকনি দিয়ে কাপে ঢেলে পরিবেশন করুন ধোঁয়া ওঠা অতুলনীয় স্বাদের চা!">{{ old('step_four') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Value Propositions / Key Feature Cards Section -->
                            <div class="col-sm-12 my-3">
                                <div class="card border border-primary border-opacity-25 bg-light p-3 rounded">
                                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                                        <h5 class="text-primary mb-0"><i class="fe-grid me-1"></i> পণ্য সুবিধা ও বৈশিষ্ট্য কার্ড (Key Feature Cards)</h5>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-feature-card-btn">
                                            <i class="fe-plus-circle me-1"></i> নতুন ফিচার যোগ করুন (+ Add Feature)
                                        </button>
                                    </div>
                                    <p class="text-muted fs-13 mb-3">ক্যাম্পেইন ল্যান্ডিং পেজে প্রদর্শিত ফিচার কার্ডসমূহ (যেমন: ব্লাড প্রেশার নিয়ন্ত্রণ, মেদ নিয়ন্ত্রণ ইত্যাদি)। আইকন ড্রপডাউন নির্বাচন করলে পাশে লাইভ প্রিভিউ দেখাবে। কার্ড সংখ্যা কম বা বেশি করতে পারেন।</p>

                                    @php
                                        $availableIcons = [
                                            'fas fa-heartbeat' => 'হার্ট / ব্লাড প্রেশার (fa-heartbeat)',
                                            'fas fa-heart-pulse' => 'হার্টবিট / পালস (fa-heart-pulse)',
                                            'fas fa-fire-alt' => 'মেদ ও ওজন নিয়ন্ত্রণ (fa-fire-alt)',
                                            'fas fa-fire' => 'আগুন / ফ্যাট বার্ন (fa-fire)',
                                            'fas fa-leaf' => '১০০% প্রাকৃতিক / আস্ত পাতা (fa-leaf)',
                                            'fas fa-shield-alt' => 'ইমিউনিটি / রোগ প্রতিরোধ (fa-shield-alt)',
                                            'fas fa-shield-heart' => 'স্বাস্থ্য সুরক্ষা (fa-shield-heart)',
                                            'fas fa-coffee' => 'কড়া লিকার / চা (fa-coffee)',
                                            'fas fa-mug-hot' => 'ধোঁয়া ওঠা গরম চা / মগ (fa-mug-hot)',
                                            'fas fa-award' => 'বাছাইকৃত সেরা গ্রেড (fa-award)',
                                            'fas fa-medal' => 'গোল্ড মেডেল / কোয়ালিটি (fa-medal)',
                                            'fas fa-star' => '৫ স্টার / রেটিং (fa-star)',
                                            'fas fa-check-circle' => '১০০% বিশুদ্ধ / গ্যারান্টি (fa-check-circle)',
                                            'fas fa-check-double' => 'দ্বিগুণ কার্যকারিতা (fa-check-double)',
                                            'fas fa-seedling' => 'অর্গানিক চাষ / চারা (fa-seedling)',
                                            'fas fa-tint' => 'বিশুদ্ধ তরল / নির্যাস (fa-tint)',
                                            'fas fa-apple-alt' => 'ভিটামিন ও পুষ্টি (fa-apple-alt)',
                                            'fas fa-sun' => 'রোদে শুকানো প্রাকৃতিক (fa-sun)',
                                            'fas fa-bolt' => 'তাৎক্ষণিক এনার্জি (fa-bolt)',
                                            'fas fa-truck-fast' => 'দ্রুত হোম ডেলিভারি (fa-truck-fast)',
                                            'fas fa-box-open' => 'নিরাপদ প্যাকেজিং (fa-box-open)',
                                            'fas fa-hand-holding-heart' => 'যত্ন ও ভালোবাসা (fa-hand-holding-heart)',
                                            'fas fa-clock' => 'ঝটপট তৈরি / সময় সাশ্রয়ী (fa-clock)',
                                            'fas fa-smile' => 'শতভাগ তৃপ্তি ও সন্তুষ্টি (fa-smile)',
                                            'fas fa-thumbs-up' => 'বিশ্বস্ত কোয়ালিটি (fa-thumbs-up)',
                                            'fas fa-weight-scale' => 'ওজন নিয়ন্ত্রণ (fa-weight-scale)',
                                            'fas fa-brain' => 'মানসিক ক্লান্তি দূর (fa-brain)',
                                        ];

                                        $defaultFeatures = [
                                            [
                                                'icon' => 'fas fa-heartbeat',
                                                'title' => 'ব্লাড প্রেশার নিয়ন্ত্রণ',
                                                'desc' => 'প্রাকৃতিকভাবে হাই ব্লাড প্রেশার কমাতে কার্যকর ভূমিকা রাখে।',
                                            ],
                                            [
                                                'icon' => 'fas fa-fire-alt',
                                                'title' => 'মেদ ও ওজন নিয়ন্ত্রণ',
                                                'desc' => 'প্রচুর অ্যান্টিঅক্সিডেন্ট মেটাবলিজম বাড়িয়ে মেদ ঝরাতে সহায়ক।',
                                            ],
                                            [
                                                'icon' => 'fas fa-leaf',
                                                'title' => '১০০% আস্ত পাহাড়ি পাপড়ি',
                                                'desc' => 'পাহাড়ে রোদে শুকানো বিষমুক্ত ও রাসায়নিকবিহীন অক্ষত ফুল।',
                                            ],
                                            [
                                                'icon' => 'fas fa-shield-alt',
                                                'title' => 'ভিটামিন সি ও রোগ প্রতিরোধ',
                                                'desc' => 'ত্বক সতেজ রাখে এবং শরীরের ইমিউনিটি বহুগুণ বাড়িয়ে তোলে।',
                                            ],
                                        ];

                                        if (old('feature_titles')) {
                                            $defaultFeatures = [];
                                            foreach (old('feature_titles') as $k => $t) {
                                                $defaultFeatures[] = [
                                                    'icon' => old('feature_icons.'.$k, 'fas fa-heartbeat'),
                                                    'title' => $t,
                                                    'desc' => old('feature_descs.'.$k, ''),
                                                ];
                                            }
                                        }
                                    @endphp

                                    <div id="feature-cards-wrapper">
                                        @foreach($defaultFeatures as $fItem)
                                            <div class="card mb-3 border border-secondary border-opacity-25 shadow-none feature-item-card bg-white">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
                                                        <span class="fw-bold text-dark fs-13">
                                                            <i class="fe-check-circle me-1 text-primary"></i> ফিচার কার্ড #<span class="feature-card-index">{{ $loop->iteration }}</span>
                                                        </span>
                                                        <button type="button" class="btn btn-xs btn-outline-danger remove-feature-card-btn" title="মুছে ফেলুন">
                                                            <i class="fe-trash-2 me-1"></i> ডিলিট
                                                        </button>
                                                    </div>
                                                    <div class="row g-2 align-items-center">
                                                        <!-- Icon dropdown + preview -->
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold fs-12 mb-1">আইকন (Icon)</label>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="feature-icon-preview text-danger d-flex align-items-center justify-content-center border rounded bg-light" style="width: 44px; height: 38px; font-size: 20px; flex-shrink: 0; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                                                    <i class="{{ $fItem['icon'] ?? 'fas fa-check-circle' }}"></i>
                                                                </div>
                                                                <select name="feature_icons[]" class="form-select form-select-sm feature-icon-select">
                                                                    @php $matched = false; @endphp
                                                                    @foreach($availableIcons as $iClass => $iLabel)
                                                                        @php
                                                                            $isSel = ($fItem['icon'] ?? '') === $iClass;
                                                                            if ($isSel) $matched = true;
                                                                        @endphp
                                                                        <option value="{{ $iClass }}" {{ $isSel ? 'selected' : '' }}>{{ $iLabel }}</option>
                                                                    @endforeach
                                                                    @if(!$matched && !empty($fItem['icon']))
                                                                        <option value="{{ $fItem['icon'] }}" selected>{{ $fItem['icon'] }} (Custom)</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Title -->
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold fs-12 mb-1">ফিচার শিরোনাম (Title)</label>
                                                            <input type="text" name="feature_titles[]" class="form-control form-control-sm" value="{{ $fItem['title'] ?? '' }}" placeholder="যেমন: ব্লাড প্রেশার নিয়ন্ত্রণ">
                                                        </div>

                                                        <!-- Description -->
                                                        <div class="col-md-5">
                                                            <label class="form-label fw-semibold fs-12 mb-1">সংক্ষিপ্ত বিবরণ (Description)</label>
                                                            <input type="text" name="feature_descs[]" class="form-control form-control-sm" value="{{ $fItem['desc'] ?? '' }}" placeholder="যেমন: প্রাকৃতিকভাবে হাই ব্লাড প্রেশার কমাতে কার্যকর ভূমিকা রাখে।">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-feature-card-btn-footer">
                                        <i class="fe-plus-circle me-1"></i> আরও ফিচার যোগ করুন (+ Add Another Feature)
                                    </button>
                                </div>
                            </div>

                            <!-- Product Comparison Section -->
                            <div class="col-sm-12 my-3">
                                <div class="card border border-success border-opacity-25 bg-light p-3 rounded">
                                    <h5 class="text-success mb-2"><i class="fe-check-square me-1"></i> সঠিক পণ্য চিনুন (Product Comparison Section)</h5>
                                    <p class="text-muted fs-13 mb-3">ক্যাম্পেইন ল্যান্ডিং পেজে সঠিক পণ্য চেনার তুলনা সেকশন কাস্টমাইজ করুন। ফাঁকা রাখলে ডিফল্ট রোজেলা/পণ্য তুলনা দেখাবে।</p>

                                    <div class="row g-2 mb-3">
                                        <div class="col-md-3">
                                            <label for="compare_tag" class="form-label fw-bold">ব্যাজ / ট্যাগ (Section Badge)</label>
                                            <input type="text" class="form-control" name="compare_tag" id="compare_tag" 
                                                   value="{{ old('compare_tag') }}" 
                                                   placeholder="সঠিক পণ্য চিনুন">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="compare_title" class="form-label fw-bold">সেকশন টাইটেল (Main Title)</label>
                                            <input type="text" class="form-control" name="compare_title" id="compare_title" 
                                                   value="{{ old('compare_title') }}" 
                                                   placeholder="পাহাড়ি রোজেলা বনাম সাধারণ / ইন্ডিয়ান রোজেলা">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="compare_subtitle" class="form-label fw-bold">সাব-টাইটেল / বিবরণ (Subtitle)</label>
                                            <input type="text" class="form-control" name="compare_subtitle" id="compare_subtitle" 
                                                   value="{{ old('compare_subtitle') }}" 
                                                   placeholder="কেন আমাদের পার্বত্য চট্টগ্রামের রোজেলা বাজারে সেরা ও অনন্য">
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <!-- Left Side: Good / Our Product -->
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white border border-success border-opacity-50 rounded h-100">
                                                <div class="mb-3">
                                                    <label for="compare_good_title" class="form-label fw-bold text-success">
                                                        <i class="fe-check-circle me-1"></i> আমাদের পণ্যের নাম / শিরোনাম (Our Product Title)
                                                    </label>
                                                    <input type="text" class="form-control" name="compare_good_title" id="compare_good_title" 
                                                           value="{{ old('compare_good_title') }}" 
                                                           placeholder="আমাদের পাহাড়ি রোজেলা">
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label fw-semibold text-muted fs-13 d-flex justify-content-between align-items-center mb-1">
                                                        <span>তুলনামূলক ভালো দিকসমূহ (পয়েন্ট)</span>
                                                        <small class="text-primary">পয়েন্ট সংখ্যা কম বা বেশি করতে পারবেন</small>
                                                    </label>
                                                    <div id="good-points-wrapper">
                                                        @php
                                                            $oldGood = old('compare_good_points', [
                                                                '১০০% আস্ত পাপড়ি: ভাঙা গুঁড়া নয়, আস্ত সুন্দর পাপড়ি পাওয়া যায়।',
                                                                'টাটকা নতুন হার্ভেস্ট: এই বছরের তাজা ফসল, তাই দারুণ সুবাস ও ফ্লেভার।',
                                                                'লাল টকটকে লিকার: প্রাকৃতিক গাঢ় লাল ও আকর্ষণীয় রুবিরঙা লিকার।',
                                                                'বিষমুক্ত পাহাড়ি চাষ: বান্দরবান ও খাগড়াছড়ির প্রাকৃতিকভাবে বেড়ে ওঠা ফসল।'
                                                            ]);
                                                        @endphp
                                                        @foreach($oldGood as $gPoint)
                                                            <div class="input-group mb-2 point-row">
                                                                <span class="input-group-text bg-white text-success fw-bold">✓</span>
                                                                <input type="text" name="compare_good_points[]" class="form-control" value="{{ $gPoint }}" placeholder="পয়েন্ট বিবরণ...">
                                                                <button type="button" class="btn btn-outline-danger remove-point-btn" title="মুছে ফেলুন"><i class="fe-trash-2"></i></button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-success mt-1 add-point-btn" data-target="#good-points-wrapper" data-name="compare_good_points[]" data-icon="✓" data-color="text-success" data-placeholder="পয়েন্ট বিবরণ...">
                                                        <i class="fe-plus-circle me-1"></i> আরও পয়েন্ট যোগ করুন (+ Add Point)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Side: Bad / Market Product -->
                                        <div class="col-md-6">
                                            <div class="p-3 bg-white border border-danger border-opacity-50 rounded h-100">
                                                <div class="mb-3">
                                                    <label for="compare_bad_title" class="form-label fw-bold text-danger">
                                                        <i class="fe-x-circle me-1"></i> সাধারণ পণ্যের নাম / শিরোনাম (Ordinary / Competitor Title)
                                                    </label>
                                                    <input type="text" class="form-control" name="compare_bad_title" id="compare_bad_title" 
                                                           value="{{ old('compare_bad_title') }}" 
                                                           placeholder="সাধারণ / ইন্ডিয়ান রোজেলা">
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label fw-semibold text-muted fs-13 d-flex justify-content-between align-items-center mb-1">
                                                        <span>সাধারণ পণ্যের খারাপ দিকসমূহ (পয়েন্ট)</span>
                                                        <small class="text-danger">পয়েন্ট সংখ্যা কম বা বেশি করতে পারবেন</small>
                                                    </label>
                                                    <div id="bad-points-wrapper">
                                                        @php
                                                            $oldBad = old('compare_bad_points', [
                                                                'কাটা ও ভাঙা পাপড়ি: বেশিরভাগ ক্ষেত্রে ভাঙাচোরা পাপড়ি পাওয়া যায়।',
                                                                'কালচে লালচে লিকার: ফুটানোর পর লিকার কালচে হয়ে যায়।',
                                                                'কম ফ্লেভার ও কম স্বাদ: প্রাকৃতিক সতেজতার অভাব থাকে।',
                                                                'পুরানো স্টকের ঝুঁকি: কেমিক্যাল ও দীর্ঘদিনের সংরক্ষণের আশঙ্কা।'
                                                            ]);
                                                        @endphp
                                                        @foreach($oldBad as $bPoint)
                                                            <div class="input-group mb-2 point-row">
                                                                <span class="input-group-text bg-white text-danger fw-bold">✕</span>
                                                                <input type="text" name="compare_bad_points[]" class="form-control" value="{{ $bPoint }}" placeholder="পয়েন্ট বিবরণ...">
                                                                <button type="button" class="btn btn-outline-danger remove-point-btn" title="মুছে ফেলুন"><i class="fe-trash-2"></i></button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1 add-point-btn" data-target="#bad-points-wrapper" data-name="compare_bad_points[]" data-icon="✕" data-color="text-danger" data-placeholder="পয়েন্ট বিবরণ...">
                                                        <i class="fe-plus-circle me-1"></i> আরও পয়েন্ট যোগ করুন (+ Add Point)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_question_one" class="form-label">Faq 1 Question</label>
                                    <input type="text" class="form-control" name="faq_question_one">
                                    @error('faq_question_one')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_answar_one" class="form-label">Faq 1 Answar</label>
                                    <textarea name="faq_answar_one" rows="6"
                                        class="summernote form-control @error('faq_answar_one') is-invalid @enderror"></textarea>
                                    @error('faq_answar_one')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_question_two" class="form-label">Faq 2 Question (optional)</label>
                                    <input type="text" class="form-control" name="faq_question_two">
                                    @error('faq_question_two')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_answar_two" class="form-label">Faq 2 Answar (optional)</label>
                                    <textarea name="faq_answar_two" rows="6"
                                        class="summernote form-control @error('faq_answar_two') is-invalid @enderror"></textarea>
                                    @error('faq_answar_two')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_question_three" class="form-label">Faq 3 Question
                                        (optional)</label>
                                    <input type="text" class="form-control" name="faq_question_three">
                                    @error('faq_question_three')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_answar_three" class="form-label">Faq 3 Answar (optional)</label>
                                    <textarea name="faq_answar_three" rows="6"
                                        class="summernote form-control @error('faq_answar_three') is-invalid @enderror"></textarea>
                                    @error('faq_answar_three')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_question_four" class="form-label">Faq 4 Question
                                        (optional)</label>
                                    <input type="text" class="form-control" name="faq_question_four">
                                    @error('faq_question_four')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_answar_four" class="form-label">Faq 4 Answar (optional)</label>
                                    <textarea name="faq_answar_four" rows="6"
                                        class="summernote form-control @error('faq_answar_four') is-invalid @enderror"></textarea>
                                    @error('faq_answar_four')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_question_five" class="form-label">Faq 5 Question
                                        (optional)</label>
                                    <input type="text" class="form-control" name="faq_question_five">
                                    @error('faq_question_five')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="faq_answar_five" class="form-label">Faq 5 Answar (optional)</label>
                                    <textarea name="faq_answar_five" rows="6"
                                        class="summernote form-control @error('faq_answar_five') is-invalid @enderror"></textarea>
                                    @error('faq_answar_five')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="campaign_review" class="form-label fw-bold">Customer Reviews (Slider)</label>
                                    <p class="text-muted fs-13 mb-2">Upload screenshot or review images from satisfied customers. Multiple images supported.</p>
                                    <input type="file" name="campaign_review[]" id="campaign_review" class="form-control" multiple onchange="previewReviewImages(this)">
                                    <div id="review_img_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                    @error('campaign_review')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- clone_price end -->

                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status" checked>
                                        <span class="slider round"></span>
                                    </label>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div>
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>

                        </form>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection


@section('script')
    <script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-pickers.init.js"></script>

    <script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".btn-increment").click(function () {
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click", ".btn-danger", function () {
                $(this).parents(".control-group").remove();
            });
            $('.select2').select2();
        });

        function previewBannerImages(input) {
            var preview = document.getElementById('banner_img_preview');
            preview.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(function(file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var div = document.createElement('div');
                        div.className = 'border rounded p-1 bg-light text-center shadow-sm';
                        div.style.width = '140px';
                        div.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="width: 100%; height: 78px; object-fit: cover;"><span class="badge bg-success mt-1 d-block" style="font-size:10px;">Selected</span>';
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        function previewReviewImages(input) {
            var preview = document.getElementById('review_img_preview');
            preview.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(function(file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var div = document.createElement('div');
                        div.className = 'border rounded p-1 bg-light text-center shadow-sm';
                        div.style.width = '100px';
                        div.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="width: 100%; height: 80px; object-fit: cover;"><span class="badge bg-success mt-1 d-block" style="font-size:10px;">Selected</span>';
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        function previewSingleImage(input, targetId) {
            var preview = document.getElementById(targetId);
            if (!preview) return;
            preview.innerHTML = '';
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var div = document.createElement('div');
                    div.className = 'border rounded p-1 bg-white text-center shadow-sm';
                    div.innerHTML = '<span class="d-block text-success fs-11 fw-bold mb-1">Selected:</span><img src="' + e.target.result + '" class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">';
                    preview.appendChild(div);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Comparison Section Dynamic Points Repeater
        $(document).on('click', '.add-point-btn', function() {
            var target = $(this).data('target');
            var name = $(this).data('name');
            var icon = $(this).data('icon');
            var color = $(this).data('color');
            var placeholder = $(this).data('placeholder');
            var html = '<div class="input-group mb-2 point-row">' +
                '<span class="input-group-text bg-white ' + color + ' fw-bold">' + icon + '</span>' +
                '<input type="text" name="' + name + '" class="form-control" placeholder="' + placeholder + '">' +
                '<button type="button" class="btn btn-outline-danger remove-point-btn" title="মুছে ফেলুন"><i class="fe-trash-2"></i></button>' +
                '</div>';
            $(target).append(html);
        });

        $(document).on('click', '.remove-point-btn', function() {
            var wrapper = $(this).closest('.point-row').parent();
            if (wrapper.find('.point-row').length > 1) {
                $(this).closest('.point-row').remove();
            } else {
                $(this).closest('.point-row').find('input').val('');
            }
        });

        // YouTube Video Live Preview
        function extractYouTubeId(url) {
            if (!url) return null;
            url = url.trim();
            if (/^[a-zA-Z0-9_-]{11}$/.test(url)) return url;
            var match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/|youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/i);
            return match ? match[1] : null;
        }

        $('#video').on('input change', function() {
            var val = $(this).val();
            var ytId = extractYouTubeId(val);
            if (ytId) {
                $('#youtube_preview_iframe').attr('src', 'https://www.youtube.com/embed/' + ytId);
                $('#youtube_preview_wrap').show();
            } else {
                $('#youtube_preview_iframe').attr('src', '');
                $('#youtube_preview_wrap').hide();
            }
        });

        // Dynamic Feature Cards Repeater & Live Icon Preview
        $(document).on('change', '.feature-icon-select', function() {
            var selectedIcon = $(this).val();
            $(this).closest('.feature-item-card').find('.feature-icon-preview i').attr('class', selectedIcon);
        });

        $(document).on('click', '#add-feature-card-btn, #add-feature-card-btn-footer', function() {
            var index = $('#feature-cards-wrapper .feature-item-card').length + 1;
            var template = $('#feature-card-template').html();
            var rendered = template.replace(/\{INDEX\}/g, index);
            $('#feature-cards-wrapper').append(rendered);
            reindexFeatureCards();
        });

        $(document).on('click', '.remove-feature-card-btn', function() {
            var wrapper = $('#feature-cards-wrapper');
            if (wrapper.find('.feature-item-card').length > 1) {
                $(this).closest('.feature-item-card').remove();
                reindexFeatureCards();
            } else {
                var card = $(this).closest('.feature-item-card');
                card.find('input').val('');
            }
        });

        function reindexFeatureCards() {
            $('#feature-cards-wrapper .feature-item-card').each(function(i) {
                $(this).find('.feature-card-index').text(i + 1);
            });
        }
    </script>

    <template id="feature-card-template">
        <div class="card mb-3 border border-secondary border-opacity-25 shadow-none feature-item-card bg-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
                    <span class="fw-bold text-dark fs-13">
                        <i class="fe-check-circle me-1 text-primary"></i> ফিচার কার্ড #<span class="feature-card-index">{INDEX}</span>
                    </span>
                    <button type="button" class="btn btn-xs btn-outline-danger remove-feature-card-btn" title="মুছে ফেলুন">
                        <i class="fe-trash-2 me-1"></i> ডিলিট
                    </button>
                </div>
                <div class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold fs-12 mb-1">আইকন (Icon)</label>
                        <div class="d-flex align-items-center gap-2">
                            <div class="feature-icon-preview text-danger d-flex align-items-center justify-content-center border rounded bg-light" style="width: 44px; height: 38px; font-size: 20px; flex-shrink: 0; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <select name="feature_icons[]" class="form-select form-select-sm feature-icon-select">
                                @foreach($availableIcons as $iClass => $iLabel)
                                    <option value="{{ $iClass }}">{{ $iLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold fs-12 mb-1">ফিচার শিরোনাম (Title)</label>
                        <input type="text" name="feature_titles[]" class="form-control form-control-sm" placeholder="ফিচার শিরোনাম...">
                    </div>

                    <div class="col-md-5">
                        <label class="form-label fw-semibold fs-12 mb-1">সংক্ষিপ্ত বিবরণ (Description)</label>
                        <input type="text" name="feature_descs[]" class="form-control form-control-sm" placeholder="সংক্ষিপ্ত বিবরণ...">
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection
