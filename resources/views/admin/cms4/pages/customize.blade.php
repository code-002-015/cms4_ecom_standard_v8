@extends('admin.layouts.app')

@section('pagetitle')
    Edit Page
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
    <link href="{{ asset('lib/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owl.carousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('pages.index')}}">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit a Page</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Edit a Page</h4>
            </div>
            <div>
                <a class="btn btn-outline-primary btn-sm" href="{{$page->get_url()}}" target="_blank">Preview Page</a>
            </div>
        </div>
        <form id="editForm" action="{{ route('pages.update-customize',$page->id) }}" method="post" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-lg-6">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="d-block">Page Title *</label>
                        <label class="d-block">{{ $page->name }}</label>
                        <label>
                            <small id="page_slug">
                                <a target="_blank" href="{{ $page->get_url() }}">{{ $page->get_url() }}</a>
                            </small>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Page Label *</label>
                        <input type="text" class="form-control @error('label') is-invalid @enderror" name="label" id="label" value="{{ old('label', $page->label) }}" required>
                        @error('label')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @php
                        $album_active = 'active';
                        $image_active = '';
                        $banner_type = 'banner_slider';
                        if(strlen($page->image_url) > 0){
                            $album_active = '';
                            $image_active = 'active';
                            $banner_type = 'banner_image';
                        }
                    @endphp
                    <div class="form-group">
                        <label class="d-block">Page Banner</label>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="banner_slider" class="btn page_banner_btn btn-secondary {{ $album_active }}">Slider</button>
                            <button type="button" id="banner_image" class="btn page_banner_btn btn-secondary {{ $image_active }}">Image</button>

                            <input type="hidden" name="banner_type" id="banner_type" value="{{ $banner_type }}">
                        </div>
                    </div>

                    <div class="form-group banner-image" style="{{($banner_type == 'banner_slider' ? 'display:none;':'')}}">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('image_url') is-invalid @enderror"  id="image_url" name="image_url" @if (!empty($page->image_url)) title="{{$page->get_image_file_name()}}" @endif>
                            <label class="custom-file-label" for="customFile" id="img_name">@if (empty($page->image_url)) Choose file @else {{$page->get_image_file_name()}} @endif</label>
                        </div>
                        <p class="tx-10">
                            Required image dimension: {{ env('SUB_BANNER_WIDTH') }}px by {{ env('SUB_BANNER_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                        </p>
                        @error('image_url')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div id="image_div" @if($page->has_slider()) style="display:none;" @endif>
                            <img src="{{ old('image_url', $page->image_url) }}" height="100" width="300" id="img_temp" alt="">  <br /><br />
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-upload" >Remove Image</a>
                        </div>
                    </div>

                    <div class="form-group banner-slider" style="{{($banner_type == 'banner_image' ? 'display:none;':'')}}">
                        <div class="row">
                            <div class="col-md-10">
                                <select class="selectpicker mg-b-5 @error('album_id') is-invalid @enderror" id="album_id" name="album_id" data-style="btn btn-outline-light btn-md btn-block tx-left" title="Select album" data-width="100%">
                                    <option value @if (empty($page->album_id)) selected @endif>- None -</option>
                                    @forelse($albums as $album)
                                        <option value="{{$album->id}}" {{ (old("album_id",$page->album_id) == $album->id ? "selected":"") }}> {{$album->name}} </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        @error('album_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="d-block">Page Visibility</label>
                        @if ($page->page_type == "default")
                            <label>
                                {{ucfirst($page->status)}}
                            </label>
                        @else
                            <div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                                <input type="checkbox" class="custom-control-input" name="visibility" {{ (old("visibility") == "ON" || $page->status == "PUBLISHED" ? "checked":"") }} id="customSwitch1">
                                <label class="custom-control-label" id="label_visibility" for="customSwitch1">{{ucfirst(strtolower($page->status))}}</label>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-12 mg-t-30">
                    <h4 class="mg-b-0 tx-spacing--1">Manage SEO</h4>
                    <hr>
                </div>

                <div class="col-lg-6 mg-t-30">
                    <div class="form-group">
                        <label class="d-block">Title <code>(meta title)</code></label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ old('meta_title',$page->meta_title) }}">
                        @error('meta_title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.title') }}</p>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Description <code>(meta description)</code></label>
                        <textarea rows="3" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description">{!! old('meta_description', $page->meta_description) !!}</textarea>
                        @error('meta_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.description') }}</p>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Keywords <code>(meta keywords)</code></label>
                        <textarea rows="3" class="form-control @error('meta_keyword') is-invalid @enderror" name="meta_keyword">{!! old('meta_keyword', $page->meta_keyword) !!}</textarea>
                        @error('meta_keyword')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.keywords') }}</p>
                    </div>
                </div>

                <div class="col-lg-12 mg-t-30">
                    <input class="btn btn-primary btn-sm btn-uppercase" type="submit" value="Update Page">
                    <a href="{{route('pages.index')}}" class="btn btn-outline-secondary btn-sm btn-uppercase" type="cancel">Cancel</a>
                </div>
            </div>
        </form>
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
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/owl.carousel/owl.carousel.js') }}"></script>
    {{--    Image validation--}}
    <script>
        let BANNER_WIDTH = "{{ env('SUB_BANNER_WIDTH') }}";
        let BANNER_HEIGHT =  "{{ env('SUB_BANNER_HEIGHT') }}";
    </script>
    <script src="{{ asset('js/image-upload-validation.js') }}"></script>
    {{--    End Image validation--}}
