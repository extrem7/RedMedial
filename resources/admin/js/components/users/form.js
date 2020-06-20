import VueUploadComponent from 'vue-upload-component'
import vSelect from 'vue-select'

import Editor from "@/components/includes/Editor"
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
    methods: {
        inputFile: function (newFile, oldFile) {
            if (newFile && oldFile && !newFile.active && oldFile.active) {
                // Get response data
                console.log('response', newFile.response)
                if (newFile.xhr) {
                    //  Get the response status code
                    console.log('status', newFile.xhr.status)
                }
            }
        },
        inputFilter: function (newFile, oldFile, prevent) {
            if (newFile && !oldFile) {
                // Filter non-image file
                if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
                    return prevent()
                }
            }

            // Create a blob field
            newFile.blob = ''
            let URL = window.URL || window.webkitURL
            if (URL && URL.createObjectURL) {
                newFile.blob = URL.createObjectURL(newFile.file)
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
        VueUploadComponent,
        vSelect,

        Editor,
        Invalid
    }
}
