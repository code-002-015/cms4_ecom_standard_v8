@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')
<section id="section-content">
    <canvas id="canvas"></canvas>
    <div class="content-wrap">

        <div class="container clearfix position-static">
        
            <div class="row">
                <span onclick="closeNav()" class="dark-curtain"></span>
                <div class="col-lg-12 col-md-5 col-sm-12">
                    <span onclick="openNav()" class="button noleftmargin d-lg-none mb-4"><span class="icon-chevron-left mr-2"></span> Filter</span>
                </div>
                <div class="col-lg-3">
                    <div class="tablet-view py-4 px-4" data-animate="fadeInLeft">
                        <div class="overlay rounded-20px" style="z-index:-2;"></div>
                        <a href="javascript:void(0)" class="closebtn d-block d-lg-none" onclick="closeNav()">&times;</a>
                        <h3>News</h3>
                        <div class="side-menu">
                            {!! $dates !!}
                        </div>
                        
                        <h3>Categories</h3>
                        <div class="side-menu">
                            {!! $categories !!}
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-9">
                    <div class="search">
                        <form id="frm_search">
                            <div class="searchbar">
                                <input type="text" name="searchtxt" id="searchtxt" class="form-control form-input form-search" placeholder="Search news" aria-label="Search news" aria-describedby="button-addon1" />
                                <button class="form-submit-search" type="submit" name="submit" id="button-addon1">
                                    <i class="icon-line-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    @if(isset($_GET['type']))
                        @if($_GET['type'] == 'searchbox')
                            @if($totalSearchedArticle > 0)
                            <div class="style-msg successmsg">
                                <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Woo hoo!</strong> We found <strong>(<span>{{ $totalSearchedArticle }}</span>)</strong> matching results.</div>
                            </div>
                            @else
                            <div class="style-msg2 errormsg">
                                <div class="msgtitle p-0 border-0">
                                    <div class="sb-msg">
                                        <i class="icon-thumbs-up"></i><strong>Uh oh</strong>! <span><strong>{{ app('request')->input('criteria') }}</strong></span> you say? Sorry, no results!
                                    </div>
                                </div>
                                <div class="sb-msg">
                                    <ul>
                                        <li>Check the spelling of your keywords.</li>
                                        <li>Try using fewer, different or more general keywords.</li>
                                    </ul>
                                </div>
                            </div>
                            @endif
                        @endif
                    @endif

                    <br>

                    @foreach($articles as $article)
                        <div class="news-post">
                            @if($article->thumbnail_url)
                                <div class="news-post-img" style="background-image:url('{{ $article->thumbnail_url }}')"></div>
                            @else
                                <div class="news-post-img" style="background-image:url('{{ asset('storage/news_image/news_thumbnail/No_Image_Available.jpg')}}')"></div>
                            @endif
                            <div class="news-post-info">
                                <div class="news-post-content w-100">
                                    <h3>
                                        <a href="{{ route('news.front.show',$article->slug) }}">{{ $article->name }}</a>
                                    </h3>
                                    <p class="news-post-info-excerpt">
                                        {{ $article->teaser }}
                                    </p>
                                </div>
                                <div class="news-post-share">
                                    <div class="share_link"></div>
                                    <p class="news-post-info-meta">Posted on {{ Setting::date_for_news_list($article->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $articles->links('theme.'.env('FRONTEND_TEMPLATE').'.layout.pagination') }}
        
                </div>
            </div>
        
        </div>

    </div>
</section>
@endsection

@section('pagejs')
    <script>
        $(function() {
            $('#frm_search').on('submit', function(e) {
                e.preventDefault();
                window.location.href = "{{route('news.front.index')}}?type=searchbox&criteria="+$('#searchtxt').val();
            });
        });
    </script>
@endsection
