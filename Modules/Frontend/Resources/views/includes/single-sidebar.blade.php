<div class="col-xl-3 col-lg-4 indent-sm">
    <div class="ads-single mb-4">
        <div id='div-gpt-ad-RM2020-01'></div>
    </div>

    <playlist v-bind="sidebarPlaylist" class="mb-4"></playlist>
    <rss-item v-bind="sidebarChannel"></rss-item>
    <social></social>

    <div class="ads-single mb-4">
        <div id='div-gpt-ad-RM2020-04'></div>
    </div>

    @include('frontend::articles.includes.app-stores')
</div>

@push('scripts')
    <script>
        googletag.cmd.push(function () {
            googletag.pubads().display('/30128925/RM2020_SINGLE/RM2020_single_01', [300, 250], 'div-gpt-ad-RM2020-01')
            googletag.pubads().display('/30128925/RM2020_SINGLE/RM2020_single_04', [300, 250], 'div-gpt-ad-RM2020-04')
        });
    </script>
@endpush
