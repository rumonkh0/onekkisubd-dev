@extends('backEnd.layouts.master')
@section('title', 'Landing Page Edit')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('campaign.index') }}" class="btn btn-primary rounded-pill">Manage</a>
                    </div>
                    <h4 class="page-title">Landing Page Edit</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('campaign.update') }}" method="POST" class=row data-parsley-validate=""
                            enctype="multipart/form-data" name="editForm">
                            @csrf
                            <input type="hidden" value="{{ $edit_data->id }}" name="hidden_id">


                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Landing Page Title *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $edit_data->name }}" id="name" required="">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="slug" class="form-label">URL Slug (e.g. rosella-tea)</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        name="slug" value="{{ old('slug', $edit_data->slug) }}" id="slug" placeholder="e.g. rosella-tea">
                                    <small class="text-muted">ঐচ্ছিক — ক্যাম্পেইনের URL পরিবর্তন করতে চাইলে এখানে লিখুন (যেমন: rosella-tea)।</small>
                                    @error('slug')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->

                            {{-- <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="banner" class="form-label">Banner Image</label>
                                    <input type="file" class="form-control @error('banner') is-invalid @enderror"
                                        name="banner" value="{{ $edit_data->banner }}" id="banner">
                                    <img src="{{ asset($edit_data->banner) }}" alt="" class="edit-image">
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
                                    <p class="text-muted fs-13 mb-2">You can select multiple images to create a banner slider.</p>
                                    
                                    @if($edit_data->banners && $edit_data->banners->count() > 0)
                                        <div class="existing-banner-list mb-3">
                                            <span class="d-block mb-1 text-muted fs-13 fw-semibold">Existing Banners ({{ $edit_data->banners->count() }}):</span>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($edit_data->banners as $banner_image)
                                                    <div class="position-relative d-inline-block border rounded p-1 bg-light text-center" style="width: 140px;">
                                                        <img src="{{ asset($banner_image->image) }}" alt="Banner" class="img-fluid rounded" style="width: 100%; height: 78px; object-fit: cover;">
                                                        <a href="{{ route('campaign.banner.destroy', ['id' => $banner_image->id]) }}"
                                                           onclick="return confirm('Are you sure you want to delete this banner image?')"
                                                           class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1 rounded-circle"
                                                           style="width: 22px; height: 22px; padding: 0; line-height: 22px; display: inline-flex; align-items: center; justify-content: center;"
                                                           title="Delete this banner">
                                                            <i class="mdi mdi-close"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

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
                            <!-- col end -->

                            {{-- <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="banner_title" class="form-label">Banner Title</label>
                                    <input type="text" class="form-control @error('banner_title') is-invalid @enderror"
                                        name="banner_title" value="{{ $edit_data->banner_title }}" id="banner_title">
                                    @error('banner_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <!-- col-end -->

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="banner_title" class="form-label">Video (Youtube Embed code)</label>
                                    <input type="text" class="form-control @error('video') is-invalid @enderror"
                                        name="video" value="{{ $edit_data->video }}" id="video">
                                    @error('video')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="product_id" class="form-label">Products *</label>
                                    <select class="select2 form-control  @error('product_id') is-invalid @enderror"
                                        value="{{ old('product_id') }}" name="product_id" data-placeholder="Choose ...">
                                        <option value="">Select..</option>
                                        @foreach ($products as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
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
                                    <label for="image_one" class="form-label fw-bold">Gallery Image 1 (রিয়েল ভিউ ১)</label>
                                    <input type="file" class="form-control @error('image_one') is-invalid @enderror"
                                        name="image_one" id="image_one" onchange="previewSingleImage(this, 'image_one_preview')">
                                    <div id="image_one_preview" class="mt-2"></div>
                                    @if($edit_data->image_one)
                                        <div class="mt-2 text-center border rounded p-1 bg-white">
                                            <span class="d-block text-muted fs-11 mb-1">Current Image:</span>
                                            <img src="{{ asset($edit_data->image_one) }}" alt="Gallery Image 1" style="max-height: 120px; max-width: 100%; object-fit: contain; border-radius: 6px;">
                                        </div>
                                    @endif
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
                                    <input type="file" class="form-control @error('image_two') is-invalid @enderror"
                                        name="image_two" id="image_two" onchange="previewSingleImage(this, 'image_two_preview')">
                                    <div id="image_two_preview" class="mt-2"></div>
                                    @if($edit_data->image_two)
                                        <div class="mt-2 text-center border rounded p-1 bg-white">
                                            <span class="d-block text-muted fs-11 mb-1">Current Image:</span>
                                            <img src="{{ asset($edit_data->image_two) }}" alt="Gallery Image 2" style="max-height: 120px; max-width: 100%; object-fit: contain; border-radius: 6px;">
                                        </div>
                                    @endif
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
                                    <input type="file" class="form-control @error('image_three') is-invalid @enderror"
                                        name="image_three" id="image_three" onchange="previewSingleImage(this, 'image_three_preview')">
                                    <div id="image_three_preview" class="mt-2"></div>
                                    @if($edit_data->image_three)
                                        <div class="mt-2 text-center border rounded p-1 bg-white">
                                            <span class="d-block text-muted fs-11 mb-1">Current Image:</span>
                                            <img src="{{ asset($edit_data->image_three) }}" alt="Gallery Image 3" style="height: 100px; width: 100px; object-fit: cover; border-radius: 6px;">
                                        </div>
                                    @endif

                                    @error('image_three')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->

                            {{-- <div class="col-sm-6 mb-3">
                                <label for="image">Review Image *</label>
                                <div class="input-group control-group increment">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" />

                            <div class="input-group-btn">
                                <button class="btn btn-success btn-increment" type="button"><i class="fa fa-plus"></i></button>
                            </div>
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="clone hide" style="display: none;">
                                    <div class="control-group input-group">
                                        <input type="file" name="image" class="form-control" />
                                        <div class="input-group-btn">
                                            <button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_img">
                                    @foreach ($edit_data->images as $image)
                                    <img src="{{asset($image->image)}}" class="edit-image border" alt="" />
                                    <a href="{{route('campaign.image.destroy',['id'=>$image->id])}}" class="btn btn-xs btn-danger waves-effect waves-light"><i class="mdi mdi-close"></i></a>
                                    @endforeach
                                </div>
                            </div> --}}

                            <!-- col-end -->
                            {{-- <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="short_description" class="form-label">Faq 1</label>
                                    <textarea name="short_description"  rows="6" class="summernote form-control @error('short_description') is-invalid @enderror">{{$edit_data->short_description}}</textarea>
                                    @error('short_description')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <!-- col end -->
                            <!-- 4 Steps Section -->
                            <div class="col-sm-12 my-3">
                                <div class="card border border-primary border-opacity-25 bg-light p-3 rounded">
                                    <h5 class="text-primary mb-2"><i class="fe-list me-1"></i> তৈরির সহজ ৪টি ধাপ (4-Step Recipe / Usage Section)</h5>
                                    <p class="text-muted fs-13 mb-3">ক্যাম্পেইন ল্যান্ডিং পেজে ৪টি ধাপের সেকশন কাস্টমাইজ করুন। ফাঁকা রাখলে ডিফল্ট লেখা দেখাবে।</p>

                                    <div class="mb-3">
                                        <label for="step_title" class="form-label fw-bold">সেকশন টাইটেল (Section Title)</label>
                                        <input type="text" class="form-control @error('step_title') is-invalid @enderror" 
                                               name="step_title" id="step_title" 
                                               value="{{ old('step_title', $edit_data->step_title) }}" 
                                               placeholder="সেরা স্বাদের চা তৈরির সহজ ৪টি ধাপ">
                                        @error('step_title')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-6 mb-2">
                                            <label for="step_one" class="form-label fw-semibold">ধাপ ১ (Step 1)</label>
                                            <textarea name="step_one" id="step_one" rows="2" class="form-control" 
                                                      placeholder="প্রথমে পরিচ্ছন্ন পাত্রে প্রয়োজনীয় পরিমাণ পানি ভালো করে ফুটিয়ে নিন।">{{ old('step_one', $edit_data->step_one) }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="step_two" class="form-label fw-semibold">ধাপ ২ (Step 2)</label>
                                            <textarea name="step_two" id="step_two" rows="2" class="form-control" 
                                                      placeholder="ফুটন্ত পানিতে পরিমাণমতো চা পাতা দিন এবং ২-৩ মিনিট ফুটান কড়া লিকারের জন্য।">{{ old('step_two', $edit_data->step_two) }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="step_three" class="form-label fw-semibold">ধাপ ৩ (Step 3)</label>
                                            <textarea name="step_three" id="step_three" rows="2" class="form-control" 
                                                      placeholder="দুধ চা করতে ঘন দুধ ও পরিমাণমতো চিনি মেশান, অথবা লাল চা হিসেবে উপভোগ করুন।">{{ old('step_three', $edit_data->step_three) }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="step_four" class="form-label fw-semibold">ধাপ ৪ (Step 4)</label>
                                            <textarea name="step_four" id="step_four" rows="2" class="form-control" 
                                                      placeholder="ছাঁকনি দিয়ে কাপে ঢেলে পরিবেশন করুন ধোঁয়া ওঠা অতুলনীয় স্বাদের চা!">{{ old('step_four', $edit_data->step_four) }}</textarea>
                                        </div>
                                    </div>
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
                                                   value="{{ old('compare_tag', $edit_data->compare_tag) }}" 
                                                   placeholder="সঠিক পণ্য চিনুন">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="compare_title" class="form-label fw-bold">সেকশন টাইটেল (Main Title)</label>
                                            <input type="text" class="form-control" name="compare_title" id="compare_title" 
                                                   value="{{ old('compare_title', $edit_data->compare_title) }}" 
                                                   placeholder="পাহাড়ি রোজেলা বনাম সাধারণ / ইন্ডিয়ান রোজেলা">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="compare_subtitle" class="form-label fw-bold">সাব-টাইটেল / বিবরণ (Subtitle)</label>
                                            <input type="text" class="form-control" name="compare_subtitle" id="compare_subtitle" 
                                                   value="{{ old('compare_subtitle', $edit_data->compare_subtitle) }}" 
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
                                                           value="{{ old('compare_good_title', $edit_data->compare_good_title) }}" 
                                                           placeholder="আমাদের পাহাড়ি রোজেলা">
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label fw-semibold text-muted fs-13 d-flex justify-content-between align-items-center mb-1">
                                                        <span>তুলনামূলক ভালো দিকসমূহ (পয়েন্ট)</span>
                                                        <small class="text-primary">পয়েন্ট সংখ্যা কম বা বেশি করতে পারবেন</small>
                                                    </label>
                                                    <div id="good-points-wrapper">
                                                        @php
                                                            $savedGood = old('compare_good_points', $edit_data->good_points ?? [
                                                                '১০০% আস্ত পাপড়ি: ভাঙা গুঁড়া নয়, আস্ত সুন্দর পাপড়ি পাওয়া যায়।',
                                                                'টাটকা নতুন হার্ভেস্ট: এই বছরের তাজা ফসল, তাই দারুণ সুবাস ও ফ্লেভার।',
                                                                'লাল টকটকে লিকার: প্রাকৃতিক গাঢ় লাল ও আকর্ষণীয় রুবিরঙা লিকার।',
                                                                'বিষমুক্ত পাহাড়ি চাষ: বান্দরবান ও খাগড়াছড়ির প্রাকৃতিকভাবে বেড়ে ওঠা ফসল।'
                                                            ]);
                                                            if (!is_array($savedGood)) $savedGood = (array)$savedGood;
                                                        @endphp
                                                        @foreach($savedGood as $gPoint)
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
                                                           value="{{ old('compare_bad_title', $edit_data->compare_bad_title) }}" 
                                                           placeholder="সাধারণ / ইন্ডিয়ান রোজেলা">
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label fw-semibold text-muted fs-13 d-flex justify-content-between align-items-center mb-1">
                                                        <span>সাধারণ পণ্যের খারাপ দিকসমূহ (পয়েন্ট)</span>
                                                        <small class="text-danger">পয়েন্ট সংখ্যা কম বা বেশি করতে পারবেন</small>
                                                    </label>
                                                    <div id="bad-points-wrapper">
                                                        @php
                                                            $savedBad = old('compare_bad_points', $edit_data->bad_points ?? [
                                                                'কাটা ও ভাঙা পাপড়ি: বেশিরভাগ ক্ষেত্রে ভাঙাচোরা পাপড়ি পাওয়া যায়।',
                                                                'কালচে লালচে লিকার: ফুটানোর পর লিকার কালচে হয়ে যায়।',
                                                                'কম ফ্লেভার ও কম স্বাদ: প্রাকৃতিক সতেজতার অভাব থাকে।',
                                                                'পুরানো স্টকের ঝুঁকি: কেমিক্যাল ও দীর্ঘদিনের সংরক্ষণের আশঙ্কা।'
                                                            ]);
                                                            if (!is_array($savedBad)) $savedBad = (array)$savedBad;
                                                        @endphp
                                                        @foreach($savedBad as $bPoint)
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
                                    <input type="text" class="form-control" name="faq_question_one"
                                        value="{{ $edit_data->faq_question_one }}">
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
                                        class="summernote form-control @error('faq_answar_one') is-invalid @enderror">{{ $edit_data->faq_answar_one }}</textarea>
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
                                    <input type="text" class="form-control" name="faq_question_two"
                                        value="{{ $edit_data->faq_question_two }}">
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
                                        class="summernote form-control @error('faq_answar_two') is-invalid @enderror">{{ $edit_data->faq_answar_two }}</textarea>
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
                                    <input type="text" class="form-control" name="faq_question_three"
                                        value="{{ $edit_data->faq_question_three }}">
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
                                        class="summernote form-control @error('faq_answar_three') is-invalid @enderror">{{ $edit_data->faq_answar_three }}</textarea>
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
                                    <input type="text" class="form-control" name="faq_question_four"
                                        value="{{ $edit_data->faq_question_four }}">
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
                                        class="summernote form-control @error('faq_answar_four') is-invalid @enderror">{{ $edit_data->faq_answar_four }}</textarea>
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
                                    <input type="text" class="form-control" name="faq_question_five"
                                        value="{{ $edit_data->faq_question_five }}">
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
                                        class="summernote form-control @error('faq_answar_five') is-invalid @enderror">{{ $edit_data->faq_answar_five }}</textarea>
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
                                    
                                    @if($edit_data->images && $edit_data->images->count() > 0)
                                        <div class="existing-review-list mb-3">
                                            <span class="d-block mb-1 text-muted fs-13 fw-semibold">Existing Reviews ({{ $edit_data->images->count() }}):</span>
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($edit_data->images as $review_item)
                                                    <div class="position-relative d-inline-block border rounded p-1 bg-light text-center" style="width: 100px;">
                                                        <img src="{{ asset($review_item->image) }}" alt="Review" class="img-fluid rounded" style="width: 100%; height: 80px; object-fit: cover;">
                                                        <a href="{{ route('campaign.image.destroy', ['id' => $review_item->id]) }}"
                                                           onclick="return confirm('Are you sure you want to delete this review image?')"
                                                           class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1 rounded-circle"
                                                           style="width: 22px; height: 22px; padding: 0; line-height: 22px; display: inline-flex; align-items: center; justify-content: center;"
                                                           title="Delete this review image">
                                                            <i class="mdi mdi-close"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <input type="file" name="campaign_review[]" id="campaign_review" class="form-control" multiple onchange="previewReviewImages(this)">
                                    <div id="review_img_preview" class="d-flex flex-wrap gap-2 mt-2"></div>

                                    @error('campaign_review')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" rows="6"
                                        class="summernote form-control @error('description') is-invalid @enderror">{{ $edit_data->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <!-- col end -->

                            <div class="col-sm-6 mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status"
                                            @if ($edit_data->status == 1) checked @endif>
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
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-pickers.init.js"></script>
    <!-- Plugins js -->
    <script src="{{ asset('public/backEnd/') }}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });
    </script>
    <script type="text/javascript">
        document.forms['editForm'].elements['product_id'].value = "{{ $edit_data->product_id }}"
        $('.select2').select2();
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-increment").click(function() {
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click", ".btn-danger", function() {
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
                        div.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="width: 100%; height: 78px; object-fit: cover;"><span class="badge bg-success mt-1 d-block" style="font-size:10px;">New Selected</span>';
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
                        div.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" style="width: 100%; height: 80px; object-fit: cover;"><span class="badge bg-success mt-1 d-block" style="font-size:10px;">New Selected</span>';
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
                    div.innerHTML = '<span class="d-block text-success fs-11 fw-bold mb-1">New Selection:</span><img src="' + e.target.result + '" class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">';
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
    </script>
@endsection
