<template>
  <div class="share-widget">
    <a class="share-widget-item share-facebook"
       @click.prevent="popup(`https://www.facebook.com/sharer/sharer.php?u=${link}`)">
      <img alt="facebook"
           src="/dist/img/icons/facebook-share.svg">
    </a>
    <a class="share-widget-item share-twitter"
       @click.prevent="popup(`https://twitter.com/intent/tweet?url=${link}`)">
      <img alt="twitter"
           src="/dist/img/icons/twitter-share.svg">
    </a>
    <a class="share-widget-item share-pinterest"
       @click.prevent="popup(`http://pinterest.com/pin/create/button/?url=${link}&media=${image}`)">
      <img alt="pinterest"
           src="/dist/img/icons/pinterest-share.svg">
    </a>
    <a class="share-widget-item share-linkedin"
       @click.prevent="popup(`https://www.linkedin.com/shareArticle?mini=true&url=${link}`)">
      <img alt="linkedin"
           src="/dist/img/icons/linkedin-share.svg">
    </a>
  </div>
</template>

<script>
export default {
  data() {
    const article = this.shared('article')
    return {
      link: article.link,
      image: article.image
    }
  },
  methods: {
    popup(url) {
      const popupSize = {
        width: 780,
        height: 550
      }

      const popupPosition = {
        vertical: Math.floor((window.innerWidth - popupSize.width) / 2),
        horizontal: Math.floor((window.innerHeight - popupSize.height) / 2)
      }

      const popup = window.open(url, 'social',
        'width=' + popupSize.width + ',height=' + popupSize.height +
        ',left=' + popupPosition.vertical + ',top=' + popupPosition.horizontal +
        ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1')

      if (popup) {
        popup.focus()
      }
    }
  }
}
</script>
