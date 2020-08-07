<template>
    <div class="col-12">
        <create-btn></create-btn>
        <b-overlay :opacity="0.5" :show="isBusy" variant="dark">
            <table class="table table-striped table-hover table-dark table-bordered">
                <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th class="id-column">ID</th>
                    <th>Title</th>
                    <th class="date-column">Created</th>
                    <th class="date-column">Updated</th>
                    <th class="actions-column"></th>
                </tr>
                </thead>
                <draggable @update="sort" handle=".drag" tag="tbody" v-model="items">
                    <tr :key="item.id" v-for="item in items">
                        <td class="vertical-align-center p-0">
                            <div class="drag">
                                <svg-vue icon="hand-rock" style="width:20px;"></svg-vue>
                            </div>
                        </td>
                        <td>{{ item.id }}</td>
                        <td>{{item.title}}</td>
                        <td>{{ item.created_at | moment("DD.MM.YYYY HH:mm") }}</td>
                        <td>{{ item.updated_at | moment("DD.MM.YYYY HH:mm") }}</td>
                        <td>
                            <actions-buttons :id="item.id" @delete="destroy(item.id)"></actions-buttons>
                        </td>
                    </tr>
                </draggable>
            </table>
        </b-overlay>
    </div>
</template>

<script>
    import Draggable from 'vuedraggable'
    import {destroy, index} from '@/mixins/index-table'

    export default {
        data() {
            return {
                items: this.shared('playlists'),
                resource: 'playlists'
            }
        },
        methods: {
            async sort() {
                const order = this.items.map(({id}) => id)
                const {status, data} = await this.axios.post(this.route(`admin.${this.resource}.sort`), {order})
                if (status === 200 && data.status) {
                    this.$bus.emit('alert', {text: data.status})
                }
            }
        },
        mixins: [index, destroy],
        components: {
            Draggable,
        }
    }
</script>
