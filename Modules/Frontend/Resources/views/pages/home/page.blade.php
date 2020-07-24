@extends('frontend::layouts.master')

@section('content')
    <main class="container" v-lazy-container="{ selector: '.banner-bottom img' }">

        <div class="main-archive">
            <div class="row">
                @include('frontend::articles.includes.card-big',['article'=>$articles['main']])

                <div class="col-lg-3 article-main-list">
                    @each('frontend::articles.includes.card',$articles['column'],'article')
                </div>

                <div class="col-12 text-center">
                    <a href="{{route('frontend.articles.index')}}" class="btn btn-cyan mt-4">More on Our blog</a>
                </div>
            </div>

            <div class="banner-bottom">
                <img data-src="https://i.ibb.co/6tj8fC4/image.png" class="img-fluid" alt="">
            </div>
        </div>

        <div class="text-center mt-3 mb-3">
            <a href="http://covid19alert.net" target="_blank" class="btn btn-red">covid-19 page</a>
        </div>

        @include('frontend::pages.home.includes.hot-news')

        <div class="banner-bottom mt-2 mb-2">
            <img data-src="https://i.ibb.co/BnvC9Rd/image.png" class="img-fluid" alt="">
        </div>

        @if(config('app.env')!=='local'&&false)
            @include('frontend::pages.home.includes.covid-map')
        @endif
        <div class="banner-bottom mt-2 mb-2">
            <img data-src="https://i.ibb.co/8PqQV70/image.png" class="img-fluid" alt="">
        </div>
        @if($country!==null)
            <section class="section-rss-local">
                <h2 class="title text-center medium-size line mb-4">Medias Near You</h2>
                <rss-list shared-key="localChannels" order-name="local-country-{{$country->id}}"></rss-list>
                <div class="text-center">
                    <a href="{{$country->link}}" class="btn btn-cyan">See All local rss</a>
                </div>
            </section>
        @endif

        <div class="banner-bottom mt-2 mb-2">
            <img data-src="https://i.ibb.co/BnvC9Rd/image.png" class="img-fluid" alt="">
        </div>

        <section class="section-rss-world">
            <h2 class="title text-center medium-size line mb-4">International Medias</h2>
            <rss-list shared-key="internationalChannels" order-name="international"></rss-list>
            <div class="text-center">
                <a href="/all-rss" class="btn btn-cyan">More on all rss</a>
            </div>
        </section>

        <section class="section-subscribe">
            <div>
                <social></social>
            </div>
        </section>

        <section class="youtube-list pt-3">
            <div class="row">
                <div class="col-md-4" v-for="player in youtube">
                    <youtube-player :player="player"></youtube-player>
                </div>
            </div>
            <div class="text-center">
                <a href="/all-youtube" class="btn btn-cyan">More on All video</a>
            </div>
        </section>

    </main>
@endsection
