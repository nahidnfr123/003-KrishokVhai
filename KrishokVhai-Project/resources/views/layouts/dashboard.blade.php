<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Config::get('app.name', 'Krishok vhai') }} | Nahid Ferdous</title>
    <link rel="icon" href="{{ asset('frontend-assets/img/core-img/favicon.ico') }}">

    <link href="{{ asset('dist/css/app.css') }}" rel="stylesheet" type="text/css">


    <link href="//fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/plugins/forms/switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/core/colors/palette-switch.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/ui/prism.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/components.min.css') }}">

    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/core/colors/palette-gradient.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css/pages/chat-application.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/style.css') }}">
    <!-- END: Custom CSS-->
</head>
<!--<body class="vertical-layout vertical-menu content-left-sidebar chat-application  fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="content-left-sidebar">-->
<body class="vertical-layout vertical-menu 2-columns fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-gradient-x-purple-blue" data-col="2-columns">
<noscript>
    <strong>We're sorry but {{ Config::get('app.name', 'Smart Agro') }} doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>
<div>
    <div id="app">

    </div>
    @include('layouts.partials.customizer')
</div>


<script src="{{ asset('dist/js/app.js') }}"></script>
<!-- BEGIN: Vendor JS-->
<script src="{{ asset('admin/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('admin/app-assets/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('admin/app-assets/js/scripts/forms/switch.min.js') }}" type="text/javascript" defer></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('admin/app-assets/vendors/js/ui/prism.min.js') }}" type="text/javascript" defer></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('admin/app-assets/js/core/app-menu.min.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('admin/app-assets/js/core/app.min.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('admin/app-assets/js/scripts/customizer.min.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('admin/app-assets/vendors/js/jquery.sharrre.js') }}" type="text/javascript" defer></script>
<script src="{{ asset('admin/app-assets/js/scripts/pages/chat-application.js') }}" type="text/javascript" defer></script>
<!-- END: Theme JS-->



</body>
</html>
