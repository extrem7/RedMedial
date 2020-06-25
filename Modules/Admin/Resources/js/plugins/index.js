import Vue from 'vue'

import './axios'
import './bootstrap'
import './ls'

import VueBus from 'vue-bus'
import SvgVue from 'svg-vue'
import VueMoment from 'vue-moment'
import VueCookies from 'vue-cookies'
import route, {Ziggy} from 'ziggy'

Vue.use(VueBus)
Vue.use(SvgVue)
Vue.use(VueMoment)
Vue.use(VueCookies)

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
        shared: (key) => shared()[key]
    }
})
