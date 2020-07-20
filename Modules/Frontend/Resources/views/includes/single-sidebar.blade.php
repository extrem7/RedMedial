<div class="col-xl-3 col-lg-4 indent-sm">
    @include('frontend::articles.includes.ads-single')
    <youtube-player :player="singleYoutube" class="mb-4"></youtube-player>
    <rss-item v-bind="singleRss"></rss-item>
    <social></social>
    @include('frontend::articles.includes.ads-single')
    @include('frontend::articles.includes.app-stores')
</div>
