@php /* @var $channel \App\Models\Rss\Channel  */  @endphp
@extends('frontend.layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>
    <div class="box-info box-info-archive">
        <div class="container text-center">
            <div class="rss-media-info">
                <div class="title title-cyan line">Media info:</div>
                <div class="mb-2">{{$channel->description}}</div>
            </div>
            <img src="{{$channel->logo}}" class="img-fluid archive-img" alt="{{$channel->title}}">
        </div>
    </div>
    <main class="container">
        <div class="row">
            <articles-list></articles-list>
            @include('frontend.includes.archive-sidebar')
        </div>
    </main>
@endsection
