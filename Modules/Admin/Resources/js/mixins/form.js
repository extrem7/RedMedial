import Editor from "@/components/includes/forms/Editor"
import Invalid from "@/components/includes/forms/Invalid"
import CardFooter from "@/components/includes/forms/CardFooter"

import {errors} from "@/helpers/helpers"

export default {
    data() {
        return {
            id: null,
            isEdit: false,
            files: [],
            errors: {},
            isLoading: false,
            wasValidated: false,

            formConfig: {
                header: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        }
    },
    methods: {
        setupEdit(name) {
            const model = this.shared(name)
            if (model) {
                this.isEdit = true
                this.id = model.id
                for (let field in this.form) {
                    if (model[field]) this.form[field] = model[field]
                }
                return model
            }
        },
        async send(url, form, multipart = false) {
            this.isLoading = true
            try {
                const {status, data} = await this.axios.post(url, form, multipart ? this.formConfig : null)
                this.wasValidated = false
                this.errors = {}
                return {status, data}
            } catch ({response}) {
                this.wasValidated = true
                this.$bus.emit('alert', {variant: 'warning', text: response.data.message})
                this.errors = errors(response)
            } finally {
                this.isLoading = false
            }
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
        Editor,
        Invalid,
        CardFooter
    }
}
