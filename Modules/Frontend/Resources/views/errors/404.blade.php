@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('404') }}
    </div>
    <div class="box-info">
        <div class="container text-center">
            <div class="title error-title mb-2">The Page You Are Looking Is Not Found</div>
            <div class="small-title">The page you are looking for does not exist. It may have been moved,
                or removed altogether. Perhaps you can return back to the <br> site's homepage and see if you can find
                what
                you are looking for.
            </div>
            <a href="{{route('frontend.home')}}" class="btn btn-outline mt-3">Back to home</a>
        </div>
    </div>
    <main class="container">
        <div class="row article-main-list">
            @foreach($articles as $article)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    @include('frontend::articles.includes.card')
                </div>
            @endforeach
        </div>
    </main>
@endsection
