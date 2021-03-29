<template>
  <div class="cabinet-content__inner cabinet-content__inner--sm-indent">
    <div class="wave">
      <div class="wave-one"></div>
    </div>
    <div class="row rss-xml">
      <div
        v-for="{title,feeds} in categories"
        class="col-md-4 col-6 rss-xml__item"
      >
        <div class="semi-bold text-uppercase">{{ title }}</div>
        <div class="rss-links">
          <a
            v-for="{name,link} in feeds"
            :href="link"
            class="link link--inherit rss-links__item"
            target="_blank"
          >
            {{ name }}
            <img alt="arrow" class="rss-links__item-arrow" src="/dist/img/icons/arrow-right-thin.svg">
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AccountLayout from '~/layouts/Account'

export default {
  props: {
    categories: Array
  },
  layout: AccountLayout
}
</script>
