<div class="col-xl-3 col-lg-4 indent-sm">
    @include('frontend::articles.includes.ads-single')
    <playlist v-bind="sidebarPlaylist" class="mb-4"></playlist>
    <rss-item v-bind="sidebarChannel"></rss-item>
    <social></social>
    @include('frontend::articles.includes.ads-single')
    @include('frontend::articles.includes.app-stores')
</div>
