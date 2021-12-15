<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="">
    <meta name="author">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Setting::info()->company_name }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage').'/icons/'.Setting::getFaviconLogo()->website_favicon }}">

    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashforge.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashforge.dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin.deepblue.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-admin.css') }}">

    @yield('pagecss') <!-- Add your own custom style and css-->

</head>

<body>

    @include('admin.layouts.sidebar')

    <div class="content ht-100v pd-0">


        <div class="content-header">

            @include('admin.layouts.header')

        </div>


        <div class="content-body">

            @yield('content')


        </div>

    </div>

    <!-- Success -->
    <div class="pos-fixed b-10 r-10">
        <div id="toast_success" class="toast bg-success bd-0 wd-350" data-delay="3000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <h6 class="tx-white tx-14 mg-b-0 mg-r-auto tx-semibold"><i data-feather="check-circle" width="14"></i> Success</h6>
                <button type="button" class="ml-2 mb-1 close tx-normal" data-dismiss="toast" aria-label="Close">
                    <i data-feather="x" aria-hidden="true" class="tx-white wd-15"></i>
                </button>
            </div>
            <div class="toast-body bg-success tx-white">
                {{ Session::get('success') }}
            </div>
        </div>
    </div>


    <!-- Error -->
    <div class="pos-fixed b-10 r-10">
        <div id="toast_error" class="toast bg-danger bd-0 wd-350" data-delay="3000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body pd-6 tx-white">
                <button type="button" class="ml-2 mb-1 close tx-normal tx-shadow-none" data-dismiss="toast" aria-label="Close">
                    <span class="tx-white" aria-hidden="true">&times;</span>
                </button>
                <h6 class="mg-b-15 mg-t-15 tx-white"><i data-feather="alert-circle"></i> ERROR!</h6>
                <p>{{ Session::get('error') }}</p>
            </div>
        </div>
    </div>

    <!-- Error -->
    <div class="pos-fixed b-10 r-10">
        <div id="toastDynamicError" class="toast bg-danger bd-0 wd-350" data-delay="60000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body pd-6 tx-white">
                <button type="button" class="ml-2 mb-1 close tx-normal tx-shadow-none" data-dismiss="toast" aria-label="Close">
                    <span class="tx-white" aria-hidden="true">&times;</span>
                </button>
                <h6 class="mg-b-15 mg-t-15 tx-white"><i data-feather="alert-circle"></i> ERROR!</h6>
                <p id="errorMessage"></p>
            </div>
        </div>
    </div>

    <div class="pos-absolute b-10 r-20 z-index-200">
        <div id="toastErrorMessage" class="toast bg-danger bd-0 wd-350" data-delay="10000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger">
                <h6 class="tx-white tx-14 mg-b-0 mg-r-auto tx-semibold"><i data-feather="x-circle" width="14"></i> Failed</h6>
                <button type="button" class="ml-2 mb-1 close tx-normal" data-dismiss="toast" aria-label="Close">
                    <i data-feather="x" aria-hidden="true" class="tx-white wd-15"></i>
                </button>
            </div>
            <div class="toast-body bg-danger tx-white">
                <ul id="errorMessage" style="list-style-type: none;padding-inline-start: 0px;">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <li>
                                <i class="mg-r-10"></i> {{ $error }}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="modal effect-scale" id="prompt-banner-error" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Failed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="bannerErrorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

    <!--Put your external scripts here -->
    @yield('pagejs')

    <script src="{{ asset('js/dashforge.js') }}"></script>
    <script src="{{ asset('js/dashforge.aside.js') }}"></script>
    <script src="{{ asset('js/dashforge.sampledata.js') }}"></script>

    @yield('customjs')

    @if(Session::has('success'))
        <script>
            $('#toast_success').toast('show');
        </script>
    @endif
</body>
</html>
