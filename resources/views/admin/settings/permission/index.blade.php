@extends('admin.layouts.app')

@section('pagetitle')
    Manage Permissions
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Account Management</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Permission Management</h4>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-md-12">
                <div class="filter-buttons mg-b-10">
                    <div class="d-md-flex bd-highlight">
                        <div class="bd-highlight mg-r-10 mg-t-10">
                            <div class="dropdown d-inline mg-r-5">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filters
                                </button>
                                <div class="dropdown-menu">
                                    <form class="pd-20">
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">Sort by</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortModule" name="sortFilter" class="custom-control-input" @if(($_GET['sort'] ?? '') == 'module') checked="checked" @endif>
                                                <label class="custom-control-label" for="sortModule">Module</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="sortUpdatedAt" name="sortFilter" class="custom-control-input" @if(($_GET['sort'] ?? '') == 'updated_at') checked="checked" @endif>
                                                <label class="custom-control-label" for="sortUpdatedAt">Updated At</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleDropdownFormEmail1">Sort order</label>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderAsc" name="orderFilter" class="custom-control-input" @if(($_GET['order'] ?? '') == 'asc') checked="checked" @endif>
                                                <label class="custom-control-label" for="orderAsc">Ascending</label>
                                            </div>

                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderDesc" name="orderFilter" @if(($_GET['order'] ?? '') == 'desc') checked="checked" @endif class="custom-control-input">
                                                <label class="custom-control-label" for="orderDesc">Descending</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-radio">
                                                <input type="checkbox" id="showDeleted" name="showDeleted" class="custom-control-input" @if(($_GET['showDeleted'] ?? '') == 'show') checked="checked" @endif>
                                                <label class="custom-control-label" for="showDeleted">Show Deleted Items</label>
                                            </div>
                                        </div>
                                        <div class="form-group mg-b-40">
                                            <label class="d-block">Items displayed</label>
                                            <input type="text" class="js-range-slider" id="pageLimit" name="pageLimit" value="{{$_GET['pageLimit'] ?? "10"}}" />
                                        </div>
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary filter">Apply filters</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="ml-auto bd-highlight mg-t-10">
                            <form autocomplete="off" class="form-inline" id="search_form" method="get">
                                @csrf
                                <div class="search-form mg-r-10">
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Module" @isset($_GET['search']) value="{{$_GET['search']}}" @endisset>
                                    <button class="btn filter" type="button"><i data-feather="search"></i></button>
                                </div>
                                @if(ViewPermissions::check_permission(Auth::user()->role_id,'admin/permission/create') == 1)
                                    <a class="btn btn-primary btn-sm mg-b-5 mt-lg-0 mt-md-0 mt-sm-0 mt-1" href="{{ route('permission.create') }}">Create a Permission</a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg table-audit">
                        <table class="table mg-b-0 table-light table-hover" style="width:100%;">
                            <thead>
                            <tr>
                                <th scope="col">Permission Route</th>
                                <th scope="col">Module</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($permissions as $permission)
                                <tr>
                                    <td><strong @if($permission->trashed()) style="text-decoration:line-through;" @endif> {{ $permission->name }}</strong></td>
                                    <td>{{ $permission->module }}</td>
                                    <td>{{ $permission->description }}</td>
                                    <td>
                                        @if($permission->trashed())
                                            <nav class="nav table-options justify-content-end">
                                                <a class="nav-link" href="{{route('permission.restore',$permission->id)}}" title="Restore this permission"><i data-feather="rotate-ccw"></i></a>
                                            </nav>
                                        @else
                                            <nav class="nav table-options justify-content-end flex-nowrap">
                                                @if(ViewPermissions::check_permission(Auth::user()->role_id,'admin/permission/edit') == 1)
                                                    <a href="{{ route('permission.edit',$permission->id) }}" class="nav-link"><i data-feather="edit"></i></a>
                                                @endif
                                                @if(ViewPermissions::check_permission(Auth::user()->role_id,'admin/permission/delete') == 1)
                                                    <a href="#modalDeletePermission" class="nav-link delete_permission" data-pid="{{ $permission->id }}" data-toggle="modal"><i data-feather="trash"></i></a>
                                                @endif
                                            </nav>
                                        @endif

                                        <nav class="nav table-options justify-content-end">

                                        </nav>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6"><center>No Permissions Found...</center></td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mg-t-5">
                    <p class="tx-gray-400 tx-12 d-inline">Showing {{$permissions->firstItem()}} to {{$permissions->lastItem()}} of {{$permissions->total()}} permissions</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $permissions->appends($param)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.settings.permission.modal')
@endsection

@section('pagejs')
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
@endsection

@section('customjs')
    <script>
        $(document).on('click','.delete_permission', function(){
            $('#modalDeletePermission').show();

            $('#pid').val($(this).data('pid'));
        });
    </script>

    <script>
        $(".js-range-slider").ionRangeSlider({
            min: 10,
            max: 100
        });

        /*** Handles the search form, redirects it to function filter ***/
        $('#search_form').submit(function(e){
            e.preventDefault();
            filter();
        });

        /*** handles the click function on filter classes, redirects it to function filter ***/
        $('.filter').click(function(){
            filter();
        });

        /*** generate the parameters for filtering of pages ***/
        function filter(){

            var url = '';

            if($('#sortUpdatedAt').is(':checked'))
                url += '&sort=updated_at';
            if($('#sortModule').is(':checked'))
                url += '&sort=module';
            if($('#orderAsc').is(':checked'))
                url += '&order=asc';
            if($('#orderDesc').is(':checked'))
                url += '&order=desc';
            if($('#pageLimit').val())
                url += '&pageLimit='+$('#pageLimit').val();
            if(($('#search').val().length)>0)
                url += '&search='+$('#search').val();
            if($('#showDeleted').is(':checked'))
                url += '&showDeleted=show';

            url = url.substring(1, url.length);

            window.location.href = "{{route('permission.search')}}?"+url;
        }
    </script>
@endsection
