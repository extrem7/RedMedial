@php
    /* @var $page \App\Models\Page
     * @var $channel \App\Models\Rss\Channel
     */
@endphp
@extends('frontend::layouts.master')

@section('content')
    <main class="container">
        {{ Breadcrumbs::render('page',$page) }}
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="title title-cyan page-title mb-3">{{$page->title}}</div>
                <div class="semi-bold">{!!$page->body!!}</div>
                <div class="box box-form mt-0 mt-md-4">
                    <div class="page-title title title-cyan">Contact us</div>
                    <div class="mt-3">Toma contacto haciendo uso del formulario.</div>
                    <form-red-de-medios></form-red-de-medios>
                </div>
                @php //todo lists in second sprint @endphp
                <div class="row rss-lists media-list mt-0 mt-md-5">
                    <div class="col-md-6">
                        <div class="rss-item">
                            <div class="rss-header">
                                <div class="title title-cyan medium-size">RED DE MEDIOS-INTERNACIONAL</div>
                            </div>
                            <div class="rss-body">
                                @foreach($international as $channel)
                                    <a href="{{$channel->link}}" class="rss-link title">
                                        <img src="{{$channel->logo}}" alt="">
                                        {{$channel->name}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rss-item">
                            <div class="rss-header">
                                <div class="title title-cyan medium-size">RED DE MEDIOS-CHILE</div>
                            </div>
                            <div class="rss-body">
                                <div class="rss-body">
                                    @foreach($chile as $channel)
                                        <a href="{{$channel->link}}" class="rss-link title">
                                            <img src="{{$channel->logo}}" alt="">
                                            {{$channel->name}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 indent-sm">
                <social></social>
                <rss-item v-bind="sidebarChannels[0]" class="mt-4"></rss-item>
                <div class="ads-single mt-4">
                    @include('frontend::articles.includes.banner-bottom')
                </div>
                <rss-item v-bind="sidebarChannels[1]" class="mt-4"></rss-item>
            </div>
        </div>

    </main>
@endsection
