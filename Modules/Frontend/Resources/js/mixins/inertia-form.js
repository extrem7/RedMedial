import InputMaterial from '~/components/includes/InputMaterial'
import {BSpinner} from 'bootstrap-vue'

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
  }
}
