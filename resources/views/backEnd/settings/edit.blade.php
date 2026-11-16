@extends('backEnd.layouts.master')
@section('title','General Setting Update')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/cropper/cropper.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('settings.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">General Setting Update</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{route('settings.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$edit_data->id}}">
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $edit_data->name}}" id="name" required="">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="white_logo" class="form-label">White Logo *</label>
                            <input type="file" class="form-control @error('white_logo') is-invalid @enderror" name="white_logo" value="{{ old('white_logo') }}"  id="white_logo" >
                            <img src="{{asset($edit_data->white_logo)}}" class="edit-image" alt="">
                            @error('white_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="dark_logo" class="form-label">Dark Logo *</label>
                            <input type="file" class="form-control @error('dark_logo') is-invalid @enderror" name="dark_logo" value="{{ old('dark_logo') }}"  id="dark_logo" >
                            <img src="{{asset($edit_data->dark_logo)}}" class="edit-image" alt="">
                            @error('dark_logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="favicon" class="form-label">Favicon Logo *</label>
                            <input type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon" value="{{ old('favicon') }}"  id="favicon" >
                            <img src="{{asset($edit_data->favicon)}}" class="edit-image" alt="">
                            @error('favicon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    
                    <div class="col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="status" class="d-block">Status</label>
                            <label class="switch">
                              <input type="checkbox" value="1" name="status" @if($edit_data->status==1)checked @endif>
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

                    <div class="col-12 mt-3">
                        <hr>
                        <h4 class="mb-2">Hero 4-Image Template &amp; Slider Settings</h4>
                        <p class="text-muted mb-2" style="font-size: 13px;">
                            All 4 hero boxes are image-only templates (place your "Order Now / এখনই কিনুন" button directly inside the image graphic). Clicking any image opens its configured link.
                        </p>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-bordered mb-0" style="font-size: 12.5px; background: #f8fafc;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Template Position</th>
                                        <th>PC / Desktop (1024px+)</th>
                                        <th>Tablet (768px – 1023px)</th>
                                        <th>Mobile (&lt; 768px)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>1. Left Main Slider</strong> (Multiple Slides)</td>
                                        <td><code>1080 × 640 px</code> (or <code>1600 × 950 px</code>)</td>
                                        <td><code>960 × 580 px</code> (optional)</td>
                                        <td><code>750 × 480 px</code> (optional)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>2. Right Top Banner</strong> (Wide)</td>
                                        <td><code>770 × 312 px</code> (or <code>1150 × 466 px</code>)</td>
                                        <td><code>960 × 366 px</code> (optional)</td>
                                        <td><code>750 × 286 px</code> (optional)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>3. Right Bottom-Left Banner</strong></td>
                                        <td><code>377 × 312 px</code> (or <code>600 × 496 px</code>)</td>
                                        <td><code>470 × 368 px</code> (optional)</td>
                                        <td><code>365 × 286 px</code> (optional)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>4. Right Bottom-Right Banner</strong></td>
                                        <td><code>377 × 312 px</code> (or <code>600 × 496 px</code>)</td>
                                        <td><code>470 × 368 px</code> (optional)</td>
                                        <td><code>365 × 286 px</code> (optional)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Slot 1: Left Main Hero Slider Slides -->
                    <div class="col-12 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">1. Left Main Hero Slider Slides</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-hero-slide-btn">+ Add New Slide</button>
                        </div>

                        <div id="hero-slides-list">
                            @foreach($heroSlides ?? [] as $slide)
                                <div class="card border mb-2">
                                    <div class="card-body py-2 px-3">
                                        <div class="row align-items-start g-2">
                                            <div class="col-md-3">
                                                <label class="form-label mb-1">Slide #{{ $loop->iteration }} Click Link (URL)</label>
                                                <input type="text" class="form-control form-control-sm" name="hero_slides[{{ $slide->id }}][link]" value="{{ $slide->link }}" placeholder="https://onekkisubd.com/product/...">
                                                <div class="mt-2 d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="hero_slides[{{ $slide->id }}][status]" value="1" id="slide_status_{{ $slide->id }}" {{ $slide->status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="slide_status_{{ $slide->id }}">Active</label>
                                                    </div>
                                                    <div class="form-check text-danger">
                                                        <input class="form-check-input" type="checkbox" name="hero_slides[{{ $slide->id }}][delete]" value="1" id="slide_del_{{ $slide->id }}">
                                                        <label class="form-check-label" for="slide_del_{{ $slide->id }}">Delete</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-1">PC Image <small class="text-muted">(1080×640 px)</small></label>
                                                <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="hero_slider" data-device="image" @if($slide->image) data-existing-src="{{ asset($slide->image) }}" @endif name="hero_slides[{{ $slide->id }}][image]">
                                                @if($slide->image)
                                                    <img src="{{ asset($slide->image) }}" alt="PC Slide" class="mt-1 rounded banner-existing-thumb" style="max-height: 45px;">
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-1">Tablet Image <small class="text-muted">(960×580 px, opt.)</small></label>
                                                <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="hero_slider" data-device="tablet_image" @if($slide->tablet_image) data-existing-src="{{ asset($slide->tablet_image) }}" @endif name="hero_slides[{{ $slide->id }}][tablet_image]">
                                                @if($slide->tablet_image)
                                                    <img src="{{ asset($slide->tablet_image) }}" alt="Tablet Slide" class="mt-1 rounded banner-existing-thumb" style="max-height: 45px;">
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label mb-1">Mobile Image <small class="text-muted">(750×480 px, opt.)</small></label>
                                                <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="hero_slider" data-device="mobile_image" @if($slide->mobile_image) data-existing-src="{{ asset($slide->mobile_image) }}" @endif name="hero_slides[{{ $slide->id }}][mobile_image]">
                                                @if($slide->mobile_image)
                                                    <img src="{{ asset($slide->mobile_image) }}" alt="Mobile Slide" class="mt-1 rounded banner-existing-thumb" style="max-height: 45px;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="new-hero-slides-container"></div>
                    </div>

                    <!-- Slots 2, 3, 4: Right-Side 3 Image Banners -->
                    <div class="col-12 mb-4">
                        <h5 class="mb-2">2, 3, 4. Right-Side Image Banners</h5>
                        @php
                            $promoSlots = [
                                0 => ['title' => '2. Top Wide Banner', 'placement' => 'hero_right_top', 'pc' => '770×312 px', 'tab' => '960×366 px', 'mob' => '750×286 px'],
                                1 => ['title' => '3. Bottom Left Banner', 'placement' => 'hero_right_bottom_left', 'pc' => '377×312 px', 'tab' => '470×368 px', 'mob' => '365×286 px'],
                                2 => ['title' => '4. Bottom Right Banner', 'placement' => 'hero_right_bottom_right', 'pc' => '377×312 px', 'tab' => '470×368 px', 'mob' => '365×286 px'],
                            ];
                        @endphp
                        @foreach($promoSlots as $slotIdx => $slotInfo)
                            @php $promo = ($heroPromos ?? collect())->values()->get($slotIdx); @endphp
                            <div class="card border mb-2">
                                <div class="card-body py-2 px-3">
                                    <input type="hidden" name="hero_promos[{{ $slotIdx }}][id]" value="{{ $promo->id ?? '' }}">
                                    <div class="row align-items-start g-2">
                                        <div class="col-md-3">
                                            <label class="form-label mb-1"><strong>{{ $slotInfo['title'] }}</strong> Link</label>
                                            <input type="text" class="form-control form-control-sm" name="hero_promos[{{ $slotIdx }}][link]" value="{{ $promo->link ?? '' }}" placeholder="https://onekkisubd.com/...">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="hero_promos[{{ $slotIdx }}][status]" value="1" id="promo_status_{{ $slotIdx }}" {{ (!$promo || $promo->status == 1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="promo_status_{{ $slotIdx }}">Active</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label mb-1">PC Image <small class="text-muted">({{ $slotInfo['pc'] }})</small></label>
                                            <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="{{ $slotInfo['placement'] }}" data-device="image" @if($promo && $promo->image) data-existing-src="{{ asset($promo->image) }}" @endif name="hero_promos[{{ $slotIdx }}][image]">
                                            @if($promo && $promo->image)
                                                <img src="{{ asset($promo->image) }}" alt="{{ $slotInfo['title'] }}" class="mt-1 rounded banner-existing-thumb" style="max-height: 45px;">
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label mb-1">Tablet Image <small class="text-muted">({{ $slotInfo['tab'] }}, opt.)</small></label>
                                            <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="{{ $slotInfo['placement'] }}" data-device="tablet_image" @if($promo && $promo->tablet_image) data-existing-src="{{ asset($promo->tablet_image) }}" @endif name="hero_promos[{{ $slotIdx }}][tablet_image]">
                                            @if($promo && $promo->tablet_image)
                                                <img src="{{ asset($promo->tablet_image) }}" alt="Tablet {{ $slotInfo['title'] }}" class="mt-1 rounded banner-existing-thumb" style="max-height: 45px;">
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label mb-1">Mobile Image <small class="text-muted">({{ $slotInfo['mob'] }}, opt.)</small></label>
                                            <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="{{ $slotInfo['placement'] }}" data-device="mobile_image" @if($promo && $promo->mobile_image) data-existing-src="{{ asset($promo->mobile_image) }}" @endif name="hero_promos[{{ $slotIdx }}][mobile_image]">
                                            @if($promo && $promo->mobile_image)
                                                <img src="{{ asset($promo->mobile_image) }}" alt="Mobile {{ $slotInfo['title'] }}" class="mt-1 rounded banner-existing-thumb" style="max-height: 45px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

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
<!-- Plugins js -->
<script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
<script>
    $(".summernote").summernote({
        placeholder: "Enter Your Text Here",
    });

    (function() {
        var newSlideIndex = 0;
        $('#add-hero-slide-btn').on('click', function() {
            var idx = newSlideIndex++;
            var html = `
                <div class="card border border-primary mb-2 new-slide-row">
                    <div class="card-body py-2 px-3">
                        <div class="row align-items-start g-2">
                            <div class="col-md-3">
                                <label class="form-label mb-1">New Slide Click Link (URL)</label>
                                <input type="text" class="form-control form-control-sm" name="new_hero_slides[${idx}][link]" placeholder="https://onekkisubd.com/product/...">
                                <div class="mt-2 d-flex align-items-center gap-2">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" name="new_hero_slides[${idx}][status]" value="1" checked>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <button type="button" class="btn btn-xs btn-outline-danger remove-new-slide">Remove</button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1">PC Image * <small class="text-muted">(1080×640 px)</small></label>
                                <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="hero_slider" data-device="image" name="new_hero_slides[${idx}][image]" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1">Tablet Image <small class="text-muted">(960×580 px, opt.)</small></label>
                                <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="hero_slider" data-device="tablet_image" name="new_hero_slides[${idx}][tablet_image]">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label mb-1">Mobile Image <small class="text-muted">(750×480 px, opt.)</small></label>
                                <input type="file" class="form-control form-control-sm banner-crop-input" accept="image/*" data-placement="hero_slider" data-device="mobile_image" name="new_hero_slides[${idx}][mobile_image]">
                            </div>
                        </div>
                    </div>
                </div>`;
            $('#new-hero-slides-container').append(html);
        });

        $(document).on('click', '.remove-new-slide', function() {
            $(this).closest('.new-slide-row').remove();
        });
    })();
</script>
@include('backEnd.partials.image_cropper_modal')
@endsection