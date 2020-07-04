<template>
    <div class="d-flex justify-content-center align-items-center h-100">
        <rocker-switch :value="!!value" @change="change" border-color="#2c3034"></rocker-switch>
    </div>
</template>

<script>
    import RockerSwitch from "vue-rocker-switch"

    export default {
        props: {
            channelId: Number,
            value: Number,
        },
        methods: {
            async change(value) {
                const {status, data} = await this.axios.post(this.route('admin.rss.channels.toggle-active', this.channelId), {
                    is_active: value
                })
                if (status === 200) {
                    this.$bus.emit('alert', {text: data.status, variant: value ? 'success' : 'warning'})
                }
            }
        },
        components: {
            RockerSwitch
        }
    }
</script>
