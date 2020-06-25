<template>
    <form @submit.prevent="submit" class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" id="title" placeholder="Title" type="text"
                       v-model="form.title" v-valid.title>
                <invalid name="title"></invalid>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input class="form-control" id="slug" placeholder="Slug" type="text"
                       v-model="form.slug" v-valid.slug>
                <invalid name="slug"></invalid>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <editor id="body" placeholder="Body" v-model="form.body"></editor>
                <invalid name="body"></invalid>
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
                <input class="form-control" id="meta_description" placeholder="Description"
                       type="text"
                       v-model="form.meta_description" v-valid.meta_description>
                <invalid name="meta_description"></invalid>
            </div>
        </div>
        <card-footer resource="pages"></card-footer>
    </form>
</template>

<script>
    import form from "@/mixins/form"

    export default {
        data() {
            return {
                form: {
                    title: '',
                    slug: '',
                    body: '',
                    meta_title: '',
                    meta_description: '',
                }
            }
        },
        methods: {
            async submit() {
                let form = this.form
                if (this.isEdit) {
                    form['_method'] = 'PATCH'
                }
                try {
                    if (this.isEdit) {
                        const {status, data} = await this.send(this.route('admin.pages.update', this.id), form)
                        if (status === 200) this.$bus.emit('alert', {text: data.status})
                    } else {
                        const {status, data} = await this.send(this.route('admin.pages.store'), form)
                        if (status === 201) window.location = this.route('admin.pages.edit', data.id)
                    }

                } catch (e) {
                    console.log(e)
                }
            }
        },
        created() {
            this.setupEdit('page')
        },
        mixins: [form]
    }
</script>

