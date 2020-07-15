@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('page',$page) }}
    </div>

    <main class="container">
        <rss-list :with-pagination="true" order-name="{{$orderName}}"></rss-list>
    </main>
@endsection
