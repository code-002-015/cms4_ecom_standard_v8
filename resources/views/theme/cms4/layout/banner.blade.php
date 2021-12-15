<section id="slider" class="slick-wrapper clearfix">
    <div class="banner-wrapper">
        <div class="container-fluid">

            @if(isset($page) && $page->album && count($page->album->banners) > 0 && $page->album->is_main_banner())
                @include('theme.'.env('FRONTEND_TEMPLATE').'.layout.home-slider')
            @elseif(isset($page) && $page->album && count($page->album->banners) > 1 && !$page->album->is_main_banner())
                @include('theme.'.env('FRONTEND_TEMPLATE').'.layout.page-slider')
            @elseif(isset($page) && (isset($page->album->banners) && (count($page->album->banners) == 1 && !$page->album->is_main_banner()) || !empty($page->image_url)))
                @include('theme.'.env('FRONTEND_TEMPLATE').'.layout.page-banner')
            @else
                @include('theme.'.env('FRONTEND_TEMPLATE').'.layout.no-banner')
            @endif

        </div>
    </div>
</section>

@if(isset($page) && $page->album && count($page->album->banners) > 0 && $page->album->is_main_banner())
@elseif(isset($page) && $page->album && count($page->album->banners) > 1 && !$page->album->is_main_banner())
    @if(isset($breadcrumb) && !isset($news))
        <section id="page-title">

            <div class="container clearfix">
                <div class="d-md-flex d-lg-flex justify-content-between align-items-center">
                    <h1 class="text-primary ls0 text-capitalize font-weight-bold ellipsis mr-0 mr-lg-5">{{ $page->name }}</h1>
                    <ol class="breadcrumb mb-0 d-flex flex-nowrap">
                        @foreach($breadcrumb as $link => $url)
                            @if($loop->last)
                                <li class="breadcrumb-item active text-primary ellipsis" aria-current="page">{{$link}}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{$url}}">{{$link}}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>

        </section>
    @endif
@elseif(isset($page) && (isset($page->album->banners) && (count($page->album->banners) == 1 && !$page->album->is_main_banner()) || !empty($page->image_url)))
    @if(isset($breadcrumb) && !isset($news))
        <section id="page-title">

            <div class="container clearfix">
                <div class="d-md-flex d-lg-flex justify-content-between align-items-center">
                    <h1 class="text-primary ls0 text-capitalize font-weight-bold ellipsis mr-0 mr-lg-5">{{ $page->name }}</h1>
                    <ol class="breadcrumb mb-0 d-flex flex-nowrap">
                        @foreach($breadcrumb as $link => $url)
                            @if($loop->last)
                                <li class="breadcrumb-item active text-primary ellipsis" aria-current="page">{{$link}}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{$url}}">{{$link}}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>

        </section>
    @endif
@else
    @if(isset($breadcrumb) && !isset($news))
        <section id="page-title">

            <div class="container clearfix">
                <div class="d-md-flex d-lg-flex justify-content-between align-items-center">
                    <h1 class="text-primary ls0 text-capitalize font-weight-bold ellipsis mr-0 mr-lg-5">{{ $page->name }}</h1>
                    <ol class="breadcrumb mb-0 d-flex flex-nowrap">
                        @foreach($breadcrumb as $link => $url)
                            @if($loop->last)
                                <li class="breadcrumb-item active text-primary ellipsis" aria-current="page">{{$link}}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{$url}}">{{$link}}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>

        </section>
    @endif
@endif
