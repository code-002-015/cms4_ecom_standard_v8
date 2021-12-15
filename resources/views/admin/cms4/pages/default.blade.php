@extends('admin.layouts.app')

@section('pagetitle')
    Edit Page
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
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
        <form id="editForm" action="{{ route('pages.update-default', $page->id) }}" method="post" enctype="multipart/form-data">
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
                        @hasError(['inputName' => 'label'])
                        @endhasError
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="d-block">Content *</label>
                        @if ($page->is_home_page())
                            <p>
                                <small>
                                    To display selected items from your News List, you need to add the following keywords:
                                    <ul>
                                        <li>{Featured Articles} = Add all the news articles marked as Featured</li>
                                    </ul>
                                </small>
                            </p>
                        @endif
                        <textarea name="contents" id="editor1" rows="10" cols="80" required>
                            {{ old('contents', $page->contents) }}
					    </textarea>
                        @hasError(['inputName' => 'contents'])
                        @endhasError

                        <span class="invalid-feedback" role="alert" id="contentsRequired" style="display: none;">
                            <strong>The content field is required</strong>
                        </span>
                    </div>
                </div>

                <div class="col-lg-12 mg-t-30">
                    <h4 class="mg-b-0 tx-spacing--1">Manage SEO</h4>
                    <hr>
                </div>

                <div class="col-lg-6 mg-t-30">
                    <div class="form-group">
                        <label class="d-block">Title <code>(meta title)</code></label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
                        @hasError(['inputName' => 'meta_title'])
                        @endhasError
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.title') }}</p>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Description <code>(meta description)</code></label>
                        <textarea rows="3" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description">{!! old('meta_description', $page->meta_description) !!}</textarea>
                        @hasError(['inputName' => 'meta_description'])
                        @endhasError
                        <p class="tx-11 mg-t-4">{{ __('standard.seo.description') }}</p>
                    </div>
                    <div class="form-group">
                        <label class="d-block">Keywords <code>(meta keywords)</code></label>
                        <textarea rows="3" class="form-control @error('meta_keyword') is-invalid @enderror" name="meta_keyword">{!! old('meta_keyword', $page->meta_keyword) !!}</textarea>
                        @hasError(['inputName' => 'meta_keyword'])
                        @endhasError
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

@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
@endsection


@section('customjs')
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        var options = {
            filebrowserImageBrowseUrl: '{{ env('APP_URL') }}/laravel-filemanager?type=Images',
            filebrowserImageUpload: '{{ env('APP_URL') }}/laravel-filemanager/upload?type=Images&_token={{ csrf_token() }}',
            filebrowserBrowseUrl: '{{ env('APP_URL') }}/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '{{ env('APP_URL') }}/laravel-filemanager/upload?type=Files&_token={{ csrf_token() }}',
            allowedContent: true,
        };
        let editor = CKEDITOR.replace('contents', options);
        editor.on('required', function (evt) {
            if ($('.invalid-feedback').length == 1) {
                $('#contentsRequired').show();
            }
            $('#cke_editor1').addClass('is-invalid');
            evt.cancel();
        });
    </script>
@endsection
