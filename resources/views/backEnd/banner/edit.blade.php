@extends('backEnd.layouts.master')
@section('title','Banner Edit')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/cropper/cropper.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('banners.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Banner Edit</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{route('banners.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$edit_data->id}}" name="id">

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="link" class="form-label">link *</label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{$edit_data->link}}" id="link" required="">
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Banner Category / Website Placement *</label>
                             <select class="form-control select2-multiple @error('category_id') is-invalid @enderror" name="category_id" id="category_id" data-toggle="select2" data-placeholder="Choose ..." required>
                                <optgroup>
                                    <option value="">Select Placement Category..</option>
                                    @foreach($categories as $value)
                                    <option value="{{$value->id}}" data-placement="{{$value->placement}}" @if($edit_data->category_id==$value->id)selected @endif>
                                        {{$value->name}}
                                        @if($value->placement && isset(\App\Models\BannerCategory::PLACEMENTS[$value->placement]) && $value->name !== \App\Models\BannerCategory::PLACEMENTS[$value->placement])
                                            — [{{ \App\Models\BannerCategory::PLACEMENTS[$value->placement] }}]
                                        @endif
                                    </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-12 mb-3">
                        <div class="alert alert-info mb-0 py-2" style="font-size: 12.5px;">
                            <strong>Recommended Image Sizes by Placement Position (PC / Tablet / Mobile):</strong><br>
                            • <strong>1. Hero Left Main Slider:</strong> PC: <code>1080×640 px</code> | Tablet: <code>960×580 px</code> | Mobile: <code>750×480 px</code><br>
                            • <strong>2. Hero Right Top Wide Banner:</strong> PC: <code>770×312 px</code> | Tablet: <code>960×366 px</code> | Mobile: <code>750×286 px</code><br>
                            • <strong>3. Hero Right Bottom-Left Banner:</strong> PC: <code>377×312 px</code> | Tablet: <code>470×368 px</code> | Mobile: <code>365×286 px</code><br>
                            • <strong>4. Hero Right Bottom-Right Banner:</strong> PC: <code>377×312 px</code> | Tablet: <code>470×368 px</code> | Mobile: <code>365×286 px</code><br>
                            <span class="text-muted">If an uploaded image does not match the selected placement ratio, the built-in <strong>Image Cropper</strong> opens automatically so you can cut it to fit.</span>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="image" class="form-label">PC / Desktop Image * <small class="cropper-dim-hint text-muted" data-for="image" data-default-hint="(Slider: 1080×640 px | Right Top: 770×312 px | Bottom Left/Right: 377×312 px)">(Slider: 1080×640 px | Right Top: 770×312 px | Bottom Left/Right: 377×312 px)</small></label>
                            <input type="file" class="form-control banner-crop-input @error('image') is-invalid @enderror" accept="image/*" data-placement-source="#category_id" data-device="image" @if($edit_data->image) data-existing-src="{{ asset($edit_data->image) }}" @endif name="image" value="{{ $edit_data->image }}" id="image">
                            @if($edit_data->image)
                                <img src="{{asset($edit_data->image)}}" alt="" class="edit-image banner-existing-thumb mt-2" style="max-height: 80px;">
                            @endif
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="tablet_image" class="form-label">Tablet Image <small class="cropper-dim-hint text-muted" data-for="tablet_image" data-default-hint="(Optional — falls back to PC | Slider: 960×580 px | Right Top: 960×366 px | Bottom Left/Right: 470×368 px)">(Optional — falls back to PC | Slider: 960×580 px | Right Top: 960×366 px | Bottom Left/Right: 470×368 px)</small></label>
                            <input type="file" class="form-control banner-crop-input @error('tablet_image') is-invalid @enderror" accept="image/*" data-placement-source="#category_id" data-device="tablet_image" @if($edit_data->tablet_image) data-existing-src="{{ asset($edit_data->tablet_image) }}" @endif name="tablet_image" id="tablet_image">
                            @if($edit_data->tablet_image)
                                <img src="{{asset($edit_data->tablet_image)}}" alt="" class="edit-image banner-existing-thumb mt-2" style="max-height: 80px;">
                            @endif
                            @error('tablet_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="mobile_image" class="form-label">Mobile Image <small class="cropper-dim-hint text-muted" data-for="mobile_image" data-default-hint="(Optional — falls back to PC | Slider: 750×480 px | Right Top: 750×286 px | Bottom Left/Right: 365×286 px)">(Optional — falls back to PC | Slider: 750×480 px | Right Top: 750×286 px | Bottom Left/Right: 365×286 px)</small></label>
                            <input type="file" class="form-control banner-crop-input @error('mobile_image') is-invalid @enderror" accept="image/*" data-placement-source="#category_id" data-device="mobile_image" @if($edit_data->mobile_image) data-existing-src="{{ asset($edit_data->mobile_image) }}" @endif name="mobile_image" id="mobile_image">
                            @if($edit_data->mobile_image)
                                <img src="{{asset($edit_data->mobile_image)}}" alt="" class="edit-image banner-existing-thumb mt-2" style="max-height: 80px;">
                            @endif
                            @error('mobile_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-12 mb-3">
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
@include('backEnd.partials.image_cropper_modal')
@endsection