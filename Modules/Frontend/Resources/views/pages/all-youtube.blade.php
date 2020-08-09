@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('page',$page) }}
    </div>

    <main class="container">
        <h1 class="page-title title title-cyan line text-center mb-4">{{$page->title}}</h1>
        <playlists order-name="all"></playlists>
    </main>
@endsection
