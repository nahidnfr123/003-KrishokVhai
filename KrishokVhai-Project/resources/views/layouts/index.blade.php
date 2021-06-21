<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Krishok Vhai') }} | Nahid Ferdous</title>

    <link rel="icon" href="{{ asset('frontend-assets/img/core-img/favicon.ico') }}">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css"/>

    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/profileDropdown.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend-assets/style.css') }}">

    <!--    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>-->


    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <style type="text/css">
        #maps {
            height: 400px !important;
            width: 100% !important;
        }

        #goog-gt-tt {
            visibility: hidden !important;
            /*display: none !important;*/
        }

        .goog-text-highlight {
            background-color: transparent !important;
            box-shadow: none !important;
        }

        .translated-ltr {
            margin-top: -40px;
        }

        .translated-ltr {
            margin-top: -40px;
        }

        .goog-te-banner-frame {
            display: none;
            margin-top: -20px;
        }

        .goog-logo-link {
            display: none !important;
        }

        .goog-te-gadget {
            color: transparent !important;
        }

        .goog-te-combo {
            padding: 2px;
        }

        .floatingLanguage {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: white;
            z-index: 10000;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
            transition: all ease-in-out 200ms;
            padding: 2px 4px;
            height: 34px;
            width: auto;
        }

        .floatingLanguage.activeLang {
            height: 100px;
            width: 160px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
<noscript>
    <strong>We're sorry but {{ Config::get('app.name', 'Smart Agro') }} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>
<div>
    <!-- Preloader -->
    <!--    <div class="preloader d-flex align-items-center justify-content-center">
            <div class="spinner"></div>
        </div>-->

    <div class="floatingLanguage">
        <div id="google_translate_element"></div>
    </div>

    <div id="app">

    </div>
</div>

<script src="{{ asset('dist/js/app.js') }}"></script>

<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
    }
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- ##### All Javascript Files ##### -->
<script src="{{ asset('frontend-assets/js/owl.carousel.min.js') }}" defer></script>
<script src="{{ asset('frontend-assets/js/classynav.js') }}" defer></script>
<script src="{{ asset('frontend-assets/js/jquery.sticky.js') }}" defer></script>
<script src="{{ asset('frontend-assets/js/jquery.magnific-popup.min.js') }}" defer></script>
<script src="{{ asset('frontend-assets/js/jquery.scrollup.min.js') }}" defer></script>

<script src="{{ asset('frontend-assets/js/wow.min.js') }}" defer></script>
{{--
<script src="{{ asset('frontend-assets/js/jarallax.min.js') }}" defer></script>
<script src="{{ asset('frontend-assets/js/jarallax-video.min.js') }}" defer></script>
--}}

{{--<script src="{{ asset('frontend-assets/js/active.js') }}" defer></script>--}}

<script defer>
    window.addEventListener("load", function () {
        function LoadWebContent() {
            let active = document.createElement("script");
            active.src = "{{ asset('frontend-assets/js/active.js') }}";
            document.body.appendChild(active);
        }
        LoadWebContent();
    });

    // toggle profile icon ...
    function ProfileMenuToggle() {
        let element = document.getElementById("Profile_Options").classList;
        let element2 = document.getElementById("Profile").classList;
        if (element.contains('show')) {
            element.remove('show');
            element2.remove('clicked');
            $('.MsgCountfront').show();
        } else {
            element.add('show');
            element2.add('clicked');
            $('.MsgCountfront').hide();
        }
    }
</script>


</body>
</html>
