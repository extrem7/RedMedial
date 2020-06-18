import Vue from 'vue'

import axios from 'axios'
import VueAxios from 'vue-axios'

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}

Vue.use(VueAxios, axios)
