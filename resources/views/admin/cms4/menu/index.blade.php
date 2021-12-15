@extends('admin.layouts.app')

@section('pagetitle')
    Manage Menus
@endsection

@section('pagecss')
	<link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
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
                    <li class="breadcrumb-item active" aria-current="page">Menu</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Manage Menus</h4>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-md-12">
            <div class="filter-buttons mg-b-10">
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
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="orderBy3" name="orderBy" class="custom-control-input" value="is_active" @if ($filter->orderBy == 'is_active') checked @endif>
                                            <label class="custom-control-label" for="orderBy3">{{__('common.status')}}</label>
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
                        @if(auth()->user()->has_access_to_route('menus.destroy_many'))
                            <div class="list-search d-inline">
                                <div class="dropdown d-inline mg-r-10">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button id="deleteMenus" class="dropdown-item tx-danger">Delete</button>
                                        <form id="menusForm" method="POST" action="{{ route('menus.destroy_many') }}">
                                            @method('DELETE')
                                            @csrf
                                            <input name="ids" id="menuIds" type="hidden">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="ml-auto bd-highlight mg-t-10">
                        <form class="form-inline" id="searchForm">
                            <div class="search-form mg-r-10">
                                <input name="search" type="search" id="search" class="form-control" placeholder="Search by Name" value="{{ $filter->search }}">
                                <button class="btn"><i data-feather="search"></i></button>
                            </div>
                            @if(auth()->user()->has_access_to_route('menus.create'))
                                <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm mg-b-5 mt-lg-0 mt-md-0 mt-sm-0 mt-1">Create a Menu</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-list mg-b-10">
                <div class="table-responsive-lg">
                    <table class="table mg-b-0 table-light table-hover" style="width:100%;word-wrap: break-word;min-width:500px">
                        <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                        <label class="custom-control-label" for="checkbox_all"></label>
                                    </div>
                                </th>
                                <th scope="col" class="wd-35p-f we-lg-50p-f">Menu Name</th>
                                <th scope="col">Menu Status</th>
                                <th scope="col">Date Modified</th>
                                <th scope="col" class="text-right">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($menus as $menu)
                                <tr id="row{{$menu->id}}" class="@if (!$menu->is_active) row_cb @endif">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input @if (!$menu->is_active) cb  @endif" id="cb{{ $menu->id }}" data-id="{{ $menu->id }}" data-is-active="{{ $menu->is_active }}" @if ($menu->is_active) disabled @endif>
                                            <label class="custom-control-label" for="cb{{ $menu->id }}"></label>
                                        </div>
                                    </th>
                                    <td style="overflow: hidden;text-overflow: ellipsis;">
                                        <strong @if($menu->trashed()) style="text-decoration:line-through;" @endif title="{{ $menu->name }}">{{ $menu->name }}</strong><br />
                                        <p class="mg-b-0 tx-gray-500 tx-11" style="overflow: hidden;text-overflow: ellipsis;">
                                            @foreach ($menu->navigation as $link)
                                                @if ($link->page_id == 0)
                                                    {{ $link->label }}@if (!$loop->last), @endif
                                                @else
                                                    {{ $link->page->name }}@if (!$loop->last), @endif
                                                @endif
                                            @endforeach
                                        </p>
                                    </td>
                                    <td>
                                        @if ($menu->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-nowrap">{{ SettingHelper::date_for_listing($menu->updated_at) }}</span>
                                    </td>
                                    <td>
                                        @if($menu->trashed())
                                            @if (auth()->user()->has_access_to_route('menus.restore'))
                                                <nav class="nav table-options justify-content-end">
                                                    <a class="nav-link" href="{{route('menus.restore', $menu->id)}}" title="Restore this menu"><i data-feather="rotate-ccw"></i></a>
                                                </nav>
                                            @endif
                                        @else
                                            <nav class="nav table-options justify-content-end">
                                                @if(auth()->user()->has_access_to_route('menus.edit'))
                                                    <a class="nav-link" title="Edit menu" href="{{ route('menus.edit', $menu->id) }}">
                                                        <i data-feather="edit"></i>
                                                    </a>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('menus.edit') || auth()->user()->has_access_to_route('menus.destroy'))
                                                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="settings"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if(auth()->user()->has_access_to_route('menus.edit'))
                                                            <a class="dropdown-item" data-target="#promptQuickEdit" data-toggle="modal" data-animation="effect-scale" data-id="{{$menu->id}}" data-name="{{ $menu->name }}" data-is-active="{{ $menu->is_active }}">Quick Edit</a>
                                                        @endif

                                                        @if(auth()->user()->has_access_to_route('menus.destroy'))
                                                            <button type="button" class="dropdown-item" @if ($menu->is_active) disabled @endif data-target="#prompt-delete-menu" data-toggle="modal" data-animation="effect-scale" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-is-active="{{ $menu->is_active }}">Delete</button>
                                                            @if (!$menu->is_active)
                                                                <form id="menuForm{{ $menu->id }}" method="POST" action="{{ route('menus.destroy', $menu->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endif
                                            </nav>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="5" style="text-align: center;"> <p class="text-danger">No menus found</p></th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- table-responsive -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="mg-t-5">
                @if ($menus->firstItem() == null)
                    <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                @else
                    <p class="tx-gray-400 tx-12 d-inline">Showing {{ $menus->firstItem() }} to {{ $menus->lastItem() }} of {{ $menus->total() }} items</p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="text-md-right float-md-right mg-t-5">
                <div>
                    {{ $menus->appends((array) $filter)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal effect-scale" id="prompt-delete-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                <button type="button" class="btn btn-sm btn-danger" id="deleteMenu">Yes, Delete</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal effect-scale" id="delete-active-menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please set a different menu to active before deleting this menu.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
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
<div class="modal effect-scale" id="promptQuickEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Quick Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="d-block">Menu Name *</label>
                        <input type="text" class="form-control" name="name" id="editName">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="hidden" required name="is_active" id="menuIsActive">
                            <input type="hidden" required name="pages_json" id="menuIsActive" value="[]">
                            <input type="checkbox" class="custom-control-input" id="editStatus">
                            <label class="custom-control-label" for="editStatus" id="editLabelStatus">Inactive</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary">Save Menu</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
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
@endsection

@section('pagejs')
	<script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script>
        let listingUrl = "{{ route('menus.index') }}";
        let advanceListingUrl = "";
        let searchType = "{{ $searchType }}";
    </script>
    <script src="{{ asset('js/listing.js') }}"></script>
@endsection

@section('customjs')
    @if ($errors->any())
        <script>
            $('#toastErrorMessage').toast('show');
        </script>
    @endif

    <script>
        function checkStatus($status) {
            if ($status) {
                $('#editStatus').prop('checked', true);
                $('#editLabelStatus').html('Active');
                $('#menuIsActive').val(1);
            } else {
                $('#editStatus').prop('checked', false);
                $('#editLabelStatus').html('Inactive');
                $('#menuIsActive').val(0);
            }
        }

        $('#promptQuickEdit').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element

            let menu = e.relatedTarget;
            let menuId = $(menu).data('id');
            let menuName = $(menu).data('name');
            let menuIsActive = $(menu).data('is-active');
            let formAction = "{{ route('menus.quick_update', 0) }}".split('/');
            formAction.pop();
            let editFormAction = formAction.join('/') + "/" + menuId;
            $('#editForm').attr('action', editFormAction);

            $('#editName').val(menuName);
            checkStatus(menuIsActive);

            if (menuIsActive) {
                $('#editStatus').prop('disabled', true);
            } else {
                $('#editStatus').prop('disabled', false);
            }
        });

        $('#editStatus').on('click', function() {
            checkStatus($(this).is(':checked'));
        });

        let ids;
        $('#deleteMenus').on('click', function() {
            if($(".cb:checked").length <= 0){
                $('#prompt-no-selected').modal('show');
                return false;
            }
            else {
                ids = [];
                $.each($(".cb:checked"), function() {
                    ids.push($(this).data('id'));
                });

                $('#prompt-delete-many').modal('show');
            }
        });

        $('#btnDeleteMany').on('click', function () {
            $('#menuIds').val(ids);
            $('#menusForm').submit();
        });

        let aid;
        $('#prompt-delete-menu').on('show.bs.modal', function (e) {
            let menu = e.relatedTarget;
            aid = $(menu).data('id');
        });

        $('#deleteMenu').on('click', function() {
            $('#menuForm'+aid).submit();
            $('#prompt-delete-menu').modal('hide');
        });
    </script>
@endsection
