<template>
    <div class="rss-item">
        <div class="rss-header">
            <a :href="source" rel="nofollow" target="_blank">
                <img :alt="name" v-lazy="logo">
            </a>
            <button class="icon btn-open-rss" v-b-toggle="`channel-${id}`">
                <img alt="burger-menu" src="/dist/img/icons/chevron-circle-down.svg">
            </button>
        </div>
        <b-collapse :id="`channel-${id}`" :visible="first">
            <div class="rss-body">
                <a :href="post.source" class="rss-link title" rel="nofollow" target="_blank" v-for="post in posts">
                    <div class="title-rss line-cap">{{ post.title }}</div>
                    <span class="article-date">{{ post.created_at | moment("HH:mm") }}</span>
                </a>
                <a :href="route('frontend.rss.channels.show',{channel:slug})" class="rss-link title">
                    <span class="read-all">View all news {{ name }}
                        <img alt="arrow-right" src="/dist/img/icons/arrow-right.svg"></span>
                </a>
            </div>
        </b-collapse>
    </div>
</template>

<script>
    import {BCollapse, VBToggle} from 'bootstrap-vue'

    export default {
        props: {
            id: Number,
            slug: String,
            name: String,
            source: String,
            created_at: String,
            logo: String,
            posts: Array,

            first: Boolean
        },
        directives: {
            'b-toggle': VBToggle
        },
        components: {
            BCollapse,
        }
    }
</script>
