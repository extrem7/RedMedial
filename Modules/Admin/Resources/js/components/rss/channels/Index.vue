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
                <template v-slot:cell(name)="{item}">
                    <a :href="route('frontend.rss.channels.show',{channel:item.slug})" target="_blank">{{item.name}}</a>
                </template>
                <template v-slot:cell(is_active)="data">
                    <active-switcher :channel-id="data.item.id" :value="data.item.is_active"></active-switcher>
                </template>
                <template v-slot:cell(last_run)="data">
                    {{ data.item.last_run | moment("DD.MM.YYYY HH:mm:ss")}}
                </template>
                <template v-slot:cell(country)="{item}">
                    <a :href="route('admin.rss.countries.edit',item.country.id)" target="_blank" v-if="item.country">{{item.country.name}}</a>
                </template>
                <template v-slot:cell(created_at)="data">
                    {{ data.item.created_at | moment("DD.MM.YYYY HH:mm") }}
                </template>

                <template v-slot:cell(actions)="data">
                    <actions-buttons :id="data.item.id" @delete="destroy(data.item.id,true)"></actions-buttons>
                </template>
            </b-table>

            <div class="d-flex justify-content-center" v-if="!total && searchQuery.length">
                <b-alert class="w-25 text-center" show variant="warning">No channels found</b-alert>
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
    import ActiveSwitcher from "./ActiveSwitcher"
    import {datatable} from '@/mixins/index-table'

    export default {
        data() {
            return {
                initialData: this.shared('channels'),
                resource: 'rss.channels',
                fields: [
                    {key: 'id', sortable: true},
                    {key: 'name', sortable: true},
                    {
                        key: 'is_active',
                        thClass: 'd-flex justify-content-center',
                        tdClass: 'p-0 vertical-align-center',
                        sortable: true
                    },
                    {key: 'last_run', thClass: 'date-column'},
                    {key: 'country', sortable: true},
                    {key: 'posts_count', label: 'Posts', sortable: true},
                    {key: 'created_at', thClass: 'date-column', sortable: true},
                    {key: 'actions', label: '', thClass: 'actions-column'}
                ],
            }
        },
        mixins: [datatable],
        components: {
            ActiveSwitcher
        }
    }
</script>
