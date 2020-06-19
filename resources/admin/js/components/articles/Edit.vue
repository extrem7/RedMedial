<template>
    <form @submit.prevent="submit" class="card card-primary ">
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

            <div class="d-flex mt-4">
                <vue-upload-component
                    @input-file="inputFile"
                    @input-filter="inputFilter"
                    ref="upload"
                    v-model="files">
                    <button class="btn btn-primary">Choose image</button>
                </vue-upload-component>
                <button @click.prevent="files=[]" class="btn btn-danger ml-2" v-if="files.length">Cancel</button>
            </div>
            <img :src="files.length?files[0].blob:oldImage" class="image-preview">
            <invalid name="image"></invalid>

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
            <button class="btn btn-outline-success float-right" type="submit">Save
                <b-spinner small v-show="loading"></b-spinner>
            </button>
        </div>
    </form>
</template>

<script>
    import {errors} from "@/helpers/helpers"
    import form from "@/components/articles/form"

    export default {
        data() {
            return {
                oldImage: null
            }
        },
        methods: {
            async submit() {
                let form = new FormData()

                const append = {
                    _method: 'PATCH',
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
                for (let field in append) form.append(field, append[field])

                if (this.files.length !== 0) {
                    form.append('image', this.files[0].file)
                }

                this.loading = true

                try {
                    const {status, data} = await this.send(form)
                    this.errors = {}
                    if (status === 200) {
                        if (this.files.length) {
                            this.oldImage = this.files[0].blob
                            this.files = []
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
                    const {status, data} = await this.axios.post(this.route('admin.articles.update', this.id), form, this.formConfig)
                    return {status, data}
                } catch ({response}) {
                    this.wasValidated = true
                    this.errors = errors(response)
                }
            }
        },
        created() {
            const article = this.shared('article')

            const props = [
                'id',
                'title',
                'slug',
                'body',
                'excerpt',
                'meta_title',
                'meta_description',
                'authors',
                'original',
                'status'
            ]
            props.forEach(prop => {
                if (prop in article && article[prop] !== null)
                    this[prop] = article[prop]
            })

            this.oldImage = article.image
        },
        mixins: [form]
    }
</script>
