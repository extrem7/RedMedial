<template>
    <div class="col-12">
        <div class="form-group">
            <a :href="route('admin.pages.create')" class="btn btn-outline-success">Create</a>
        </div>
        <b-table
            :fields="fields"

            :items="pages"
            bordered

            dark
            hover
            ref="table">
            <template v-slot:cell(created_at)="data">
                {{ data.item.created_at | moment("DD.MM.YYYY HH:mm") }}
            </template>
            <template v-slot:cell(updated_at)="data">
                {{ data.item.updated_at | moment("DD.MM.YYYY HH:mm") }}
            </template>

            <template v-slot:cell(actions)="data">
                <div class="d-flex">
                    <a :href="route('admin.pages.edit',data.item.id)" class="btn btn-outline-primary">
                        Edit
                    </a>
                    <button @click="destroy(data.item.id)" class="btn btn-outline-danger ml-2">
                        Delete
                    </button>
                </div>
            </template>
        </b-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                pages: this.shared('pages') || [],

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
        methods: {
            async destroy(id) {
                const {status, data} = await this.axios.delete(this.route('admin.pages.destroy', id))
                if (status === 200) {
                    this.$bus.emit('alert', {text: data.status})
                    this.pages = this.pages.filter(page => page.id !== id)
                }
            },

        }
    }
</script>
