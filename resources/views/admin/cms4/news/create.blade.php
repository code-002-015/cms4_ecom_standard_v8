@extends('admin.layouts.app')

@section('pagetitle')
    Create News
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
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <small id="news_slug"></small>
                </div>
                <div class="form-group">
                    <label class="d-block">Date *</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{ old('date',date('Y-m-d')) }}">
                    @error('date')
                        <span class="text-danger">{{ $message }}</span>
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
                    @error('category_id')
                        <span class="text-danger">{{ $message }}</span>
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
                        <img src="" id="img_temp" alt="" height="100" width="250">  <br /><br />
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

                    @if(env('NEWS_THUMBNAIL_WIDTH') && env('NEWS_THUMBNAIL_HEIGHT'))
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
                    <textarea name="contents" id="editor1" rows="10" cols="80" required>
                         {{ old('contents') }}
                    </textarea>
                    @error('contents')
                        <span class="text-danger">{{ $message }}</span>
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
                    @error('teaser')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Page Visibility</label>
                    <div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                        <input type="checkbox" class="custom-control-input" name="visibility" {{ (old("visibility") ? "checked":"") }} id="customSwitch1">
                        <label class="custom-control-label" id="label_visibility" for="customSwitch1">@if (old("visibility")) Published @else Private @endif</label>
                    </div>
                    @error('visibility')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-block">Display @if (Article::has_featured_limit()) (Max Featured: {{ Article::has_featured_limit() }}) @endif</label>
                    <div class="custom-control custom-switch @error('is_featured') is-invalid @enderror">
                        <input type="checkbox" class="custom-control-input" name="is_featured" {{ (old("is_featured") ? "checked":"") }} id="customSwitch2" @if (Article::cannot_create_featured_news()) disabled @endif >
                        <label class="custom-control-label" for="customSwitch2">Featured</label>
                    </div>
                    @error('is_featured')
                        <span class="text-danger">{{ $message }}</span>
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
                    @error('meta_title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <p class="tx-11 mg-t-4">{{ __('standard.seo.title') }}</p>
                </div>
                <div class="form-group">
                    <label class="d-block">Description <code>(meta description)</code></label>
                    <textarea rows="3" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description">{{ old('meta_description') }}</textarea>
                    @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <p class="tx-11 mg-t-4">{{ __('standard.seo.description') }}</p>
                </div>
                <div class="form-group">
                    <label class="d-block">Keywords <code>(meta keywords)</code></label>
                    <textarea rows="3" class="form-control @error('meta_keyword') is-invalid @enderror" name="meta_keyword">{{ old('meta_keyword') }}</textarea>
                    @error('meta_keyword')
                        <span class="text-danger">{{ $message }}</span>
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
	<script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/file-upload-validation.js') }}"></script>
@endsection

@section('customjs')
	<script>
        // CKEditor
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
