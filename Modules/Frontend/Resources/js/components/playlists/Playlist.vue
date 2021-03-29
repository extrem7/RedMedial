<template>
  <div v-observe-visibility="{once:true,callback:init}"
       class="video-chanel">
    <div class="chanel-name drag">{{ title }}</div>
    <div class="chanel-main-video">
      <Youtube
        v-if="visible"
        ref="youtube"
        :video-id="current.id"
        @ended="change('ended')"
        @paused="change('paused')"
        @playing="change('playing')"/>
    </div>
    <div class="chanel-play-box">
      <div class="play-btn">
        <img :src="`/dist/img/icons/${playing?'pause':'play'}.svg`"
             alt="play"
             @click="playing?pause():play()">
      </div>
      <div class="video-name">{{ current.title }}</div>
      <div class="time">{{ current.time }}</div>
    </div>
    <div class="chanel-video-list">
      <div v-for="({id,title,duration},i) in videos"
           class="video-item"
           @click="play(i)">
        <img v-lazy="`https://img.youtube.com/vi/${id}/default.jpg`"
             :alt="title">
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
  mounted() {
    this.$bus.on('pause-all', id => {
      if (this.id !== id) this.pause()
    })
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
  }
}
</script>
