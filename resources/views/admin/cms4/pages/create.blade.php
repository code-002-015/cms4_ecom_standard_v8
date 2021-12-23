@extends('admin.layouts.app')

@section('pagetitle')
    Create Page
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owl.carousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
    {{-- <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script> --}}

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        rel="stylesheet"
    />
    {{-- <link rel="stylesheet" href="{{ asset('lib/grapesjs/toastr.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/grapesjs/dist/css/grapes.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/assets/css/bamburgh.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/assets/css/custom-grapesjs.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/custom-grapesjs/linearicon/css/linearicons.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('lib/grapesjs/grapick.min.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('lib/grapesjs/grapesjs-preset-webpage.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tooltip.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/grapesjs-plugin-filestack.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tui-color-picker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lib/grapesjs/tui-image-editor.min.css') }}" />
@endsection

@section('content')

    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('pages.index')}}">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create a Page</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create a Page</h4>
            </div>
        </div>
        <form method="post" action="{{ route('pages.store') }}" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-lg-6">
                    @csrf
                    <div class="form-group">
                        <label class="d-block">Page Title *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required @htmlValidationMessage({{__('standard.empty_all_field')}})>
                        @hasError(['inputName' => 'name'])
                        @endhasError
                        <small id="page_slug"></small>
                        @hasError(['inputName' => 'slug'])
                        @endhasError
                    </div>
                    <div class="form-group">
                        <label class="d-block">Page Label *</label>
                        <input type="text" class="form-control @error('label') is-invalid @enderror" name="label" id="label" value="{{ old('label') }}" required>
                        @hasError(['inputName' => 'label'])
                        @endhasError
                    </div>
                    <div class="form-group">
                        <label class="d-block">Parent Page</label>
                        <select id="parentPage" class="selectpicker mg-b-5 @error('parent_page_id') is-invalid @enderror" name="parent_page_id" data-style="btn btn-outline-light btn-md btn-block tx-left" title="- None -" data-width="100%">
                            <option selected value>- None -</option>
                            @forelse($pages as $page)
                                <option value="{{$page->id}}" {{ (old("parent_page_id") == $page->id ? "selected":"") }}> {{$page->name}} </option>
                            @empty
                            @endforelse

                        </select>
                        @hasError(['inputName' => 'parent_page_id'])
                        @endhasError
                    </div>

                    <div class="form-group">
                        <label class="d-block">Page Banner</label>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" id="banner_slider" class="btn page_banner_btn btn-secondary
							@if(old('banner_type') != 'banner_image') active @endif">Slider
                            </button>
                            <button type="button" id="banner_image" class="btn page_banner_btn btn-secondary
							@if(old('banner_type') == 'banner_image') active @endif">Image
                            </button>
                            <input type="hidden" name="banner_type" id="banner_type" value="{{ old('banner_type','banner_slider') }}">
                        </div>
                    </div>
                    <div class="form-group banner-image" @if(old('banner_type') != 'banner_image') style="display:none;" @endif>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('image_url') is-invalid @enderror" name="image_url" id="image_url" accept="image/*">
                            <label class="custom-file-label" for="image_url" id="img_name">Choose file</label>
                        </div>
                        @error('image_url')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <p class="tx-10">
                            Required image dimension: {{ env('SUB_BANNER_WIDTH') }}px by {{ env('SUB_BANNER_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                        </p>

                        <div id="image_div" style="display:none;">
                            <img src="" height="300" width="180" id="img_temp" alt="">  <br /><br />
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="remove_image();">Remove Image</a>
                        </div>
                    </div>

                    <div class="form-group banner-slider" @if(old('banner_type') == 'banner_image') style="display:none;" @endif>
                        <div class="row">
                            <div class="col-md-10">
                                <select class="selectpicker mg-b-5 @error('album_id') is-invalid @enderror" id="album_id" name="album_id" data-style="btn btn-outline-light btn-md btn-block tx-left" title="- None -" data-width="100%">
                                    <option selected value>- None -</option>
                                    @forelse($albums as $album)
                                        <option value="{{$album->id}}" {{ (old("album_id") == $album->id ? "selected":"") }}> {{$album->name}} </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            {{--						<div class="col-md-2" id="preview_btn_div" style="display:none;">--}}
                            {{--							<a href="#" data-toggle="modal" data-target="#preview-banner" id="preview_btn" class="btn btn-xs btn-success">Preview</a>--}}
                            {{--						</div>--}}
                        </div>

                        @hasError(['inputName' => 'album_id'])
                        @endhasError
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="d-block" id="contentLabel">Content *</label>

                        <div class="grid h-100 overflow-hidden" id="editor-area">
                            <div class="grid-item grid-item--behavior-fixed" style="flex-basis: 275px;margin-left:-275px" id="layers">
                                <div class="app-content--sidebar h-100" id="sidebar-inner-1">
                                    <div class="app-content--sidebar__content scrollbar-container">
                                        <div class="nav-header">
                                            <i class="lnr lnr-layers font-20px mr-3"></i>
                                            <span>Layers</span>
                                        </div>

                                        <div class="layer-view overflow-auto">
                                            <div class="layers-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid-item position-relative overflow-hidden" id="grapesjs-editor">
                                <div class="app-header px-0">
                                    <div class="position-relative d-flex justify-content-start">
                                        <button class="gjs-panel-vw" data-toggle="tooltip" data-placement="right" title="Show Layers" id="layers-view-btn" type="button">
                                            <i class="lnr lnr-chevron-right font-16px"></i>
                                            <i class="lnr lnr-chevron-left font-16px"></i>
                                        </button>

                                        <button class="gjs-panel-add" data-toggle="tooltip" data-placement="bottom" title="Blocks" id="add-blocks-btn" type="button">
                                            <i class="fa fa-plus font-16px"></i>
                                        </button>

                                        <div class="gjs-panel-res gjs-pn-buttons">
                                            <button type="button" class="btn btn-link btn-hsm device-type mr-1 bg-neutral-first px-0" id="desktop-view" data-toggle="tooltip" data-placement="bottom" title="Desktop" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center">
                                                <i class="lnr lnr-screen font-16px"></i>
                                            </span>
                                            </button>

                                            <button type="button" class="btn btn-hsm btn-link device-type mr-1 px-0" id="tablet-view" data-toggle="tooltip" data-placement="bottom" title="Tablet" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center">
                                                <i class="lnr lnr-tablet font-16px"></i>
                                            </span>
                                            </button>

                                            <button type="button" class="btn btn-hsm btn-link device-type px-0" id="mobile-view" data-toggle="tooltip" data-placement="bottom" title="Mobile" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center">
                                                <i class="lnr lnr-phone font-16px"></i>
                                            </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="position-relative d-flex justify-content-start">
                                        <div class="gjs-panel-tool gjs-pn-buttons">
                                            <button type="button" class="btn btn-link btn-hsm device-type mr-1 swv" id="sw-visibility" data-toggle="tooltip" data-placement="bottom" title="Show Borders" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center">
                                                <i class="lnr lnr-border-style font-16px"></i>
                                            </span>
                                            </button>

                                            <button type="button" class="btn btn-hsm btn-link device-type mr-1" id="editor-fullscreen" data-toggle="tooltip" data-placement="bottom" title="Fullscreen" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center">
                                                <i class="lnr lnr-expand font-16px"></i>
                                            </span>
                                            </button>

                                            <button type="button" class="btn btn-hsm btn-link device-type" data-toggle="tooltip" data-placement="bottom" title="Export" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center" data-toggle="modal" id="export" data-target="#editor-export">
                                                <i class="lnr lnr-code font-16px"></i>
                                            </span>
                                            </button>

                                            <button type="button" class="btn btn-hsm btn-link device-type" data-toggle="tooltip" data-placement="bottom" title="Import" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center" data-toggle="modal" id="export" data-target="#editor-import">
                                                <i class="lnr lnr-enter-down font-16px"></i>
                                            </span>
                                            </button>

                                            <button type="button" class="btn btn-hsm btn-link device-type" id="editor-undo" data-toggle="tooltip" data-placement="bottom" title="Undo" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center">
                                                <i class="lnr lnr-undo2 font-16px"></i>
                                            </span>
                                            </button>

                                            <button type="button" class="btn btn-hsm btn-link device-type" id="editor-redo" data-toggle="tooltip" data-placement="bottom" title="Redo" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center">
                                                <i class="lnr lnr-redo2 font-16px"></i>
                                            </span>
                                            </button>

                                            <button type="button" class="btn btn-hsm btn-link device-type" data-toggle="tooltip" data-placement="bottom" title="Clear Canvas" id="canvas-clear" type="button">
                                            <span class="btn-wrapper--icon d-flex align-items-center">
                                                <i class="lnr lnr-trash2 font-16px"></i>
                                            </span>
                                            </button>
                                        </div>
                                        <button class="gjs-panel-vw" data-toggle="tooltip" data-placement="left" title="Show Styles & Properties" id="styles-view-btn" type="button">
                                            <i class="lnr lnr-chevron-left font-16px"></i>
                                            <i class="lnr lnr-chevron-right font-16px"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="gjs">

                                </div>

                                <!-- Export-modal -->
                                <div class="modal fade" id="editor-export" tabindex="-1" role="dialog" aria-labelledby="modal-b4" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="modal-title-default">
                                                    <i class="lnr lnr-exit-right"></i>
                                                    Export
                                                </h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body row">
                                                <div class="col-lg-12">
                                                    <ul class="nav nav-line" id="myTab3" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="html-export-tab" data-toggle="tab" href="#html-export" role="tab" aria-controls="home" aria-selected="true">
                                                                HTML
                                                                <div class="divider"></div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="css-export-tab" data-toggle="tab" href="#css-export" role="tab" aria-controls="profile" aria-selected="false">
                                                                CSS
                                                                <div class="divider"></div>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content p-2 pb-0">
                                                        <div class="tab-pane fade" id="html-export" role="tabpanel" aria-labelledby="html-export-tab">

                                                        </div>
                                                        <div class="tab-pane fade" id="css-export" role="tabpanel" aria-labelledby="css-export-tab">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary ml-auto" id='gjs-export-zip'>
                                                    <i class="lnr lnr-file-zip"></i>
                                                    Export to ZIP
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- import modal -->
                                <div class="modal fade" id="editor-import" tabindex="-1" role="dialog" aria-labelledby="modal-b4" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title" id="modal-title-default">
                                                    <i class="lnr lnr-enter-right"></i>
                                                    Import
                                                </h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body row">
                                                <div class="col-lg-12">

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary ml-auto" id='import-component'>
                                                    <i class="lnr lnr-check"></i>
                                                    Import
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="grid-item grid-item--behavior-fixed h-100" style="flex-basis: 280px;margin-right:-280px" id="styles-or-traits-mgr">
                                <div class="nav-header">
                                    <i class="lnr lnr-palette font-20px mr-3"></i>
                                    <span>Styles & Properties</span>
                                </div>
                                <div class="style-view position-relative overflow-auto">
                                    <div id="selector-mgr">

                                    </div>
                                    <div id="traits-mgr">

                                    </div>
                                    <div id="styles-mgr">

                                    </div>
                                </div>
                            </div>

                            <!-- block panel -->
                            <div class="panel-blocks">
                                <div class="app-content--sidebar__header py-3 panel-blocks-header">
                                    <div class="grid grid--align-center">
                                        <div class="grid-item">
                                            <div class="input-group-container">
                                                <div class="position-relative d-none">
                                                    <input class="input-group__input--select input-box" type="text" placeholder="Search block" />
                                                </div>
                                                <div class="position-relative">
                                                    <select id="block-select" class="input-group__input--select input-box">
                                                        <option value="1" selected>Basic Blocks</option>
                                                        <option value="2">Built-in Blocks</option>
                                                    </select>
                                                    <i class="select-group__icon is-abs--r is-no-pointer icon fa fa-null"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid-item grid-item--behavior-fixed ml-2 d-none">
                                            <button type="button" class="btn btn-block btn-hinfo btn-sm px-2" id="mobile-view">
                                            <span class="btn-wrapper--icon">
                                                <i class="lnr lnr-magnifier"></i>
                                                <i class="lnr lnr-cross2"></i>
                                            </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="blocks-mgr">

                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="json" id="json" value="">
                        <input type="hidden" name="contents" id="contents" value="">
                        <input type="hidden" name="styles" id="styles" value="">

                        {{-- <textarea name="contents" id="editor1" rows="10" cols="80" required>
                             {{ old('contents') }}
                        </textarea> --}}
                        @hasError(['inputName' => 'contents'])
                        @endhasError
                        <span class="invalid-feedback" role="alert" id="contentsRequired" style="display: none;">
                        <strong>The content field is required</strong>
                    </span>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Page Visibility</label>
                        <div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                            <input type="checkbox" class="custom-control-input" name="visibility" {{ (old("visibility") ? "checked":"") }} id="customSwitch1">
                            <label class="custom-control-label" id="label_visibility" for="customSwitch1">Private</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mg-t-30">
                    <h4 class="mg-b-0 tx-spacing--1">Manage SEO</h4>
                    <hr>
                </div>

                <div class="col-lg-6 mg-t-30">
                    <div class="form-group">
                        <label class="d-block">Title <code>(meta title)</code></label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ old('meta_title') }}">
                        @hasError(['inputName' => 'meta_title'])
                        @endhasError
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.title') }}</p>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Description <code>(meta description)</code></label>
                        <textarea rows="3" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description">{{ old('meta_description') }}</textarea>
                        @hasError(['inputName' => 'meta_description'])
                        @endhasError
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.description') }}</p>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Keywords <code>(meta keywords)</code></label>
                        <textarea rows="3" class="form-control @error('meta_keyword') is-invalid @enderror" name="meta_keyword">{{ old('meta_keyword') }}</textarea>
                        @hasError(['inputName' => 'meta_keyword'])
                        @endhasError
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.keywords') }}</p>
                    </div>
                </div>

                <div class="col-lg-12 mg-t-30">
                    <input class="btn btn-primary btn-sm btn-uppercase" type="submit" value="Save Page">
                    <a href="{{ route('pages.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
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
@endsection

@section('pagejs')
    <script>
        // jQuery Typing
        (function(f){function l(g,h){function d(a){if(!e){e=true;c.start&&c.start(a,b)}}function i(a,j){if(e){clearTimeout(k);k=setTimeout(function(){e=false;c.stop&&c.stop(a,b)},j>=0?j:c.delay)}}var c=f.extend({start:null,stop:null,delay:400},h),b=f(g),e=false,k;b.keypress(d);b.keydown(function(a){if(a.keyCode===8||a.keyCode===46)d(a)});b.keyup(i);b.blur(function(a){i(a,0)})}f.fn.typing=function(g){return this.each(function(h,d){l(d,g)})}})(jQuery);
        $(document).ready( function($){
            $('#icons-filter').typing({
                stop: function (event, $elem) {
                    var filterValue = $elem.val(),
                        count = 0;
                    if( $elem.val() ) {
                        $(".icons-list li").each(function(){
                            if ($(this).text().search(new RegExp(filterValue, "i")) < 0) {
                                $(this).fadeOut();
                            } else {
                                $(this).show();
                                count++
                            }
                        });
                    } else {
                        $(".icons-list li").show();
                    }
                    count = 0;
                },
                delay: 500
            });
        });
    </script>
    <script>
        let jsComponents = "";
        let jsStyles = "";
    </script>
    <script src="{{ asset('lib/custom-grapesjs/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/owl.carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('js/file-upload-validation.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button-2.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs/dist/grapes.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-blocks-basic/dist/grapesjs-blocks-basic.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-pkurg-bootstrap4-plugin.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-lory-slider.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-touch.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-parser-postcss.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-tooltip.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-tui-image-editor.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-typed.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-style-bg.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/tui-code-snippet.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/tui-color-picker.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-plugin-ckeditor.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-plugin-export.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-blocks-bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/b4bulder-custom-blocks.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-preset-webpage.min.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/grapesjs-plugins/grapesjs-plugin-animation.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/assets/js/custom-grapesjs.js') }}"></script>
    <script src="{{ asset('lib/custom-grapesjs/assets/js/bamburgh.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.0/typed.min.js"></script>
@endsection
@section('customjs')
    <script>
        // jQuery Typing
        (function(f){function l(g,h){function d(a){if(!e){e=true;c.start&&c.start(a,b)}}function i(a,j){if(e){clearTimeout(k);k=setTimeout(function(){e=false;c.stop&&c.stop(a,b)},j>=0?j:c.delay)}}var c=f.extend({start:null,stop:null,delay:400},h),b=f(g),e=false,k;b.keypress(d);b.keydown(function(a){if(a.keyCode===8||a.keyCode===46)d(a)});b.keyup(i);b.blur(function(a){i(a,0)})}f.fn.typing=function(g){return this.each(function(h,d){l(d,g)})}})(jQuery);
        jQuery(document).ready( function($){
            $('#icons-filter').typing({
                stop: function (event, $elem) {
                    var filterValue = $elem.val(),
                        count = 0;
                    if( $elem.val() ) {
                        $(".icons-list li").each(function(){
                            if ($(this).text().search(new RegExp(filterValue, "i")) < 0) {
                                $(this).fadeOut();
                            } else {
                                $(this).show();
                                count++
                            }
                        });
                    } else {
                        $(".icons-list li").show();
                    }
                    count = 0;
                },
                delay: 500
            });
        });
    </script>
    <script>
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
        /** Generation of the page slug **/
        function get_page_slug() {
            var url = $('#name').val();
            var parentPage = $('#parentPage').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            })
            $.ajax({
                type: "POST",
                url: "{{ route('pages.get_slug') }}",
                data: {url: url, parentPage: parentPage}
            })
                .done(function (response) {
                    slug_url = '{{env('APP_URL')}}/' + response;
                    $('#page_slug').html("<a target='_blank' href='" + slug_url + "'>" + slug_url + "</a>");
                });
        }
        $('#parentPage').change(function(){
            get_page_slug();
        });
        $('#name').change(function(){
            get_page_slug();
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
                $('#img_name').html('Choose file');
                $('#album_id').val('');
                $('#image_div').hide();
                $('#banner_type').val(btn);
                $('#image_url').val();
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
    </script>
    <script>
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
            $('#img_name').html('Choose file');
            $('#img_temp').attr('src', '');
            $('#image_div').hide();
            let files = evt.target.files;
            let maxSize = 1;
            let validateFileTypes = ["image/jpeg", "image/png"];
            let requiredWidth = "{{ env('SUB_BANNER_WIDTH') }}";
            let requiredHeight =  "{{ env('SUB_BANNER_HEIGHT') }}";
            validate_files(files, readURL, maxSize, validateFileTypes, requiredWidth, requiredHeight, remove_banner_value_when_error);
        });
        function remove_banner_value_when_error()
        {
            $('#image_url').val('');
            $('#image_url').removeAttr('title');
        }
        function remove_image() {
            $('#img_name').html('Choose file');
            $('#image_url').removeAttr('title');
            $('#image_url').val('');
            $('#img_temp').attr('src', '');
            $('#image_div').hide();
        }
    </script>
@endsection
