import Vue from 'vue'
import VueCompositionAPI from '@vue/composition-api'

Vue.use(VueCompositionAPI)

Vue.config.productionTip = false

import IframeCustom from './components/IframeCustom'

new Vue({
  el: '#redmedial',
  components: {
    IframeCustom
  }
})
