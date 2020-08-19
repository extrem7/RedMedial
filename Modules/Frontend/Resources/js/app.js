import Vue from 'vue'

import './plugins'
import './filters'

import components from './components'

const app = new Vue({
    el: '#app',
    data() {
        return {
            sidebarChannel: this.shared('sidebarChannel') || null,
            sidebarChannels: this.shared('sidebarChannels') || [],
            sidebarPlaylist: this.shared('sidebarPlaylist') || null,
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
    },
    components,
})
