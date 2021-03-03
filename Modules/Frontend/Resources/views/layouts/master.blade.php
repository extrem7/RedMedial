<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="it-rating" content="it-rat-96ce2df79b44e83b1c096943ce4efc94"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    @include('includes.favicon')
    <link href="{{mix('dist/css/app.css')}}" rel="stylesheet">
    @stack('styles')
    @include('frontend::includes.google')
</head>
<body class="{{ $bodyClass }}">
<div id="redmedial" class="pseudo-app">
    <red-header></red-header>
    @yield('content')
    <red-footer></red-footer>
    <alert-notification></alert-notification>
</div>
@shared
@routes('frontend')
@stack('scripts')
<script src="{{mix('dist/js/app.js')}}"></script>
@schema
</body>
</html>
