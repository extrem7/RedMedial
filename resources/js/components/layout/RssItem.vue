<template>
    <div class="rss-item">
        <div class="rss-header">
            <a :href="rss.link" target="_blank">
                <img :alt="rss.alt" :src="rss.img">
            </a>
            <button class="icon btn-open-rss" v-b-toggle="`rss-${i}`"><img alt="burger-menu"
                                                                           src="/dist/img/icons/chevron-circle-down.svg">
            </button>
        </div>
        <b-collapse :id="`rss-${i}`">
            <div class="rss-body">
                <a :href="news.link" class="rss-link title" target="_blank" v-for="news in rss.news">
                    <div class="title-rss line-cap">{{ news.name }}</div>
                    <span class="article-date">{{ news.time }}</span>
                </a>
                <a :href="rss.linkArchive" class="rss-link title">
                    <span class="read-all">View all news {{ rss.name }} <img alt="arrow-right"
                                                                             src="/dist/img/icons/arrow-right.svg"></span>
                </a>
            </div>
        </b-collapse>
    </div>
</template>

<script>
    export default {
        props: ['rss', 'i'],
    }
</script>

<style>

</style>
