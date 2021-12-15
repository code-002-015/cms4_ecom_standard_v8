<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Stylesheets
    ============================================= -->
    <link href="http://fonts.googleapis.com/css?family=Heebo:300,400,500,700,900" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/style.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/magnific-popup.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/custom.css') }}" type="text/css" />

    <!-- Freelancer Demo Specific Stylesheet -->
    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/fonts.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/freelancer.css') }}" type="text/css" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="{{ asset('theme/'.env('THEME_FOLDER').'/css/colors.php?color=f7c25e') }}" type="text/css" />

    <!-- Document Title
    ============================================= -->
    @if (isset($page->name) && $page->name == 'Home')
        <title>{{ Setting::info()->company_name }}</title>
    @else
        <title>{{ (empty($page->meta_title) ? $page->name:$page->meta_title) }} | {{ Setting::info()->company_name }}</title>
    @endif

    @if(!empty($page->meta_description))
        <meta name="description" content="{{ $page->meta_description }}">
    @endif

    @if(!empty($page->meta_keyword))
        <meta name="keywords" content="{{ $page->meta_keyword }}">
    @endif

    <!-- Favicon
    ============================================= -->
    <link rel="shortcut icon" href="{{ asset('theme/'.env('THEME_FOLDER').'/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('theme/'.env('THEME_FOLDER').'/images/favicon.png') }}" type="image/x-icon">

</head>

<body class="stretched">
    <div id="wrapper" class="clearfix">
        
        @include('theme.'.env('FRONTEND_TEMPLATE').'.layout.header')
        @include('theme.'.env('FRONTEND_TEMPLATE').'.layout.banner')

        <!-- Content
        ============================================= -->
        @yield('content')
        <!-- #content end -->

        <!-- Footer
        ============================================= -->
        <footer id="footer" class="border-0" style="background-color: #C9D6CF;">
            @include('theme.'.env('FRONTEND_TEMPLATE').'.layout.footer')
        </footer>
        <!-- #footer end -->
    </div>

    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-double-angle-up bg-white text-dark rounded-circle shadow"></div>

    <!-- External JavaScripts
    ============================================= -->
    <script src="{{ asset('theme/'.env('THEME_FOLDER').'/js/jquery.js') }}"></script>
    <script src="{{ asset('theme/'.env('THEME_FOLDER').'/js/plugins.min.js') }}"></script>

    <!-- Footer Scripts
    ============================================= -->
    <script src="{{ asset('theme/'.env('THEME_FOLDER').'/js/functions.js') }}"></script>

    <script>
        // Owl Carousel Scripts
        jQuery(window).on( 'pluginCarouselReady', function(){
            $('#oc-services').owlCarousel({
                items: 1,
                margin: 30,
                nav: false,
                dots: true,
                smartSpeed: 400,
                responsive:{
                    576: { stagePadding: 30, items: 1 },
                    768: { stagePadding: 30, items: 2 },
                    991: { stagePadding: 150, items: 3 },
                    1200: { stagePadding: 150, items: 3}
                },
            });
        });
    </script>

</body>
</html>