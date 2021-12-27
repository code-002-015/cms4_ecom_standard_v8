@extends('admin.layouts.app')

@section('pagetitle')
    Create News
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
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
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('news.index')}}">News</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create a News</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Create a News</h4>
            </div>
        </div>
        <form method="post" action="{{ route('news.store') }}" enctype="multipart/form-data">
            <div class="row row-sm">
                <div class="col-lg-6">
                    @csrf
                    <div class="form-group">
                        <label class="d-block">Title *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required @htmlValidationMessage({{__('standard.empty_all_field')}})>
                        @error(['inputName' => 'name'])
                        @enderror
                        <small id="news_slug"></small>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Date *</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{ old('date',date('Y-m-d')) }}">
                        @error(['inputName' => 'date'])
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Category</label>
                        <select id="category_id" class="selectpicker mg-b-5 @error('category_id') is-invalid @enderror" name="category_id" data-style="btn btn-outline-light btn-md btn-block tx-left" title="- None -" data-width="100%">
                            <option value="0" selected>- None -</option>
                            @forelse($categories as $category)
                                <option value="{{$category->id}}">{{strtoupper($category->name)}}</option>
                            @empty
                            @endforelse
                        </select>
                        @error(['inputName' => 'category_id'])
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Article banner</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('news_image') is-invalid @enderror" name="news_image" id="news_image"  accept="image/*">
                            <label class="custom-file-label" for="news_image" id="img_name">Choose file</label>
                        </div>
                        <p class="tx-10">
                            Required image dimension: {{ env('NEWS_BANNER_WIDTH') }}px by {{ env('NEWS_BANNER_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                        </p>
                        @error('news_image')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div id="image_div" style="display:none;">
                            <img src="" id="img_temp" alt="" height="300" width="180">  <br /><br />
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="remove_image();">Remove Image</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Article thumbnail</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('news_thumbnail') is-invalid @enderror" name="news_thumbnail" id="news_thumbnail"  accept="image/*">
                            <label class="custom-file-label" for="news_thumbnail" id="img_name_thumbnail">Choose file</label>
                        </div>
                        @error('news_thumbnail')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        @if (env('NEWS_THUMBNAIL_WIDTH') && env('NEWS_THUMBNAIL_HEIGHT'))
                            <p class="tx-10">
                                Required image dimension: {{ env('NEWS_THUMBNAIL_WIDTH') }}px by {{ env('NEWS_THUMBNAIL_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                            </p>
                        @endif
                        <div id="image_div_thumbnail" style="display:none;">
                            <img src="" id="img_temp_thumbnail" alt="">  <br /><br />
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger" onclick="remove_image_thumbnail();">Remove Image</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="d-block">Content *</label>

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

                        @error(['inputName' => 'contents'])
                        @enderror
                        <span class="invalid-feedback" role="alert" id="contentsRequired" style="display: none;">
                        <strong>The content field is required</strong>
                    </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-block">Teaser *</label>
                        <textarea class="form-control @error('teaser') is-invalid @enderror" name="teaser" rows="4" required @htmlValidationMessage({{__('standard.empty_all_field')}})>{{ old("teaser") }}</textarea>
                        @error(['inputName' => 'teaser'])
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Page Visibility</label>
                        <div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                            <input type="checkbox" class="custom-control-input" name="visibility" {{ (old("visibility") ? "checked":"") }} id="customSwitch1">
                            <label class="custom-control-label" id="label_visibility" for="customSwitch1">@if (old("visibility")) Published @else Private @endif</label>
                        </div>
                        @error(['inputName' => 'visibility'])
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="d-block">Display @if (\App\Article::has_featured_limit()) (Max Featured: {{ \App\Article::has_featured_limit() }}) @endif</label>
                        <div class="custom-control custom-switch @error('is_featured') is-invalid @enderror">
                            <input type="checkbox" class="custom-control-input" name="is_featured" {{ (old("is_featured") ? "checked":"") }} id="customSwitch2" @if (\App\Article::cannot_create_featured_news()) disabled @endif >
                            <label class="custom-control-label" for="customSwitch2">Featured</label>
                        </div>
                        @error(['inputName' => 'is_featured'])
                        @enderror
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
                        @error(['inputName' => 'meta_title'])
                        @enderror
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.title') }}</p>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Description <code>(meta description)</code></label>
                        <textarea rows="3" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description">{{ old('meta_description') }}</textarea>
                        @error(['inputName' => 'meta_description'])
                        @enderror
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.description') }}</p>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Keywords <code>(meta keywords)</code></label>
                        <textarea rows="3" class="form-control @error('meta_keyword') is-invalid @enderror" name="meta_keyword">{{ old('meta_keyword') }}</textarea>
                        @error(['inputName' => 'meta_keyword'])
                        @enderror
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.keywords') }}</p>
                    </div>
                </div>

                <div class="col-lg-12 mg-t-30">
                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Save News</button>
                    <a href="{{ route('news.index') }}" class="btn btn-outline-secondary btn-sm btn-uppercase">Cancel</a>
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
        $(function() {
            $('.selectpicker').selectpicker();
        });
        $(function() {
            $("#customSwitch1").change(function() {
                if(this.checked) {
                    $('#label_visibility').html('Published');
                }
                else{
                    $('#label_visibility').html('Private');
                }
            });
            $('#name').change(function(){
                let url = $('#name').val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('news.get-slug') }}",
                    data: { url: url, _token: "{{ csrf_token() }}" }
                }).done(function(response){
                    slug_url = '{{env('APP_URL')}}/news/'+response;
                    $('#news_slug').html("<a target='_blank' href='"+slug_url+"'>"+slug_url+"</a>");
                });
            });
        });
    </script>
    <script>
        function readURL(file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#img_name').html(file.name);
                $('#news_image').attr('title', file.name);
                $('#img_temp').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
            $('#image_div').show();
        }
        $("#news_image").change(function(evt) {
            $('#img_name').html('Choose file');
            $('#img_temp').attr('src', '');
            $('#image_div').hide();
            let files = evt.target.files;
            let maxSize = 1;
            let validateFileTypes = ["image/jpeg", "image/png"];
            let requiredWidth = "{{ env('NEWS_BANNER_WIDTH') }}";
            let requiredHeight =  "{{ env('NEWS_BANNER_HEIGHT') }}";
            validate_files(files, readURL, maxSize, validateFileTypes, requiredWidth, requiredHeight, empty_banner_value);
        });
        function empty_banner_value()
        {
            $('#news_image').removeAttr('title');
            $('#news_image').val('');
        }
        function remove_image() {
            $('#img_name').html('Choose file');
            $('#news_image').removeAttr('title');
            $('#news_image').val('');
            $('#img_temp').attr('src', '');
            $('#image_div').hide();
        }
        // Thumbnail
        function readURLThumb(file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#img_name_thumbnail').html(file.name);
                $('#news_thumbnail').attr('title', file.name);
                $('#img_temp_thumbnail').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
            $('#image_div_thumbnail').show();
        }
        $("#news_thumbnail").change(function(evt) {
            $('#img_name_thumbnail').html('Choose file');
            $('#img_temp_thumbnail').attr('src', '');
            $('#image_div_thumbnail').hide();
            let files = evt.target.files;
            let maxSize = 1;
            let validateFileTypes = ["image/jpeg", "image/png"];
            let requiredWidth = "{{ env('NEWS_THUMBNAIL_WIDTH') }}";
            let requiredHeight =  "{{ env('NEWS_THUMBNAIL_HEIGHT') }}";
            validate_files(files, readURLThumb, maxSize, validateFileTypes, requiredWidth, requiredHeight, empty_thumbnail_value);
        });
        function empty_thumbnail_value()
        {
            $('#news_thumbnail').val('');
            $('#news_thumbnail').removeAttr('title');
        }
        function remove_image_thumbnail(){
            $('#img_name_thumbnail').html('Choose file');
            $('#news_thumbnail').removeAttr('title');
            $('#news_thumbnail').val('');
            $('#img_temp_thumbnail').attr('src', '');
            $('#image_div_thumbnail').hide();
        }
    </script>
@endsection
