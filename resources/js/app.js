import Vue from 'vue'

import './plugins'
import './filters'

import components from './components'

import store from './store'

const app = new Vue({
    el: '#app',
    data() {
        return {}
    },
    components,
    store,
    mounted() {
    }
})

store.app = app
