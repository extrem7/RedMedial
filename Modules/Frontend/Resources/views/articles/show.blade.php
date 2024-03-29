@php /* @var $article \App\Models\Article */  @endphp
@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render() }}
    </div>
    <main class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <article class="article">
                    <div class="position-relative">
                        <div class="main-article-banner">
                            <img src="{{$article->banner}}" class="img-fluid" alt="alt">
                        </div>
                        <div class="main-article-card">
                            <h1 class="title title-cyan line-cap">{{$article->title}}</h1>
                            <div class="d-flex justify-content-between mt-4">
                                <div class="article-date">{{$article->date}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center">
                        <share></share>
                        @include('frontend::articles.includes.donate')
                    </div>
                    <div class="banner-bottom">
                        <div id='div-gpt-ad-RM2020-02'></div>
                    </div>
                    <div class="description dynamic-content">{!!$article->body!!}</div>
                    <div class="d-flex flex-column flex-md-row mt-4">
                        @if($article->authors)
                            <div class="box-line mw-267">
                                <div class="title title-cyan page-title">LOS AUTORES</div>
                                <div class="mt-3">
                                    @foreach(explode(',',$article->authors) as $author)
                                        <div class="mb-2">{{$author}}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($article->original)
                            <div class="box-line mw-267 mt-3 mt-md-0">
                                <div class="title title-cyan page-title">MEDIA</div>
                                <div class="mt-3">
                                    <a href="{{$article->original}}" class="link d-block mt-2">Noticia original</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </article>

                <div id="fb-root"></div>
                <div class="fb-comments" data-href="{{$article->link}}" data-numposts="5" data-width="100%"></div>

                @include('frontend::articles.includes.banner-bottom')
            </div>
            @include('frontend::includes.single-sidebar')
        </div>
    </main>
@endsection

@push('scripts')
    {!!$articleSchema!!}
    <script async defer crossorigin="anonymous"
            src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v7.0&appId=2267874190154020&autoLogAppEvents=1"
            nonce="UGIJPutf"></script>
    <script>
        googletag.cmd.push(function () {
            googletag.display('div-gpt-ad-RM2020-02')
        });
    </script>
@endpush
