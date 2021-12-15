
<div class="row">
    <div class="col-lg-12" style="padding:0;">
        <div id="banner" class="slick-slider">
            @foreach ($page->album->banners as $banner)
                <div class="hero-slide">
                    <img src="{{ $banner->image_path }}">
                </div>
            @endforeach
        </div>
    </div>
</div>
