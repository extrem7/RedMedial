<template>
    <div class="article-archive">
        <a :href="link" class="article-archive-header overflow-box">
            <img :alt="title" class="img-fluid" v-lazy="thumb">
        </a>
        <div class="article-archive-body">
            <a :href="link" class="title">{{ title }}</a>
            <div class="d-flex align-items-center flex-wrap">
                <div class="article-date">{{ createdAt | moment("DD MMMM, YYYY") }}</div>
            </div>
            <div class="article-description line-cap" v-html="excerpt"></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            excerpt: String,
            thumb: String,
            link: String,
            createdAt: String,
        }
    }
</script>
