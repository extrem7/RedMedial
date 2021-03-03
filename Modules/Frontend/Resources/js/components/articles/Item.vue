<template>
  <div class="article-archive">
    <a :href="link"
       :target="target"
       class="article-archive-header overflow-box">
      <img v-lazy="thumb"
           :alt="title"
           class="img-fluid">
    </a>
    <div class="article-archive-body">
      <a :href="link"
         :target="target"
         class="title">
        {{ title }}
      </a>
      <div class="d-flex align-items-center flex-wrap">
        <div class="article-date">
          {{ formatDate(createdAt) }}
        </div>
      </div>
      <div class="article-description line-cap" v-html="excerpt"/>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
    excerpt: String,
    thumb: String,
    link: String,
    createdAt: String,

    isChannel: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    target() {
      return this.isChannel ? '_blank' : ''
    }
  },
  methods: {
    formatDate(date) {
      const d = new Date(date)
      return `${d.getDate()} ${d.toLocaleDateString('en', {month: 'long'})}, ${d.getFullYear()}`
    }
  }
}
</script>
