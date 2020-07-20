@php /* @var $page \App\Models\Page */  @endphp
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
                                <a href="" class="rss-link title"><img
                                        src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                        alt="">Telesur</a>
                                <a href="" class="rss-link title"><img
                                        src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                        alt="">Telesur</a>
                                <a href="" class="rss-link title"><img
                                        src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                        alt="">Telesur</a>
                                <a href="" class="rss-link title"><img
                                        src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                        alt="">Telesur</a>
                                <a href="" class="rss-link title"><img
                                        src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                        alt="">Telesur</a>
                                <a href="" class="rss-link title"><img
                                        src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                        alt="">Telesur</a>
                                <a href="" class="rss-link title"><img
                                        src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                        alt="">Telesur</a>
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
                                    <a href="" class="rss-link title"><img
                                            src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                            alt="">Telesur</a>
                                    <a href="" class="rss-link title"><img
                                            src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                            alt="">Telesur</a>
                                    <a href="" class="rss-link title"><img
                                            src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                            alt="">Telesur</a>
                                    <a href="" class="rss-link title"><img
                                            src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                            alt="">Telesur</a>
                                    <a href="" class="rss-link title"><img
                                            src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                            alt="">Telesur</a>
                                    <a href="" class="rss-link title"><img
                                            src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                            alt="">Telesur</a>
                                    <a href="" class="rss-link title"><img
                                            src="https://redmedial.com/wp-content/uploads/2019/06/Captura-de-pantalla-2019-06-25-a-las-10.51.27.png"
                                            alt="">Telesur</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 indent-sm">
                <social></social>
                <rss-item v-bind="singleRss" class="mt-4"></rss-item>
                <div class="ads-single mt-4">
                    <div id="div-gpt-ad-RM2020-01" data-google-query-id="CP7R7sX6jeoCFQIZewodFYkH4Q">
                        <div id="google_ads_iframe_/30128925/RM2020_SINGLE/RM2020_single_01_0__container__"
                             style="border: 0pt none;">
                            <iframe id="google_ads_iframe_/30128925/RM2020_SINGLE/RM2020_single_01_0"
                                    title="3rd party ad content"
                                    name="google_ads_iframe_/30128925/RM2020_SINGLE/RM2020_single_01_0" width="300"
                                    height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"
                                    srcdoc="" style="border: 0px; vertical-align: bottom;" data-google-container-id="1"
                                    data-gtm-yt-inspected-1_27="true" data-load-complete="true"></iframe>
                        </div>
                    </div>
                </div>
                <rss-item v-bind="singleRss" class="mt-4"></rss-item>
            </div>
        </div>

    </main>
@endsection
