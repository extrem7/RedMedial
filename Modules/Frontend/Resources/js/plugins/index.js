import Vue from 'vue'

import {plugin} from '@inertiajs/inertia-vue'

Vue.use(plugin)

import './axios'

import VueBus from 'vue-bus'
import SvgVue from 'svg-vue'
//import './bootstrap'
import './ls'

import route, {Ziggy} from 'ziggy'
import VueLazyload from 'vue-lazyload'
import VueScrollTo from 'vue-scrollto'
import VueObserveVisibility from 'vue-observe-visibility'
import VueYoutube, {Youtube} from 'vue-youtube'
import ReactiveProvide from 'vue-reactive-provide'

Vue.use(VueBus)
Vue.use(SvgVue)
Vue.use(VueLazyload, {
  error: '/dist/img/no-image.jpg',
})
Vue.use(VueScrollTo)
Vue.use(VueObserveVisibility)
Vue.use(VueYoutube)
Vue.component('Youtube', Youtube)
Vue.use(ReactiveProvide)

import {InertiaProgress} from '@inertiajs/progress'

InertiaProgress.init()

Vue.mixin({
  methods: {
    route: (name, params, absolute) => route(name, params, absolute, Ziggy),
    shared: (key) => shared()[key]
  }
})

