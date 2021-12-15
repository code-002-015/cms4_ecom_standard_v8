@extends('admin.layouts.app')

@section('pagetitle')
    User Management
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{route('product-categories.index')}}">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit a Product Category</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Edit a Product Category</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('product-categories.update',$category->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="d-block">Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name',$category->name)}}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small id="category_slug"><a target="_blank" href="{{ url('/').'/products-list?type=category&criteria='.$category->id }}">{{ url('/').'/?type=category&criteria='.$category->id }}</a></small>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Parent Category</label>
                        <select id="parentPage" class="selectpicker mg-b-5 @error('parent_page') is-invalid @enderror" name="parent_page" data-style="btn btn-outline-light btn-md btn-block tx-left" title="- None -" data-width="100%">
                            <option value="0" selected>- None -</option>
                            @foreach ($productCategories as $productCategory)
                                <option value="{{ $productCategory->id }}" @if ($productCategory->id == $category->parent_id) selected @endif>{{ $productCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="d-block">Description *</label>
                        <textarea rows="3" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description',$category->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="d-block">Visibility</label>
                        <div class="custom-control custom-switch @error('visibility') is-invalid @enderror">
                            <input type="checkbox" class="custom-control-input" name="visibility" {{ ($category->status == 'PUBLISHED' ? "checked":"") }} id="customSwitch1">
                            <label class="custom-control-label" id="label_visibility" for="customSwitch1">{{ucwords(strtolower($category->status))}}</label>
                        </div>
                        @error('visibility')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Update Category</button>
                    <a class="btn btn-outline-secondary btn-sm btn-uppercase" href="{{ route('product-categories.index') }}">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
@endsection

@section('customjs')
    <script>
        $(function() {
            $('.selectpicker').selectpicker();
        });

        $("#customSwitch1").change(function() {
            if(this.checked) {
                $('#label_visibility').html('Published');
            }
            else{
                $('#label_visibility').html('Private');
            }
        });

        /** Generation of the page slug **/
        jQuery('#name').change(function(){

            var url = $('#name').val();

            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr("content")
                }
            })

            $.ajax({
                type: "POST",
                url: "/admin/product-category-get-slug",
                data: { url: url }
            })

            .done(function(response){
                slug_url = '{{env('APP_URL')}}/product-categories/'+response;
                $('#category_slug').html("<a target='_blank' href='"+slug_url+"'>"+slug_url+"</a>");
            });
        });
    </script>
@endsection
