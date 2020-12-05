@if(isset($iframe))
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{mix('dist/css/app.css')}}" rel="stylesheet">
    <div id="app">
        @endif

        <section class="hot-news mb-4 {{isset($iframe)?'container':''}}">
            <h2 class="title red-color text-center medium-size line">{{ $title }}</h2>
            <div class="row article-main-list mt-3 inline-block-xs" v-lazy-container="{ selector: 'img' }">
                @php /* @var $post \App\Models\Rss\Post */  @endphp
                @foreach($hot as $post)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="article-card">
                            <a href="{{$post->source}}" target="_blank" rel="nofollow"
                               class="article-header overflow-box">
                                <img data-src="{{$post->thumbnail}}" alt="{{$post->title}}">
                            </a>
                            <div class="article-body">
                                @if($post->country!==null)
                                    <a href="{{$post->country->link}}"
                                       class="article-category">{{$post->country->name}}</a>
                                @endif
                                <a href="{{$post->source}}"
                                   target="_blank"
                                   rel="nofollow"
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
            @if(isset($covid))
                <div class="text-center">
                    <a href="http://covid19alert.net" target="_blank" class="btn btn-red mt-2">more about covid-19</a>
                </div>
            @endif
            <div class="text-center mt-3 mb-3">
                <copy-iframe text="copy news code(iframe) to your site"
                             iframe='<iframe src="{{route('frontend.iframe.'.$route)}}" frameborder="0" width="100%" height="920px"></iframe>'></copy-iframe>
            </div>
        </section>
        @if(isset($iframe))
            <alert-notification></alert-notification>
    </div>
    @shared
    @routes('frontend')
    <script src="{{mix('dist/js/app.js')}}"></script>
@endif
