@php /* @var $article \App\Models\Article */  @endphp
<div class="article-card">
    <a href="{{$article->link}}" class="article-header overflow-box">
        <img src="{{$article->thumbnail}}" alt="{{$article->title}}">
    </a>
    <div class="article-body">
        <a href="{{$article->link}}" class="article-title title title-cyan line-cap">{{$article->title}}</a>
        <div class="d-flex justify-content-between">
            <a href="{{$article->link}}" class="read-all">Read more</a>
            <div class="article-date">{{$article->date}}</div>
        </div>
    </div>
</div>
