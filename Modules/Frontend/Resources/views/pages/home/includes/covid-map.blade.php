@if(isset($iframe))
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{mix('dist/css/app.css')}}" rel="stylesheet">
    <div id="app">
        @endif

        <section class="container">
            <h2 class="title red-color text-center medium-size line">Coronavirus Map</h2>
            <iframe id="covid-map"
                    ref="map" v-observe-visibility="{once:true,callback:mapVisible}"></iframe>

            <div class="text-center mt-3 mb-3">
                <copy-iframe text="copy map iframe"
                             iframe='<iframe src="http://redmedial.loc/iframe/covid-map" frameborder="0" width="100%" height="820px"></iframe>'></copy-iframe>
            </div>
        </section>

        @if(isset($iframe))
            <alert-notification></alert-notification>
    </div>
    @shared
    @routes('frontend')
    <script src="{{mix('dist/js/app.js')}}"></script>
@endif
