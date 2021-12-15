<!-- 
<div class="row">
	<div class="col-lg-12" style="padding:0;">
		<div class="sub-banner-caption">
			<div class="container" style="position: relative;">
				<h2>{{ $page->name }}</h2>
                <div class="sub-banner-flex">
                    <ol class="breadcrumb nobottommargin">
                        @foreach($breadcrumb as $link => $url)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{$link}}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{$url}}">{{$link}}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </div>
			</div>
		</div>
		<div id="banner" class="slick-slider">
			<div class="hero-slide">
				<div class="sub-banner-overlay-1"></div>
				<img src="{{ asset('theme/'.env('THEME_FOLDER').'/images/plain-subbanner.jpg') }}">
			</div>
		</div>
	</div>
</div> -->