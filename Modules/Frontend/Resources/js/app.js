import Vue from 'vue'
import VueCompositionAPI from '@vue/composition-api'

Vue.use(VueCompositionAPI)

import './plugins'
import './filters'

import store from './store'
import components from './components'

Vue.config.productionTip = false

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
          this.$refs.map.src = `${src}${window.innerWidth > 768
            ? 'bda7594740fd40299423467b48e9ecf6'
            : '85320e2ea5424dfaaa75ae62e5c06e61'}`
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
      resolveComponent: async name => import(`./pages/${name}`)
        .then(async ({default: page}) => {
          if (page.layout === undefined) {
            const master = await import('~/layouts/Master')
            page.layout = master.default
          }

          return page
        })
    },
  })
  vueOptions.mounted = function () {
    this.$inertia.on('navigate', (event) => {
      const {meta: {title}} = event.detail.page.props
      document.title = `${title} - Red Medial`
    })

    const events = ['success', 'error']
    events.forEach((eventType) => {
      this.$inertia.on(eventType, (event) => {
        const {flash} = event.detail.page.props

        if (flash.message !== undefined) {
          this.$bus.emit('alert', {text: flash.message})
        }
        if (flash.error !== undefined) {
          this.$bus.emit('alert', {text: flash.error, variant: 'warning'})
        }
      })
    })
  }
}

new Vue(vueOptions)
