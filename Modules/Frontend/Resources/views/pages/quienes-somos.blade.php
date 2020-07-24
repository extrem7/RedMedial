@php /* @var $page \App\Models\Page */  @endphp
@extends('frontend::layouts.master')

@section('content')
    <div class="container">
        {{ Breadcrumbs::render('page',$page) }}
    </div>
    <main class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <article class="article">
                    <div class="position-relative">
                        <div class="main-article-banner">
                            <img src="{{asset('dist/img/quienes-somos.png')}}" class="img-fluid" alt="{{$page->title}}">
                        </div>
                        <div class="main-article-card height-mod-2">
                            <h1 class="title title-cyan">{{$page->title}}</h1>
                            <div class="d-flex justify-content-center article-description">
                                {{$page->meta_description}}
                            </div>
                        </div>
                    </div>
                    <div class="description dynamic-content">{!!$page->body!!}</div>
                </article>
            </div>
            @include('frontend::includes.page-sidebar')
        </div>
    </main>
@endsection
