<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('asset-landingpage/css/header.css') }}">
    <title>MA Nurul Ilmi Bategede</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logomanuril.png') }}">
    @yield('head')
</head>

<body>
    <!-- Page Wrapper End -->
    <div class="page-wrapper">
        <!-- Header Section Start -->
        <header class="header-wrap {{ Request::is('/') ? 'style2' : 'style1' }}">
            @include('partials.topbar')
            @include('partials.navbar')
        </header>

        @if (!Request::is('/'))
            <div class="content-wrapper">

                <!-- Breadcrumb Start -->
                <div class="breadcrumb-wrap bg-f br-3">
                    <div class="overlay op-8 bg-downriver"></div>
                    <div class="container">
                        <div class="breadcrumb-title">
                            <h2>{{ $title }}</h2>
                            <ul class="breadcrumb-menu list-style">
                                <li><a href="/">Home </a></li>
                                <li>{{ $title }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
        @endif

        <!-- Header Section End -->
        @yield('main')
        @if (!Request::is('/'))
    </div>
    @endif

    @include('partials.footer')
    </div>

    <!-- Back-to-top button Start -->
    <a href="javascript:void(0)" class="back-to-top bounce"><i class="ri-arrow-up-s-line"></i></a>
    <!-- Back-to-top button End -->

    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('asset-landingpage/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/form-validator.min.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/contact-form-script.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/aos.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/odometer.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/fslightbox.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/tweenmax.min.js') }}"></script>
    <script src="{{ asset('asset-landingpage/js/main.js') }}"></script>

</body>

</html>
