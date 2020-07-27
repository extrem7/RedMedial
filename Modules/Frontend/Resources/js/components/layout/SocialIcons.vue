<template>
    <div class="media-block">
        <a :href="social.facebook.link" rel="nofollow" target="_blank">
            <svg-vue icon="facebook"></svg-vue>
        </a>
        <a :href="social.instagram.link" rel="nofollow" target="_blank">
            <svg-vue icon="instagram"></svg-vue>
        </a>
        <a :href="social.twitter.link" rel="nofollow" target="_blank">
            <svg-vue icon="twitter"></svg-vue>
        </a>
        <a :href="social.youtube.link" rel="nofollow" target="_blank">
            <svg-vue icon="play"></svg-vue>
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