@endsection


@section('customjs')
    <script>
        function has_none_option(objectId, currentValue)
        {
            if (currentValue == "0" || currentValue == "" || currentValue == "null") {
                document.getElementById(objectId).selectedIndex = -1;
            }
            $('#'+objectId).on('change', function() {
                if ($(this).val() == 0) {
                    document.getElementById(objectId).selectedIndex = -1;
                }
            });
        }

        $(function() {
            $('.selectpicker').selectpicker();
        });

        /**  START Slider Preview **/
        $('#album_id').on('change', function() {
            $("#preview_btn").data("id", $('#album_id').val());
            if($('#album_id').val() && $('#album_id').val() > 0){
                $('#preview_btn_div').show();
            } else {
                $('#preview_btn_div').hide();
            }
        });

        $('#preview-banner').on('show.bs.modal', function (e) {
            let album = e.relatedTarget;
            let albumId = $(album).data('id');
            $('#previewCarousel').html('');
            $.ajax({
                type: "POST",
                data: { _token: "{{ csrf_token() }}"},
                url: "{{ route('albums.banners', '') }}/" + albumId,
                success: function(returnData) {
                    console.log(returnData);
                    let pathHTML = '';
                    $.each(returnData['banner_paths'], function(index, path) {
                        pathHTML += `<div class="item">
                            <img src="`+path+`">
                        </div>`;
                    });
                    $('#previewCarousel').trigger('destroy.owl.carousel');

                    $('#previewCarousel').html(pathHTML);

                    $('#previewCarousel').owlCarousel({
                        animateOut: returnData['transition_out'],
                        animateIn: returnData['transition_in'],
                        loop: true,
                        dots: false,
                        margin: 0,
                        autoplay: true,
                        autoplayTimeout: (returnData['transition']*1000),
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
                }
            });
        });
        /**  END Slider Preview **/

        $("#customSwitch1").change(function() {
            if(this.checked) {
                $('#label_visibility').html('Published');
            }
            else{
                $('#label_visibility').html('Private');
            }
        });

        /** Handles the page banner functions **/
        $('.page_banner_btn').click(function(){

            var btn = $(this).attr('id');

            if(btn == $('#banner_type').val()){ // if user clicked the already selected button then cancel the operation.
                return false;
            }
            else{

                /** reset the input boxes **/
                $('#image_url').val('');
                $('#album_id').val('');
                $('#image_div').hide();
                $('#img_name').html('Choose file');

                $('#banner_type').val(btn);

                if(btn == 'banner_slider'){ // if user selected the banner slider

                    $("#banner_image").removeClass("active");
                    $("#banner_slider").addClass("active");

                    // $("#album_id").prop('required',true);
                    // $("#image_url").prop('required',false);

                    $(".banner-image").hide();
                    $(".banner-slider").show();
                }


                if(btn == 'banner_image'){ // if user selected the banner image

                    $("#banner_slider").removeClass("active");
                    $("#banner_image").addClass("active");

                    // $("#image_url").prop('required',true);
                    // $("#album_id").prop('required',false);

                    $(".banner-slider").hide();
                    $(".banner-image").show();

                }
            }
        });

        function readURL(file) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('#img_name').html(file.name);
                $('#image_url').attr('title', file.name);
                $('#img_temp').attr('src', e.target.result);
            }

            reader.readAsDataURL(file);
            $('#image_div').show();
        }

        $("#image_url").change(function(evt) {
            validate_images(evt, readURL);
        });

        $(document).on('click', '.remove-upload', function() {
            $('#prompt-remove').modal('show');
        });

        $('#btnRemove').on('click', function() {
            $('#editForm').prepend('<input type="hidden" name="delete_image" value="1"/>');
            $('#img_name').html('Choose file');
            $('#image_url').removeAttr('title');
            $('#image_url').val('');
            $('#img_temp').attr('src', '');
            $('#image_div').hide();
            $('#prompt-remove').modal('hide');
        });

    </script>
@endsection
