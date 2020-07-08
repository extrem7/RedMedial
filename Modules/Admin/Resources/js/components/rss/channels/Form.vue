<template>
    <form @submit.prevent="submit" class="card card-primary">
        <div class="card-body">
            <div class="form-group">
                <label for="country_id">Country</label>
                <v-select :clearable="false" :options="countries" :reduce="label => label.value" :searchable="false"
                          class="form-control" inputId="country_id" placeholder="Country" v-model="form.country_id"
                          v-valid.country_id></v-select>
                <invalid name="country_id"></invalid>
            </div>

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

            <div class="form-group">
                <label for="feed">Feed</label>
                <input class="form-control" id="feed" placeholder="Feed" type="text"
                       v-model="form.feed" v-valid.feed>
                <invalid name="feed"></invalid>
            </div>
            <div class="form-group">
                <label for="link">Link</label>
                <input class="form-control" id="link" placeholder="Link" type="text"
                       v-model="form.link" v-valid.link>
                <invalid name="link"></invalid>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" placeholder="Description" rows="2"
                          v-model="form.description" v-valid.description></textarea>
                <invalid name="description"></invalid>
            </div>

            <red-cropper :old="oldLogo" ref="cropper" validate="logo"></red-cropper>

            <h4 class="mt-4">Parsing settings</h4>
            <b-form-checkbox :unchecked-value="0" :value="1" size="lg" switch v-model="form.use_fulltext">
                Use fulltext
            </b-form-checkbox>
            <b-form-checkbox :unchecked-value="0" :value="1" size="lg" switch v-model="form.use_og">
                Use OG tags for thumb(if feed hasn't it)
            </b-form-checkbox>
            <b-form-checkbox :unchecked-value="0" :value="1" size="lg" switch v-model="form.is_active">
                Is active
            </b-form-checkbox>

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
        <card-footer></card-footer>
    </form>
</template>

<script>
    import form from "@/mixins/form"

    export default {
        data() {
            return {
                form: {
                    country_id: null,
                    name: '',
                    slug: '',
                    feed: '',
                    link: '',
                    description: '',
                    use_fulltext: 0,
                    use_og: 0,
                    is_active: 0,
                    meta_title: '',
                    meta_description: '',
                },
                countries: [...this.shared('countries')],
                oldLogo: null,
                resource: 'rss.channels'
            }
        },
        methods: {
            async submit() {
                let form = new FormData()

                if (this.isEdit) form.append('_method', 'PATCH')

                for (let field in this.form)
                    if (this.form[field] !== null)
                        form.append(field, this.form[field])

                const logo = await this.$refs.cropper.getBlob()
                if (logo) form.append('logo', logo, logo.name)

                try {
                    if (this.isEdit) {
                        const {status, data} = await this.send(this.route('admin.rss.channels.update', this.id), form, true)
                        if (status === 200) {
                            const updated = data.channel
                            delete updated.country_id
                            this.setupEdit(null, updated)
                            if (logo) {
                                this.$refs.cropper.resetImage()
                                this.oldLogo = updated.logo
                            }
                            this.$bus.emit('alert', {text: data.status})
                        }
                    } else {
                        const {status, data} = await this.send(this.route('admin.rss.channels.store'), form, true)

                        if (status === 201) {
                            this.$bus.emit('alert', {text: data.status})
                            setTimeout(() => {
                                window.location = this.route('admin.rss.channels.edit', data.id)
                            }, 2500)
                        }
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        },
        created() {
            this.setupEdit('channel')
            this.oldLogo = this.shared('channel').logo
        },
        mixins: [form]
    }
</script>

