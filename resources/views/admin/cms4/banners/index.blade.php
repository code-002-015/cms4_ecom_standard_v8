@extends('admin.layouts.app')

@section('pagetitle')
    Manage Banners
@endsection

@section('pagecss')
    <link href="{{ asset('lib/bselect/dist/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owl.carousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
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
                        <li class="breadcrumb-item active" aria-current="page">Albums</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Albums</h4>
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
                            @if(auth()->user()->has_access_to_route('albums.destroy_many'))
                                <div class="list-search d-inline">
                                    <div class="dropdown d-inline mg-r-10">
                                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <form id="albumsForm" method="POST" class="d-none" action="{{ route('albums.destroy_many') }}">
                                            @method('DELETE')
                                            @csrf
                                            <input name="ids" id="albumIds" type="hidden">
                                        </form>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <button id="deleteAlbums" class="dropdown-item tx-danger">Delete</button>
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
                                @if(auth()->user()->has_access_to_route('albums.edit'))
                                    <a href="{{ route('albums.edit', 1) }}" class="btn btn-primary btn-sm mg-b-5 mt-lg-0 mt-md-0 mt-sm-0 mt-1">Manage Home Banner</a>
                                @endif
                                @if(auth()->user()->has_access_to_route('albums.create'))
                                    <a href="{{route('albums.create')}}" class="btn btn-primary btn-sm mg-b-5 mg-l-5 mt-lg-0 mt-md-0 mt-sm-0 mt-1">Create an Album</a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover" style="width:100%;word-wrap: break-word;">
                            <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox_all">
                                        <label class="custom-control-label" for="checkbox_all"></label>
                                    </div>
                                </th>
                                <th scope="col" width="60%">Album Name</th>
                                <th scope="col">Total images</th>
                                <th scope="col">Date Updated</th>
                                <th scope="col" class="text-right">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($albums as $album)
                                <tr id="row{{$album->id}}" class="row_cb">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input cb" id="cb{{ $album->id }}" data-id="{{ $album->id }}">
                                            <label class="custom-control-label" for="cb{{ $album->id }}"></label>
                                        </div>
                                    </th>
                                    <td style="overflow: hidden;text-overflow: ellipsis;" title="{{$album->name}}">
                                        <strong @if($album->trashed()) style="text-decoration:line-through;" @endif title="{{ $album->name }}">{{ $album->name }}</strong>
                                    </td>
                                    <td>{{ $album->banners->count() }}</td>
                                    <td><span class="text-nowrap">{{ Setting::date_for_listing($album->updated_at) }}</span></td>
                                    <td>
                                        @if($album->trashed())
                                            @if (auth()->user()->has_access_to_route('albums.restore'))
                                                <nav class="nav table-options justify-content-end flex-nowrap">
                                                    <form id="form{{$album->id}}" method="post" action="{{ route('albums.restore', $album->id) }}">
                                                        @csrf
                                                        @method('POST')
                                                        <a class="nav-link" href="#" title="Restore this banner" onclick="document.getElementById('form{{$album->id}}').submit()"><i data-feather="rotate-ccw"></i></a>
                                                    </form>
                                                </nav>
                                            @endif
                                        @else
                                            <nav class="nav table-options justify-content-end flex-nowrap">
                                                @if(auth()->user()->has_access_to_route('albums.edit'))
                                                    <a class="nav-link" title="Edit banner" href="{{ route('albums.edit', $album->id) }}"><i data-feather="edit"></i></a>
                                                @endif

                                                @if (auth()->user()->has_access_to_route('albums.quick_update') || auth()->user()->has_access_to_route('albums.destroy'))
                                                    <a class="nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i data-feather="settings"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @if(auth()->user()->has_access_to_route('albums.quick_update'))
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#promptQuickEdit" href="#" data-id="{{ $album->id }}" data-name="{{ $album->name }}" data-transition-in="{{ $album->transition_in }}" data-transition-out="{{ $album->transition_out }}" data-transition="{{ $album->transition }}">Quick Edit</a>
                                                        @endif
                                                        @if(auth()->user()->has_access_to_route('albums.destroy'))
                                                            <button type="button" class="dropdown-item" data-target="#prompt-delete" data-toggle="modal" data-animation="effect-scale" data-id="{{ $album->id }}" data-name="{{ $album->name }}">Delete</button>
                                                            <form id="albumForm{{ $album->id }}" method="POST" action="{{ route('albums.destroy', $album->id) }}" class="d-none">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endif
                                                    </div>
                                                @endif
                                            </nav>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center;"> <p class="text-danger">No albums found.</p></td>
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
                    @if ($albums->firstItem() == null)
                        <p class="tx-gray-400 tx-12 d-inline">{{__('common.showing_zero_items')}}</p>
                    @else
                        <p class="tx-gray-400 tx-12 d-inline">Showing {{ $albums->firstItem() }} to {{ $albums->lastItem() }} of {{ $albums->total() }} items</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right float-md-right mg-t-5">
                    <div>
                        {{ $albums->appends((array) $filter)->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
    @if(auth()->user()->has_access_to_route('albums.quick_update'))
        <div class="modal effect-scale" id="promptQuickEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Quick Edit Banner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="d-block">Album Name *</label>
                                <input type="text" class="form-control" name="name" id="editName" required>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Transition In *</label>
                                <select name="transition_in" id="editTransitionIn" class="selectpicker mg-b-5" data-style="btn btn-outline-light btn-sm btn-block tx-left" title="Select transition" data-width="100%" required>
                                    @foreach ($animations as $animation)
                                        @if ($animation->is_entrance_field_type())
                                            <option value="{{ $animation->id }}">{{ $animation->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Transition Out *</label>
                                <select name="transition_out" id="editTransitionOut" class="selectpicker mg-b-5" data-style="btn btn-outline-light btn-sm btn-block tx-left" title="Select transition" data-width="100%" required>
                                    @foreach ($animations as $animation)
                                        @if ($animation->is_exit_field_type())
                                            <option value="{{ $animation->id }}">{{ $animation->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Transition Duration (seconds) *</label>
                                <input name="transition" id="editTransition" type="text" class="js-range-slider" name="my_range" />
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-sm btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade" id="preview-banner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content tx-14">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel3">Preview</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="owl-carousel owl-theme" id="previewCarousel">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary tx-13" data-dismiss="modal">Close</button>
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
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('lib/owl.carousel/owl.carousel.js') }}"></script>
    <script>
        let listingUrl = "{{ route('albums.index') }}";
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
        $("#editTransition").ionRangeSlider({
            grid: true,
            min: 2,
            max: 10
        });

        let slider = $("#editTransition").data("ionRangeSlider");

        $('#promptQuickEdit').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            let album = e.relatedTarget;
            let albumId = $(album).data('id');
            let albumName = $(album).data('name');
            let albumTransitionIn = $(album).data('transition-in');
            let albumTransitionOut = $(album).data('transition-out');
            let albumTransition = $(album).data('transition');
            let formAction = "{{ route('albums.quick_update', 0) }}".split('/');
            formAction.pop();
            let editFormAction = formAction.join('/') + "/" + albumId;
            $('#editForm').attr('action', editFormAction);

            $('#editName').val(albumName);
            $('#editTransitionIn').val(albumTransitionIn).change();
            $('#editTransitionOut').val(albumTransitionOut).change();
            // $('#editTransition').val(albumTransition);
            slider.update({
                from: albumTransition
            });
        });

        let ids;
        $('#deleteAlbums').on('click', function() {
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
            $('#albumIds').val(ids);
            $('#albumsForm').submit();
        });

        let albumId;
        $('#prompt-delete').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            let album = e.relatedTarget;
            albumId = $(album).data('id');
            let albumName = $(album).data('name');

            $('#albumName').html(albumName);
        });

        $('#btnDelete').on('click', function() {
            $('#albumForm'+albumId).submit();
        });

        $('#preview-banner').on('show.bs.modal', function (e) {
            let album = e.relatedTarget;
            let albumId = $(album).data('id');
            $('#previewCarousel').html('');
            $.ajax({
                type: "POST",
                data: { _token: "{{ csrf_token() }}"},
                url: "{{ route('albums.banners', '') }}/" + albumId,
                success: function(returnData) {
                    let pathHTML = '';
                    $.each(returnData['banner_paths'], function(index, path) {
                        pathHTML += `<div class="item">
                            <img src="`+path+`">
                        </div>`;
                    });
                    $('#previewCarousel').trigger('destroy.owl.carousel');

                    $('#previewCarousel').html(pathHTML);

                    $('#previewCarousel').owlCarousel({
                        animateOut: returnData['transition_out'],
                        animateIn: returnData['transition_in'],
                        loop: true,
                        dots: false,
                        margin: 0,
                        autoplay: true,
                        autoplayTimeout: (returnData['transition']*1000),
                        autoplayHoverPause: false,
                        nav: false,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 1
                            },
                            1000: {
                                items: 1
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
