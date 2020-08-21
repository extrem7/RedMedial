@php /* @var $post \App\Models\Rss\Post */  @endphp
@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('frontend.rss.posts.show',$post) }}
    </div>
    <main class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <article class="article">
                    <div class="position-relative">
                        <div class="main-article-banner">
                            <img src="{{$post->image}}" class="img-fluid" alt="alt">
                        </div>
                        <div class="main-article-card">
                            <h1 class="title title-cyan line-cap">{{$post->title}}</h1>
                            <div class="d-flex justify-content-between mt-4">
                                <div class="article-date">{{$post->date}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center">
                        <div>
                            <share></share>
                        </div>
                        @include('frontend::articles.includes.donate')
                    </div>
                    <div class="banner-bottom">
                        <div id='div-gpt-ad-RM2020-02'></div>
                    </div>
                    <div class="description dynamic-content">{!!$post->body!!}</div>
                </article>

                <div id="fb-root"></div>
                <div class="fb-comments" data-href="{{$post->link}}" data-numposts="5" data-width="100%"></div>

                @include('frontend::articles.includes.banner-bottom')
            </div>
            @include('frontend::includes.single-sidebar')
        </div>
    </main>
@endsection

@push('scripts')
    {!!$postSchema!!}
    <script async defer crossorigin="anonymous"
            src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v7.0&appId=2267874190154020&autoLogAppEvents=1"
            nonce="UGIJPutf"></script>
@endpush
