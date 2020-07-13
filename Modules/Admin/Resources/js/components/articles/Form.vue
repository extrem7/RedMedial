<template>
    <form @submit.prevent="submit" class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control meta_description mb-2" id="title" placeholder="Title" type="text"
                       v-model="form.title" v-valid.title>
                <invalid name="title"></invalid>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input class="form-control meta_description mb-2" id="slug" placeholder="Slug" type="text"
                       v-model="form.slug" v-valid.slug>
                <invalid name="slug"></invalid>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <editor id="body" placeholder="Body" v-model="form.body"></editor>
                <invalid name="body"></invalid>
            </div>
            <div class="form-group">
                <label for="excerpt">Excerpt</label>
                <editor id="excerpt" placeholder="Excerpt" v-model="form.excerpt"></editor>
                <invalid name="excerpt"></invalid>
            </div>

            <red-cropper :old="oldImage" ref="cropper" validate="image"></red-cropper>

            <h4 class="mt-4">Seo settings</h4>
            <div class="form-group">
                <label for="meta_title">Title</label>
                <input class="form-control meta_description mb-2" id="meta_title" placeholder="Title" type="text"
                       v-model="form.meta_title" v-valid.meta_title>
                <invalid name="meta_title"></invalid>
            </div>
            <div class="form-group">
                <label for="meta_description">Description</label>
                <input class="form-control meta_description mb-2" id="meta_description" placeholder="Description"
                       type="text"
                       v-model="form.meta_description" v-valid.meta_description>
                <invalid name="meta_description"></invalid>
            </div>

            <h4 class="mt-4">Additional</h4>
            <div class="form-group">
                <label for="authors">Authors (coma separated)</label>
                <input class="form-control meta_description mb-2" id="authors" placeholder="Authors" type="text"
                       v-model="form.authors" v-valid.authors>
                <invalid name="authors"></invalid>
            </div>
            <div class="form-group">
                <label for="original">Original(link)</label>
                <input class="form-control meta_description mb-2" id="original" placeholder="Original" type="text"
                       v-model="form.original" v-valid.original>
                <invalid name="original"></invalid>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <v-select :clearable="false" :options="statuses" :reduce="label => label.value" :searchable="false"
                          class="form-control" inputId="status" placeholder="Status" v-model="form.status"
                          v-valid.status></v-select>
                <invalid name="status"></invalid>
            </div>
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
                    title: '',
                    slug: '',
                    body: '',
                    excerpt: '',

                    meta_title: '',
                    meta_description: '',

                    authors: '',
                    original: '',

                    status: null,
                },
                resource: 'articles',
                statuses: this.shared('statuses'),
                oldImage: null
            }
        },
        methods: {
            async submit() {
                let form = new FormData()

                if (this.isEdit) form.append('_method', 'PATCH')

                for (let field in this.form) form.append(field, this.form[field])

                const image = await this.$refs.cropper.getBlob()
                if (image) form.append('image', image, image.name)

                try {
                    if (this.isEdit) {
                        const {status, data} = await this.send(this.route('admin.articles.update', this.id), form, true)
                        if (status === 200) {
                            if (image) {
                                this.$refs.cropper.resetImage()
                                this.oldImage = data.image
                            }
                            this.$bus.emit('alert', {text: data.status})
                        }
                    } else {
                        const {status, data} = await this.send(this.route('admin.articles.store'), form, true)
                        if (status === 201) window.location = this.route('admin.articles.edit', data.id)
                    }
                } catch (e) {
                    console.log(e)
                }
            },
            setupEdit() {
                const article = this.$super(form).setupEdit('article')
                if (this.isEdit)
                    this.oldImage = article.oldImage
            }
        },
        created() {
            this.setupEdit()

            if (!this.isEdit)
                this.form.status = this.statuses[0].value
        },
        mixins: [form],
        components: {
            vSelect,
            RedCropper,
        }
    }
</script>

