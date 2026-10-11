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
    </script>
@endsection
