@php
    $is_video = 0;
    if($page->album->banner_type == 'video'){
        $is_video = 1;
    }
@endphp


<section id="slider" class="slider-element min-vh-md-100 py-4 include-header" style="background: #FFF url({{URL::asset("theme/".env('THEME_FOLDER')."/images/hero-bg.svg")}}) repeat top center; background-size: cover;">
    <div class="slider-inner">
        <div class="vertical-middle slider-element-fade">
            <div class="container text-center py-5">
                <div class="emphasis-title mb-2">
                    <h4 class="text-uppercase ls3 fw-bolder mb-0">I'm a Freelance</h4>
                    <h1>
                        <span id="oc-images" class="owl-carousel image-carousel carousel-widget" data-items="1" data-margin="0" data-autoplay="3000" data-loop="true" data-nav="false" data-pagi="false" data-animate-in="fadeInUp">
                            <div class="oc-item gradient-text gradient-red-yellow text-uppercase">Developer</div>
                            <div class="oc-item gradient-text gradient-red-yellow text-uppercase">Designer</div>
                        </span>
                    </h1>
                </div>

                <div class="mx-auto"  style="max-width: 600px">
                    <p class="lead fw-normal text-dark mb-5">Authoritatively expedite backward-compatible e-commerce with cross-media e-commerce. Credibly provide access to world-class action items through resource-leveling resources.</p>
                    <a href="demo-freelancer-works.html" class="button button-dark button-hero h-translatey-3 tf-ts button-reveal overflow-visible bg-dark text-end"><span>View our Works</span><i class="icon-line-arrow-right"></i></a>
                    <a href="#" data-scrollto="#footer" data-easing="easeInOutExpo" data-speed="1250" data-offset="70" class="button button-large button-light text-dark bg-transparent m-0"><i class="icon-line2-arrow-down fw-bold"></i> <u>Contact Me</u></a>
                </div>
            </div>
        </div>
    </div>
</section>

{{--<div class="row">
    <div class="col-lg-12" style="padding:0;">
        <div id="banner" class="slick-slider">
            @foreach ($page->album->banners as $banner)
                <div class="hero-slide">
                    @if($is_video > 0)
                        <video autoplay="" muted="" loop="" id="myVideo">
                            <source src="{{ $banner->image_path }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ $banner->image_path }}">
                    @endif

                    <div class="banner-caption">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <h6 class="mb-4 ls5 text-uppercase text-secondary text-lg-white">{{ $banner->title }}</h6>
                                    <h2 class="mb-4 mb-lg-0 text-lg-white">{{ $banner->description }}</h2>
                                </div>
                                <div class="col-lg-4">
                                    @if($banner->url && $banner->button_text)
                                        <a href="{{ $banner->url }}" class="button custom button-border button-light button-fill button-xlarge noleftmargin clearfix float-lg-end">{{ $banner->button_text }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>--}}


