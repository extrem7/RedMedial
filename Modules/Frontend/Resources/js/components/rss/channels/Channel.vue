<template>
  <div class="rss-item">
    <div class="rss-header">
      <a :href="source"
         rel="nofollow"
         target="_blank">
        <img v-lazy="logo"
             :alt="name">
      </a>
      <button v-b-toggle="`channel-${id}`"
              class="icon btn-open-rss">
        <img alt="burger-menu" src="/dist/img/icons/chevron-circle-down.svg">
      </button>
    </div>
    <BCollapse
      :id="`channel-${id}`"
      :visible="first">
      <div class="rss-body">
        <a v-for="post in posts"
           :href="post.source"
           class="rss-link title"
           rel="nofollow"
           target="_blank">
          <div class="title-rss line-cap">{{ post.title }}</div>
          <span class="article-date">{{ formatTime(post.created_at) }}</span>
        </a>
        <a :href="route('rss.channels.show',{channel:slug})"
           class="rss-link title">
          <span class="read-all">View all news {{ name }}
            <img alt="arrow-right" src="/dist/img/icons/arrow-right.svg">
          </span>
        </a>
      </div>
    </BCollapse>
  </div>
</template>

<script>
import {BCollapse, VBToggle} from 'bootstrap-vue'

export default {
  props: {
    id: Number,
    slug: String,
    name: String,
    source: String,
    created_at: String,
    logo: String,
    posts: Array,

    first: Boolean
  },
  directives: {
    'b-toggle': VBToggle
  },
  components: {
    BCollapse,
  },
  methods: {
    formatTime(date) {
      return new Date(date).toLocaleTimeString('default', {hour: '2-digit', minute: '2-digit'})
    }
  }
}
</script>
