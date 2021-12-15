@extends('admin.layouts.app')

@section('pagetitle')
    Category Management
@endsection

@section('pagecss')
    <style>
        #errorMessage {
            list-style-type: none;
            padding: 0;
            margin-bottom: 0px;
        }
    </style>
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('news-categories.index')}}">News Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create News Category</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create Template Category</h4>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12">
                <form autocomplete="off" action="{{ route('template-categories.store') }}" method="post">
                    @method('POST')
                    @csrf
                    <div class="row row-sm">
                        <div class="col-sm-6">
                            <div class="form-group mg-b-20">
                                <label class="d-block">Name <i class="tx-danger">*</i></label>
                                <input required type="text" class="form-control @error('name') is-invalid @enderror" name="name" required>
                            </div>

                            <div class="form-group">
                                <label class="d-block">Status</label>
                                <div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                                    <input type="checkbox" class="custom-control-input" name="visibility" {{ (old("visibility") ? "checked":"") }} id="customSwitch1">
                                    <label class="custom-control-label" id="label_visibility" for="customSwitch1">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary btn-uppercase">Save</button>
                    <a href="{{ route('template-categories.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
                </form>
        </div>
    </div>
</div>
@endsection

@section('customjs')
    <script>
    </script>
@endsection
