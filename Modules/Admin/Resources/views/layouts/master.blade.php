<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    @include('includes.favicon')
    <link rel="stylesheet" href="{{asset_admin('css/pace.css')}}">
    <script src="{{asset_admin('js/pace.js')}}"></script>
    <link rel="stylesheet" href="{{mix('admin/css/app.css')}}">
    @stack('styles')
</head>
<body class="{{ $bodyClass }}">
<div id="app">
    @yield('main')
    <alert></alert>
</div>
@shared
@routes('admin')
<script src="{{mix('admin/js/app.js')}}"></script>
@stack('scripts')
</body>
</html>
