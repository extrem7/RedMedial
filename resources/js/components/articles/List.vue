<template>
    <div class="col-xl-9 col-lg-8">
        <div class="article-list">
            <b-overlay :opacity="0.9" :show="isLoading" variant="white">
                <item :key="article.id" v-bind="article" v-for="article in articles"></item>
            </b-overlay>
        </div>
        <nav class="navigation pagination" role="navigation">
            <div class="nav-links">
                <a @click.prevent="load(false)" class="prev page-numbers" href="#" v-if="page>1">previous</a>
                <a @click.prevent="load" class="next page-numbers" href="#" v-if="page<lastPage">Next</a>
            </div>
        </nav>
    </div>
</template>

<script>
    import {BOverlay} from 'bootstrap-vue'

    import Item from "./Item"

    export default {
        data() {
            const articles = this.shared('articles')
            return {
                articles: articles.data,
                page: 1,
                lastPage: articles.lastPage,
                isLoading: false
            }
        },
        methods: {
            async load(next = true) {
                this.isLoading = true
                this.page = next ? this.page + 1 : this.page - 1
                try {
                    const response = await this.axios.get(`?page=${this.page}`)
                    this.articles = response.data.data
                } catch (e) {
                    console.log(e)
                }
                setTimeout(() => {
                    this.isLoading = false
                }, 100)

            }
        },
        components: {
            BOverlay,
            Item
        }
    }
</script>
