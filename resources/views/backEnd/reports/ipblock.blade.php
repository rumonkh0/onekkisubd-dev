@extends('backEnd.layouts.master')
@section('title', 'IP Block Manage')
@section('css')
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">IP Block & Security Management</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 

    <div class="row">
        <!-- Add IP Block Form Card -->
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-header bg-danger text-white py-2">
                    <h5 class="card-title text-white mb-0"><i class="fe-shield-off me-1"></i> Block New IP Address</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.ipblock.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="ip_no" class="form-label fw-semibold">IP Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ip_no') is-invalid @enderror" 
                                name="ip_no" value="{{ old('ip_no') }}" id="ip_no" 
                                placeholder="e.g. 192.168.1.100 or 2001:db8::1" required>
                            @error('ip_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="text-muted">Enter IPv4 or IPv6 address to prevent access.</small>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label fw-semibold">Block Reason <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" 
                                name="reason" id="reason" rows="3" 
                                placeholder="e.g. Fake order spam, malicious bot traffic" required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn btn-danger w-100"><i class="fe-slash me-1"></i> Block This IP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Blocked IPs List Card -->
        <div class="col-lg-8 col-md-7">
            <div class="card">
                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fe-list me-1"></i> Currently Blocked IP Addresses</h5>
                    <span class="badge bg-danger rounded-pill">{{ count($data) }} Total Blocked</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap w-100 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>IP Address</th>
                                    <th>Reason</th>
                                    <th>Blocked Date</th>
                                    <th style="width: 15%;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $key => $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <code class="fw-bold text-danger fs-6">{{ $value->ip_no }}</code>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $value->reason }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $value->created_at ? $value->created_at->format('d M, Y h:i A') : 'N/A' }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="button-list">
                                            <button type="button" class="btn btn-xs btn-primary waves-effect waves-light" 
                                                data-bs-toggle="modal" data-bs-target="#ipEdit{{ $value->id }}" title="Edit">
                                                <i class="fe-edit-1"></i>
                                            </button>

                                            <form method="POST" action="{{ route('customers.ipblock.destroy') }}" class="d-inline">        
                                                @csrf
                                                <input type="hidden" value="{{ $value->id }}" name="id">
                                                <button type="submit" class="btn btn-xs btn-danger waves-effect waves-light delete-confirm" title="Unblock">
                                                    <i class="fe-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fe-shield font-24 d-block mb-1 text-success"></i>
                                        No IP addresses are currently blocked.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>

{{-- Edit Modals --}}
@foreach($data as $key => $value)
<div class="modal fade" id="ipEdit{{ $value->id }}" tabindex="-1" aria-labelledby="ipEditLabel{{ $value->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="ipEditLabel{{ $value->id }}"><i class="fe-edit me-1"></i> Edit Blocked IP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('customers.ipblock.update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{ $value->id }}">
                    <div class="mb-3">
                        <label for="ip_no_{{ $value->id }}" class="form-label fw-semibold">IP Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ip_no" id="ip_no_{{ $value->id }}" value="{{ $value->ip_no }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="reason_{{ $value->id }}" class="form-label fw-semibold">Block Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="reason" id="reason_{{ $value->id }}" rows="3" required>{{ $value->reason }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success"><i class="fe-check me-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('script')
<!-- third party js -->
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('/public/backEnd/') }}/assets/js/pages/datatables.init.js"></script>
@endsection