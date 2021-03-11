<template>
  <div class="pseudo-app">
    <RedHeader/>
    <div class="cabinet-wrapper flex-fill container">
      <div class="row cabinet-wrapper__row">
        <Sidebar
          :class="{'sidebar--open' : isSidebarOpen}"
          class="col-xl-3 col-lg-4 sidebar sidebar--mobile"
          @close="isSidebarOpen = false"
        />
        <main class="col-xl-9 col-lg-8 cabinet-content">
          <Breadcrumbs
            v-if="breadcrumbs && breadcrumbs.length"
            :items="breadcrumbs"
          />
          <h1 class="page-title title title--cyan">{{ title }}</h1>
          <slot></slot>
        </main>
      </div>
    </div>
    <RedFooter class="footer--has-btn-mobile"/>
    <AlertNotification/>
    <button
      class="btn btn-cyan btn-mobile-sidebar"
      @click="isSidebarOpen = !isSidebarOpen"
    >
      Menu
    </button>
    <div
      :class="{'overlay--open' : isSidebarOpen}"
      class="overlay"
      @click="isSidebarOpen = !isSidebarOpen"
    />
  </div>
</template>

<script>
import RedHeader from '~/components/layout/Header'
import Breadcrumbs from '~/components/layout/Breadcrumbs'
import Sidebar from '~/components/layout/Sidebar'
import RedFooter from '~/components/layout/Footer'
import AlertNotification from '~/components/includes/AlertNotification'

export default {
  name: 'AccountLayout',
  components: {
    RedHeader,
    Breadcrumbs,
    Sidebar,
    RedFooter,
    AlertNotification
  },
  data() {
    return {
      isSidebarOpen: false
    }
  },
  computed: {
    breadcrumbs() {
      return this.$page.props.breadcrumbs
    },
    title() {
      return this.$page.props.meta.title
    }
  }
}
</script>
