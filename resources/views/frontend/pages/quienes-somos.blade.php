@php /* @var $page \App\Models\Page */  @endphp
@extends('frontend.layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('page',$page) }}
    </div>
    <main class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <article class="article">
                    <div class="position-relative">
                        <div class="main-article-banner">
                            <img src="{{asset('dist/img/quienes-somos.png')}}" class="img-fluid" alt="{{$page->title}}">
                        </div>
                        <div class="main-article-card">
                            <div class="title title-cyan">{{$page->title}}</div>
                            <div class="d-flex justify-content-center article-description">
                                {{$page->meta_description}}
                            </div>
                        </div>
                    </div>
                    <div class="description dynamic-content">{!!$page->body!!}</div>
                </article>
            </div>
            <div class="col-xl-3 col-lg-4 indent-sm">
                <social></social>
                <rss-item :rss="singleRss" class="mt-4"></rss-item>
                @include('frontend.articles.includes.ads-single')
                <rss-item :rss="singleRss" class="mt-4"></rss-item>
            </div>
        </div>
    </main>
@endsection
