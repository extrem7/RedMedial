<template>
    <form @submit.prevent="submit" class="card card-primary bg-dark">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control bg-dark mb-2" id="title" placeholder="Title" type="text"
                       v-model="title" v-valid="title">
                <invalid name="title"></invalid>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input class="form-control bg-dark mb-2" id="slug" placeholder="Slug" type="text"
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
                    post-action="/post.method"
                    put-action="/put.method"
                    ref="upload"
                    v-model="files">
                    <button class="btn btn-primary">Choose image</button>
                </vue-upload-component>
                <button @click.prevent="files=[]" class="btn btn-danger ml-2" v-if="files.length">
                    Remove image
                </button>
            </div>
            <img :src="files[0].blob" class="image-preview" v-if="files.length">
            <invalid name="image"></invalid>

            <h4 class="mt-4">Seo settings</h4>
            <div class="form-group">
                <label for="seo_title">Title</label>
                <input class="form-control bg-dark mb-2" id="seo_title" placeholder="Title" type="text"
                       v-model="seo_title" v-valid="seo_title">
                <invalid name="seo_title"></invalid>
            </div>
            <div class="form-group">
                <label for="seo_description">Description</label>
                <input class="form-control bg-dark mb-2" id="seo_description" placeholder="Description" type="text"
                       v-model="seo_description" v-valid="seo_description">
                <invalid name="seo_description"></invalid>
            </div>

            <h4 class="mt-4">Additional</h4>
            <div class="form-group">
                <label for="authors">Authors (coma separated)</label>
                <input class="form-control bg-dark mb-2" id="authors" placeholder="Authors" type="text"
                       v-model="authors" v-valid="authors">
                <invalid name="authors"></invalid>
            </div>
            <div class="form-group">
                <label for="original">Original(link)</label>
                <input class="form-control bg-dark mb-2" id="original" placeholder="Original" type="text"
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
    import Invalid from "@/components/includes/Invalid"

    export default {
        components: {Invalid},
        data() {
            return {
                title: '',
                slug: '',
                body: '',
                excerpt: '',

                seo_title: '',
                seo_description: '',

                authors: '',
                original: '',

                status: null,
            }
        },
        methods: {
            async submit() {
                try {
                    let form = new FormData()

                    if (this.files.length !== 0) {
                        form.append('image', this.files[0].file)
                    }

                    const append = {
                        title: this.title,
                        body: this.body,
                        excerpt: this.excerpt,
                        seo_title: this.seo_title,
                        seo_description: this.seo_description,
                        authors: this.authors,
                        original: this.original,
                        status: this.status,
                    }
                    for (let field in append) form.append(field, this[field])

                    this.loading = true

                    const {status, data} = await this.axios.post(this.route('admin.articles.store'), form, {
                        header: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    if (status === 201) window.location = this.route('admin.articles.edit', data.id)

                } catch ({response}) {
                    this.wasValidated = true
                    this.errors = errors(response)
                }
                this.loading = false
            },
        },
        created() {
            this.status = this.statuses[0].value
        },
        mixins: [form]
    }
</script>

