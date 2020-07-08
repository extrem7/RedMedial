@extends('frontend.layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('page',$page) }}
    </div>

    <main class="container">
        <rss-list order-name="{{$orderName}}"></rss-list>

        <!--<div class="text-center">
            <button class="btn btn-cyan">Load more</button>
        </div>-->
    </main>
@endsection
