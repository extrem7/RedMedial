<template>
  <div class="media-block">
    <a :href="social.facebook.link"
       rel="nofollow"
       target="_blank">
      <SvgVue icon="facebook"/>
    </a>
    <a :href="social.instagram.link"
       rel="nofollow"
       target="_blank">
      <SvgVue icon="instagram"/>
    </a>
    <a :href="social.twitter.link"
       rel="nofollow"
       target="_blank">
      <SvgVue icon="twitter"/>
    </a>
    <a :href="social.youtube.link"
       rel="nofollow"
       target="_blank">
      <SvgVue icon="play"/>
    </a>
  </div>
</template>

<script>
export default {
  data() {
    return {
      social: {...this.shared('social')},
    }
  }
}
</script>
