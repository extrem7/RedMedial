<section class="container d-none d-lg-block">
    <h2 class="title red-color text-center medium-size line">Coronavirus Map</h2>
    <iframe id="covid-map"
            ref="map" v-observe-visibility="{once:true,callback:mapVisible}"></iframe>

    <div class="text-center mt-3 mb-3">
        <copy-iframe text="copy map iframe"
                     iframe='<iframe src="https://redmedial.com/covidmap-iframe" frameborder="0" width="100%" height="820px"></iframe>'></copy-iframe>
    </div>
</section>
