<template>
  <div class="pseudo-app">
    <RedHeader/>
    <main class="container container--flex">
      <Breadcrumbs
        v-if="breadcrumbs && breadcrumbs.length"
        :items="breadcrumbs"
      />
      <slot></slot>
    </main>
    <RedFooter/>
    <AlertNotification/>
  </div>
</template>

<script>
import RedHeader from '~/components/layout/Header'
import Breadcrumbs from '~/components/layout/Breadcrumbs'
import RedFooter from '~/components/layout/Footer'
import AlertNotification from '~/components/includes/AlertNotification'

export default {
  name: 'MasterLayout',
  components: {
    RedHeader,
    Breadcrumbs,
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
