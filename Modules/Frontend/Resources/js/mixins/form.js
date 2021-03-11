import Invalid from "../components/includes/Invalid"
import {errors} from "../helpers/helpers"

export default {
    data() {
        return {
            errors: {},
            isLoading: false
        }
    },
    methods: {
        async submit() {
            this.isLoading = true
            try {
                const {status, data} = await this.axios.post(this.route('contact-form'), this.form)
                try {
                    if (status === 200) {
                        for (let field in this.form) this.form[field] = ''

                        this.errors = {}

                        this.$bus.emit('alert', {text: data.status})
                    }
                } catch (e) {
                    console.log(e)
                }
            } catch ({response}) {
                this.wasValidated = true
                this.errors = errors(response)
            }
            this.isLoading = false
        }
    },
    directives: {
        valid(el, {modifiers}, {context}) {
            if (Object.keys(modifiers)[0] in context.errors) {
                el.classList.remove('is-valid')
                el.classList.add('is-invalid')
            } else {
                el.classList.remove('is-invalid')
                if (context.wasValidated) {
                    el.classList.add('is-valid')
                } else if (el.classList.contains('is-valid')) {
                    el.classList.remove('is-valid')
                }
            }
        }
    },
    components: {
        Invalid
    }
}
