@extends('backEnd.layouts.master')
@section('title', $order_status->name . ' Order')
@section('content')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
    <style>
        p {
            margin: 0;
        }

        @page {
            margin: 50px 0px 0px 0px;
        }

        @media print {
            td {
                font-size: 18px;
            }

            p {
                margin: 0;
            }

            title {
                font-size: 25px;
            }

            header,
            footer,
            .no-print,
            .left-side-menu,
            .navbar-custom {
                display: none !important;
            }
        }
    </style>
@endsection
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <!--<a href="{{ route('admin.order.create') }}" class="btn btn-danger rounded-pill"><i-->
                    <!--        class="fe-shopping-cart"></i> Add New</a>-->
                </div>
                <h4 class="page-title">{{ $order_status->name }} Order ({{ $order_status->orders_count }})</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row order_page">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <ul class="action2-btn">
                                <li><a data-bs-toggle="modal" data-bs-target="#asignUser"
                                        class="btn rounded-pill btn-success"><i class="fe-plus"></i> Assign User</a>
                                </li>
                                <li><a data-bs-toggle="modal" data-bs-target="#changeStatus"
                                        class="btn rounded-pill btn-primary"><i class="fe-plus"></i> Change Status</a>
                                </li>
                                <li><a href="{{ route('admin.order.bulk_destroy') }}"
                                        class="btn rounded-pill btn-danger order_delete"><i class="fe-plus"></i> Delete
                                        All</a></li>
                                <li><a href="{{ route('admin.order.order_print') }}"
                                        class="btn rounded-pill btn-info multi_order_print"><i class="fe-printer"></i>
                                        Print</a></li>
                                <li>
                                    <div class="export-print text-end">
                                        <button id="export-excel-button" class="rounded-pill no-print btn btn-info"><i
                                                class="fas fa-file-export"></i> Export</button>
                                    </div>
                                </li>
                                @if($steadfast)
                                <li><a href="{{route('admin.bulk_courier', 'steadfast')}}" class="btn rounded-pill btn-warning multi_order_courier"><i class="fe-truck"></i> Steadfast</a></li>
                                @endif
                                <li><a href="{{route('admin.bulk_courier', 'pathao')}}" class="btn rounded-pill btn-info multi_pathao"><i class="fe-truck"></i> pathao</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-4">
                            <form class="custom_form">
                                <div class="form-group">
                                    <input type="text" name="keyword" placeholder="Search">
                                    <button class="btn  rounded-pill btn-info">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="content-to-export">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped w-100">
                                <thead>
                                    <tr>
                                        <th style="width:2%">
                                            <div class="form-check"><label class="form-check-label"><input
                                                        type="checkbox" class="form-check-input checkall"
                                                        value=""></label></div>
                                        </th>
                                        <th style="width:2%">SL</th>
                                        <th style="width:8%">Action</th>
                                        <th style="width:8%">Invoice</th>
                                        <th style="width:10%">Date</th>
                                        <th style="width:10%">Name</th>
                                        <th style="width:10%">Phone</th>
                                        <th style="width:10%">Assign</th>
                                        <th style="width:10%">Order Type</th>
                                        <th style="width:10%">Total Amount</th>
                                        <th style="width:10%">Partial Amount</th>
                                        <th style="width:10%">Due Amount</th>
                                        <th style="width:10%">Note</th>
                                        <th style="width:10%">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($show_data as $key => $value)
                                        <tr>
                                            <td><input type="checkbox" class="checkbox" value="{{ $value->id }}">
                                            </td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="button-list custom-btn-list">
                                                    <a href="{{ route('admin.order.invoice', ['invoice_id' => $value->invoice_id]) }}"
                                                        title="Invoice"><i class="fe-eye"></i></a>
                                                    <a href="{{ route('admin.order.process', ['invoice_id' => $value->invoice_id]) }}"
                                                        title="Process"><i class="fe-settings"></i></a>
                                                    <a href="{{ route('admin.order.edit', ['invoice_id' => $value->invoice_id]) }}"
                                                        title="Edit"><i class="fe-edit"></i></a>
                                                    <form method="post" action="{{ route('admin.order.destroy') }}"
                                                        class="d-inline">
                                                        @csrf
                                                        <input type="hidden" value="{{ $value->id }}"
                                                            name="id">
                                                        <button type="submit" title="Delete" class="delete-confirm"><i
                                                                class="fe-trash-2"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>{{ $value->invoice_id }}</td>
                                            <td>{{ date('d-m-Y', strtotime($value->updated_at)) }}<br>
                                                {{ date('h:i:s a', strtotime($value->updated_at)) }}</td>
                                            <td><strong>{{ $value->shipping ? $value->shipping->name : '' }}</strong>
                                                <p>{{ $value->shipping ? $value->shipping->address : '' }}</p>
                                            </td>
                                            <td>{{$value->shipping?$value->shipping->phone:''}}<br><button class="btn btn-success btn-sm" style="margin: 4px;padding: 0px 4px;" data-num="{{$value->shipping?$value->shipping->phone:''}}" data-inv="{{$value->invoice_id}}" id="checkfraud">Check</button></td>
                                            <td>{{ $value->user ? $value->user->name : '' }}</td>
                                            <td>{{ $value->order_type }}</td>
                                            <td>৳{{ $value->amount }}</td>
                                            <td>
                                                @if ($value->paid_partial_payment_amount)
                                                    ৳{{ $value->paid_partial_payment_amount }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>৳{{ $value->amount - $value->paid_partial_payment_amount }}</td>
                                            <td>{{ $value->note ? $value->note : 'N/A' }}</td>
                                            <td>{{ $value->status ? $value->status->name : '' }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="custom-paginate">
                        {{ $show_data->links('pagination::bootstrap-4') }}
                    </div>
                </div> <!-- end card body-->

            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
<!-- Assign User End -->
<div class="modal fade" id="asignUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.order.assign') }}" id="order_assign">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="user_id" id="user_id" class="form-control">
                            <option value="">Select..</option>
                            @foreach ($users as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Assign User End-->

<!-- Assign User End -->
<div class="modal fade" id="changeStatus" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.order.status') }}" id="order_status_form">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="order_status" id="order_status" class="form-control">
                            <option value="">Select..</option>
                            @foreach ($orderstatus as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Assign User End-->
<!-- pathao coureir start -->
<div class="modal fade" id="pathao" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pathao Courier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.order.pathao') }}" id="order_sendto_pathao">

                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="order_ids" id="orids">
                        <label for="pathaostore" class="form-label">Store</label>
                        <select name="pathaostore" id="pathaostore" class="pathaostore form-control">
                            <option value="">Select Store...</option>
                            @if (isset($pathaostore['data']['data']))
                                @foreach ($pathaostore['data']['data'] as $key => $store)
                                    <option value="{{ $store['store_id'] }}">{{ $store['store_name'] }}</option>
                                @endforeach
                            @else
                            @endif
                        </select>
                        @if ($errors->has('pathaostore'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pathaostore') }}</strong>
                            </span>
                        @endif
                    </div>
                    <!-- form group end -->
                    <div class="form-group mt-3">
                        <label for="pathaocity" class="form-label">City</label>
                        <select name="pathaocity" id="pathaocity" class="chosen-select pathaocity form-control"
                            style="width:100%">
                            <option value="">Select City...</option>
                            @if (isset($pathaocities['data']['data']))
                                @foreach ($pathaocities['data']['data'] as $key => $city)
                                    <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                @endforeach
                            @else
                            @endif
                        </select>
                        @if ($errors->has('pathaocity'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pathaocity') }}</strong>
                            </span>
                        @endif
                    </div>
                    <!-- form group end -->
                    <div class="form-group mt-3">
                        <label for="" class="form-label">Zone</label>
                        <select name="pathaozone" id="pathaozone"
                            class="pathaozone chosen-select form-control  {{ $errors->has('pathaozone') ? ' is-invalid' : '' }}"
                            value="{{ old('pathaozone') }}" style="width:100%">
                        </select>
                        @if ($errors->has('pathaozone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pathaozone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <!-- form group end -->
                    <div class="form-group mt-3">
                        <label for="" class="form-label">Area</label>
                        <select name="pathaoarea" id="pathaoarea"
                            class="pathaoarea chosen-select form-control  {{ $errors->has('pathaoarea') ? ' is-invalid' : '' }}"
                            value="{{ old('pathaoarea') }}" style="width:100%">
                        </select>
                        @if ($errors->has('pathaoarea'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('pathaoarea') }}</strong>
                            </span>
                        @endif
                    </div>
                    <!-- form group end -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- pathao courier  End-->

<div class="modal" id="froudcheck">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="display:inline !important">
                <div class="d-flex justify-content-between">
                    <h5 class="modal-title">INV#<span id="invnum"></span></h5>
                    <button type="button" class="close" id="discol" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h5 class="modal-title" id="mtitle"> Parcel Receive & Cancel Ratio of :- <b><span style="color:red" id="cusnum"></span></b> </h5>
            </div>
            <div class="modal-body" style="text-align: center;">
                <div class="text-center auto-load" style="display: none;">
                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                        <path fill="#000"
                            d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                        </path>
                    </svg>
                </div>
                <div  id="cuslist">
                    
                </div>
            </div>

        </div>
    </div>
</div><!-- End popup Modal-->

@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
<script src="{{ asset('public/backEnd/') }}/assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />

<script>
    $(document).ready(function() {
        $('#export-excel-button').on('click', function() {
            var contentToExport = $('#content-to-export').html();
            var tempElement = $('<div>');
            tempElement.html(contentToExport);
            tempElement.find('table').table2excel({
                exclude: ".no-export",
                name: "Orders"
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        
        var token = $('#token').val();
        
        $(document).on('click', '#checkfraud', function(e) {
            e.preventDefault();
            var number = $(this).attr('data-num'); 
            var inv = $(this).attr('data-inv'); 
            $('#froudcheck').modal('show');
            $('#cuslist').empty();
            $('.auto-load').css('display','inline');
            $('#cusnum').html(number);
            $('#invnum').html(inv);
            $.ajax({
                type: "GET",
                url: "https://supersalebd24.com/api/fraud-check-data",
                data: {
                    'number': number, 
                    '_token': token
                },
                success: function(response) {
                    $('.auto-load').css('display','none');
                    $('#cuslist').empty().append(response);
                }
            });
        });
        
        $(".checkall").on('change', function() {
            $(".checkbox").prop('checked', $(this).is(":checked"));
        });

        $(document).on('click', '.multi_pathao', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var order = $('input.checkbox:checked').map(function() {
                return $(this).val();
            });
            var order_ids = order.get();

            if (order_ids.length == 0 || order_ids.length > 1) {
                $('#orids').val('');
                toastr.error('Please Select An Order First !');
                return;
            } else {
                $('#orids').val(order_ids);
            }

        });

        // order assign
        $(document).on('submit', 'form#order_assign', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            let user_id = $(document).find('select#user_id').val();

            var order = $('input.checkbox:checked').map(function() {
                return $(this).val();
            });
            var order_ids = order.get();

            if (order_ids.length == 0) {
                toastr.error('Please Select An Order First !');
                return;
            }

            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    user_id,
                    order_ids
                },
                success: function(res) {
                    if (res.status == 'success') {
                        toastr.success(res.message);
                        window.location.reload();

                    } else {
                        toastr.error('Failed something wrong');
                    }
                }
            });

        });

        // order status change
        $(document).on('submit', 'form#order_status_form', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var method = $(this).attr('method');
            let order_status = $(document).find('select#order_status').val();

            var order = $('input.checkbox:checked').map(function() {
                return $(this).val();
            });
            var order_ids = order.get();

            if (order_ids.length == 0) {
                toastr.error('Please Select An Order First !');
                return;
            }

            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    order_status,
                    order_ids
                },
                success: function(res) {
                    if (res.status == 'success') {
                        toastr.success(res.message);
                        window.location.reload();

                    } else {
                        toastr.error('Failed something wrong');
                    }
                }
            });

        });
        // order delete
        $(document).on('click', '.order_delete', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var order = $('input.checkbox:checked').map(function() {
                return $(this).val();
            });
            var order_ids = order.get();

            if (order_ids.length == 0) {
                toastr.error('Please Select An Order First !');
                return;
            }

            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    order_ids
                },
                success: function(res) {
                    if (res.status == 'success') {
                        toastr.success(res.message);
                        window.location.reload();

                    } else {
                        toastr.error('Failed something wrong');
                    }
                }
            });

        });

        // multiple print
        $(document).on('click', '.multi_order_print', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var order = $('input.checkbox:checked').map(function() {
                return $(this).val();
            });
            var order_ids = order.get();

            if (order_ids.length == 0) {
                toastr.error('Please Select Atleast One Order!');
                return;
            }
            $.ajax({
                type: 'GET',
                url,
                data: {
                    order_ids
                },
                success: function(res) {
                    if (res.status == 'success') {
                        console.log(res.items, res.info);
                        var myWindow = window.open("", "_blank");
                        myWindow.document.write(res.view);
                    } else {
                        toastr.error('Failed something wrong');
                    }
                }
            });
        });
        // multiple courier 
        $(document).on('click', '.multi_order_courier', function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var order = $('input.checkbox:checked').map(function(){
              return $(this).val();
            });
            var order_ids=order.get();
            
            if(order_ids.length ==0){
                toastr.error('Please Select An Order First !');
                return ;
            }
            
            $.ajax({
               type:'GET',
               url:url,
               data:{order_ids},
               success:function(res){
                   if(res.status=='success'){
                    toastr.success(res.message);
                    window.location.reload();
                    
                }else{
                    toastr.error('Failed something wrong');
                }
               }
            });
        
        });
        
        $(document).on('click', '.multi_pathao', function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var order = $('input.checkbox:checked').map(function(){
              return $(this).val();
            });
            var order_ids=order.get();
            
            if(order_ids.length ==0){
                toastr.error('Please Select An Order First !');
                return ;
            }
            
            $.ajax({
               type:'GET',
               url:url,
               data:{order_ids},
               success:function(res){
                   if(res.status=='success'){
                    toastr.success(res.message);
                    window.location.reload();
                    
                }else{
                    toastr.error('Failed something wrong');
                }
               }
            });
        
        });
    })
</script>
@endsection
