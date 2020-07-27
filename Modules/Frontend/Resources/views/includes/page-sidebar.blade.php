<div class="col-xl-3 col-lg-4 indent-sm">
    <div>
        <social></social>
    </div>
    <rss-item v-bind="sidebarChannels[0]" class="mt-4"></rss-item>
    <div class="ads-single mt-4">
        @include('frontend::articles.includes.banner-bottom')
    </div>
    <rss-item v-bind="sidebarChannels[1]" class="mt-4"></rss-item>
</div>
