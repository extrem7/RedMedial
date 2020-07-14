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
                            <a href="{{$post->channel->country->link}}"
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
        <copy-iframe text="copy news code(iframe) to your site"
                     iframe='<iframe src="https://redmedial.com/covid-iframe" frameborder="0" width="100%" height="920px"></iframe>'></copy-iframe>
    </div>
</section>
