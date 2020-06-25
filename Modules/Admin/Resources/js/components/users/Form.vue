<template>
    <form @submit.prevent="submit" class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" id="email" placeholder="Email" type="email"
                       v-model="form.email" v-valid.email>
                <invalid name="email"></invalid>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" id="name" placeholder="Name" type="text"
                       v-model="form.name" v-valid.name>
                <invalid name="name"></invalid>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" id="password" placeholder="Password" type="text"
                       v-model="form.password" v-valid.password>
                <invalid name="password"></invalid>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <v-select :clearable="false" :options="roles" :reduce="label => label.value" :searchable="false"
                          class="form-control" inputId="role" placeholder="Role" v-model="form.role"
                          v-valid.role></v-select>
                <invalid name="role"></invalid>
            </div>

            <red-cropper :old="oldAvatar" ref="cropper" validate="avatar"></red-cropper>
        </div>
        <card-footer resource="users"></card-footer>
    </form>
</template>

<script>
    import vSelect from 'vue-select'
    import RedCropper from "../includes/forms/RedCropper"
    import form from '@/mixins/form'

    export default {
        data() {
            return {
                form: {
                    email: '',
                    name: '',
                    password: '',
                    role: null,
                },
                roles: [...this.shared('roles')],
                oldAvatar: null
            }
        },
        methods: {
            async submit() {
                let form = new FormData()

                if (this.isEdit) form.append('_method', 'PATCH')

                for (let field in this.form) form.append(field, this.form[field])

                const avatar = await this.$refs.cropper.getBlob()
                if (avatar) form.append('avatar', avatar, avatar.name)

                try {
                    if (this.isEdit) {
                        const {status, data} = await this.send(this.route('admin.users.update', this.id), form, true)
                        if (status === 200) {
                            if (avatar) {
                                this.$refs.cropper.resetImage()
                                this.oldAvatar = data.avatar
                            }
                            this.$bus.emit('alert', {text: data.status})
                        }
                    } else {
                        const {status, data} = await this.send(this.route('admin.users.store'), form, true)
                        if (status === 201) window.location = this.route('admin.users.edit', data.id)
                    }
                } catch (e) {
                    console.log(e)
                }
            },
            setupEdit() {
                const user = this.$super(form).setupEdit('user')
                if (this.isEdit)
                    this.oldAvatar = user.oldAvatar
            }
        },
        created() {
            this.setupEdit()

            if (!this.isEdit)
                this.form.role = this.roles[0].value
        },
        mixins: [form],
        components: {
            vSelect,
            RedCropper,
        }
    }
</script>
