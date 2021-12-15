@extends('admin.layouts.app')

@section('pagetitle')
Manage News
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
                        <li class="breadcrumb-item active" aria-current="page">News</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage News</h4>
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
                                                <label class="custom-control-label" for="orderBy2">{{__('common.title')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy3" name="orderBy" class="custom-control-input" value="is_featured" @if ($filter->orderBy == 'is_featured') checked @endif>
                                                <label class="custom-control-label" for="orderBy3">Featured</label>
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
                            @if(auth()->user()->has_access_to_route('news.change.status') || auth()->user()->has_access_to_route('news.delete'))
                                <div class="list-search d-inline">
                                    <div class="dropdown d-inline mg-r-10">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if(auth()->user()->has_access_to_route('news.change.status'))
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="change_status('PUBLISHED')">{{__('common.publish')}}</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="change_status('PRIVATE')">{{__('common.private')}}</a>
                                            @endif
                                            @if(auth()->user()->has_access_to_route('news.delete'))
                                                <a class="dropdown-item tx-danger" href="javascript:void(0)" onclick="delete_page()">{{__('common.delete')}}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="ml-auto bd-highlight mg-t-10 mg-r-10">
                            <form class="form-inline" id="searchForm">
                                <div class="search-form mg-r-10">
                                    <input name="search" type="search" id="search" class="form-control" placeholder="Search by Title" value="{{ $filter->search }}">
                                    <button class="btn filter" id="btnSearch"><i data-feather="search"></i></button>
                                </div>
                                <a class="btn btn-success btn-sm mg-b-5 mt-lg-0 mt-md-0 mt-sm-0 mt-1" href="javascript:void(0)" data-toggle="modal" data-target="#advanceSearchModal">{{__('common.advance_search')}}</a>
                            </form>
                        </div>
                        <div class="mg-t-10">
                            @if(auth()->user()->has_access_to_route('news.create'))
                                <a class="btn btn-primary btn-sm mg-b-20" href="{{ route('news.create') }}">{{__('standard.news.article.create')}}</a>
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
                        <table class="table mg-b-0 table-light table-hover" style="word-wrap: break-word;min-width: 700pxs">
                            <thead>
                                <tr>
                                    <th style="width: 10%">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                            <label class="custom-control-label" for="checkbox_all"></label>
                                        </div>
                                    </th>
                                    <th style="width: 40%;overflow: hidden;">Title</th>
                                    <th style="width: 10%">Category</th>
                                    <th style="width: 10%">Type</th>
                                    <th style="width: 10%">Visibility</th>
                                    <th style="width: 10%">Updated</th>
                                    <th style="width: 10%">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($news as $new)
                                    <tr id="row{{$new->id}}" class="row_cb">
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input cb" id="cb{{$new->id}}">
                                                <label class="custom-control-label" for="cb{{$new->id}}"></label>
                                            </div>
                                        </th>
                                        <td style="overflow: hidden;" title="{{$new->name}}">
                                            <strong @if($new->trashed()) style="text-decoration:line-through;" @endif> {{$new->name}}</strong>
                                            <p class="mg-b-0 tx-gray-500 tx-11">
                                               <a target="_blank" href="{{route('news.front.show',$new->slug)}}">{{route('news.front.show',$new->slug)}}</a>
                                            </p>
                                        </td>
                                        <td>
                                            {{$new->category->name}}
                                        </td>
                                        <td>
                                            @if($new->is_featured=='1')<span class="badge badge-success">Featured</span>@endif</td>
                                        <td style="text-transform:capitalize !important;">{!! ($new->trashed() ? '<span class="badge badge-danger">Deleted</span>':strtolower($new->status)) !!}</td>
                                        <td><span class="text-nowrap">{{ Setting::date_for_listing($new->updated_at) }}</span></td>
                                        <td>
                                            @if($new->trashed())
                                                @if (auth()->user()->has_access_to_route('news.restore'))
                                                    <nav class="nav table-options justify-content-end flex-nowrap">
                                                        <a class="nav-link" href="{{route('news.restore',$new->id)}}" title="Restore this news"><i data-feather="rotate-ccw"></i></a>
                                                    </nav>
                                                @endif
                                            @else
                                                <nav class="nav table-options justify-content-end flex-nowrap">
                                                    <a class="nav-link" target="_blank" href="{{route('news.front.show',$new->slug)}}" title="View News"><i data-feather="eye"></i></a>

                                                    @if(auth()->user()->has_access_to_route('news.edit'))
                                                        <a class="nav-link" href="{{ route('news.edit', $new->id) }}" title="Edit News"><i data-feather="edit"></i></a>
                                                    @endif

                                                    @if(auth()->user()->has_access_to_route('news.change.status') || auth()->user()->has_access_to_route('news.delete'))
                                                        <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i data-feather="settings"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            @if (auth()->user()->has_access_to_route('news.change.status'))
                                                                @if(strtoupper($new->status)=='PUBLISHED')
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="post_form('{{route('news.change.status')}}','PRIVATE',{{$new->id}})"> Private</a>
                                                                @else
                                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="post_form('{{route('news.change.status')}}','PUBLISHED',{{$new->id}})"> Publish</a>
                                                                @endif
                                                            @endif

                                                            @if (auth()->user()->has_access_to_route('news.delete'))
                                                                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_one_page({{$new->id}},'{{$new->name}}');">Delete</a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </nav>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center;"> <p class="text-danger">No news found.</p></td>
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
                    @if ($news->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $news->firstItem() }} to {{ $news->lastItem() }} of {{ $news->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $news->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <form action="" id="posting_form" style="display:none;" method="post">
        @csrf
        <input type="text" id="pages" name="pages">
        <input type="text" id="status" name="status">
    </form>

    <div id="advanceSearchModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form role="form" id="advanceFilterForm" method="GET" action="{{route('news.index.advance-search')}}">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('common.advance_search')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="name" value="{{ $advanceSearchData->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Contents</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="contents" value="{{ $advanceSearchData->contents }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Teaser</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="teaser" value="{{ $advanceSearchData->teaser }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Category</label>
                            <div>
                                <select name="category_id" class="form-control input-sm">
                                    <option value="">- All Category -</option>
                                    @php $noCategory = 0; @endphp
                                    @foreach($uniqueNewsByCategory as $news)
                                        @php $categoryId = ($news->category_id) ? $news->category_id : 0; @endphp
                                        @if ($categoryId == 0)
                                            @if ($noCategory)
                                                @continue
                                            @endif
                                            @php $noCategory += 1; @endphp
                                        @endif
                                        <option value="{{ $categoryId }}" @if ($advanceSearchData->category_id != null && $advanceSearchData->category_id == $news->category_id) selected @endif>{{$news->category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Modified by</label>
                            <div>
                                <select name="user_id" class="form-control input-sm">
                                    <option value="">- All Users -</option>
                                    @foreach($uniqueNewsByUser as $page)
                                        <option value="{{$page->user_id}}" @if ($advanceSearchData->user_id == $page->user_id) selected @endif>{{$page->user->name}}</option>
                                    @endforeach
                                </select>
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
                            <label class="control-label">Featured News</label>
                            <div>
                                <select class="form-control input-sm" name="is_featured">
                                    <option value="">- Featured & Not Featured -</option>
                                    <option value="1" @if ($advanceSearchData->is_featured == '1') selected @endif>Featured only</option>
                                    <option value="0" @if ($advanceSearchData->is_featured == '0') selected @endif>Not featured only</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SEO Title</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="meta_title" value="{{ $advanceSearchData->meta_title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SEO Description</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="meta_description" value="{{ $advanceSearchData->meta_description }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">SEO Keyword</label>
                            <div>
                                <input type="text" class="form-control input-sm" name="meta_keyword" value="{{ $advanceSearchData->meta_keyword }}">
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
                        <a class="btn btn-info" href="{{ route('news.index') }}">Reset</a>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <input type="submit" value="{{__('common.search')}}" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-delete-many" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{__('common.delete_mutiple_confirmation_title')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('common.delete_mutiple_confirmation')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnDeleteMany">Yes, Delete</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
                    You are about to <span id="newsStatus"></span> this item. Do you want to continue?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="btnUpdateStatus">Yes, Update</button>
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
    <script>
        let listingUrl = "{{ route('news.index') }}";
        let advanceListingUrl = "{{ route('news.index.advance-search') }}";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')
    <script>
        /*** handles the changing of status of multiple pages ***/
        function change_status(status){

            var counter = 0;
            var selected_pages = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_pages += fid.substring(2, fid.length)+'|';
            });

            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{

                if(parseInt(counter) > 1){ // ask for confirmation when multiple pages was selected
                    let statusName = (status == 'PUBLISHED') ? 'PUBLISH' : status;
                    $('#newsStatus').html(statusName)
                    $('#prompt-update-status').modal('show');

                    $('#btnUpdateStatus').on('click', function() {
                        post_form('{{route('news.change.status')}}',status,selected_pages);
                    });
                }
                else{
                    post_form('{{route('news.change.status')}}',status,selected_pages);
                }
            }

        }

        function post_form(url,status,pages){

            $('#posting_form').attr('action',url);
            $('#pages').val(pages);
            $('#status').val(status);
            $('#posting_form').submit();

        }

        function delete_page(){
            var counter = 0;
            var selected_pages = '';
            $(".cb:checked").each(function(){
                counter++;
                fid = $(this).attr('id');
                selected_pages += fid.substring(2, fid.length)+'|';
            });

            if(parseInt(counter) < 1){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else{
                $('#prompt-delete-many').modal('show');
                $('#btnDeleteMany').on('click', function() {
                    post_form('{{route('news.delete')}}','',selected_pages);
                });

            }
        }

        function delete_one_page(id,page){
            $('#prompt-delete').modal('show');
            $('#btnDelete').on('click', function() {
                post_form('{{route('news.delete')}}','',id);
            });
        }



        $('.cb').change(function() {
            var id = ($(this).attr('id')).replace("cb", "");
            if(this.checked) {
                $('#row'+id).addClass("row-selected");
            }
            else{
                $('#row'+id).removeClass("row-selected");
            }
        });

        function reset_form(){

            $("#advance_search_form").find("input[type=text],input[type=date], textarea, select").val("");

        }

        function check_date(feld){
            if($('#search_datestart').val() && $('#search_dateend').val()){
                if($('#search_datestart').val() > $('#search_dateend').val()){
                    alert('Date Start should not be later than Date End!');
                    $('#'+feld).val('');
                    return false;
                }
            }
            else{
                return true;
            }
        }
    </script>


@endsection
