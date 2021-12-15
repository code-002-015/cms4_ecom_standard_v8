@extends('admin.layouts.app')

@section('pagetitle')
    Manage Files
@endsection

@section('pagecss')
	<link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <style>

    </style>
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Files</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Manage Files</h4>
        </div>
    </div>
    <iframe src="{{ route('file-manager.show') }}" style="width: 100%; height: 600px; overflow: hidden; border: solid 1px #eee;"></iframe>
</div>
@include('admin.cms4.files.modals')
@endsection

@section('pagejs')
	<script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('customjs')
	<script>
    </script>


@endsection
