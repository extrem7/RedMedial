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
                <template v-slot:cell(created_at)="data">
                    {{ data.item.created_at | moment("DD.MM.YYYY HH:mm") }}
                </template>

                <template v-slot:cell(actions)="data">
                    <actions-buttons :id="data.item.id" :resource="resource"
                                     @delete="destroy(data.item.id)"></actions-buttons>
                </template>
            </b-table>

            <div class="d-flex justify-content-center" v-if="!total && searchQuery.length">
                <b-alert class="w-25 text-center" show variant="warning">No users found</b-alert>
            </div>
        </b-overlay>

        <b-pagination
            :per-page="perPage"
            :total-rows="total"
            v-if="total"
            v-model="currentPage">
        </b-pagination>
    </div>
</template>

<script>
    import {datatable} from '@/mixins/index-table'

    export default {
        data() {
            return {
                initialData: this.shared('users'),
                resource: 'users',
                fields: [
                    {key: 'id', sortable: true},
                    {key: 'email', sortable: true},
                    {key: 'name', sortable: true},
                    {key: 'role'},
                    {key: 'created_at', label: 'Registered at', thClass: 'date-column', sortable: true},
                    {key: 'actions', label: '', thClass: 'actions-column'}
                ],
            }
        },
        mixins: [datatable]
    }
</script>
