@extends('admin.layouts.app')

@section('pagetitle')
    Edit Album
@endsection

@section('pagecss')
	<link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owl.carousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active" aria-current="page">Edit an Album</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Edit an Album</h4>
        </div>
    </div>
    <form id="updateForm" method="POST" action="{{ route('albums.update', $album->id) }}" enctype="multipart/form-data">
        @foreach (old('remove_banners', []) as $bannerId)
            <input type="hidden" name="remove_banners[]" value="{{ $bannerId }}">
        @endforeach
        @method('PUT')
        @csrf
        <div class="row row-sm">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="d-block">Album Name *</label>
                    <input name="user_id" type="hidden" value="{{Auth::user()->id}}">
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name',$album->name) }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Transition In *</label>
                    <select name="transition_in" class="selectpicker mg-b-5" data-style="btn btn-outline-light btn-sm btn-block tx-left" title="Select transition" data-width="100%">
                        @foreach ($animations as $animation)
                            @if ($animation->is_entrance_field_type())
                                <option {{ (old("transition_in",$album->transition_in) == $animation->id ? "selected":"") }} value="{{ $animation->id }}">{{ $animation->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="d-block">Transition Out *</label>
                    <select name="transition_out" class="selectpicker mg-b-5" data-style="btn btn-outline-light btn-sm btn-block tx-left" title="Select transition" data-width="100%">
                        @foreach ($animations as $animation)
                            @if ($animation->is_exit_field_type())
                                <option {{ (old("transition_out",$album->transition_out) == $animation->id ? "selected":"") }} value="{{ $animation->id }}">{{ $animation->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="d-block">Transition Duration (seconds) *</label>
                    <input name="transition" type="text" class="js-range-slider" name="my_range" value="{{ old('transition',$album->transition) }}" />
                </div>
                <div class="form-group mg-b-0">
                    <input type="file" name="banner" class="d-none" id="upload_image" accept="image/*" multiple>
                    <button type="button" class="btn btn-light btn-xs btn-uppercase upload @error('banners') is-invalid @enderror" type="submit"><i data-feather="upload"></i> Upload image*</button>
                    @error('banners')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @if ($album->id == 1)
                        <p class="tx-10">
                            Required image dimension: {{ env('MAIN_BANNER_WIDTH') }}px by {{ env('MAIN_BANNER_HEIGHT') }}px <br /> Maximum file size: 2MB <br /> Required file type: .jpeg .png
                        </p>
                    @else
                        <p class="tx-10">
                            Required image dimension: {{ env('SUB_BANNER_WIDTH') }}px by {{ env('SUB_BANNER_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                        </p>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="row draggable-portlets">
                    <div class="col-md-12" id="banners">
                        @php $banners = old('banners', $album->banners); @endphp
                        @foreach ($banners as $key => $banner)
                            @php if(!isset($banner['id'])) {
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
                                                        @if(!isset($banner['new']))
                                                            <input name="banners[{{ $banner['id'] }}][id]" type="hidden" value="{{ $banner['id'] }}" />
                                                        @endif
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
                        <button type="submit" class="btn btn-primary btn-sm btn-uppercase" type="submit">Update Album</button>
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
                <p>{{__('standard.banner.remove_image')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" id="btnRemove">Yes, remove image</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="preview-banner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content tx-14">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel3">Preview</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="owl-carousel owl-theme" id="previewCarousel">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
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
    <script src="{{ asset('lib/owl.carousel/owl.carousel.js') }}"></script>
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

            $('#previewCarousel').owlCarousel({
                animateOut: "{{$album->animationOut->value}}",
                animateIn: "{{$album->animationIn->value}}",
                loop: true,
                dots: false,
                margin: 0,
                autoplay: true,
                autoplayTimeout: ("{{$album->transition}}")*1000,
                autoplayHoverPause: false,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
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

            $('#upload_image').change(function (evt) {
                // validate_images(evt, upload_image);

                let files = evt.target.files;
                let maxSize = 2;
                let validateFileTypes = ["image/jpeg", "image/png"];
                let requiredWidth = "{{ env('SUB_BANNER_WIDTH') }}";
                let requiredHeight =  "{{ env('SUB_BANNER_HEIGHT') }}";

                validate_files(files, upload_image, maxSize, validateFileTypes, requiredWidth, requiredHeight);
            });

            $(document).on('click', '.remove-upload', function() {
                objRemove = $(this);
                $('#prompt-remove').modal('show');
            });

            $('#btnRemove').on('click', function() {
                objRemove.parent().parent().parent().parent().parent().parent().remove();
                let attr = objRemove.attr('data-id');
                if (typeof(attr) != 'undefined') {
                    $('#updateForm').prepend('<input type="hidden" name="remove_banners[]" value="'+attr+'">');
                }

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
