@extends('backEnd.layouts.master') 
@section('title','Courier API')
@section('css')
<style>
  .increment_btn,
  .remove_btn {
    margin-top: -17px;
    margin-bottom: 10px;
  }
</style>
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />
@endsection @section('content')
<div class="container-fluid">
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <h4 class="page-title">Steadfast Courier</h4>
      </div>
    </div>
  </div>
  <!-- end page title -->
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <form action="{{route('courierapi.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$steadfast->id}}">
            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label for="api_key" class="form-label">API key *</label>
                <input type="text" class="form-control @error('api_key') is-invalid @enderror" name="api_key" value="{{ $steadfast->api_key}}" id="api_key" required="" />
                @error('api_key')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- col-end -->
            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label for="secret_key" class="form-label">Secret key *</label>
                <input type="text" class="form-control @error('secret_key') is-invalid @enderror" name="secret_key" value="{{ $steadfast->secret_key }}" id="secret_key" required="" />
                @error('secret_key')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- col-end -->
            
            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label for="url" class="form-label">URL *</label>
                <input type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $steadfast->url }}" id="url" required="" />
                @error('url')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <!-- col-end -->
            <div class="col-sm-3 mb-3">
              <div class="form-group">
                <label for="status" class="d-block">Status</label>
                <label class="switch">
                  <input type="checkbox" value="1" @if($steadfast->status==1)checked @endif name="status" />
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
              <input type="submit" class="btn btn-success" value="Submit" />
            </div>
          </form>
        </div>
        <!-- end card-body-->
      </div>
      <!-- end card-->
    </div>
    <!-- end col-->
  </div>
  <!-------------new-start------------>
  <!-- start page title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <h4 class="page-title">Pathao Courier</h4>
      </div>
    </div>
  </div>
  <!-- end page title -->
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          @if(isset($pathaoTokenStatus))
            @if(!empty($pathaoTokenStatus['is_expired']))
              <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                <i class="fe-alert-triangle font-20 me-2"></i>
                <div class="flex-grow-1">
                  <strong>Pathao Connection Inactive / Token Expired!</strong> {{ $pathaoTokenStatus['message'] }}<br>
                  <small>Fill in your <strong>Client ID, Client Secret, Username, and Password</strong> below, then click <strong>"Connect &amp; Generate Token"</strong>. The system will automatically generate and refresh your tokens!</small>
                </div>
              </div>
            @else
              <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                <i class="fe-check-circle font-20 me-2"></i>
                <div class="flex-grow-1">
                  <strong>Pathao Connected &amp; Active:</strong> {{ $pathaoTokenStatus['message'] }}
                  @if(!empty($pathaoTokenStatus['merchant_id']))
                    (Merchant ID: <code>{{ $pathaoTokenStatus['merchant_id'] }}</code>)
                  @endif
                  <br><small class="text-muted">Automatic token refresh is active. Your orders will dispatch smoothly.</small>
                </div>
              </div>
            @endif
          @endif

          <form id="pathao-form" action="{{route('courierapi.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $pathao->id}}">

            <div class="col-12 mb-2">
              <h5 class="text-muted font-14"><i class="fe-shield me-1"></i> API Credentials (OAuth 2.0)</h5>
              <p class="text-muted font-12 mb-2">Obtain your credentials from your <a href="https://merchant.pathao.com" target="_blank" class="fw-bold text-primary">Pathao Merchant Dashboard</a> &gt; Developer API Settings.</p>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label for="pathao_url" class="form-label">Base URL *</label>
                <input type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ $pathao->url ?: 'https://api-hermes.pathao.com' }}" id="pathao_url" required="" />
                @error('url')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <small class="text-muted">Production: <code>https://api-hermes.pathao.com</code> | Sandbox: <code>https://courier-api-sandbox.pathao.com</code></small>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label for="pathao_client_id" class="form-label">Client ID</label>
                <input type="text" class="form-control @error('api_key') is-invalid @enderror" name="api_key" value="{{ $pathao->api_key }}" id="pathao_client_id" placeholder="Enter Pathao Client ID" />
                @error('api_key')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group mb-3">
                <label for="pathao_client_secret" class="form-label">Client Secret</label>
                <input type="text" class="form-control @error('secret_key') is-invalid @enderror" name="secret_key" value="{{ $pathao->secret_key }}" id="pathao_client_secret" placeholder="Enter Pathao Client Secret" />
                @error('secret_key')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group mb-3">
                <label for="pathao_username" class="form-label">Login Email / Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $pathao->username }}" id="pathao_username" placeholder="Merchant Email" />
                @error('username')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group mb-3">
                <label for="pathao_password" class="form-label">Login Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="pathao_password" placeholder="{{ !empty($pathao->password) ? '•••••••• (Saved)' : 'Enter Password' }}" />
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <small class="text-muted">Leave blank to keep existing password.</small>
              </div>
            </div>

            <div class="col-12 mt-2 mb-2">
              <h5 class="text-muted font-14"><i class="fe-key me-1"></i> Issued Tokens (Auto-Managed)</h5>
            </div>

            <div class="col-sm-8">
              <div class="form-group mb-3">
                <label for="token" class="form-label">Access Token (Bearer)</label>
                <textarea rows="3" class="form-control font-12 @error('token') is-invalid @enderror" name="token" id="token" placeholder="Automatically issued when you click 'Connect & Generate Token' or paste manual token">{{ $pathao->token }}</textarea>
                @error('token')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <small class="text-muted">Valid for 5 days. Auto-refreshes automatically using your credentials above.</small>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="form-group mb-3">
                <label for="pathao_status" class="d-block">Status</label>
                <label class="switch">
                  <input type="checkbox" value="1" @if($pathao->status==1)checked @endif name="status" id="pathao_status" />
                  <span class="slider round"></span>
                </label>
                <p class="text-muted font-12 mt-2">Enable or disable Pathao as a courier option across the admin order processing panel.</p>
              </div>
            </div>

            <div class="col-12 d-flex flex-wrap gap-2 align-items-center mt-2">
              <button type="submit" class="btn btn-success">
                <i class="fe-save me-1"></i> Save Settings
              </button>
              <button type="button" id="btn-issue-pathao-token" class="btn btn-primary">
                <i class="fe-refresh-cw me-1"></i> Connect &amp; Generate Token
              </button>
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

  $('#btn-issue-pathao-token').on('click', function(e) {
    e.preventDefault();
    var btn = $(this);
    var originalHtml = btn.html();

    var clientId = $('#pathao_client_id').val();
    var clientSecret = $('#pathao_client_secret').val();
    var username = $('#pathao_username').val();
    var password = $('#pathao_password').val();
    var url = $('#pathao_url').val();

    if (!clientId || !clientSecret || !username) {
      alert('Please fill in Client ID, Client Secret, and Username (Email) before generating a token.');
      return;
    }

    btn.prop('disabled', true).html('<i class="fe-rotate-cw fa-spin me-1"></i> Connecting to Pathao...');

    $.ajax({
      url: "{{ route('courierapi.pathao.token') }}",
      type: "POST",
      data: {
        _token: "{{ csrf_token() }}",
        client_id: clientId,
        client_secret: clientSecret,
        username: username,
        password: password,
        url: url
      },
      success: function(response) {
        btn.prop('disabled', false).html(originalHtml);
        if (response.status) {
          if (response.access_token) {
            $('#token').val(response.access_token);
          }
          alert(response.message);
          window.location.reload();
        } else {
          alert('Error: ' + response.message);
        }
      },
      error: function(xhr) {
        btn.prop('disabled', false).html(originalHtml);
        var msg = 'Failed to connect to Pathao.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          msg = xhr.responseJSON.message;
        }
        alert('Error: ' + msg);
      }
    });
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
  });
</script>
<script type="text/javascript">
  $(document).ready(function () {
    $(".increment_btn").click(function () {
      var html = $(".clone_price").html();
      $(".increment_price").after(html);
    });
    $("body").on("click", ".remove_btn", function () {
      $(this).parents(".increment_control").remove();
    });

    $(".select2").select2();
  });
</script>
@endsection