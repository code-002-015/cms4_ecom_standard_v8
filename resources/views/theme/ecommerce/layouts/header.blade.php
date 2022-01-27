<header id="header" class="full-header header-size-md">
	<div id="header-wrap">
		<div class="container">
			<div class="header-row justify-content-lg-between">

				<!-- Logo
				============================================= -->
				<div id="logo" class="me-lg-4">
					<a href="/" class="standard-logo"> <img src="{{ asset('storage').'/logos/'.Setting::getFaviconLogo()->company_logo }}" alt="{{''.env('COMPANY_NAME')}}"></a>
					<a href="demo-shop.html" class="retina-logo"><img src="{{ asset('theme/'.env('THEME_FOLDER').'/images/logo@2x.png') }}" alt="Canvas Logo"></a>
				</div><!-- #logo end -->
				
				<div class="header-misc">

					<!-- Top Search
					============================================= -->
					<div id="top-account">
						@if(auth()->check())
							<a href="{{ route('my-account.manage-account')}}"><i class="icon-line2-user me-1 position-relative" style="top: 1px;"></i><span class="d-none d-sm-inline-block font-primary fw-medium">{{ auth()->user()->fullname }}</span></a>
						@else
							<a href="{{ route('customer-front.login') }}"><i class="icon-line2-user me-1 position-relative" style="top: 1px;"></i><span class="d-none d-sm-inline-block font-primary fw-medium">Login</span></a>
						@endif
					</div><!-- #top-search end -->

					<!-- Top Cart
					============================================= -->
					<div id="top-cart" class="header-misc-icon d-none d-sm-block">
						<a href="{{ route('cart.front.show') }}"><i class="icon-line-bag"></i><span class="top-cart-number">{!! Setting::EcommerceCartTotalItems() !!}</span></a>
					</div>

					<!-- Top Search
					============================================= -->
					<div id="top-search" class="header-misc-icon">
						<a href="#" id="top-search-trigger"><i class="icon-line-search"></i><i class="icon-line-cross"></i></a>
					</div><!-- #top-search end -->

				</div>

				<div id="primary-menu-trigger">
					<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
				</div>

				<!-- Primary Navigation
				============================================= -->
				<nav class="primary-menu with-arrows me-lg-auto">

					<ul class="menu-container">
						<li class="menu-item current"><a class="menu-link" href="{{ route('shop') }}"><div>Home</div></a></li>
						<li class="menu-item"><a class="menu-link" href="{{ route('product.front.list') }}"><div>Shop</div></a></li>
					</ul>

				</nav><!-- #primary-menu end -->

				<form class="top-search-form" action="search.html" method="get">
					<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter.." autocomplete="off">
				</form>

			</div>
		</div>
	</div>
	<div class="header-wrap-clone"></div>
</header><!-- #header end -->
