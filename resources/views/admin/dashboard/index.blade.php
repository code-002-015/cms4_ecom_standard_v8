@extends('admin.layouts.app')

@section('pagecss')
    <style>
        .dashboard-summary {
            height: 31rem;
        }
    </style>

@endsection
@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Welcome, {{ Auth::user()->firstname }}!</h4>
            </div>
            <div class="d-none d-md-block">
                <a href="{{ env('APP_URL') }}" target="_blank" class="btn btn-sm pd-x-15 btn-white btn-uppercase">
                    <i data-feather="arrow-up-right" class="wd-10 mg-r-5"></i> View Website
                </a>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="row row-sm">
                    @if (auth()->user()->has_access_to_pages_module())
                        <div class="col-lg-4 col-md-6">
                            <div class="card dashboard-widget">
                                <a href="{{route('pages.index')}}">
                                    <div class="card-body">
                                        <h4 class="tx-bold mg-b-5 lh-1"><i data-feather="layers" class="mg-r-6"></i> {{ Page::totalPages() }}</h4>
                                        <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Total Pages</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    @if (auth()->user()->has_access_to_albums_module())
                        <div class="col-lg-4 col-md-6">
                            <div class="card dashboard-widget">
                                <a href="{{ route('albums.index') }}">
                                    <div class="card-body">
                                        <h4 class="tx-bold mg-b-5 lh-1"><i data-feather="image" class="mg-r-6"></i> {{ Album::totalAlbums() }}</h4>
                                        <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Total Banner
                                    Albums</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    @if (auth()->user()->has_access_to_news_module())
                        <div class="col-lg-4 col-md-6">
                            <div class="card dashboard-widget">
                                <a href="{{ route('news.index') }}">
                                    <div class="card-body">
                                        <h4 class="tx-bold mg-b-5 lh-1"><i data-feather="edit" class="mg-r-6"></i> {{ Article::totalArticles() }}</h4>
                                        <span class="tx-uppercase tx-11 tx-spacing-1 tx-color-02 tx-semibold">Total
                                    News</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-12">
                <div class="row row-sm">
                    @if (auth()->user()->has_access_to_pages_module() || auth()->user()->has_access_to_albums_module() || auth()->user()->has_access_to_user_module() || auth()->user()->has_access_to_news_module())
                        <div class="col-lg-3 col-md-4">
                            @if (auth()->user()->has_access_to_pages_module() || auth()->user()->has_access_to_albums_module() || auth()->user()->has_access_to_user_module() || auth()->user()->has_access_to_news_module())
                                <div class="card dashboard-summary mg-t-20">
                                    <div class="card-header">
                                        Website Summary
                                    </div>
                                    <div class="card-body" style="height:800px !important;">
                                        @if (auth()->user()->has_access_to_pages_module())
                                            <h6><strong>Pages</strong></h6>
                                            <p><a href="{{route('pages.index.advance-search')}}?status=published"><span class="badge badge-dark">{{ Page::totalPublicPages() }}</span> Published Pages</a></p>
                                            <p><a href="{{route('pages.index.advance-search')}}?status=private"><span class="badge badge-dark">{{ Page::totalPrivatePages() }}</span> Private Pages</a></p>
                                            <p><a href="{{route('pages.index.advance-search')}}?showDeleted=on"><span class="badge badge-dark">{{ Page::totalDeletePages() }}</span> Deleted Pages</a></p>
                                            <hr>
                                        @endif
                                        @if (auth()->user()->has_access_to_albums_module())
                                            <h6><strong>Sub Banners</strong></h6>
                                            <p><a href="{{ route('albums.index') }}"><span class="badge badge-dark">{{ Album::totalNotDeletedAlbums() }}</span> Albums</a></p>
                                            <p><a href="{{ route('albums.index') }}?showDeleted=on"><span class="badge badge-dark">{{ Album::totalDeletePages() }}</span> Deleted Albums</a></p>
                                            <hr>
                                        @endif
                                        @if (auth()->user()->has_access_to_user_module())
                                            <h6><strong>Users</strong></h6>
                                            <p><a href="{{ route('users.index') }}"><span class="badge badge-dark">{{ User::activeTotalUser() }}</span> Active Users</a></p>
                                            <p><a href="{{ route('users.index') }}?showDeleted=on"><span class="badge badge-dark">{{ User::inactiveTotalUser() }}</span> Inactive Users</a></p>
                                            <hr>
                                        @endif
                                        @if (auth()->user()->has_access_to_news_module())
                                            <h6><strong>News</strong></h6>
                                            <p><a href="{{ route('news.index.advance-search') }}?status=published"><span class="badge badge-dark">{{ Article::totalPublishedArticles() }}</span> Published News</a></p>
                                            <p><a href="{{ route('news.index.advance-search') }}?status=private"><span class="badge badge-dark">{{ Article::totalDraftArticles() }}</span> Private News</a></p>
                                            <p><a href="{{ route('news.index.advance-search') }}?showDeleted=on"><span class="badge badge-dark">{{ Article::totalDeletedArticles() }}</span> Deleted News</a></p>

                                        @endif
                                    </div>
                                </div>
                                @if (auth()->user()->has_access_to_pages_module() || auth()->user()->has_access_to_news_module() || auth()->user()->has_access_to_albums_module())
                                    <div class="dashboard-quick mg-t-20">
                                        @if (auth()->user()->has_access_to_pages_module())
                                            <a href="{{ route('pages.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase btn-block tx-left text-white">
                                                <i data-feather="layers" class="wd-10 mg-r-5"></i> Create a Page
                                            </a>
                                        @endif
                                        @if (auth()->user()->has_access_to_news_module())
                                            <a href="{{ route('news.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase btn-block tx-left text-white">
                                                <i data-feather="edit" class="wd-10 mg-r-5"></i> Create a News
                                            </a>
                                        @endif
                                        @if (auth()->user()->has_access_to_albums_module())
                                            <a href="{{ route('albums.create') }}" class="btn btn-sm pd-x-15 btn-primary btn-uppercase btn-block tx-left text-white">
                                                <i data-feather="image" class="wd-10 mg-r-5"></i> Create an Album
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                    <div class=" @if (auth()->user()->has_access_to_pages_module() || auth()->user()->has_access_to_albums_module() || auth()->user()->has_access_to_user_module() || auth()->user()->has_access_to_news_module()) col-lg-9 col-md-8 @else col-lg-12 @endif">
                        <div class="card position-relative dashboard-recent mg-t-20 h-xs-100 overflow-y-auto">
                            <div class="card-header position-sticky z-index-10 bg-white" style="top:0">
                                My Recent Activities
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    @forelse($logs as $log)
                                        <p class="list-group-item list-group-item-action d-flex flex-column flex-lg-row flex-lg-start mb-2 mb-lg-0">
                                            {{--<a href="{{route('settings.audit')}}?search={{$log->id}}" target="_blank">--}}
                                            <span class="badge badge-dark lh-7 align-self-start mr-2">{{ ucwords($log->admin->firstname) }} {{ ucwords($log->admin->lastname) }}</span>
                                            {{--</a> --}}
                                            <span?>{{ $log->dashboard_activity }} at <span class="text-nowrap">{{ Setting::date_for_listing($log->activity_date) }}</span></span>
                                        </p>
                                    @empty
                                        No activities found!
                                    @endforelse
                                </div>
                            </div>
                            <div class="card-footer position-sticky z-index-10 bg-white" style="bottom:0">
                                <div class="d-flex justify-content-end">
                                    <span class="tx-12"><a href="{{ route('users.show', Auth::user()->id) }}">Show all activities <i class="fa fa-arrow-right"></i></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejs')
    <script src="{{ asset('lib/nestable2/jquery.nestable.min.js') }}"></script>
@endsection

@section('customjs')
    <script></script>
@endsection