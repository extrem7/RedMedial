<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    @include('includes.favicon')
    <link href="{{mix('dist/css/app.css')}}" rel="stylesheet">
    @stack('styles')
</head>
<body class="{{ $bodyClass }}">
<div id="app">
    <red-header></red-header>
    @yield('content')
    <red-footer></red-footer>
    <alert-notification></alert-notification>
</div>
@shared
@routes('frontend')
@stack('scripts')
<script src="{{mix('dist/js/app.js')}}" async defer></script>
@schema
</body>
</html>
