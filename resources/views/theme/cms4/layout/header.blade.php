<header id="header" class="border-bottom-0 no-sticky transparent-header">
    <div id="header-wrap">
        <div class="container">
            <div class="header-row">

                <div id="logo">
                    <a href="{{ route('home') }}" class="standard-logo"><img src="{{ asset('theme/'.env('THEME_FOLDER').'/images/logo.png') }}" alt="Canvas Logo"></a>
                    <a href="{{ route('home') }}" class="retina-logo"><img src="{{ asset('theme/'.env('THEME_FOLDER').'/images/logo@2x.png') }}" alt="Canvas Logo"></a>
                </div>

                <div class="header-misc">
                </div>

                <div id="primary-menu-trigger">
                    <svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
                </div>

                <nav class="primary-menu">
                    @include('theme.'.env('THEME_FOLDER').'.layout.menu')
                </nav>
            </div>
        </div>
    </div>
</header>


{{--<div id="logo">
    <a href="{{ route('home') }}" class="standard-logo"><img src="{{ asset('storage/logos/'.Setting::getFaviconLogo()->company_logo) }}" alt="Varguard Academy"></a>
    <a href="{{ route('home') }}" class="retina-logo"><img src="{{ asset('storage/logos/'.Setting::getFaviconLogo()->company_logo) }}" alt="Vanguard Academy"></a>
</div>--}}
