import Vue from 'vue'

import './axios'

import VueBus from 'vue-bus'
import SvgVue from 'svg-vue'
//import './bootstrap'
import './ls'

import route, {Ziggy} from 'ziggy'
import VueMoment from "vue-moment"
import VueLazyload from 'vue-lazyload'
import VueScrollTo from 'vue-scrollto'
import VueObserveVisibility from 'vue-observe-visibility'

Vue.use(VueBus)
Vue.use(SvgVue)
Vue.use(VueMoment)
Vue.use(VueLazyload)
Vue.use(VueScrollTo)
Vue.use(VueObserveVisibility)

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
        shared: (key) => shared()[key]
    }
})

