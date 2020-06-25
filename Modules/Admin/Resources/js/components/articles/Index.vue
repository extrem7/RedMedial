<template>
    <div class="col-12">
        <div class="d-flex justify-content-lg-between">
            <create-btn></create-btn>
            <search @search="search" v-model="searchQuery"></search>
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
                    <actions-buttons :id="data.item.id" :resource="resource"
                                     @delete="destroy(data.item.id)"></actions-buttons>
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
    import {datatable} from '@/mixins/index-table'

    export default {
        data() {
            return {
                initialData: this.shared('articles'),
                resource: 'articles',
                fields: [
                    {key: 'id', sortable: true},
                    {key: 'title', sortable: true},
                    {key: 'status', sortable: true},
                    {key: 'created_at', sortable: true},
                    {key: 'updated_at', sortable: true},
                    {key: 'actions', label: '', thClass: 'actions-column'}
                ],
                sortDesc: true,
            }
        },
        mixins: [datatable]
    }
</script>
