@extends('frontend::layouts.master')

@section('content')
    <main class="container" v-lazy-container="{ selector: '.banner-bottom img' }">
        <h1 class="sr-only">{!!SEO::getTitle()!!}</h1>
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

            <div class="banner-bottom mt-4 mb-4">
                <div id='div-gpt-ad-RM2020-01'></div>
            </div>
        </div>

        <div class="text-center mt-3 mb-3">
            <a href="http://covid19alert.net" target="_blank" class="btn btn-red">covid-19 page</a>
        </div>

        @include('frontend::pages.home.includes.hot-news')

        <div class="banner-bottom mt-2 mb-2">
            <div id='div-gpt-ad-RM2020-02'></div>
        </div>

        @if(config('app.env')!=='local')
            @include('frontend::pages.home.includes.covid-map')
        @endif
        <div class="banner-bottom mt-2 mb-2">
            <div id='div-gpt-ad-RM2020-03'></div>
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
            <div id='div-gpt-ad-RM2020-04'></div>
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
            <playlists order-name="home"></playlists>
            <div class="text-center">
                <a href="/all-youtube" class="btn btn-cyan">More on All video</a>
            </div>
        </section>

    </main>
@endsection

@push('scripts')
    <script>
        googletag.cmd.push(function () {
            googletag.display('div-gpt-ad-RM2020-01')
            googletag.display('div-gpt-ad-RM2020-02')
            googletag.display('div-gpt-ad-RM2020-03')
            googletag.display('div-gpt-ad-RM2020-04')
        });
    </script>
@endpush
