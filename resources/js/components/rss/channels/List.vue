<template>
    <draggable @update="sort" handle=".drag" tag="div" v-bind="dragOptions" v-model="channels">
        <transition-group class="rss-lists row justify-content-center" name="flip-list" tag="div" type="transition">
            <div :key="channel.id" class="col-xl-3 col-lg-4 col-sm-6 drag" v-for="channel in channels">
                <channel v-bind="channel"></channel>
            </div>
        </transition-group>
    </draggable>
</template>

<script>
    import Draggable from 'vuedraggable'
    import Channel from "./Channel"

    export default {
        props: {
            orderName: String
        },
        data() {
            return {
                channels: [...this.shared('channels')],
                dragOptions: {
                    animation: 200
                },
                orderNameLs: `channels_${this.orderName}_order`
            }
        },
        methods: {
            sort() {
                const order = this.channels.map(({id}) => id)
                this.$ls.set(this.orderNameLs, order)
            }
        },
        created() {
            const order = this.$ls.get(this.orderNameLs)
            if (order !== null && order.length) {
                this.channels = this.channels.sort((a, b) => order.indexOf(a.id) - order.indexOf(b.id))
            }
        },
        components: {
            Draggable,
            Channel
        }
    }
</script>
