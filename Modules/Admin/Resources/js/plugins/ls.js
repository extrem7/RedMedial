import Vue from 'vue'

import Storage from 'vue-ls'

const options = {
    namespace: 'redmedial_admin___',
    name: 'ls',
    storage: 'local',
};

Vue.use(Storage, options)
