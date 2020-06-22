import vSelect from 'vue-select'

import Editor from "@/components/includes/Editor"
import RedCropper from "@/components/includes/RedCropper"
import Invalid from "@/components/includes/Invalid"

export default {
    data() {
        return {
            email: '',
            name: '',
            password: '',
            role: null,

            files: [],

            roles: [...this.shared('roles')] || [],
            errors: {
                image: null
            },
            loading: false,
            wasValidated: false,

            formConfig: {
                header: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        }
    },
    directives: {
        valid(el, {expression}, {context}) {
            if (expression in context.errors) {
                el.classList.remove('is-valid')
                el.classList.add('is-invalid')
            } else {
                el.classList.remove('is-invalid')
                if (context.wasValidated) el.classList.add('is-valid')
            }
        }
    },
    components: {
        vSelect,

        Editor,
        RedCropper,
        Invalid
    }
}
