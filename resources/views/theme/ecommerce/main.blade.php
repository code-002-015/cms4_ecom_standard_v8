<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Montserrat:300,400,500,600,700|Merriweather:300,400,300i,400i&display=swap" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/bootstrap.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/style.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/dark.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/swiper.css') }}" type="text/css" />

	<!-- shop Demo Specific Stylesheet -->
	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/shop.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/fonts.css') }}" type="text/css" />
	<!-- / -->

	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/font-icons.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/animate.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/magnific-popup.css') }}" type="text/css" />

	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/custom.css') }}" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="stylesheet" href="{{ asset('theme/ecommerce/css/colors.php?color=000000') }}" type="text/css" />

	<!-- Document Title
	============================================= -->
	<title>Shop Demo | Canvas</title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">
		<!-- Top Bar
		============================================= -->
		@include('theme.ecommerce.layouts.topbar')

		<!-- Header
		============================================= -->
		@include('theme.ecommerce.layouts.header')

		@if(isset($page) && $page->name == 'Shop')
		<!-- Slider
		============================================= -->
		@include('theme.ecommerce.layouts.shop-slider')
		@endif

		<!-- Content
		============================================= -->
		<section id="content">
			@yield('content')
		</section>

		<!-- Footer
		============================================= -->
		@include('theme.ecommerce.layouts.footer')

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-line-arrow-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="{{ asset('theme/ecommerce/js/jquery.js') }}"></script>
	<script src="{{ asset('theme/ecommerce/js/plugins.min.js') }}"></script>

	<!-- Footer Scripts
	============================================= -->
    <script type="text/javascript">
        var bannerFxIn = "bounceIn";
        var bannerFxOut = "bounceOut";
        var bannerCaptionFxIn = "fadeInUp";
        var autoPlayTimeout = 4000;
        var bannerID = "banner";
        var app_url = "{{ env('APP_URL') }}";
    </script>

	<script src="{{ asset('theme/ecommerce/js/functions.js') }}"></script>

	<!-- ADD-ONS JS FILES -->

	<script src="{{ asset('js/notify.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    @yield('pagejs')


    @yield('customjs')
	<script>
		function add_to_cart(product,qty){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                data: {
                    "product_id": product,
                    "qty": qty,
                    "_token": "{{ csrf_token() }}",
                },
                type: "post",
                url: "{{route('cart.add')}}",
                beforeSend: function(){
                    $('#btn'+product).html('<img src="{{asset('img/ajax-loader.gif')}}">');
                },
                success: function(returnData) {
                    $("#loading-overlay").hide();
                    if (returnData['success']) {

                        $('.top-cart-number').html(returnData['totalItems']);


                        $.notify("Product Added to your cart",
                            {
                                position:"bottom right",
                                className: "success"
                            }
                        );
                        $('#btn'+product).html('<i class="fa fa-cart-plus bg-warning text-light p-1 rounded" title="Already added on cart"></i>');
                    }
                    else{
                        swal({
                            toast: true,
                            position: 'center',
                            title: "Warning!",
                            text: "We have insufficient inventory for this item.",
                            type: "warning",
                            showCancelButton: true,
                            timerProgressBar: true,
                            closeOnCancel: false

                        });
                    }
                },
                failed: function() {

                }
            });
        }
	</script>

</body>
</html>
