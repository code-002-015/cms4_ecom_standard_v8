<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage').'/icons/'.Setting::getFaviconLogo()->website_favicon }}">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="keywords" content="{{ env('APP_NAME') }}">



    <link rel="stylesheet" href="{{ asset('theme/cerebro/plugins/font-awesome/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/cerebro/plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/cerebro/plugins/aos/dist/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/cerebro/css/animate.css') }}" media="screen" />
    <link rel="stylesheet" href="{{ asset('theme/cerebro/plugins/navik/navik.menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/cerebro/plugins/linearicon/linearicon.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/cerebro/plugins/jssocials/jssocials.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/cerebro/plugins/jssocials/jssocials-theme-flat.css') }}" />
    <link rel="stylesheet" href="{{ asset('theme/cerebro/css/style.css') }}" />
</head>
<body onload="window.print()">
<main>
    <section>
        <div class="main-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="article-content">
                            <img src="{{$news->image_url}}" alt="" />
                            <p>
                                {!! $news->contents !!}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
    </section>
</main>
</body>
</html>
