import Vue from 'vue'

import './plugins'
import './filters'
import store from './store'

import components from './components'

import MasterLayout from '~/layouts/Master'

const vueOptions = {
  el: '#redmedial',
  components,
  store,
  data() {
    return {
      sidebarChannel: this.shared('sidebarChannel') || null,
      sidebarChannels: this.shared('sidebarChannels') || [],
      sidebarPlaylist: this.shared('sidebarPlaylist') || null,
    }
  },
  created() {
    const user = this.shared('auth')
    if (user) {
      this.$store.commit('setUser', user)
    }
  },
  methods: {
    mapVisible(visible) {
      if (visible) {
        setTimeout(() => {
          const src = `https://www.arcgis.com/apps/opsdashboard/index.html#/`
          this.$refs.map.src = `${src}${window.innerWidth > 768 ? 'bda7594740fd40299423467b48e9ecf6' : '85320e2ea5424dfaaa75ae62e5c06e61'}`
        }, 3000)
      }
    }
  }
}

import {InertiaApp} from '@inertiajs/inertia-vue'

const el = document.getElementById('app')
if (el) {
  vueOptions.render = h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(el.dataset.page),
      resolveComponent: name => import(`./pages/${name}`)
        .then(({default: page}) => {
          page.layout = page.layout === undefined ? MasterLayout : page.layout
          return page
        })
    },
  })
}

new Vue(vueOptions)
