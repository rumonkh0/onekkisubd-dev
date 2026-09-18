@extends('backEnd.layouts.master') @section('title', 'Product Edit') @section('css')
<style>
    .increment_btn,
    .remove_btn,
    .btn-warning {
        margin-top: -17px;
        margin-bottom: 10px;
    }

    #taka {
        padding: 6px;
        line-height: 35px;
    }
</style>
<link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
    type="text/css" />
@endsection @section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Product Edit</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data"
                        name="editForm">
                        @csrf
                        <input type="hidden" value="{{ $edit_data->id }}" name="id" id="product_id" />
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $edit_data->name }}" id="name" required="" />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="product_code" class="form-label">Product Code *</label>
                                <input type="text" class="form-control @error('product_code') is-invalid @enderror"
                                    name="product_code" value="{{ $edit_data->product_code }}" id="product_code"
                                    required="" />
                                @error('product_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Categories *</label>
                                <select id="category_id"
                                    class="form-control form-select select2 @error('category_id') is-invalid @enderror"
                                    name="category_id" value="{{ old('category_id') }}" required>
                                    <optgroup>
                                        <option value="">Select..</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if ($edit_data->category_id == $category->id) selected @endif>{{ $category->name }}
                                            </option>
                                            @foreach ($category->childrenCategories as $childCategory)
                                                <option value="{{ $childCategory->id }}"
                                                    @if ($edit_data->category_id == $childCategory->id) selected @endif>-
                                                    {{ $childCategory->name }}</option>
                                                }
                                            @endforeach
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
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="subcategory_id" class="form-label">SubCategories (Optional)</label>
                                <select
                                    class="form-control form-select select2-multiple @error('subcategory_id') is-invalid @enderror"
                                    id="subcategory_id" name="subcategory_id" data-placeholder="Choose ...">
                                    <optgroup>
                                        <option value="">Select..</option>
                                        @foreach ($subcategory as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->subcategoryName }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('subcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="childcategory_id" class="form-label">Child Categories (Optional)</label>
                                <select
                                    class="form-control form-select select2-multiple @error('childcategory_id') is-invalid @enderror"
                                    id="childcategory_id" name="childcategory_id" data-placeholder="Choose ...">
                                    <optgroup>
                                        <option value="">Select..</option>
                                        @foreach ($childcategory as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->childcategoryName }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('childcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="brand_id" class="form-label">Brands</label>
                                <select class="form-control select2 @error('brand_id') is-invalid @enderror"
                                    value="{{ old('brand_id') }}" name="brand_id" id="brand_id">
                                    <option value="">Select..</option>
                                    @foreach ($brands as $value)
                                        <option value="{{ $value->id }}"
                                            @if ($edit_data->brand_id == $value->id) selected @endif>{{ $value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="purchase_price" class="form-label">Purchase Price </label>
                                <input type="text"
                                    class="form-control @error('purchase_price') is-invalid @enderror"
                                    name="purchase_price" value="{{ $edit_data->purchase_price }}"
                                    id="purchase_price" required />
                                @error('purchase_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="old_price" class="form-label">Old Price *</label>
                                <input type="text" class="form-control @error('old_price') is-invalid @enderror"
                                    name="old_price" value="{{ $edit_data->old_price }}" id="old_price" />
                                @error('old_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="new_price" class="form-label">New Price *</label>
                                <input type="text" class="form-control @error('new_price') is-invalid @enderror"
                                    name="new_price" value="{{ $edit_data->new_price }}" id="new_price" required />
                                @error('new_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="stock" class="form-label">Stock *</label>
                                <input type="text" class="form-control @error('stock') is-invalid @enderror"
                                    name="stock" value="{{ $edit_data->stock }}" id="stock" />
                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->

                        <div class="col-sm-4 mb-3">
                            <label for="image">Image *</label>
                            <div class="input-group control-group increment">
                                <input type="file" name="productimage" id="productimage"
                                    class="form-control @error('image') is-invalid @enderror" />

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="product_img">
                                @foreach ($edit_data->images as $image)
                                    <img src="{{ asset($image->image) }}" class="edit-image border"
                                        alt="" />
                                @endforeach
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="pro_unit" class="form-label">Product Unit (Optional)</label>
                                <input type="text" class="form-control @error('pro_unit') is-invalid @enderror"
                                    name="pro_unit" value="{{ $edit_data->pro_unit }}" id="pro_unit" />
                                @error('pro_unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="pro_video" class="form-label">Product Video (Optional)</label>
                                <input type="text" class="form-control @error('pro_video') is-invalid @enderror"
                                    name="pro_video" value="{{ $edit_data->pro_video }}" id="pro_video" />
                                @error('pro_video')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="pro_video" class="form-label">Product Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="">Choose</option>
                                    <option value="0" @if ($edit_data->type == 0) selected @endif>Single
                                    </option>
                                    <option value="1" @if ($edit_data->type == 1) selected @endif>Varient
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-5 mb-3">
                            <div class="form-group">
                                <label for="">Short Description</label>
                                <textarea name="short_des" id="short_des" rows="3" class="summernote form-control">{{ $edit_data->short_des }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group mb-3">
                                <label for="prebooking" class="form-label">Partial Payment (Optional)</label>
                                <input type="text" class="form-control @error('prebooking') is-invalid @enderror"
                                    name="prebooking" value="{{ $edit_data->prebooking }}" id="prebooking" />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group"
                                style="padding: 10px;padding-top: 3px;margin:0;padding-bottom:3px;width:96%;margin-left: 8px;border-radius: 8px;padding-left: 0;margin-left: -0;">
                                <label class="fileContainer">
                                    <span style="font-size: 20px;">Slider
                                        image</span>
                                </label>
                                <br>
                                <button type="button" class="btn btn-danger d-block mb-2" style="background: red">
                                    <input type="file" onchange="prevPost_Img()" name="PostImage[]"
                                        id="PostImage" multiple>
                                </button>
                            </div>
                            <div class="file">
                                <div id="prevFile" style="width: 100%;float:left;background: lightgray;">
                                    @if (json_decode($edit_data->PostImage))
                                        @forelse(json_decode($edit_data->PostImage) as $image)
                                            <div class="postImg" style="width:25%;float:left;position:relative;">
                                                <img src="{{ asset('public/images/product/slider') }}/{{ $image }}"
                                                    alt="" id="previewImage"
                                                    style="border-radius: 10px;width:100%;padding:5px;">
                                            </div>
                                        @empty
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header p-0" id="headingOne">
                                    <h5 class="mb-0">
                                        <button type="button" id="collupshead" class="btn btn-link"
                                            data-bs-toggle="collapse" data-bs-target="#collapseVariant"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            <h5 class="text-uppercase m-0">Product Variant<span
                                                    class="text-danger">*</span></h5>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseVariant" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body p-0">
                                        <table id="mediaTable" style="width: 100% !important;"
                                            class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Color</th>
                                                    <th>Image</th>
                                                    <th>Choose File</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($varients as $varient)
                                                    <tr>
                                                        <td><input type="hidden" id="mID"
                                                                style="width:80px;border: none;color: black;"
                                                                value="{{ $varient->id }}"><input type="text"
                                                                id="mediaID"
                                                                style="width:80px;border: none;color: black;"
                                                                value="{{ $varient->color_id }}" disabled></td>
                                                        <td><input type="text" name="color" id="color"
                                                                style="width:80px;border: none;color: black;"
                                                                value="{{ $varient->color }}" disabled> </td>
                                                        <td><img src="{{ asset($varient->Image) }}"
                                                                style="width:50px"></td>
                                                        <td><input type="file" id="image"
                                                                class="form-control"></td>
                                                        <td><button type="button"
                                                                class="btn btn-sm btn-danger mdelete-btn"><i
                                                                    class="fa fa-trash"></i></button></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">
                                                        <select id="mediavariantID" style="width: 100%;">
                                                            <option value="">Select Product Variant</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-4">
                            <div class="card">
                                <div class="card-header p-0" id="headingOne">
                                    <h5 class="mb-0">
                                        <button type="button" id="collupshead" class="btn btn-link"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSize"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            <h5 class="text-uppercase m-0">Product Size / Weight<span
                                                    class="text-danger">*</span></h5>
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseSize" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion">
                                    <div class="card-body p-0">
                                        <table id="sizeTable" style="width: 100% !important;"
                                            class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Size / Weight</th>
                                                    <th>Quantity</th>
                                                    <th>Regular Price</th>
                                                    <th>Discount</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sizes as $size)
                                                    <tr>
                                                        <td><input type="hidden" id="sID"
                                                                style="width:80px;border: none;color: black;"
                                                                value="{{ $size->id }}"><input type="text"
                                                                id="sizeID"
                                                                style="width:80px;border: none;color: black;"
                                                                value="{{ $size->size_id }}" disabled></td>
                                                        <td><input type="text" name="size" id="size"
                                                                style="width:80px;border: none;color: black;"
                                                                value="{{ $size->size }}" disabled> </td>
                                                        <td><input type="text" name="quantity"
                                                            value="{{ $size->quantity }}" id="quantity"
                                                            class="form-control" style="width:100px;float:left;"></td>
                                                        <td><input type="text" name="RegularPrice"
                                                                value="{{ $size->RegularPrice }}" id="RegularPrice"
                                                                class="form-control" style="width:100px;float:left;">
                                                            <span id="taka">TK</span>
                                                        </td>
                                                        <td><input type="text" name="Discount"
                                                                value="{{ $size->Discount }}" id="Discount"
                                                                class="form-control" style="width:100px;float:left;">
                                                            <span id="taka">TK</span>
                                                        </td>
                                                        <td><button type="button"
                                                                class="btn btn-sm btn-danger sdelete-btn"><i
                                                                    class="fa fa-trash"></i></button></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">
                                                        <select id="sizevariantID" style="width: 100%;">
                                                            <option value="">Select Product Size / Weight
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--col end -->
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="6" id="description"
                                    class="summernote form-control @error('description') is-invalid @enderror">{{ $edit_data->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <!-- col end -->
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="status" class="d-block">Status</label>
                                <label class="switch">
                                    <input type="checkbox" value="1" name="status" id="status"
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
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="topsale" class="d-block">Flash Sales</label>
                                <label class="switch">
                                    <input type="checkbox" id="topsale_checkbox"
                                        {{ $edit_data->topsale == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                                <input type="hidden" name="topsale" id="topsale"
                                    value="{{ $edit_data->topsale }}">
                                @error('topsale')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <script>
                            document.getElementById('topsale_checkbox').addEventListener('change', function() {
                                document.getElementById('topsale').value = this.checked ? 1 : 0;
                            });
                        </script>

                        <!-- col end -->
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="feature_product" class="d-block">Top Trending</label>
                                <label class="switch">
                                    <input type="checkbox" id="toptrending_checkbox"
                                        {{ $edit_data->feature_product == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                                <input type="hidden" name="feature_product" id="feature_product"
                                    value="{{ $edit_data->feature_product }}">
                                @error('feature_product')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <script>
                            document.getElementById('toptrending_checkbox').addEventListener('change', function() {
                                document.getElementById('feature_product').value = this.checked ? 1 : 0;
                            });
                        </script>

                        <!-- col end -->
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="deal_of_theday" class="d-block">Deal Of The Day</label>
                                <label class="switch">
                                    <input type="checkbox" id="deal_of_theday_checkbox"
                                        {{ $edit_data->deal_of_theday == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                                <input type="hidden" name="deal_of_theday" id="deal_of_theday"
                                    value="{{ $edit_data->deal_of_theday }}">
                                @error('deal_of_theday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <script>
                            document.getElementById('deal_of_theday_checkbox').addEventListener('change', function() {
                                document.getElementById('deal_of_theday').value = this.checked ? 1 : 0;
                            });
                        </script>
                        <!-- col end -->

                        <div>
                            <input type="button" id="submit" class="btn btn-success" value="Submit" />
                        </div>
                    </form>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
</div>
@endsection @section('script')
<script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
<!-- Plugins js -->
<script src="{{ asset('public/backEnd/') }}/assets/libs//summernote/summernote-lite.min.js"></script>
<script>
    $(".summernote").summernote({
        placeholder: "Enter Your Text Here",
    });
</script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var token = $("input[name='_token']").val();

        $(document).on("click", "#submit", function() {
            var name = $("#name");
            var category_id = $("#category_id");
            var product_code = $("#product_code");
            var subcategory_id = $("#subcategory_id");
            var childcategory_id = $("#childcategory_id");
            var brand_id = $("#brand_id");
            var purchase_price = $("#purchase_price");
            var old_price = $("#old_price");
            var new_price = $("#new_price");
            var stock = $("#stock");
            var pro_unit = $("#pro_unit");
            var pro_video = $("#pro_video");
            var description = $("#description");
            var status = $("#status");
            var topsale = $("#topsale");
            var deal_of_theday = $("#deal_of_theday");
            var feature_product = $("#feature_product");
            var type = $("#type");
            var short_des = $("#short_des");
            var prebooking = $("#prebooking");


            if (name.val() == '') {
                toastr.error('Product Name Should Not Be Empty');
                name.css('border', '1px solid red');
                return;
            }
            name.css('border', '1px solid #ced4da');

            if (product_code.val() == '') {
                toastr.error('Product Code Should Not Be Empty');
                product_code.css('border', '1px solid red');
                return;
            }
            product_code.css('border', '1px solid #ced4da');

            if (category_id.val() == '') {
                toastr.error('Category Should Not Be Empty');
                category_id.closest('.form-group').css('border', '1px solid red');
                return;
            }
            category_id.closest('.form-group').css('border', '1px solid #ced4da');

            if (type.val() == '') {
                toastr.error('Type Should Not Be Empty');
                type.closest('.form-group').css('border', '1px solid red');
                return;
            }
            type.closest('.form-group').css('border', '1px solid #ced4da');


            if (stock.val() == '') {
                toastr.error('Stock Should Not Be Empty');
                stock.closest('.form-group').css('border', '1px solid red');
                return;
            }
            stock.closest('.form-group').css('border', '1px solid #ced4da');

            if (type.val() == 0) {

                var old_price = $("#old_price");
                var new_price = $("#new_price");

                if (old_price.val() == '') {
                    toastr.error('Old Price Should Not Be Empty');
                    old_price.closest('.form-group').css('border', '1px solid red');
                    return;
                }
                new_price.closest('.form-group').css('border', '1px solid #ced4da');
                if (new_price.val() == '') {
                    toastr.error('New Price Should Not Be Empty');
                    new_price.closest('.form-group').css('border', '1px solid red');
                    return;
                }
                new_price.closest('.form-group').css('border', '1px solid #ced4da');

            } else {
                var variant = [];
                var variantCount = 0;
                $("#mediaTable tbody tr").each(function(index, value) {
                    var currentRow = $(this);
                    var obj = {};
                    obj.mID = currentRow.find("#mID").val();
                    obj.mediaID = currentRow.find("#mediaID").val();
                    obj.color = currentRow.find("#color").val();
                    obj.image = currentRow.find("#image")[0].files[0];
                    variant.push(obj);
                    variantCount++;
                });

                var size = [];
                var sizeCount = 0;
                $("#sizeTable tbody tr").each(function(index, value) {
                    var currentRow = $(this);
                    var obj = {};
                    obj.sID = currentRow.find("#sID").val();
                    obj.sizeID = currentRow.find("#sizeID").val();
                    obj.size = currentRow.find("#size").val();
                    obj.quantity = currentRow.find("#quantity").val();
                    obj.RegularPrice = currentRow.find("#RegularPrice").val();
                    obj.Discount = currentRow.find("#Discount").val();
                    size.push(obj);
                    sizeCount++;
                });

                if (variant == 0) {
                    toastr.error('Product Color Should Not Be Empty');
                    return;
                }

                if (size == 0) {
                    toastr.error('Size / Weight Should Not Be Empty');
                    return;
                }

            }

            var formData = new FormData();
            formData.append('name', name.val());
            formData.append('product_code', product_code.val());
            formData.append('category_id', category_id.val());
            formData.append('subcategory_id', subcategory_id.val());
            formData.append('childcategory_id', childcategory_id.val());
            formData.append('brand_id', brand_id.val());
            formData.append('purchase_price', purchase_price.val());
            formData.append('old_price', old_price.val());
            formData.append('new_price', new_price.val());
            formData.append('stock', stock.val());
            formData.append('pro_unit', pro_unit.val());
            formData.append('pro_video', pro_video.val());
            formData.append('description', description.val());
            formData.append('status', status.val());
            formData.append('topsale', topsale.val());
            formData.append('deal_of_theday', deal_of_theday.val());
            formData.append('feature_product', feature_product.val());
            formData.append('type', type.val());
            formData.append('short_des', short_des.val());
            formData.append('prebooking', prebooking.val());
            formData.append('image', $('#productimage')[0].files[0]);

            var fileList = $('#PostImage').get(0).files;

            if (fileList.length > 0) {
                for (let i = 0; i < fileList.length; i += 1) {
                    formData.append('PostImage[]', fileList[i]);
                }
            }

            if (type.val() == 0) {

            } else {
                variant.forEach((item, index) => {
                    Object.entries(item).forEach(([key, value]) => {
                        formData.append(`variant[${index}][${key}]`, value);
                    });
                });
                size.forEach((item, index) => {
                    Object.entries(item).forEach(([key, value]) => {
                        formData.append(`size[${index}][${key}]`, value);
                    });
                });
            }

            formData.append('_token', token);
            formData.append('product_id', $("#product_id").val());
            $.ajax({
                type: "POST",
                url: '{{ url('admin/products/update') }}',
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    var data = JSON.parse(response);
                    if (data["status"] === "success") {
                        toastr.success(data["message"]);
                        window.location.href = "{{ url('admin/products/manage') }}";

                    } else {
                        toastr.error(data["message"])
                    }
                }
            });
        });


        $("#mediavariantID").select2({
            placeholder: "Select a Product Variant",
            templateResult: function(state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<span>' +
                    state.text +
                    "</span>"
                );
                return $state;
            },
            ajax: {
                type: 'GET',
                url: '{{ url('admin/product/color') }}',
                processResults: function(data) {
                    var data = $.parseJSON(data);
                    return {
                        results: data.data
                    };
                }
            }
        }).trigger("change").on("select2:select", function(e) {
            $("#mediaTable tbody").append(
                "<tr>" +
                '<td><input type="hidden" id="mID" style="width:80px;border: none;color: black;" value="" disabled><input type="text" id="mediaID" style="width:80px;border: none;color: black;" value="' +
                e.params.data.id + '" disabled></td>' +
                '<td><input type="text" name="color" id="color" style="width:80px;border: none;color: black;" value="' +
                e.params.data.text + '" disabled> </td>' +
                '<td><img src="" style="width:50px"></td>' +
                '<td><input type="file" id="image" class="form-control"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger mdelete-btn"><i class="fa fa-trash"></i></button></td>\n' +
                "</tr>"
            );
        });

        $("#sizevariantID").select2({
            placeholder: "Select a Product Size",
            templateResult: function(state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<span>' +
                    state.text +
                    "</span>"
                );
                return $state;
            },
            ajax: {
                type: 'GET',
                url: '{{ url('admin/product/size-weight') }}',
                processResults: function(data) {
                    var data = $.parseJSON(data);
                    return {
                        results: data.data
                    };
                }
            }
        }).trigger("change").on("select2:select", function(e) {
            $("#sizeTable tbody").append(
                "<tr>" +
                '<td><input type="hidden" id="sID" style="width:80px;border: none;color: black;" value="" disabled><input type="text" id="sizeID" style="width:80px;border: none;color: black;" value="' +
                e.params.data.id + '" disabled></td>' +
                '<td><input type="text" name="size" id="size" style="width:80px;border: none;color: black;" value="' +
                e.params.data.text + '" disabled> </td>' +
                '<td><input type="text" name="quantity" id="quantity" class="form-control" style="width:100px;float:left;">  <span id="taka">TK</span></td>' +
                '<td><input type="text" name="RegularPrice" id="RegularPrice" class="form-control" style="width:100px;float:left;">  <span id="taka">TK</span></td>' +
                '<td><input type="text" name="Discount" id="Discount" class="form-control" style="width:100px;float:left;"> <span id="taka">TK</span></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger sdelete-btn"><i class="fa fa-trash"></i></button></td>\n' +
                "</tr>"
            );
        });

        $(document).on("click", ".mdelete-btn", function() {
            var mID = $(this).closest("tr").find("#mID").val();
            $(this).closest("tr").remove();
            $.ajax({
                type: "GET",
                url: '{{ url('admin/remove-varient/') }}' + '/' + mID,

                success: function(response) {
                    var data = JSON.parse(response);
                    if (data["status"] === "success") {
                        toastr.success(data["message"]);
                    } else {
                        toastr.error(data["message"])
                    }
                }
            });
        });
        $(document).on("click", ".sdelete-btn", function() {
            var sID = $(this).closest("tr").find("#sID").val();
            $(this).closest("tr").remove();
            $.ajax({
                type: "GET",
                url: '{{ url('admin/remove-size/') }}' + '/' + sID,

                success: function(response) {
                    var data = JSON.parse(response);
                    if (data["status"] === "success") {
                        toastr.success(data["message"]);
                    } else {
                        toastr.error(data["message"])
                    }
                }
            });
        });


        $(document).on("click", ".delete-btn", function() {
            $(this).closest("tr").remove();
        });

    });

    var PostImages = [];

    function prevPost_Img() {
        var PostImage = document.getElementById('PostImage').files;

        for (i = 0; i < PostImage.length; i++) {
            if (check_duplicate(PostImage[i].name)) {
                PostImages.push({
                    "name": PostImage[i].name,
                    "url": URL.createObjectURL(PostImage[i]),
                    "file": PostImage[i],
                });
            } else {
                alert(PostImage[i].name + 'is already added to your list');
            }
        }

        document.getElementById("prevFile").innerHTML = PostImage_show();

    }

    function check_duplicate(name) {
        var PostImage = true;
        if (PostImages.length > 0) {
            for (e = 0; e < PostImages.length; e++) {
                if (PostImages[e].name == name) {
                    PostImage = false;
                    break;
                }
            }
        }
        return PostImage;
    }

    function PostImage_show() {
        var PostImage = "";
        PostImages.forEach((i) => {
            PostImage += `<div class="postImg" style="width:25%;float:left;position:relative;">
                                <img src="` + i.url + `" alt="" id="previewImage" style="border-radius: 10px;width:100%;padding:5px;">
                                <span onclick="removeSelectedPostImage(` + PostImages.indexOf(i) + `)" style="position: absolute;right: 0;cursor: pointer;font-size: 31px;color: red;margin-top: -8px;margin-right: 8px;">&times</span>
                            </div>`;
        })
        return PostImage;
    }

    function removeSelectedPostImage(e) {
        PostImages.splice(e, 1);
        document.getElementById("prevFile").innerHTML = PostImage_show();
    }

    var editPostImages = [];

    function editprevPost_Img() {
        $('#viewprevFile').html('');
        var editPostImage = document.getElementById('editPostImage').files;

        for (i = 0; i < editPostImage.length; i++) {
            if (check_duplicate(editPostImage[i].name)) {
                editPostImages.push({
                    "name": editPostImage[i].name,
                    "url": URL.createObjectURL(editPostImage[i]),
                    "file": editPostImage[i],
                });
            } else {
                alert(editPostImage[i].name + 'is already added to your list');
            }
        }

        document.getElementById("editprevFile").innerHTML = editPostImage_show();

    }

    function check_duplicate(name) {
        var editPostImage = true;
        if (editPostImages.length > 0) {
            for (e = 0; e < editPostImages.length; e++) {
                if (editPostImages[e].name == name) {
                    editPostImage = false;
                    break;
                }
            }
        }
        return editPostImage;
    }

    function editPostImage_show() {
        var editPostImage = "";
        editPostImages.forEach((i) => {
            editPostImage += `<div class="postImg" style="width:25%;float:left;position:relative;">
                                <img src="` + i.url + `" alt="" id="previewImage" style="border-radius: 10px;width:100%;padding:5px;">
                                <span onclick="removeSelectededitPostImage(` + editPostImages.indexOf(i) + `)" style="position: absolute;right: 0;cursor: pointer;font-size: 31px;color: red;margin-top: -8px;margin-right: 8px;">&times</span>
                            </div>`;
        })
        return editPostImage;
    }

    function removeSelectededitPostImage(e) {
        editPostImages.splice(e, 1);
        document.getElementById("editprevFile").innerHTML = editPostImage_show();
    }
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
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".increment_btn").click(function() {
            var html = $(".clone_price").html();
            $(".increment_price").after(html);
        });
        $("body").on("click", ".remove_btn", function() {
            $(this).parents(".increment_control").remove();
        });

        $("#category_id").select2();
        $("#subcategory_id").select2();
        $("#childcategory_id").select2();
    });

    // category to sub
    $("#category_id").on("change", function() {
        var ajaxId = $(this).val();
        if (ajaxId) {
            $.ajax({
                type: "GET",
                url: "{{ url('ajax-product-subcategory') }}?category_id=" + ajaxId,
                success: function(res) {
                    if (res) {
                        $("#subcategory_id").empty();
                        $("#subcategory_id").append('<option value="0">Choose...</option>');
                        $.each(res, function(key, value) {
                            $("#subcategory_id").append('<option value="' + key + '">' +
                                value + "</option>");
                        });
                    } else {
                        $("#subcategory_id").empty();
                    }
                },
            });
        } else {
            $("#subcategory_id").empty();
        }
    });

    // subcategory to childcategory
    $("#subcategory_id").on("change", function() {
        var ajaxId = $(this).val();
        if (ajaxId) {
            $.ajax({
                type: "GET",
                url: "{{ url('ajax-product-childcategory') }}?subcategory_id=" + ajaxId,
                success: function(res) {
                    if (res) {
                        $("#childcategory_id").empty();
                        $("#childcategory_id").append('<option value="0">Choose...</option>');
                        $.each(res, function(key, value) {
                            $("#childcategory_id").append('<option value="' + key + '">' +
                                value + "</option>");
                        });
                    } else {
                        $("#childcategory_id").empty();
                    }
                },
            });
        } else {
            $("#childcategory_id").empty();
        }
    });
</script>
<script type="text/javascript">
    document.forms["editForm"].elements["category_id"].value = "{{ $edit_data->category_id }}";
    document.forms["editForm"].elements["subcategory_id"].value = "{{ $edit_data->subcategory_id }}";
    document.forms["editForm"].elements["childcategory_id"].value = "{{ $edit_data->childcategory_id }}";
</script>
@endsection
