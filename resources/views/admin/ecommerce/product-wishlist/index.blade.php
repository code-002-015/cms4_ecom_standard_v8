@extends('admin.layouts.app')

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
                        <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Manage Wishlist</h4>
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
                                                <label class="custom-control-label" for="orderBy1">Added At</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="orderBy2" name="orderBy" class="custom-control-input" value="product_name" @if ($filter->orderBy == 'product_name') checked @endif>
                                                <label class="custom-control-label" for="orderBy2">Name</label>
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
                                        <div class="form-group mg-b-40">
                                            <label class="d-block">{{__('common.item_displayed')}}</label>
                                            <input id="displaySize" type="text" class="js-range-slider" name="perPage" value="{{ $filter->perPage }}"/>
                                        </div>
                                        <button id="filter" type="button" class="btn btn-sm btn-primary">{{__('common.apply_filters')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="ml-auto bd-highlight mg-t-10 mg-b-10">
                            <form class="form-inline" id="searchForm">
                                <div class="search-form">
                                    <input name="search" type="search" id="search" class="form-control"  placeholder="Search by Product Name" value="{{ $filter->search }}">
                                    <button class="btn filter" type="button" id="btnSearch"><i data-feather="search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Filters -->


            <!-- Start Pages -->
            <div class="col-md-12">
                <div class="table-list mg-b-10">
                    <div class="table-responsive-lg">
                        <table class="table mg-b-0 table-light table-hover" style="word-break: break-all;">
                            <thead>
                            <tr>
                                <th width="65%">&nbsp;&nbsp;&nbsp;&nbsp;Product Name</th>
                                <th class="text-center" width="20%">Total Count</th>
                                <th width="15%">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($products as $product)
                                <tr id="row{{$product->id}}">
                                    <td>
                                        <p></p>
                                        &nbsp;&nbsp;&nbsp;&nbsp;{{$product->product_name }}
                                        <div style="visibility: hidden;" class="custom-control custom-checkbox">
                                            <input  type="checkbox" class="custom-control-input cb" id="cb{{ $product->id }}">
                                            <label class="custom-control-label" for="cb{{ $product->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $product->total_count }}</td>
                                    <td>
                                        <nav class="nav table-options">
                                            <a target="_blank" href="{{ route('product.front.show', $product->product_details->slug) }}" title="View Product Profile" class="nav-link"><i class="fa fa-eye"></i></a>
                                            <a href="javascript:;" class="nav-link" data-toggle="collapse" data-target="#product_{{$product->product_id}}" class="accordion-toggle" title="View Customers"><i class="fa fa-list"></i></a>
                                        </nav>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="hiddenRow">
                                        <div class="accordian-body collapse" id="product_{{$product->product_id}}">
                                            <div class="autoship-table">
                                                <div class="table-responsive mg-b-30">
                                                    <table class="table table-sm table-hover mg-0">
                                                        <thead class="mg-b-20">
                                                            <tr>
                                                                <th scope="col" width="50%">Customer Name</th>
                                                                <th scope="col">Email</th>
                                                                <th>Date Added</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($product->wishlist_customer as $customer)
                                                                <tr>
                                                                    <td>{{ $customer->customer_details->fullname }}</td>
                                                                    <td>{{ $customer->customer_details->email }}</td>
                                                                    <td>{{ Setting::date_for_listing($customer->updated_at) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="3" style="text-align: center;"> <p class="text-danger">No products found.</p></th>
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
@endsection

@section('pagejs')
    <script src="{{ asset('lib/bselect/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('lib/bselect/dist/js/i18n/defaults-en_US.js') }}"></script>
    <script src="{{ asset('lib/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        let listingUrl = "{{ route('product-favorite.list') }}";
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
    </script>
@endsection
