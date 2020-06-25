<template>
    <div class="col-12">
        <div class="d-flex justify-content-lg-between">
            <div class="form-group">
                <a :href="route('admin.articles.create')" class="btn btn-outline-success">Create</a>
            </div>
            <form @submit.prevent="search" class="form-group w-25 d-flex">
                <input class="form-control" placeholder="Search" type="search" v-model="searchQuery">
                <button class="btn btn-outline-primary ml-1">Search</button>
            </form>
        </div>

        <b-overlay :opacity="0.5" :show="isBusy" variant="dark">
            <b-table
                :busy.async="isBusy"
                :current-page="currentPage"

                :fields="fields"
                :items="items"

                :per-page="perPage"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"

                bordered
                dark
                hover

                ref="table"
                sort-icon-left
                v-show="total">
                <template v-slot:cell(title)="data">
                    <a :href="data.item.link" target="_blank">{{data.item.title}}</a>
                </template>
                <template v-slot:cell(created_at)="data">
                    {{ data.item.created_at | moment("DD.MM.YYYY HH:mm") }}
                </template>
                <template v-slot:cell(updated_at)="data">
                    {{ data.item.updated_at | moment("DD.MM.YYYY HH:mm") }}
                </template>

                <template v-slot:cell(actions)="data">
                    <div class="d-flex">
                        <a :href="route('admin.articles.edit',data.item.id)" class="btn btn-outline-primary">
                            Edit
                        </a>
                        <button @click="destroy(data.item.id)" class="btn btn-outline-danger ml-2">
                            Delete
                        </button>
                    </div>
                </template>
            </b-table>

            <div class="d-flex justify-content-center" v-if="!total && searchQuery.length">
                <b-alert class="w-25 text-center" show variant="warning">No articles found</b-alert>
            </div>
        </b-overlay>

        <b-pagination
            v-if="total"
            :per-page="perPage"
            :total-rows="total"
            v-model="currentPage">
        </b-pagination>
    </div>
</template>

<script>
    export default {
        data() {
            const initial = this.shared('articles')
            return {
                initial: initial.data,
                initialized: false,

                searchQuery: '',

                perPage: initial.per_page,
                currentPage: 1,

                sortBy: 'id',
                sortDesc: true,

                total: initial.total,

                isBusy: false,
                articles: this.shared('articles') || [],

                fields: [
                    {key: 'id', sortable: true},
                    {key: 'title', sortable: true},
                    {key: 'status', sortable: true},
                    {key: 'created_at', sortable: true},
                    {key: 'updated_at', sortable: true},
                    {key: 'actions', label: '', thClass: 'actions-column'}
                ],
            }
        },
        methods: {
            async items(ctx) {
                if (!this.initialized) {
                    this.initialized = true
                    console.log('init', this.initial)
                    return this.initial
                }
                this.isBusy = true
                try {
                    const {data} = await this.axios.get(this.route('admin.articles.index'), {
                        params: {
                            searchQuery: this.searchQuery,
                            page: ctx.currentPage,
                            sortBy: ctx.sortBy,
                            sortDesc: +ctx.sortDesc
                        },
                    })
                    this.isBusy = false

                    this.perPage = data.per_page
                    this.total = data.total

                    return data.data
                } catch (error) {
                    this.isBusy = false
                    return []
                }
            },
            async destroy(id) {
                const {status, data} = await this.axios.delete(this.route('admin.articles.destroy', id))
                if (status === 200) {
                    this.$bus.emit('alert', {text: data.status})
                    this.$refs.table.refresh()
                }
            },
            search() {
                this.$refs.table.refresh()
            },
            resetPage() {
                this.currentPage = 1
            }
        },
        watch: {
            sortBy: 'resetPage',
            sortDesc: 'resetPage',
        }
    }
</script>
