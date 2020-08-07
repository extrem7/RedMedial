<template>
    <div class="video-field row">
        <div class="form-group col-md-8">
            <input class="form-control" placeholder="Title" v-model="video.title">
        </div>
        <div class="form-group col-md-2">
            <input class="form-control" placeholder="ID" v-model="video.id">
        </div>
        <div class="form-group col-md-2">
            <input class="form-control" placeholder="Duration" v-model="video.duration">
        </div>
    </div>
</template>
<script>
    export default {
        name: 'video',
        props: {
            value: {
                type: Object,
                required: true
            }
        },
        computed: {
            video: {
                get() {
                    return this.value
                },
                set(video) {
                    this.$emit('input', video)
                }
            }
        }
    }
</script>
