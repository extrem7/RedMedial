@php /* @var $article \App\Models\Article */  @endphp
<div class="col-lg-9 position-relative">
    <a href="{{$article->link}}" class="main-article-banner">
        <img src="{{$article->image}}" class="img-fluid" alt="{{$article->title}}">
    </a>
    <div class="main-article-card">
        <a href="{{$article->link}}" class="title title-cyan line-cap">{{$article->title}}</a>
        <div class="article-description line-cap">{!!$article->excerpt!!}</div>
        <div class="d-flex justify-content-between">
            <a href="{{$article->link}}" class="read-all">Read more</a>
            <div class="article-date">{{$article->date}}
            </div>
        </div>
    </div>
</div>
