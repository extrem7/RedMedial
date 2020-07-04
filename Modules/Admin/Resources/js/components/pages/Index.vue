<template>
    <div class="col-12">
        <create-btn></create-btn>
        <b-overlay :opacity="0.5" :show="isBusy" variant="dark">
            <b-table
                :fields="fields"

                :items="items"
                bordered

                dark
                hover
                ref="table">
                <template v-slot:cell(slug)="data">
                    <a :href="data.item.link" target="_blank">{{data.item.slug}}</a>
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
        </b-overlay>
    </div>
</template>

<script>
    import {destroy, index} from '@/mixins/index-table'

    export default {
        data() {
            return {
                items: this.shared('pages'),
                resource: 'pages',
                fields: [
                    'id',
                    'title',
                    'slug',
                    {key: 'created_at', thClass: 'date-column'},
                    {key: 'updated_at', thClass: 'date-column'},
                    {key: 'actions', label: '', thClass: 'actions-column'}
                ],
            }
        },
        provide() {
            return {
                resource: this.resource,
            }
        },
        mixins: [index, destroy]
    }
</script>
