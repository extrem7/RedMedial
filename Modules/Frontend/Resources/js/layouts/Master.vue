<template>
  <div class="pseudo-app">
    <RedHeader/>
    <main class="container container--flex">
      <nav v-if="breadcrumbs && breadcrumbs.length"
           aria-label="breadcrumb"
           class="nav-breadcrumb">
        <ol class="breadcrumb">
          <li v-for="{title,url} in breadcrumbs"
              :class="{active:url}"
              class="breadcrumb-item">
            <a v-if="url" :href="url">{{ title }}</a>
            {{ !url ? title : '' }}
          </li>
        </ol>
      </nav>
      <slot></slot>
    </main>
    <RedFooter/>
    <AlertNotification/>
  </div>
</template>

<script>
import RedHeader from '~/components/layout/Header'
import RedFooter from '~/components/layout/Footer'
import AlertNotification from '~/components/includes/AlertNotification'

export default {
  name: 'MasterLayout',
  components: {
    RedHeader,
    RedFooter,
    AlertNotification
  },
  computed: {
    breadcrumbs() {
      return this.$page.props.breadcrumbs
    }
  }
}
</script>
