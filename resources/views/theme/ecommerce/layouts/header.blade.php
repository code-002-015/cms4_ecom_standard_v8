<header id="header" class="full-header header-size-md">
	<div id="header-wrap">
		<div class="container">
			<div class="header-row justify-content-lg-between">

				<!-- Logo
				============================================= -->
				<div id="logo" class="me-lg-4">
					<a href="demo-shop.html" class="standard-logo"><img src="{{ asset('theme/'.env('THEME_FOLDER').'/images/logo.png') }}" alt="Canvas Logo"></a>
					<a href="demo-shop.html" class="retina-logo"><img src="{{ asset('theme/'.env('THEME_FOLDER').'/images/logo@2x.png') }}" alt="Canvas Logo"></a>
				</div><!-- #logo end -->

				<div class="header-misc">

					<!-- Top Search
					============================================= -->
					<div id="top-account">
						@if(auth()->check())
							<a href="{{ route('customer-front.login') }}"><i class="icon-line2-user me-1 position-relative" style="top: 1px;"></i><span class="d-none d-sm-inline-block font-primary fw-medium">{{ auth()->user()->fullname }}</span></a>
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
						<li class="menu-item current"><a class="menu-link" href="#"><div>Home</div></a></li>
						<li class="menu-item mega-menu"><a class="menu-link" href="#"><div>Men</div></a>
							<div class="mega-menu-content mega-menu-style-2">
								<div class="container">
									<div class="row">
										<ul class="sub-menu-container mega-menu-column border-start-0 col-lg-3">
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Footwear</div></a>
												<ul class="sub-menu-container">
													<li class="menu-item"><a class="menu-link" href="#"><div>Casual Shoes</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Formal Shoes</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sports shoes</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Flip Flops</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Slippers</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sandals</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Show all <i class="icon-angle-right"></i></div></a></li>
												</ul>
											</li>
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Clothing</div></a>
												<ul class="sub-menu-container">
													<li class="menu-item"><a class="menu-link" href="#"><div>Casual Shirts</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>T-Shirts</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Collared Tees</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Pants / Trousers</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Show all <i class="icon-angle-right"></i></div></a></li>
												</ul>
											</li>
										</ul>
										<ul class="sub-menu-container mega-menu-column border-start-0 col-lg-3">
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Sportswear</div></a>
												<ul class="sub-menu-container">
													<li class="menu-item"><a class="menu-link" href="#"><div>Sports Casual Shirts</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sports T-Shirts</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sports Collared Tees</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sports Shoes</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Jackets</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Swimwears</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Show all <i class="icon-angle-right"></i></div></a></li>
												</ul>
											</li>
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Innerwears</div></a>
												<ul class="sub-menu-container">
													<li class="menu-item"><a class="menu-link" href="#"><div>Boxers</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Vests</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sleepwears</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Show all <i class="icon-angle-right"></i></div></a></li>
												</ul>
											</li>
										</ul>
										<ul class="sub-menu-container mega-menu-column border-start-0 col-lg-3">
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Innerwears</div></a>
												<ul class="sub-menu-container">
													<li class="menu-item"><a class="menu-link" href="#"><div>Boxers</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Vests</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sleepwears</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Show all <i class="icon-angle-right"></i></div></a></li>
												</ul>
											</li>
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Sunglasses</div></a>
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Watches</div></a>
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Bags</div></a>
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Headphones</div></a>
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Accessories</div></a>
										</ul>
										<ul class="sub-menu-container mega-menu-column col-lg-3 border-start-0">
											<li class="card p-0 bg-transparent border-0">
												<img class="card-img-top" src="{{ asset('theme/ecommerce/images/menu-image.jpg') }}" alt="image cap">
												<a href="#" class="btn btn-link text-start fw-medium ps-0 bg-transparent"><u>Editor's Pick</u></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
						<li class="menu-item mega-menu mega-menu-small"><a class="menu-link" href="#"><div>Women</div></a>
							<div class="mega-menu-content mega-menu-style-2">
								<div class="container">
									<div class="row">
										<ul class="sub-menu-container mega-menu-column col-lg-6">
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Footwear</div></a>
												<ul class="sub-menu-container">
													<li class="menu-item"><a class="menu-link" href="#"><div>Casual Shoes</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Formal Shoes</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sports shoes</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Flip Flops</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Slippers</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Sandals</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Party Shoes</div></a></li>
												</ul>
											</li>
										</ul>
										<ul class="sub-menu-container mega-menu-column col-lg-6">
											<li class="menu-item mega-menu-title"><a class="menu-link" href="#"><div>Clothing</div></a>
												<ul class="sub-menu-container">
													<li class="menu-item"><a class="menu-link" href="#"><div>Casual Shirts</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>T-Shirts</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Collared Tees</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Pants / Trousers</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Ethnic Wear</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Jeans</div></a></li>
													<li class="menu-item"><a class="menu-link" href="#"><div>Swimwear</div></a></li>
												</ul>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
						<li class="menu-item"><a class="menu-link" href="#"><div>Accessories</div></a></li>
						<li class="menu-item"><a class="menu-link" href="#"><div>Blog</div></a></li>
						<li class="menu-item"><a class="menu-link" href="#"><div>Sales</div></a></li>
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