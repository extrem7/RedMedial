<template>
    <form @submit.prevent="submit" class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control meta_description mb-2" id="title" placeholder="Title" type="text"
                       v-model="title" v-valid="title">
                <invalid name="title"></invalid>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input class="form-control meta_description mb-2" id="slug" placeholder="Slug" type="text"
                       v-model="slug" v-valid="slug">
                <invalid name="slug"></invalid>
            </div>
            <div class="form-group">
                <label for="body">Body</label>
                <editor id="body" placeholder="Body" v-model="body"></editor>
                <invalid name="body"></invalid>
            </div>
            <div class="form-group">
                <label for="excerpt">Excerpt</label>
                <editor id="excerpt" placeholder="Excerpt" v-model="excerpt"></editor>
                <invalid name="excerpt"></invalid>
            </div>

            <red-cropper ref="cropper" validate="image"></red-cropper>

            <h4 class="mt-4">Seo settings</h4>
            <div class="form-group">
                <label for="meta_title">Title</label>
                <input class="form-control meta_description mb-2" id="meta_title" placeholder="Title" type="text"
                       v-model="meta_title" v-valid="meta_title">
                <invalid name="meta_title"></invalid>
            </div>
            <div class="form-group">
                <label for="meta_description">Description</label>
                <input class="form-control meta_description mb-2" id="meta_description" placeholder="Description"
                       type="text"
                       v-model="meta_description" v-valid="meta_description">
                <invalid name="meta_description"></invalid>
            </div>

            <h4 class="mt-4">Additional</h4>
            <div class="form-group">
                <label for="authors">Authors (coma separated)</label>
                <input class="form-control meta_description mb-2" id="authors" placeholder="Authors" type="text"
                       v-model="authors" v-valid="authors">
                <invalid name="authors"></invalid>
            </div>
            <div class="form-group">
                <label for="original">Original(link)</label>
                <input class="form-control meta_description mb-2" id="original" placeholder="Original" type="text"
                       v-model="original" v-valid="original">
                <invalid name="original"></invalid>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <v-select :clearable="false" :options="statuses" :reduce="label => label.value" :searchable="false"
                          class="form-control" inputId="status" placeholder="Status" v-model="status"
                          v-valid="status"></v-select>
                <invalid name="status"></invalid>
            </div>
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
    import {errors} from "@/helpers/helpers"

    export default {
        methods: {
            async submit() {
                let form = new FormData()

                const image = await this.$refs.cropper.getBlob()
                if (image) form.append('image', image, image.name)

                const append = {
                    title: this.title,
                    slug: this.slug,
                    body: this.body,
                    excerpt: this.excerpt,
                    meta_title: this.meta_title,
                    meta_description: this.meta_description,
                    authors: this.authors,
                    original: this.original,
                    status: this.status,
                }
                for (let field in append) form.append(field, this[field])

                this.loading = true

                try {
                    const {status, data} = await this.send(form)
                    if (status === 201) window.location = this.route('admin.articles.edit', data.id)

                } catch (e) {
                    console.log(e)
                }

                this.loading = false
            },
            async send(form) {
                try {
                    const {status, data} = await this.axios.post(this.route('admin.articles.store'), form, this.formConfig)
                    return {status, data}
                } catch ({response}) {
                    this.wasValidated = true
                    this.errors = errors(response)
                }
            }
        },
        created() {
            this.status = this.statuses[0].value
        },
        mixins: [form]
    }
</script>

