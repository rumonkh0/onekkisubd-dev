@extends('backEnd.layouts.master')
@section('title','Landing Page Create')
@section('css')
    <link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />

    <link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('public/backEnd')}}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
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
                                    <label for="video" class="form-label">Video </label>
                                    <input type="text" class="form-control @error('video') is-invalid @enderror" name="video" value="{{ old('video') }}"  id="video">
                                    @error('video')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
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
    </script>
@endsection
