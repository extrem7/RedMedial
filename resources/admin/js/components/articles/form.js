import vSelect from 'vue-select'

import Editor from "@/components/includes/Editor"
import RedCropper from "@/components/includes/RedCropper"
import Invalid from "@/components/includes/Invalid"

export default {
    data() {
        return {
            title: '',
            slug: '',
            body: '',
            excerpt: '',

            meta_title: '',
            meta_description: '',

            authors: '',
            original: '',

            status: null,

            files: [],

            statuses: this.shared('statuses') || [],
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
