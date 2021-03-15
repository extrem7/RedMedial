<template>
  <div
    :style="styles"
    class="iframe-box"
  >
    <div
      v-if="title"
      class="iframe-box__title"
    >
      {{ title }}
    </div>
    <div class="iframe-grid inline-block-xs">
      <div
        v-for="{title,link,thumb,createdAt} in posts"
        class="article-card">
        <a
          :href="link"
          class="article-card__header"
          rel="nofollow"
          target="_blank"
        >
          <img
            :src="thumb"
            class="article-card__img"
          >
        </a>
        <div class="article-card__body">
          <a class="article-card__category" href="https://redmedial.com/countries/ucrania">Ucrania</a>
          <a
            :href="link"
            class="article-card__title"
            rel="nofollow"
            target="_blank"
          >
            {{ title }}
          </a>
          <div class="article-card__footer">
            <a
              :href="link"
              class="read-all"
            >
              Read more
            </a>
            <div class="article-card__date">{{ formatDate(createdAt) }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {formatDate} from '~/use'

export default {
  setup() {
    return {formatDate}
  },
  data() {
    return {
      ...shared('options'),
      posts: shared('posts')
    }
  },
  computed: {
    styles() {
      return {
        '--iframeBorderColor': this.borderColor || '#c7c9cb',
        '--iframeBorderStyle': this.borderType || 'solid',
        '--iframeBorderWidth': this.borderSize ? `${this.borderSize}px` : '1px'
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@import "../../scss/iframe";
</style>

<style>

*, :after, :before {
  box-sizing: border-box;
}

html {
  font-family: sans-serif;
  line-height: 1.15;
  -webkit-text-size-adjust: 100%;
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
}

body {
  margin: 0;
  font-family: 'Open Sans', sans-serif;
  font-weight: 400;
  font-size: 14px;
  line-height: 1.5;
  background-color: #fff;
}
</style>
