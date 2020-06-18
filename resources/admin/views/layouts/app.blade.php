<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @meta_tags
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    @stack('styles')
</head>
<body class="hold-transition {{ $bodyClass }}">
<div id="app">
    @yield('main')
    <alert></alert>
</div>
@shared
@routes('admin')
@meta_tags('footer')
@stack('scripts')
</body>
</html>
