<template>
    <div class="col-xl-9 col-lg-8">
        <div class="article-list" id="article-list">
            <b-overlay :opacity="0.9" :show="isLoading" variant="white">
                <item :key="article.id" v-bind="article" v-for="article in articles"></item>
            </b-overlay>
        </div>
        <nav class="navigation pagination" role="navigation">
            <div class="nav-links">
                <a :href="link(page-1)" @click.prevent="load(false)" class="prev page-numbers"
                   v-scroll-to="{ el: '#article-list', offset: -100 }"
                   v-if="page>1">previous</a>
                <a :href="link(page+1)" @click.prevent="load" class="next page-numbers"
                   v-if="page<lastPage" v-scroll-to="{ el: '#article-list', offset: -100 }">Next</a>
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
                page: articles.currentPage || 1,
                lastPage: articles.lastPage,
                isLoading: false,
                currentRoute: null
            }
        },
        methods: {
            async load(next = true) {
                this.isLoading = true
                this.page = next ? this.page + 1 : this.page - 1
                try {
                    const response = await this.axios.get(this.link(this.page))
                    this.articles = response.data.data
                    window.history.pushState('', '', this.link(this.page))
                } catch (e) {
                    console.log(e)
                }
                setTimeout(() => {
                    this.isLoading = false
                }, 100)

            },
            link(page) {
                const routeParams = {}
                if (this.currentRoute.includes('channel')) {
                    routeParams.channel = this.shared('channel').slug
                } else if (this.currentRoute.includes('search')) {
                    routeParams.query = this.shared('query')
                }

                if (page === 1) return this.route(this.currentRoute, routeParams)

                routeParams.page = page
                return this.route(this.currentRoute + '.page', routeParams)
            }
        },
        created() {
            this.currentRoute = this.route().current().replace('.page', '')
        },
        components: {
            BOverlay,
            Item
        }
    }
</script>
