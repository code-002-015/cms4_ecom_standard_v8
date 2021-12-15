@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/jssocials/jssocials.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/sysu/plugins/jssocials/jssocials-theme-flat.min.css') }}" />
@endsection

@section('content')
<section id="section-content">
    <canvas id="canvas"></canvas>
    <div class="content-wrap">

        <div class="container clearfix position-static">
            <div class="row row-article">
                <div class="col-lg-3">
                    <div class="article-opt">
                        <p>
                            <a href="{{ route('news.front.index') }}"><span><i class="fas fa-long-arrow-alt-left"></i></span>Back to
                                news listing</a>
                        </p>
                    </div>
                    <div class="article-opt">
                        <div class="search nopadding">
                            <form id="frm_search">
                                <div class="searchbar">
                                    <input type="text" name="searchtxt" id="searchtxt" class="form-control form-input form-search" placeholder="Search news" aria-label="Search news" aria-describedby="button-addon1" />
                                    <button class="form-submit-search" type="button" name="submit">
                                        <i class="icon-line-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="article-widget">
                        <h4 class="article-widget-title">
                            Latest News
                        </h4>
                        @foreach($latestArticles as $latest)
                            <div class="article-widget-news">
                                <p class="news-date">{{ date('F d, Y',strtotime($latest->date)) }}</p>
                                <p class="news-title">
                                    <a href="{{ route('news.front.show',$latest->slug) }}">{{ $latest->name }}</a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-9 mb-xs-4">
                    @if(isset($breadcrumb))
                        <ol class="breadcrumb nobottommargin d-flex flex-nowrap">
                            @foreach($breadcrumb as $link => $url)
                                @if($loop->last)
                                    <li class="breadcrumb-item active ellipsis" aria-current="page">{{$link}}</li>
                                @else
                                    <li class="breadcrumb-item text-nowrap"><a href="{{$url}}">{{$link}}</a></li>
                                @endif
                            @endforeach
                        </ol>
                    @endif

                    <h3 class="bottommargin-sm">{{ $news->name }}</h3>
                    <div class="article-meta-share notopmargin">
                        <div class="article-meta">
                            <p>
                                Posted on {{ Setting::date_for_news_list($news->date) }} by
                                <span class="article-meta-author">{{$news->user->name}}</span>
                            </p>
                        </div>
                        <div class="article-share">
                            <div class="article-share-text">Share:</div>
                            <div id="article-social"></div>
                        </div>
                    </div>
                    <div class="article-content">
                        @if($news->thumbnail_url)
                            <img class="mb-2" src="{{ $news->thumbnail_url }}" alt="..." data-aos="fade-in" data-aos-duration="1500" data-aos-once="true" data-aos-easing="ease-in-back" />
                            <hr>
                        @endif
                        
                        {!! $news->contents !!}
                    </div>
                </div>
            </div>
        
        </div>

    </div>
</section>
@endsection

@section('pagejs')
@endsection

@section('customjs')
<script>
    var navikMenuListDropdown = $(".side-menu ul li:has(ul)");

    navikMenuListDropdown.each(function() {
        $(this).append('<span class="dropdown-append"></span>');
    });

    $(".side-menu .active").each(function() {
        $(this).parents("ul").css("display", "block");
        $(this).parents("ul").prev("a").css("color", "#00bfca");
        $(this).parents("ul").next(".dropdown-append").addClass("dropdown-open");
    });

    $(".dropdown-append").on("click", function() {
        $(this).prev("ul").slideToggle(300);
        $(this).toggleClass("dropdown-open");
    });
</script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        $('#frm_search').on('submit', function(e) {
            e.preventDefault();
            window.location.href = "{{route('news.front.index')}}?type=searchbox&criteria="+$('#searchtxt').val();
        });

        // $('#shareEmailForm').submit(function(evt) {
        //     evt.preventDefault();
        //     let data = $('#shareEmailForm').serialize();

        //     $('#spanSendArticle').html('Sending...');
        //     $('#btnSendArticle').prop('disabled',true);
            
        //     $.ajax({
        //         data: data,
        //         type: "POST",
        //         url: "{{ route('news.front.share', $news->slug) }}",
        //         success: function(returnData) {
        //             $('#email-success').modal('show');
        //             $('#email-article').modal('hide');
        //             $('#email-article input').val('');
        //         },
        //         error: function(){
        //             $('#email-failed').modal('show');
        //             $('#email-article').modal('hide');
        //             $('#email-article input').val('');
        //         }
        //     });
        //     return false;
        // });
    });
</script>
@endsection
