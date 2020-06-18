import Vue from 'vue'

import './axios'

import VueBus from 'vue-bus'
import SvgVue from 'svg-vue'
import './bootstrap'
import './ls'

import route, {Ziggy} from 'ziggy'

Vue.use(VueBus)

Vue.use(SvgVue)

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
        shared: (key) => shared()[key]
    }
})
