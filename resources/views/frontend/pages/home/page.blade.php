@extends('frontend.layouts.master')

@section('content')
    <main class="container">

        <div class="main-archive">
            <div class="row">
                @include('frontend.articles.includes.card-big',['article'=>$articles['main']])

                <div class="col-lg-3 article-main-list">
                    @each('frontend.articles.includes.card',$articles['column'],'article')
                </div>

                <div class="col-12 text-center">
                    <a href="{{route('frontend.articles.index')}}" class="btn btn-cyan mt-4">More on Our blog</a>
                </div>
            </div>
        </div>

        <div class="text-center mt-3 mb-3">
            <a href="http://covid19alert.net" target="_blank" class="btn btn-red">covid-19 page</a>
        </div>

        <section class="hot-news mb-4">
            <h2 class="title red-color text-center medium-size line">Latest Coronavirus News</h2>
            <div class="row article-main-list mt-3 inline-block-xs">
                @php /* @var $post \App\Models\Rss\Post */  @endphp
                @foreach($covid as $post)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="article-card">
                            <a href="{{$post->link}}" class="article-header overflow-box"><img src="{{$post->image}}"
                                                                                               alt="{{$post->title}}"></a>
                            <div class="article-body">
                                @if($post->channel->country!==null)
                                    <a href="{{$post->link}}"
                                       class="article-category">{{$post->channel->country->name}}</a>
                                @endif
                                <a href="{{$post->link}}"
                                   class="article-title title title-cyan line-cap">{{$post->title}}</a>
                                <div class="d-flex justify-content-between">
                                    <a href="{{$post->link}}" class="read-all">Read more</a>
                                    <div class="article-date">{{$post->date}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <img src="{{asset('dist/img/icons/swipe.svg')}}" alt="swipe" class="swipe-tooltip">
            <div class="text-center">
                <a href="http://covid19alert.net" class="btn btn-red mt-2">more about covid-19</a>
            </div>
            <div class="text-center mt-3 mb-3">
                <a href="#" class="red-color copy-iframe"><img src="{{asset('dist/img/icons/copy.svg')}}" alt="copy"
                                                               class="mr-2">copy
                    news code(iframe) to your site</a>
            </div>
        </section>


        <section class="section-rss-local">
            <h2 class="title text-center medium-size line mb-4">Medias Near You</h2>
            <rss-list order-name="local"></rss-list>
            <div class="text-center">
                <a href="https://redmedial.com/all-rss/" class="btn btn-cyan">See All local rss</a>
            </div>
        </section>

        <div class="banner-bottom mt-2 mb-2">
            <div id="div-gpt-ad-RM2020-04" data-google-query-id="CMbCwKTMi-oCFbdBkQUd82sEWg">
                <div id="google_ads_iframe_/30128925/RM2020_HOME/RM2020_home_04_0__container__"
                     style="border: 0pt none; display: inline-block; width: 300px; height: 250px;">
                    <iframe frameborder="0"
                            src="https://b1519b8ccc03e32da1a3bc53edbedc12.safeframe.googlesyndication.com/safeframe/1-0-37/html/container.html"
                            id="google_ads_iframe_/30128925/RM2020_HOME/RM2020_home_04_0" title="3rd party ad content"
                            name="" scrolling="no" marginwidth="0" marginheight="0" width="300" height="250"
                            data-is-safeframe="true"
                            sandbox="allow-forms allow-pointer-lock allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts allow-top-navigation-by-user-activation"
                            data-google-container-id="4" style="border: 0px; vertical-align: bottom;"
                            data-gtm-yt-inspected-1_27="true" data-load-complete="true"></iframe>
                </div>
            </div>
        </div>

        <section class="section-rss-world">
            <h2 class="title text-center medium-size line mb-4">International Medias</h2>
            <rss-list order-name="international"></rss-list>
            <div class="text-center">
                <a href="https://redmedial.com/all-rss/" class="btn btn-cyan">More on all rss</a>
            </div>
        </section>

        <section class="section-subscribe">
            <social></social>
        </section>

        <section class="youtube-list pt-3">
            <div class="row">
                <div class="col-md-4" v-for="player in youtube">
                    <youtube-player :player="player"></youtube-player>
                </div>
            </div>
            <div class="text-center">
                <a href="https://redmedial.com/all-youtube/" class="btn btn-cyan">More on All video</a>
            </div>
        </section>

    </main>
@endsection
