<template>
    <b-overlay :opacity="0.9" :show="isLoading" variant="white">
        <draggable :disabled="disabled" @update="sort" handle=".drag" tag="div" v-bind="dragOptions" v-model="channels">
            <transition-group class="rss-lists row justify-content-center" name="flip-list" tag="div" type="transition">
                <div :key="channel.id" class="col-xl-3 col-lg-4 col-sm-6 drag" v-for="channel in channels">
                    <channel v-bind="channel"></channel>
                </div>
            </transition-group>
        </draggable>
        <div class="text-center" v-if="page<lastPage">
            <button @click="load" class="btn btn-cyan">
                Load more
                <span class="spinner-border spinner-border-sm ml-2" v-if="isLoading"></span>
            </button>
        </div>
    </b-overlay>
</template>

<script>
    import {BOverlay} from 'bootstrap-vue'
    import Draggable from 'vuedraggable'
    import Channel from "./Channel"

    export default {
        props: {
            withPagination: false,
            sharedKey: {
                type: String,
                default: 'channels'
            },
            orderName: String
        },
        data() {
            const shared = this.shared(this.sharedKey)
            return {
                channels: this.withPagination ? [...shared.data] : [...shared],
                dragOptions: {
                    animation: 200
                },
                orderNameLs: `channels_${this.orderName}_order`,
                disabled: this.withPagination,

                page: 1,
                lastPage: this.withPagination ? shared.last_page : 1,
                isLoading: false
            }
        },
        methods: {
            sort() {
                const order = this.channels.map(({id}) => id)
                this.$ls.set(this.orderNameLs, order)
            },
            async load() {
                this.isLoading = true
                this.page += 1
                try {
                    const response = await this.axios.get(`?page=${this.page}`)
                    this.channels = [...this.channels, ...response.data.data]
                } catch (e) {
                    console.log(e)
                }
                setTimeout(() => {
                    this.isLoading = false
                }, 100)

            }
        },
        created() {
            const order = this.$ls.get(this.orderNameLs)
            if (order !== null && order.length) {
                this.channels = this.channels.sort((a, b) => order.indexOf(a.id) - order.indexOf(b.id))
            }
        },
        components: {
            BOverlay,
            Draggable,
            Channel
        }
    }
</script>
