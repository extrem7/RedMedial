<template>
    <div class="col-lg-8">
        <b-overlay :opacity="0.5" :show="isBusy" variant="dark">
            <table class="table table-striped table-hover table-dark table-bordered">
                <draggable @update="sort" handle=".drag" tag="tbody" v-model="items">
                    <tr :key="item.id" v-for="item in items">
                        <td class="vertical-align-center p-0">
                            <div class="drag">
                                <svg-vue icon="hand-rock" style="width:20px;"></svg-vue>
                            </div>
                        </td>
                        <td>{{ item.id }}</td>
                        <td>{{item.name}}</td>
                    </tr>
                </draggable>
            </table>
        </b-overlay>
    </div>
</template>

<script>
    import Draggable from 'vuedraggable'

    export default {
        data() {
            return {
                items: this.shared('channels'),
                resource: 'rss.channels',
                isBusy: false
            }
        },
        methods: {
            async sort() {
                this.isBusy = true
                const order = this.items.map(({id}) => id)
                try {
                    const {status, data} = await this.axios.post(this.route(`admin.${this.resource}.sort`), {order})
                    if (status === 200 && data.status) {
                        this.$bus.emit('alert', {text: data.status})
                    }
                } catch (e) {
                    console.log(e)
                } finally {
                    this.isBusy = false
                }
            }
        },
        components: {
            Draggable,
        }
    }
</script>
