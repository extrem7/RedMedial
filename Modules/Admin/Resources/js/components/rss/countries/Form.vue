<template>
    <form @submit.prevent="submit" class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" id="name" placeholder="Name" type="text"
                       v-model="form.name" v-valid.name>
                <invalid name="name"></invalid>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input class="form-control" id="slug" placeholder="Slug" type="text"
                       v-model="form.slug" v-valid.slug>
                <invalid name="slug"></invalid>
            </div>

            <h4 class="mt-4">Seo settings</h4>
            <div class="form-group">
                <label for="meta_title">Title</label>
                <input class="form-control" id="meta_title" placeholder="Title" type="text"
                       v-model="form.meta_title" v-valid.meta_title>
                <invalid name="meta_title"></invalid>
            </div>
            <div class="form-group">
                <label for="meta_description">Description</label>
                <textarea class="form-control" id="meta_description"
                          placeholder="Description" rows="2" v-model="form.meta_description"
                          v-valid.meta_description></textarea>
                <invalid name="meta_description"></invalid>
            </div>
        </div>
        <card-footer resource="rss.countries"></card-footer>
    </form>
</template>

<script>
    import form from "@/mixins/form"

    export default {
        data() {
            return {
                form: {
                    name: '',
                    slug: '',
                    meta_title: '',
                    meta_description: '',
                }
            }
        },
        methods: {
            async submit() {
                let form
                if (this.isEdit) {
                    form = {
                        _method: 'PATCH',
                        ...this.form
                    }
                } else {
                    form = this.form
                }

                try {
                    if (this.isEdit) {
                        const {status, data} = await this.send(this.route('admin.rss.countries.update', this.id), form)
                        if (status === 200) {
                            this.$bus.emit('alert', {text: data.status})
                        }
                    } else {
                        const {status, data} = await this.send(this.route('admin.rss.countries.store'), form)

                        if (status === 201) {
                            this.$bus.emit('alert', {text: data.status})
                            setTimeout(() => {
                                window.location = this.route('admin.rss.countries.edit', data.id)
                            }, 2500)
                        }
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        },
        created() {
            this.setupEdit('country')
        },
        mixins: [form]
    }
</script>

