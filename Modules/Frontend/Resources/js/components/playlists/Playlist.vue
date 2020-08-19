<template>
    <div class="video-chanel" v-observe-visibility="{once:true,callback:init}">
        <div class="chanel-name drag">{{ title }}</div>
        <div class="chanel-main-video">
            <youtube :video-id="current.id" @ended="change('ended')" @paused="change('paused')"
                     @playing="change('playing')"
                     ref="youtube"
                     v-if="visible"></youtube>
        </div>
        <div class="chanel-play-box">
            <div class="play-btn">
                <img :src="`/dist/img/icons/${playing?'pause':'play'}.svg`" @click="playing?pause():play()" alt="play">
            </div>
            <div class="video-name">{{ current.title }}</div>
            <div class="time">{{ current.time }}</div>
        </div>
        <div class="chanel-video-list">
            <div @click="play(i)" class="video-item" v-for="({id,title,duration},i) in videos">
                <img :alt="title" v-lazy="`https://img.youtube.com/vi/${id}/default.jpg`">
                <div>
                    <div class="video-name">{{ title }}</div>
                    <div class="time">{{ duration }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            id: Number,
            title: String,
            videos: Array
        },
        data() {
            return {
                visible: false,
                index: 0,
                playing: false
            }
        },
        computed: {
            current() {
                return this.videos[this.index]
            }
        },
        methods: {
            init(isVisible) {
                this.visible = isVisible
            },
            change(event) {
                if (['playing', 'buffering'].includes(event)) {
                    this.playing = true
                    this.$bus.emit('pause-all', this.id)
                } else if (['paused', 'ended', 'error'].includes(event)) {
                    this.playing = false
                }
            },
            play(index = null) {
                if (index) this.index = index
                setTimeout(() => {
                    this.$refs.youtube.player.playVideo()
                }, 100)
            },
            pause() {
                this.$refs.youtube.player.pauseVideo()
            }
        },
        mounted() {
            this.$bus.on('pause-all', id => {
                if (this.id !== id) this.pause()
            })
        }
    }
</script>
