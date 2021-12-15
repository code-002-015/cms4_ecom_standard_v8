@php
    $photoUrl = (isset($page->album->banners) && count($page->album->banners) == 1) ? $page->album->banners[0]->image_path : $page->image_url;
@endphp

<div class="row">
    <div class="col-lg-12" style="padding:0;">
        <div id="banner" class="slick-slider">
            <div class="hero-slide">
                <img src="{{ $photoUrl }}">
            </div>
        </div>
    </div>
</div>