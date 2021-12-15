@extends('admin.layouts.app')

@section('pagetitle')
    Create Album
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">

    <style>
        #errorMessage {
            list-style-type: none;
            padding: 0;
            margin-bottom: 0px;
        }
        .image_path {
            opacity: 0;
            width: 0;
        }
    </style>
@endsection

@php
    function extract_file_name($fileName) {
        $path = explode('/', $fileName);
        $nameIndex = count($path) - 1;
        if ($nameIndex < 0)
            return '';

        return $path[$nameIndex];
    }
@endphp

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('albums.index')}}">Albums</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create an Album</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create an Album</h4>
            </div>
        </div>
        <form id="albumForm" method="POST" action="{{ route('albums.store') }}" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <div class="row row-sm">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="d-block">Album Name *</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}" @htmlValidationMessage({{__('standard.empty_all_field')}})>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Transition In *</label>
                        <select name="transition_in"  class="selectpicker mg-b-5" data-style="btn btn-outline-light btn-sm btn-block tx-left" title="Select transition" data-width="100%" required @error('transition_in') @htmlValidationMessage({{__('standard.banner.empty_transition')}}) @enderror >
                            @foreach ($animations as $animation)
                                @if ($animation->is_entrance_field_type())
                                    <option value="{{ $animation->id }}" {{ (old("transition_in") == $animation->id ? "selected":"") }}>{{ $animation->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Transition Out *</label>
                        <select name="transition_out" class="selectpicker mg-b-5" data-style="btn btn-outline-light btn-sm btn-block tx-left" title="Select transition" data-width="100%" required @error('transition_out') @htmlValidationMessage({{__('standard.banner.empty_transition')}}) @enderror >
                            @foreach ($animations as $animation)
                                @if ($animation->is_exit_field_type())
                                    <option value="{{ $animation->id }}" {{ (old("transition_out") == $animation->id ? "selected":"") }}>{{ $animation->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Transition Duration (seconds) *</label>
                        <input name="transition" type="integer" class="js-range-slider" value="{{ old('transition') }}" required @error('transition') is-invalid @enderror/>
                    </div>
                    <div class="form-group mg-b-0">
                        <input type="file" id="upload_image" class="image_path" accept="image/*" multiple>
                        <button type="button" class="btn btn-light btn-xs btn-uppercase upload @error('banners') is-invalid @enderror" type="submit"><i data-feather="upload"></i> Upload banner*</button>
                        @error('banners')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <p class="tx-10">
                            Required image dimension: {{ env('SUB_BANNER_WIDTH') }}px by {{ env('SUB_BANNER_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                        </p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row draggable-portlets">
                        <div class="col-md-12" id="banners">
                            @php $banners = old('banners', []); @endphp
                            @foreach ($banners as $key => $banner)
                                @php
                                    if(!isset($banner['id'])) {
                                        $banner['id'] = $key;
                                        $banner['new'] = true;
                                    }
                                @endphp
                                <div class="sorted">
                                    <div class="card upload-card p-10 mg-t-20">
                                        <div class="card-header ui-sortable-handle"><i data-feather="move"></i> {{ extract_file_name($banner['image_path']) }}</div>
                                        <div class="card-body">
                                            <div class="row row-sm">
                                                <div class="col-lg-12">
                                                    <div class="form-group upload-image mg-b-0" style="background: url('{{ $banner['image_path'] }}');background-size: cover;">
                                                        <div class="marker pos-absolute t-10 l-20 p-0 bg-transparent">
                                                            {{--                                                    <button class="btn btn-light btn-xs btn-uppercase" type="submit"><i data-feather="upload"></i> Upload image</button>--}}
                                                            <button type="button" class="btn btn-danger btn-xs btn-uppercase remove-upload" type="button" data-id="{{ $banner['id'] }}"><i data-feather="x"></i> Remove image</button>
                                                            <input name="banners[{{ $banner['id'] }}][image_path]" class="image_path" type="text" value="{{ $banner['image_path'] }}"  required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-12 mg-t-30">
                            <hr>
                            <button type="submit" class="btn btn-primary btn-sm btn-uppercase" type="submit">Save Album</button>
                            <a href="{{ route('albums.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase" type="cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal effect-scale" id="prompt-remove" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Remove image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove the image?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnRemove">Yes, remove</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/file-upload-validation.js') }}"></script>
@endsection

@section('customjs')
    <script>
        $(function() {
            let image_count = 1;
            let objUpload;
            let objRemove;
            $('.selectpicker').selectpicker();
            $(".js-range-slider").ionRangeSlider({
                grid: true,
                min: 2,
                max: 10
            });
            $(document).on('click', '.upload', function() {
                objUpload = $(this);
                $('#upload_image').click();
            });


            function upload_image(file)
            {
                let data = new FormData();
                data.append("_token", "{{ csrf_token() }}");
                data.append("banner", file);
                $.ajax({
                    data: data,
                    type: "POST",
                    url: "{{ route('albums.upload') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(returnData) {
                        $('#upload_image').val('');
                        if (returnData.status == "success") {
                            while ($('input[name="banners['+image_count+'][image_path]"]').length) {
                                image_count += 1;
                            }
                            let bannerHTML = `<div class="sorted">
                                            <div class="card upload-card p-10 mg-t-20">
                                                <div class="card-header ui-sortable-handle"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-move"><polyline points="5 9 2 12 5 15"></polyline><polyline points="9 5 12 2 15 5"></polyline><polyline points="15 19 12 22 9 19"></polyline><polyline points="19 9 22 12 19 15"></polyline><line x1="2" y1="12" x2="22" y2="12"></line><line x1="12" y1="2" x2="12" y2="22"></line></svg> `+returnData.image_name+`</div>
                                                    <div class="card-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg-12">
                                                                <div class="form-group upload-image mg-b-0" style="background: url('`+returnData.image_url+`');background-size: cover;">
                                                                    <div class="marker pos-absolute t-10 l-20 p-0 bg-transparent">
                                                                    <button type="button" class="btn btn-danger btn-xs btn-uppercase remove-upload" type="submit" data-image-path="`+returnData.image_url+`"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> Remove image</button>
                                                                    <input name="banners[`+image_count+`][image_path]" class="image_path" type="text" value="`+returnData.image_url+`" required onvalid="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Please upload image.')" oninput="this.setCustomValidity('')"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                            $('#banners').append(bannerHTML);
                            dragInit();
                        }
                    },
                    failed: function() {
                        alert('FAILED NGA!');
                    }
                });
            }

            $('#upload_image').on('change', function (evt) {
                let files = evt.target.files;
                let maxSize = 1;
                let validateFileTypes = ["image/jpeg", "image/png"];
                let requiredWidth = "{{ env('SUB_BANNER_WIDTH') }}";
                let requiredHeight =  "{{ env('SUB_BANNER_HEIGHT') }}";

                validate_files(files, upload_image, maxSize, validateFileTypes, requiredWidth, requiredHeight);
            });

            let image_path = '';
            $(document).on('click', '.remove-upload', function() {
                objRemove = $(this);
                image_path = $(this).data('image-path');
                $('#prompt-remove').modal('show');
            });

            $('#btnRemove').on('click', function() {
                objRemove.parent().parent().parent().parent().parent().parent().remove();
                $('#albumForm').prepend('<input type="hidden" name="delete_banners[]" value="'+image_path+'"/>');
                image_path = '';
                $('#prompt-remove').modal('hide');
            });

            /* Draggable */
            function dragInit() {
                var $draggable_portlets = $(".draggable-portlets");
                $(".draggable-portlets .sorted").sortable({
                    connectWith: ".draggable-portlets .sorted",
                    handle: '.card-header',
                    start: function () {
                        $draggable_portlets.addClass('dragging');
                    },
                    stop: function () {
                        $draggable_portlets.removeClass('dragging');
                    }
                });
                $(".draggable-portlets .sorted .card-header").disableSelection();
            }
            dragInit();
            /* End Draggable */
        });
    </script>
@endsection
