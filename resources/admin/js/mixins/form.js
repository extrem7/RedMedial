import Editor from "@/components/includes/Editor"
import Invalid from "@/components/includes/Invalid"

export default {
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
        Editor,
        Invalid
    }
}
