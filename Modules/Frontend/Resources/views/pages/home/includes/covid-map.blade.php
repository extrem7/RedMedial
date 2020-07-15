<div class="container">
    <div class="title red-color text-center medium-size line">Coronavirus Map</div>
    <iframe id="covid-map"
            src="https://www.arcgis.com/apps/opsdashboard/index.html#/bda7594740fd40299423467b48e9ecf6"
            frameborder="0" width="100%" height="700"></iframe>

    <div class="text-center mt-3 mb-3">
        <a href="#" class="red-color copy-iframe">
            <img src="{{asset('dist/img/icons/copy.svg')}}" alt="copy" class="mr-2" style="width: 12px;">
            copy map iframe
        </a>
        <copy-iframe text="copy map iframe"
                     iframe='<iframe src="https://redmedial.com/covidmap-iframe" frameborder="0" width="100%" height="820px"></iframe>'></copy-iframe>
    </div>
</div>
