@extends('admin.layouts.app')

@section('pagetitle')
    Category Management
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <script src="{{ asset('lib/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('templates.index')}}">Templates</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Template</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Create Template</h4>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-lg-12">
                <form autocomplete="off" action="{{ route('templates.store') }}" method="post" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="row row-sm">
                        <div class="col-sm-6">
                            <div class="form-group mg-b-20">
                                <label class="d-block">Name <i class="tx-danger">*</i></label>
                                <input required type="text" class="form-control" name="name" required>
                            </div>

                            <div class="form-group">
                                <label class="d-block">Category <i class="tx-danger">*</i></label>
                                <select id="category_id" class="selectpicker mg-b-5" name="category_id" data-style="btn btn-outline-light btn-md btn-block tx-left" title="Select Category" data-width="100%" required>
                                    @forelse($categories as $category)
                                        <option value="{{$category->id}}">{{strtoupper($category->name)}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="d-block">Description</label>
                                <textarea class="form-control" rows="3" name="desc"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="d-block">Tags</label>
                                <input type="text" class="form-control" data-role="tagsinput" name="tags">
                            </div>

                            <div class="form-group">
                                <label class="d-block">URL <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" name="url">
                            </div>

                            <div class="form-group">
                                <label class="d-block">Thumbnail <i class="text-danger">*</i></label>
                                <input type="file" name="thumbnail_url" class="form-control">
                                <small>Required image dimension: 400px by 300px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png</small>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">Main Banner Dimensions <i class="text-danger">*</i></label>
                                        <input type="text" name="main_banner_width" class="form-control" placeholder="Width (px)" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">&nbsp;</label>
                                        <input type="text" name="main_banner_height" class="form-control" placeholder="Height (px)" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">Sub Banner Dimensions <i class="text-danger">*</i></label>
                                        <input type="text" name="sub_banner_width" class="form-control" placeholder="Width (px)" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">&nbsp;</label>
                                        <input type="text" name="sub_banner_height" class="form-control" placeholder="Height (px)" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">News Banner Dimensions <i class="text-danger">*</i></label>
                                        <input type="text" name="news_banner_width" class="form-control" placeholder="Width (px)" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">&nbsp;</label>
                                        <input type="text" name="news_banner_height" class="form-control" placeholder="Height (px)" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">News Thumbnail Dimensions <i class="text-danger">*</i></label>
                                        <input type="text" name="news_thumbnail_width" class="form-control" placeholder="Width (px)" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">&nbsp;</label>
                                        <input type="text" name="news_thumbnail_height" class="form-control" placeholder="Height (px)" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">User Logo Dimensions <i class="text-danger">*</i></label>
                                        <input type="text" name="user_logo_width" class="form-control" placeholder="Width (px)" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="d-block">&nbsp;</label>
                                        <input type="text" name="user_logo_height" class="form-control" placeholder="Height (px)" required>
                                    </div>
                                </div>
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

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/file-upload-validation.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>

    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });
    </script>
@endsection
