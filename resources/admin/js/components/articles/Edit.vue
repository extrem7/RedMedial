<template>
    <form @submit.prevent="submit" class="card card-primary bg-dark">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Назва</label>
                <input class="form-control bg-dark mb-2" id="title" placeholder="Назва статті" type="text"
                       v-model="title.uk">
                <span class="invalid-feedback" v-html="errors.title||null"></span>
            </div>
            <div class="form-group">
                <label for="body">Текст статті</label>
                <editor id="body" placeholder="Текст статті" v-model="body.uk"></editor>
                <span class="invalid-feedback" v-html="errors.body||null"></span>
            </div>
            <div class="form-group">
                <label for="excerpt">Анонс статті</label>
                <editor id="excerpt" placeholder="Анонс статті" v-model="excerpt.uk"></editor>
                <span class="invalid-feedback" v-html="errors.excerpt||null"></span>
            </div>

            <div class="d-flex mt-4">
                <vue-upload-component
                    @input-file="inputFile"
                    @input-filter="inputFilter"
                    post-action="/post.method"
                    put-action="/put.method"
                    ref="upload"
                    v-model="files">
                    <button class="btn btn-primary">Вибрати фото</button>
                </vue-upload-component>
                <button @click.prevent="files=[]" class="btn btn-danger ml-2" v-if="files.length">Відмінити</button>
            </div>
            <img :src="files.length?files[0].blob:oldImage" class="image-preview">
            <span class="invalid-feedback" v-html="errors.image||null"></span>
        </div>
        <div class="card-footer">
            <a :href="route('admin.articles.index')" class="btn btn-outline-secondary">Назад</a>
            <button class="btn btn-outline-success float-right" type="submit">Зберегти
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
            const article = this.shared('article')
            return {
                id: article.id,
                title: article.title,
                body: article.body,
                excerpt: article.excerpt,

                oldImage: article.image
            }
        },
        methods: {
            async submit() {
                try {
                    let form = new FormData()

                    if (this.files.length !== 0) {
                        form.append('image', this.files[0].file)
                    }
                    form.append('_method', 'PATCH')
                    form.append('title', this.title.uk)
                    form.append('body', this.body.uk)
                    form.append('excerpt', this.excerpt.uk)
                    this.loading = true

                    const {status} = await this.axios.post(this.route('admin.articles.update', this.id), form, {
                        header: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    this.errors = {}
                    if (status === 204) {
                        if (this.files.length) {
                            this.oldImage = this.files[0].blob
                            this.files = []
                        }
                        this.$bus.emit('alert', {text: 'Статтю було відредаговано'})
                    }

                } catch ({response}) {
                    this.errors = errors(response)
                }
                this.loading = false
            }
        },
        mixins: [form]
    }
</script>

<style lang="scss" scoped>
    .image-preview {
        display: block;
        max-height: 250px;
        max-width: 100%;
        object-fit: contain;
        margin: 25px auto 0;
    }
</style>

<style>
    .file-uploads.file-uploads-html5 label {
        cursor: pointer;
    }

    .invalid-feedback {
        display: block !important;
    }
</style>
