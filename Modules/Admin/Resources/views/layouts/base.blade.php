@extends('admin::layouts.master')

@section('main')
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-dark">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <menu-toggle></menu-toggle>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{route('frontend.home')}}" class="nav-link" target="_blank">Go to RedMedial</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <logout></logout>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{route('frontend.home')}}" class="brand-link" target="_blank">
                <img src="{{asset_admin('img/logo.svg')}}" alt="logo" class="">
            </a>
            @include('admin::includes.sidebar')
        </aside>

        <div class="content-wrapper">
            @if(isset($pageTitle))
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">{{$pageTitle}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
@endsection
