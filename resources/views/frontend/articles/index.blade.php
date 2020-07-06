@extends('frontend.layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('articles') }}
    </div>
    <main class="container">
        <div class="row">
            <articles-list></articles-list>
            @include('frontend.includes.archive-sidebar')
        </div>
    </main>
@endsection
