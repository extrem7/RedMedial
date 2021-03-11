import InputMaterial from '~/components/includes/InputMaterial'
import {BSpinner} from 'bootstrap-vue'

/** @property form */
export default {
  components: {
    InputMaterial,
    BSpinner
  },
  reactiveProvide: {
    name: 'bag',
    include: ['errors'],
  },
  computed: {
    processing() {
      return this.form.processing
    },
    errors() {
      return this.form.errors
    }
  },
  methods: {
    fillForm(data) {
      for (let key in data) {
        const value = data[key]
        if (this.form.hasOwnProperty(key) && value) {
          this.form[key] = value
        }
      }
    }
  }
}
