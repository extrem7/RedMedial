<template>
    <draggable @update="sort" handle=".drag" tag="div" v-bind="dragOptions" v-model="playlists">
        <transition-group class="row" name="flip-list" tag="div" type="transition">
            <div :key="playlist.id" class="col-md-4" v-for="playlist in playlists">
                <playlist v-bind="playlist"></playlist>
            </div>
        </transition-group>
    </draggable>
</template>

<script>
    import Draggable from 'vuedraggable'
    import Playlist from "./Playlist"

    export default {
        props: {
            orderName: String
        },
        data() {
            return {
                playlists: this.shared('playlists'),

                orderNameLs: `playlists_${this.orderName}_order`,
                dragOptions: {
                    animation: 200
                },
            }
        },
        methods: {
            sort() {
                const order = this.playlists.map(({id}) => id)
                this.$ls.set(this.orderNameLs, order)
            },
        },
        created() {
            const order = this.$ls.get(this.orderNameLs)
            if (order !== null && order.length) {
                this.playlists = this.playlists.sort((a, b) => order.indexOf(a.id) - order.indexOf(b.id))
            }
        },
        components: {
            Draggable,
            Playlist
        }
    }
</script>
