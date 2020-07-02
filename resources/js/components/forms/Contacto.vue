<template>
    <form @submit.prevent="submit" class="form-feedback">
        <div class="form-group">
            <input class="form-control" id="name" placeholder=" " type="text" v-model="form.name" v-valid.name>
            <label class="label" for="name">name</label>
            <invalid name="name"></invalid>
        </div>
        <div class="form-group">
            <input class="form-control" id="email" placeholder=" " required type="email" v-model="form.email"
                   v-valid.email>
            <label class="label" for="email">Email</label>
            <invalid name="email"></invalid>
        </div>
        <div class="form-group">
            <textarea class="form-control" placeholder="Text message" rows="6" v-model="form.message"
                      v-valid.message></textarea>
            <invalid name="message"></invalid>
        </div>
        <div class="form-group">
            <button class="btn btn-cyan">
                Send
                <span class="spinner-border spinner-border-sm ml-2" v-if="isLoading"></span>
            </button>
        </div>
    </form>
</template>

<script>
    import form from "~/mixins/form"

    export default {
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    message: '',
                }
            }
        },
        mixins: [form]
    }
</script>

