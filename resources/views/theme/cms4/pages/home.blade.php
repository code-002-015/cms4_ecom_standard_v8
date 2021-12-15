@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@php
    $contents = $page->contents;

    $featuredArticles = Article::where('is_featured', 1)->where('status', 'Published')->get();

    if ($featuredArticles->count()) {

        $featuredArticlesHTML = '<section class="position-relative" id="section-news">
                                    <div class="content-wrap" style="z-index:2">
                                        <div class="container">
                                            <h6 class="mb-2 ls5 text-uppercase text-secondary text-center">News and Updates</h6>
                                            <h2 class="mb-4 text-center">Latest News</h2>

                                            <div class="row mb-5">';

        $prefooter = asset('theme/'.env('FRONTEND_TEMPLATE').'/images/pre-footer.jpg');

        foreach ($featuredArticles as $index => $article) {
            $imageUrl = (empty($article->thumbnail_url)) ? asset('theme/'.env('FRONTEND_TEMPLATE').'/images/misc/no-image.jpg') : $article->thumbnail_url;

            
            $featuredArticlesHTML .= '<div class="col-lg-4 mb-5 mb-lg-0">
                                        <div class="card shadow rounded-20px border-0">
                                            <img class="card-img-top rounded-top-20px" src="'. $imageUrl .'" alt="Card image cap">
                                            <div class="card-body p-4">
                                                <p class="card-text mb-2"><small class="text-muted">Posted on '. $article->date_posted() .'</small></p>
                                                <h4 class="card-title excerpt-1">'. $article->name .'</h4>
                                                <p class="card-text excerpt-2">'. $article->teaser .'</p>
                                                <a href="'. $article->get_url() .'" class="button button-custom button-large nomargin clearfix">Read More <i class="icon-circle-arrow-right ml-2 mr-0"></i></a>
                                            </div>
                                        </div>
                                    </div>';

            if (Article::has_featured_limit() && $index >= env('FEATURED_NEWS_LIMIT')) {
                break;
            }
        }

        $featuredArticlesHTML .= '</div>
                    </div>
                </div>          
            </section>';

        $contents = str_replace('{Featured Articles}', $featuredArticlesHTML, $contents);

    } else {
        $contents = str_replace('{Featured Articles}', '', $contents);
    }
@endphp

@section('content')
    {!! $contents !!}
@endsection

@section('pagejs')
@endsection

@section('customjs')
@endsection
