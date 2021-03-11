<template>
    <div class="col-xl-9 col-lg-8">
        <div class="article-list" id="article-list">
            <BOverlay
                :opacity="0.9"
                :show="isLoading"
                variant="white">
                <Item
                  v-for="article in articles"
                  :key="article.id"
                  v-bind="article"
                  :is-channel="!currentRoute.includes('articles')"/>
            </BOverlay>
        </div>
        <nav class="navigation pagination" role="navigation">
            <div class="nav-links">
                <a :href="link(page-1)"
                   class="prev page-numbers"
                   @click.prevent="load(false)"
                   v-scroll-to="{ el: '#article-list', offset: -100 }"
                   v-if="page>1">previous</a>
                <a v-if="page<lastPage"
                   v-scroll-to="{ el: '#article-list', offset: -100 }"
                   :href="link(page+1)"
                   class="next page-numbers"
                   @click.prevent="load">Next</a>
            </div>
        </nav>
    </div>
</template>

<script>
import {BOverlay} from 'bootstrap-vue'
import Item from "./Item"

export default {
    components: {
        BOverlay,
        Item
    },
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
    created() {
        this.currentRoute = this.route().current().replace('.page', '')
    },
    methods: {
        async load(next = true) {
            this.isLoading = true
            this.page = next ? this.page + 1 : this.page - 1
            try {
                const response = await this.axios.get(this.link(this.page))
                this.articles = response.data.data.data
                window.history.pushState('', '', this.link(this.page, true))
            } catch (e) {
                console.log(e)
            }
            setTimeout(() => {
                this.isLoading = false
            }, 200)

        },
        link(page, hack = false) {
            const routeParams = {}

            if (!hack) routeParams.api_life_hack = 1

            if (this.currentRoute.includes('channels')) {
                routeParams.channel = this.shared('channel').slug
            } else if (this.currentRoute.includes('categories')) {
                routeParams.category = this.shared('category').slug
            } else if (this.currentRoute.includes('search')) {
                routeParams.query = this.shared('query')
            }

            if (page === 1) return this.route(this.currentRoute, routeParams)

            routeParams.page = page
            return this.route(this.currentRoute + '.page', routeParams)
        }
    }
}
</script>
