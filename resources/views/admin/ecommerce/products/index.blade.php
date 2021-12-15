@extends('admin.layouts.app')

@section('pagetitle')
Manage Customer
@endsection

@section('pagecss')
<link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
<style>
    .row-selected {
        background-color: #92b7da !important;
    }
</style>
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-5">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('products.index')}}">Products</a></li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Products</h4>
            </div>
        </div>

        <div class="row row-sm">

            <!-- Start Filters -->
            <div class="col-md-12">
                <div class="filter-buttons">
                    <div class="d-md-flex bd-highlight">
                        <div class="bd-highlight mg-r-10 mg-t-10">
                            <div class="dropdown d-inline mg-r-5">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{__('common.filters')}}
                                </button>
                                <div class="dropdown-menu">
                                    <form id="filterForm" class="pd-20">
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">{{__('common.sort_by')}}</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy1" name="orderBy" class="custom-control-input" value="updated_at" @if ($filter->orderBy == 'updated_at') checked @endif>
                                                <label class="custom-control-label" for="orderBy1">{{__('common.date_modified')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy2" name="orderBy" class="custom-control-input" value="name" @if ($filter->orderBy == 'name') checked @endif>
                                                <label class="custom-control-label" for="orderBy2">{{__('common.name')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">{{__('common.sort_order')}}</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortByAsc" name="sortBy" class="custom-control-input" value="asc" @if ($filter->sortBy == 'asc') checked @endif>
                                                <label class="custom-control-label" for="sortByAsc">{{__('common.ascending')}}</label>
                                            </div>

                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortByDesc" name="sortBy" class="custom-control-input" value="desc"  @if ($filter->sortBy == 'desc') checked @endif>
                                                <label class="custom-control-label" for="sortByDesc">{{__('common.descending')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="showDeleted" name="showDeleted" class="custom-control-input" @if ($filter->showDeleted) checked @endif>
                                                <label class="custom-control-label" for="showDeleted">{{__('common.show_deleted')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group mg-b-40">
                                            <label class="d-block">{{__('common.item_displayed')}}</label>
                                            <input id="displaySize" type="text" class="js-range-slider" name="perPage" value="{{ $filter->perPage }}"/>
                                        </div>
                                        <button id="filter" type="button" class="btn btn-sm btn-primary">{{__('common.apply_filters')}}</button>
                                    </form>
                                </div>
                            </div>
                            @if (auth()->user()->has_access_to_route('product.multiple.change.status') || auth()->user()->has_access_to_route('products.multiple.delete'))
                                <div class="list-search d-inline">
                                    <div class="dropdown d-inline mg-r-10">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if (auth()->user()->has_access_to_route('product.multiple.change.status'))
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="change_status('PUBLISHED')">{{__('common.publish')}}</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="change_status('PRIVATE')">{{__('common.private')}}</a>
                                            @endif

                                            @if (auth()->user()->has_access_to_route('products.multiple.delete'))
                                                <a class="dropdown-item tx-danger" href="javascript:void(0)" onclick="delete_category()">{{__('common.delete')}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="ml-auto bd-highlight mg-t-10 mg-r-10">
                            <form class="form-inline" id="searchForm">
                                <div class="search-form mg-r-10">
                                    <input name="search" type="search" id="search" class="form-control"  placeholder="Search by Name" value="{{ $filter->search }}">
                                    <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                                </div>
                                <a class="btn btn-success btn-sm mg-b-5" href="javascript:void(0)" data-toggle="modal" data-target="#advanceSearchModal">Advance Search</a>
                            </form>
                        </div>
                        <div class="mg-t-10">
                            @if (auth()->user()->has_access_to_route('products.create'))
                                <a class="btn btn-primary btn-sm mg-b-20" href="{{ route('products.create') }}">{{__('standard.products.product.create')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Filters -->


            <!-- Start Pages -->
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                            <label class="custom-control-label" for="checkbox_all"></label>
                                        </div>
                                    </th>
                                    <th style="width: 20%;overflow: hidden;">Name</th>
                                    <th style="width: 15%;">Category</th>
                                    <th style="width: 15%;">Brand</th>
                                    <th style="width: 10%;">Price</th>
                                    <th style="width: 10%;">Inventory</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;">Last Date Modified</th>
                                    <th style="width: 10%;">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)

                                @if($product->category_id > 0)
                                    @php
                                        $category = ProductCategory::where('id', $product->category_id)->first();
                                        if(empty($category)){
                                            $cat = 'Uncategorized';
                                        }
                                        else{
                                            $cat = $category->name;
                                        }

                                    @endphp
                                @else
                                    @php
                                        $cat = 'Uncategorized';
                                    @endphp
                                @endif
                                <tr id="row{{$product->id}}">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input cb" id="cb{{ $product->id }}">
                                            <label class="custom-control-label" for="cb{{ $product->id }}"></label>
                                        </div>
                                    </th>
                                    <td>
                                        <strong @if($product->trashed()) style="text-decoration:line-through;" @endif> {{ $product->name }}</strong>
                                    </td>
                                    <td>{{ $cat }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>{{ $product->currency }} {{ number_format($product->price,2) }}</td>
                                    {{--<td><a href="#" onclick='window.open("{{route('report.product.stockcard',$product->id)}}", "Stock Card", "width=1200,height=800")'>{{ number_format($product->InventoryActual,2) }}</a></td>--}}
                                    <td>{{ number_format($product->InventoryActual,2) }}</td>
                                    <td>{{ $product->status }}</td>
                                    <td>{{ Setting::date_for_listing($product->updated_at) }}</td>
                                    <td>
                                        @if($product->trashed())
                                            @if (auth()->user()->has_access_to_route('product.restore'))
                                                <nav class="nav table-options">
                                                    <a class="nav-link" href="{{route('product.restore',$product->id)}}" title="Restore this product"><i data-feather="rotate-ccw"></i></a>
                                                </nav>
                                            @endif
                                        @else
                                            <nav class="nav table-options">
                                                <a class="nav-link" target="_blank" href="{{ route('product.front.show', $product->slug) }}" title="View Product Profile"><i data-feather="eye"></i></a>

                                                @if (auth()->user()->has_access_to_route('products.edit'))
                                                    <a class="nav-link" href="{{ route('products.edit',$product->id) }}" title="Edit Product"><i data-feather="edit"></i></a>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('product.single.delete'))
                                                    <a class="nav-link" href="javascript:void(0)" onclick="delete_one_category({{$product->id}},'{{$product->name}}')" title="Delete Product"><i data-feather="trash"></i></a>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('product.single-change-status'))
                                                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="settings"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if($product->status == 'PUBLISHED')
                                                            <a class="dropdown-item" href="{{route('product.single-change-status',[$product->id,'PRIVATE'])}}" > Private</a>
                                                        @else
                                                            <a class="dropdown-item" href="{{route('product.single-change-status',[$product->id,'PUBLISHED'])}}"> Publish</a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </nav>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <th colspan="7" style="text-align: center;"> <p class="text-danger">No products found.</p></th>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End Pages -->
            <div class="col-md-6">
                <div class="mg-t-5">
                    @if ($products->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $products->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="products" name="products">
        <input type="text" id="status" name="status">
    </form>

    <div class="modal effect-scale" id="prompt-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.delete_confirmation')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDelete">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-multiple-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_mutiple_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{__('common.delete_mutiple_confirmation')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDeleteMultiple">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-update-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.update_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    You are about to <span id="productStatus"></span> this item. Do you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnUpdateStatus">Yes, Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-no-selected" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.no_selected_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.no_selected')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="advanceSearchModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form role="form" id="advanceFilterForm" method="GET" action="{{route('product.index.advance-search')}}">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('common.advance_search')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="name" value="{{ $advanceSearchData->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <div>
                                <select name="category_id" class="form-control input-sm">
                                    <option value="">- All Category -</option>
                                    @foreach($uniqueProductByCategory as $pr)
                                        <option value="{{($pr->category_id) ? $pr->category_id : 0}}" @if ($advanceSearchData->category_id && $advanceSearchData->category_id == $pr->category_id) selected @endif>{{$pr->category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Brand</label>
                            <div>
                                <select name="brand" class="form-control input-sm">
                                    <option value="">- All Brands -</option>
                                    @foreach($uniqueProductByBrand as $pr)
                                        <option value="{{($pr->brand) ? $pr->brand : ''}}" @if ($advanceSearchData->brand && $advanceSearchData->brand == $pr->brand) selected @endif>{{$pr->brand}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Modified by</label>
                            <div>
                                <select name="user_id" class="form-control input-sm">
                                    <option value="">- All Users -</option>
                                    @foreach($uniqueProductByUser as $pr)
                                        <option value="{{$pr->user_id}}" @if ($advanceSearchData->user_id == $pr->user_id) selected @endif>{{$pr->user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Short Description</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="short_description" value="{{ $advanceSearchData->short_description }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Description</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="description" value="{{ $advanceSearchData->description }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Visibility</label>
                            <div>
                                <select class="form-control input-sm" name="status">
                                    <option value="">- Published & Private -</option>
                                    <option value="published" @if ($advanceSearchData->status == 'published') selected @endif>Published only</option>
                                    <option value="private" @if ($advanceSearchData->status == 'private') selected @endif>Private only</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="price1">Price (From)</label>
                                    <input type="number" step="0.01" class="form-control input-sm" id="price1" name="price1" value="{{ $advanceSearchData->price1 }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="price2">Price (To)</label>
                                    <input type="number" step="0.01" class="form-control input-sm" id="price2" name="price2" value="{{ $advanceSearchData->price2 }}" min="{{ $advanceSearchData->price2 }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="updated_at1">Date Modified (From)</label>
                                    <input type="date" class="form-control input-sm" id="updated_at1" name="updated_at1" value="{{ $advanceSearchData->updated_at1 }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="updated_at2">Date Modified (To)</label>
                                    <input type="date" class="form-control input-sm" id="updated_at2" name="updated_at2" value="{{ $advanceSearchData->updated_at2 }}" min="{{ $advanceSearchData->updated_at1 }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-info" href="{{ route('pages.index') }}">Reset</a>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <input type="submit" value="{{__('common.search')}}" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        let listingUrl = "{{ route('products.index') }}";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')
    <script>

        $(".js-range-slider").ionRangeSlider({
            grid: true,
            from: selected,
            values: perPage
        });

        /*** Handles the Select All Checkbox ***/
        $("#checkbox_all").click(function(){
            $('.cb').not(this).prop('checked', this.checked);
        });

        /*** handles the changing of status of multiple pages ***/
        function change_status(status){
            var counter = 0;
            var selected_videos = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_videos += fid.substring(2, fid.length)+'|';
            });
            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                if(parseInt(counter)>1){ // ask for confirmation when multiple pages was selected
                    $('#productStatus').html(status)
                    $('#prompt-update-status').modal('show');

                    $('#btnUpdateStatus').on('click', function() {
                        post_form("{{route('product.multiple.change.status')}}",status,selected_videos);
                    });
                }
                else{
                    post_form("{{route('product.multiple.change.status')}}",status,selected_videos);
                }
            }
        }

        function post_form(url,status,product){
            $('#posting_form').attr('action',url);
            $('#products').val(product);
            $('#status').val(status);
            $('#posting_form').submit();
        }

        function delete_category(){
            var counter = 0;
            var selected_products = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_products += fid.substring(2, fid.length)+'|';
            });

            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                $('#prompt-multiple-delete').modal('show');
                $('#btnDeleteMultiple').on('click', function() {
                    post_form("{{route('products.multiple.delete')}}",'',selected_products);
                });
            }
        }

        function delete_one_category(id,product){
            $('#prompt-delete').modal('show');
            $('#btnDelete').on('click', function() {
                post_form("{{route('product.single.delete')}}",'',id);
            });
        }

        $('.cb').change(function() {
            var id = ($(this).attr('id')).replace("cb", "");
            if(this.checked) {
                $('#row'+id).addClass("table-warning");
            }
            else{
                $('#row'+id).removeClass("table-warning");
            }

        });
    </script>
@endsection
