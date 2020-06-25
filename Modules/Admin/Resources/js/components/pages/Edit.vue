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
    import {errors} from "../../helpers/helpers"
    import form from "../articles/form"

    export default {
        methods: {
            async submit() {
                let form = {
                    _method: 'PATCH',
                    title: this.title,
                    slug: this.slug,
                    body: this.body,
                    meta_title: this.meta_title,
                    meta_description: this.meta_description,
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
                    const {status, data} = await this.axios.post(this.route('admin.pages.update', this.id), form)
                    return {status, data}
                } catch ({response}) {
                    this.wasValidated = true
                    this.errors = errors(response)
                }
            }
        },
        created() {
            const page = this.shared('page')
            const props = [
                'id',
                'title',
                'slug',
                'body',
                'meta_title',
                'meta_description',
            ]
            props.forEach(prop => {
                if (prop in page && page[prop] !== null)
                    this[prop] = page[prop]
            })
        },
        mixins: [form]
    }
</script>
