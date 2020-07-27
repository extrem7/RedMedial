@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('page',$page) }}
    </div>

    <main class="container">
        <h1 class="page-title title title-cyan line text-center mb-4">All rss</h1>
        <rss-list :with-pagination="true" order-name="{{$orderName}}"></rss-list>
    </main>
@endsection
