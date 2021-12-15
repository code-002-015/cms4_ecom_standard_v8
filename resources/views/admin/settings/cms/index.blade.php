@extends('admin.layouts.app')

@section('pagetitle')
    CMS Settings
@endsection

@section('pagecss')

@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page">CMS</li>
                    <li class="breadcrumb-item" aria-current="page">Settings</li>
                    <li class="breadcrumb-item active" aria-current="page">CMS Settings</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">CMS Settings</h4>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">CMS Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Updates</a>
                </li>
            </ul>
            <div class="tab-content rounded bd bd-gray-300 bd-t-0 pd-20" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form class="col-md-6 mg-t-15">
                        <div class="form-group">
                            <label class="d-block">Company Name *</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Favicon</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <p class="tx-10">
                                Required image dimension: 128px by 128px <br /> Maxmimum file size: 100KB
                            </p>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form class="col-md-6 mg-t-15">
                        <button class="btn btn-dark btn-sm" type="submit"><i data-feather="box" class="mg-r-10"></i> Check for Updates</button>
                        <div class="alert alert-warning d-flex align-items-center mg-t-15" role="alert">
                            <p class="mg-b-0"><i data-feather="alert-circle" class="mg-r-10"></i> An update is available!
                                <a href="#" class="tx-gray-900">Download now.</a></p>
                        </div>
                        <div class="alert alert-success d-flex align-items-center mg-t-15" role="alert">
                            <p class="mg-b-0"><i data-feather="check-circle" class="mg-r-10"></i> No available updates. Your CMS is doing fine.</p>
                        </div>
                        <div class="form-group mg-t-20">
                            <label class="d-block">Enter API Key *</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mg-t-30">
            <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Save Settings</button>
            <button class="btn btn-outline-secondary btn-sm btn-uppercase" type="cancel">Cancel</button>
        </div>
    </div>
</div>
@endsection

@section('pagejs')

@endsection

@section('customjs')

@endsection