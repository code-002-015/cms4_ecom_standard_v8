@extends('admin.layouts.app')

@section('pagetitle')
Manage Inventory
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
                        <li class="breadcrumb-item active" aria-current="page">Inventory</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Inventory</h4>
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

                                        <div class="form-group mg-b-40">
                                            <label class="d-block">{{__('common.item_displayed')}}</label>
                                            <input id="displaySize" type="text" class="js-range-slider" name="perPage" value="{{ $filter->perPage }}"/>
                                        </div>
                                        <button id="filter" type="button" class="btn btn-sm btn-primary">{{__('common.apply_filters')}}</button>
                                    </form>
                                </div>
                            </div>

                        </div>

                        <div class="ml-auto bd-highlight mg-t-10 mg-r-10">
                            <form class="form-inline" id="searchForm">
                                <div class="search-form mg-r-10">
                                    <input name="search" type="search" id="search" class="form-control" placeholder="Search by Ref#" value="{{ $filter->search }}">
                                    <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                                </div>

                            </form>
                        </div>
                        <div class="mg-t-10">
                            @if (auth()->user()->has_access_to_route('inventory.download.template'))
                                <a class="btn btn-info btn-sm mg-b-20" href="{{ route('inventory.download.template') }}">Download Template</a>
                            @endif

                            @if (auth()->user()->has_access_to_route('inventory.upload.template'))
                                <a class="btn btn-primary btn-sm mg-b-20" href="javascript:void(0)" onclick="$('#prompt-upload').modal('show');">Upload Inventory</a>
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
                        <table class="table mg-b-0 table-light table-hover" style="table-layout: fixed;word-wrap: break-word;">
                            <thead>
                                <tr>
                                    <th style="width: 10%;overflow: hidden;">&nbsp;&nbsp;&nbsp;Reference #</th>
                                    <th style="width: 15%">Status</th>
                                    <th style="width: 15%">Created</th>
                                    <th style="width: 15%">Posted</th>
                                    <th style="width: 15%">Cancelled</th>
                                    <th style="width: 15%">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lists as $list)
                                    <tr id="row{{$list->id}}" class="row_cb">
                                        <td style="overflow: hidden;" title="{{$list->name}}">
                                            <strong>&nbsp;&nbsp;&nbsp;{{$list->id}}</strong>
                                        </td>

                                        <td>
                                            {{$list->status}}
                                        </td>
                                        <td>
                                            <strong>{{$list->user->name ?? ''}}</strong><br>
                                            {{date('Y-m-d h:i A',strtotime($list->created_at))  ?? ''}}
                                        </td>
                                        <td>
                                            @if(!empty($list->posted_at))
                                                <strong>{{$list->posted->name ?? ''}}</strong><br>
                                                {{date('Y-m-d h:i A',strtotime($list->posted_at))  ?? ''}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($list->cancelled_at))
                                                <strong>{{$list->cancelled->name ?? ''}}</strong><br>
                                                {{date('Y-m-d h:i A',strtotime($list->cancelled_at))  ?? ''}}
                                            @endif
                                        </td>

                                        <td>
                                            @if($list->status=='SAVED')
                                                <nav class="nav table-options">
                                                    @if (auth()->user()->has_access_to_route('inventory.post'))
                                                        <a class="nav-link" href="{{route('inventory.post',$list->id)}}" title="Post this inventory"><i data-feather="send"></i></a>
                                                    @endif

                                                    @if (auth()->user()->has_access_to_route('inventory.cancel'))
                                                        <a class="nav-link" href="{{route('inventory.cancel',$list->id)}}" title="Cancel this inventory"><i data-feather="delete"></i></a>
                                                    @endif
                                                    <a class="nav-link" target="_blank" href="{{route('inventory.view',$list->id)}}" title="View items"><i data-feather="eye"></i></a>
                                                </nav>
                                            @else
                                                <nav class="nav table-options">
                                                    <a class="nav-link" target="_blank" href="{{route('inventory.view',$list->id)}}" title="View items"><i data-feather="eye"></i></a>
                                                </nav>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center;"> <p class="text-danger">No record found.</p></td>
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
                    @if ($lists->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $lists->firstItem() }} to {{ $lists->lastItem() }} of {{ $lists->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $lists->appends((array) $filter)->links() }}
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

    <div class="modal effect-scale" id="prompt-upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <form action="{{ route('inventory.upload.template') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Upload Inventory</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Note: Make sure you've used the correct csv template</p>
                        <input type="file" name="csv" required="required">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger">Upload</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
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
        let listingUrl = "{{ route('inventory.index') }}";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')


@endsection
