<template>
    <form @submit.prevent="submit" class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" id="email" placeholder="Email" type="email"
                       v-model="email" v-valid="email">
                <invalid name="email"></invalid>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" id="name" placeholder="Name" type="text"
                       v-model="name" v-valid="name">
                <invalid name="name"></invalid>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" id="password" placeholder="Password" type="text"
                       v-model="password" v-valid="password">
                <invalid name="password"></invalid>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <v-select :clearable="false" :options="roles" :reduce="label => label.value" :searchable="false"
                          class="form-control" inputId="role" placeholder="Role" v-model="role"
                          v-valid="role"></v-select>
                <invalid name="role"></invalid>
            </div>

            <red-cropper ref="cropper" validate="avatar"></red-cropper>
        </div>
        <div class="card-footer">
            <a :href="route('admin.articles.index')" class="btn btn-outline-secondary">Back</a>
            <button class="btn btn-outline-success float-right" type="submit">Create
                <b-spinner small v-show="loading"></b-spinner>
            </button>
        </div>
    </form>
</template>

<script>
    import form from './form'
    import {errors} from "../../helpers/helpers"

    export default {
        methods: {
            async submit() {
                let form = new FormData()

                const avatar = await this.$refs.cropper.getBlob()
                if (avatar) form.append('avatar', avatar, avatar.name)

                const fields = [
                    'email', 'name', 'password', 'role'
                ]
                fields.forEach(field => form.append(field, this[field]))

                this.loading = true

                try {
                    const {status, data} = await this.send(form)
                    if (status === 201) window.location = this.route('admin.users.edit', data.id)

                } catch (e) {
                    console.log(e)
                }

                this.loading = false
            },
            async send(form) {
                try {
                    const {status, data} = await this.axios.post(this.route('admin.users.store'), form, this.formConfig)
                    return {status, data}
                } catch ({response}) {
                    this.wasValidated = true
                    this.errors = errors(response)
                }
            },
        },
        created() {
            this.role = this.roles[0].value
        },
        mixins: [form],
    }
</script>
