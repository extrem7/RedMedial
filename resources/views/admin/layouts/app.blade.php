<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="{{asset_admin('css/pace.css')}}">
    <script src="{{asset_admin('js/pace.js')}}"></script>

    <link rel="stylesheet" href="{{mix('admin/css/app.css')}}">
    @stack('styles')
</head>
<body class="hold-transition {{ $bodyClass }}">
<div id="app">
    @yield('main')
    <alert></alert>
</div>
@shared
@routes('admin')
<script src="{{mix('admin/js/main.js')}}"></script>
<script src="{{mix('admin/js/app.js')}}"></script>
@stack('scripts')
</body>
</html>
