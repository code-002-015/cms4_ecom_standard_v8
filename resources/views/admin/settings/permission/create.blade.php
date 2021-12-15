@extends('admin.layouts.app')

@section('pagetitle')
    Manage Roles &amp; Permissions
@endsection

@section('pagecss')
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page">CMS</li>
                    <li class="breadcrumb-item active" aria-current="page">Account Management</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Permission Management</h4>
        </div>
    </div>
    @if($message = Session::get('duplicate'))
        <div class="alert alert-warning d-flex align-items-center mg-t-15" role="alert">
            <p class="mg-b-0"><i data-feather="alert-circle" class="mg-r-10"></i>{{ $message }}
        </div>
    @endif
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card ht-lg-100p">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="mg-b-0">Permissions</h6>
                </div><!-- card-header -->
                <div class="card-body pd-0">
                    <div class="table-responsive">
                        <form action="{{ route('permission.store') }}" method="post" id="selectForm2">
                            @csrf
                            <div class="modal-body pd-sm-t-30 pd-sm-b-40 pd-sm-x-30">
                                <div class="row row-sm">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Name <i class="tx-danger">*</i></label>
                                            <input required type="text" class="form-control" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Module Name <i class="tx-danger">*</i></label>
                                            <select name="module" class="form-control">
                                                @foreach ($modules as $key => $module)
                                                    <option value="{{ $key }}">{{ $module }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Permission Description <i class="tx-danger">*</i></label>
                                            <input required type="text" class="form-control" name="description">
                                        </div>
                                        <div class="form-group">
                                            <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Routes <i class="tx-danger">*</i></label>
                                            <select id="methods" name="methods[]" multiple="multiple" class="form-control" required >
                                                @foreach ($panelRoutes as $route)
                                                    <option value="{{ $route->getActionMethod() }}" data-id="{{ $loop->iteration }}" id="method{{ $loop->iteration }}">{{ $route->getName() }} - {{ $route->uri() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group" style="display: none;">
                                            <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Routes <i class="tx-danger">*</i></label>
                                            <select id="routes" name="routes[]" multiple="multiple" class="form-control" required >
                                                @foreach ($panelRoutes as $route)
                                                    <option value="{{ $route->getName() }}" data-id="{{ $loop->iteration }}" id="route{{ $loop->iteration }}">{{ $route->getName() }} - {{ $route->uri() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Is it for view/listing page permission?</label>
                                            <input type="checkbox" name="is_view_page" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer pd-x-20 pd-y-15">
                                <a href="{{ route('permission.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Save Permission</button>
                            </div>
                        </form>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
    </div>
</div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            $('#routes').select2({
                closeOnSelect: false,
            });
            $('#methods').select2({
                closeOnSelect: false,
            });

            $('#methods').on('change', function() {
                let options = $("#methods option:selected");

                let selected = [];
                $.each(options, function () {
                   let routeId = $(this).data('id');
                    selected.push($('#route'+routeId).val());
                });

                $('#routes').val(selected);
                $('#routes').trigger('change');
            });
        });
    </script>
@endsection

