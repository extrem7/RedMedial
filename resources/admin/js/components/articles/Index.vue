<template>
    <div>
        <b-table
            :busy.async="isBusy"
            :current-page="currentPage"
            :fields="fields"
            :items="items"
            :per-page="perPage"
            bordered
            dark hover ref="table">

            <template v-slot:cell(created_at)="data">
                {{ data.item.created_at | moment("DD.MM.YYYY HH.mm") }}
            </template>
            <template v-slot:cell(updated_at)="data">
                {{ data.item.updated_at | moment("DD.MM.YYYY HH.mm") }}
            </template>

            <template v-slot:cell(actions)="data">
                <div class="d-flex ">
                    <a :href="route('admin.articles.edit',data.item.id)" class="btn btn-outline-primary">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button @click="destroy(data.item.id)" class="btn btn-outline-danger ml-2">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </template>
        </b-table>
        <b-pagination
            :per-page="perPage"
            :total-rows="total"
            v-if="total"
            v-model="currentPage">
        </b-pagination>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                perPage: null,
                currentPage: 1,
                total: null,

                isBusy: false,
                articles: this.shared('articles') || [],

                fields: [
                    'id',
                    'title',
                    'created_at',
                    'updated_at',
                    'actions'
                ],
            }
        },
        methods: {
            async items(ctx) {
                this.isBusy = true
                try {
                    const {data} = await this.axios.get(this.route('admin.articles.index'), {
                        params: {page: ctx.currentPage}
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
            }
        }
    }
</script>
