import form from "../../mixins/form"

export default {
    data() {
        return {
            title: '',
            slug: '',
            body: '',

            meta_title: '',
            meta_description: '',

            errors: {},
            loading: false,
            wasValidated: false,
        }
    },
    mixins: [form]
}
