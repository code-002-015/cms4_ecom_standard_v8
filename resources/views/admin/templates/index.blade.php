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
                        <li class="breadcrumb-item active" aria-current="page">Templates</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Templates</h4>
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
                            </form>
                        </div>
                        <div class="mg-t-10">
                            <a class="btn btn-primary btn-sm mg-b-20" href="{{ route('templates.create') }}">Create Template</a>
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
                                    <th width="5%">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                            <label class="custom-control-label" for="checkbox_all"></label>
                                        </div>
                                    </th>
                                    <th width="25%">Name</th>
                                    <th width="10%">Category</th>
                                    <th width="20%">Tags</th>
                                    <th width="10%">Status</th>
                                    <th width="15%">Last Date Modified</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($templates as $temp)
                                    <tr id="row{{$temp->id}}" class="row_cb">
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input cb" id="cb{{$temp->id}}">
                                                <label class="custom-control-label" for="cb{{$temp->id}}"></label>
                                            </div>
                                        </th>
                                        <td>
                                            <strong @if($temp->trashed()) style="text-decoration:line-through;" @endif> {{$temp->name}}</strong>
                                        </td>
                                        <td>{{$temp->category->name}}</td>
                                        <td>{{$temp->tags}}</td>
                                        <td>{{$temp->status}}</td>
                                        <td>{{ Setting::date_for_listing($temp->updated_at) }}</td>
                                        <td>
                                            <nav class="nav table-options justify-content-end flex-nowrap">
                                                <a class="nav-link" href="" title="Edit News"><i data-feather="edit"></i></a>

                                                <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i data-feather="settings"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if(strtoupper($temp->status)=='PUBLISHED')
                                                        <a class="dropdown-item" href="javascript:void(0);"> Private</a>
                                                    @else
                                                        <a class="dropdown-item" href="javascript:void(0);"> Publish</a>
                                                    @endif

                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_one_page({{$temp->id}},'{{$temp->name}}');">Delete</a>
                                                </div>
                                            </nav>
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
                    @if ($templates->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $templates->firstItem() }} to {{ $templates->lastItem() }} of {{ $templates->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $templates->appends((array) $filter)->links() }}
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
