<template>
    <form @submit.prevent="submit" class="card card-primary ">
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

            <red-cropper :old="oldAvatar" ref="cropper" validate="avatar"></red-cropper>
        </div>
        <div class="card-footer">
            <a :href="route('admin.articles.index')" class="btn btn-outline-secondary">Back</a>
            <button class="btn btn-outline-success float-right" type="submit">Save
                <b-spinner small v-show="loading"></b-spinner>
            </button>
        </div>
    </form>
</template>

<script>
    import {errors} from "@/helpers/helpers"
    import form from "./form"

    export default {
        data() {
            return {
                oldAvatar: null
            }
        },
        methods: {
            async submit() {
                const form = new FormData()
                form.append('_method', 'PATCH')

                const avatar = await this.$refs.cropper.getBlob()
                if (avatar) form.append('avatar', avatar, avatar.name)

                const fields = [
                    'email', 'name', 'password', 'role'
                ]
                fields.forEach(field => form.append(field, this[field]))

                this.loading = true

                try {
                    const {status, data} = await this.send(form)
                    this.errors = {}
                    if (status === 200) {
                        if (avatar) {
                            this.$refs.cropper.resetImage()
                            this.oldAvatar = data.avatar
                        }
                        this.$bus.emit('alert', {text: data.status})

                        this.wasValidated = false
                    }
                } catch (e) {
                    console.log(e)
                }

                this.loading = false
            },
            async send(form) {
                try {
                    const {status, data} = await this.axios.post(this.route('admin.users.update', this.id), form, this.formConfig)
                    return {status, data}
                } catch ({response}) {
                    this.wasValidated = true
                    this.errors = errors(response)
                }
            }
        },
        created() {
            const user = this.shared('user')

            const props = [
                'id',
                'email',
                'name',
                'role',
                'oldAvatar'
            ]
            props.forEach(prop => {
                if (prop in user && user[prop] !== null)
                    this[prop] = user[prop]
            })
        },
        mixins: [form]
    }
</script>
