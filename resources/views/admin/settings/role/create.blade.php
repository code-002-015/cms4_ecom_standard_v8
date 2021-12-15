@extends('admin.layouts.app')

@section('pagetitle')
    Manage Roles
@endsection


@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('role.index')}}">Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create a Role</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create a Role</h4>
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
                    <h6 class="mg-b-0">Roles</h6>
                </div><!-- card-header -->
                <div class="card-body pd-0">
                    <div class="table-responsive">
                        <form action="{{ route('role.store') }}" method="post" id="selectForm2">
                            @method('POST')
                            @csrf
                            <div class="modal-body pd-sm-t-30 pd-sm-b-40 pd-sm-x-30">
                                <div class="row row-sm">
                                    <div class="col-sm">
                                        <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Role Name <i class="tx-danger">*</i></label>
                                        <input required type="text" class="form-control" name="role" placeholder="Enter role name" maxlength="150">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="tx-10 tx-uppercase tx-medium tx-spacing-1 mg-b-5 tx-color-03">Role Description <i class="tx-danger">*</i></label>
                                    <textarea required class="form-control" name="description" rows="2" placeholder="Enter role description" maxlength="190"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer pd-x-20 pd-y-15">
                                <a href="{{ route('role.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Save Role</button>
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
@endsection

