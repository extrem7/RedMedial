<template>
  <form class="card card-primary" @submit.prevent="submit">
    <div class="card-body">
      <div class="form-group">
        <label for="country_id">Country</label>
        <v-select v-model="form.country_id" v-valid.country_id :clearable="false" :options="countries"
                  :reduce="label => label.value" :searchable="false" class="form-control" inputId="country_id"
                  placeholder="Country"></v-select>
        <invalid name="country_id"></invalid>
      </div>
      <div class="form-group">
        <label for="language_id">Language</label>
        <v-select v-model="form.language_id" v-valid.language_id :clearable="false" :options="languages"
                  :reduce="label => label.value" :searchable="false" class="form-control" inputId="language_id"
                  placeholder="Language"></v-select>
        <invalid name="language_id"></invalid>
      </div>

      <div class="form-group">
        <label for="name">Name</label>
        <input id="name" v-model="form.name" v-valid.name class="form-control"
               placeholder="Name" type="text">
        <invalid name="name"></invalid>
      </div>
      <div class="form-group">
        <label for="slug">Slug</label>
        <input id="slug" v-model="form.slug" v-valid.slug class="form-control"
               placeholder="Slug" type="text">
        <invalid name="slug"></invalid>
      </div>

      <div class="form-group">
        <label for="feed">Feed</label>
        <input id="feed" v-model="form.feed" v-valid.feed class="form-control"
               placeholder="Feed" type="text">
        <invalid name="feed"></invalid>
      </div>
      <div class="form-group">
        <label for="source">Source</label>
        <input id="source" v-model="form.source" v-valid.source class="form-control"
               placeholder="Source" type="text">
        <invalid name="source"></invalid>
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <editor id="description" v-model="form.description" height="250" placeholder="description"></editor>
        <invalid name="description"></invalid>
      </div>

      <red-cropper ref="cropper" :old="oldLogo" validate="logo"></red-cropper>

      <h4 class="mt-4">Parsing settings</h4>
      <b-form-checkbox v-model="form.use_fulltext" :unchecked-value="0" :value="1" size="lg" switch>
        Use fulltext
      </b-form-checkbox>
      <b-form-checkbox v-model="form.use_og" :unchecked-value="0" :value="1" size="lg" switch>
        Use OG tags for thumb(if feed hasn't it)
      </b-form-checkbox>
      <b-form-checkbox v-model="form.is_active" :unchecked-value="0" :value="1" size="lg" switch>
        Is active
      </b-form-checkbox>

      <h4 class="mt-4">Seo settings</h4>
      <div class="form-group">
        <label for="meta_title">Title</label>
        <input id="meta_title" v-model="form.meta_title" v-valid.meta_title class="form-control"
               placeholder="Title" type="text">
        <invalid name="meta_title"></invalid>
      </div>
      <div class="form-group">
        <label for="meta_description">Description</label>
        <textarea id="meta_description" v-model="form.meta_description"
                  v-valid.meta_description class="form-control" placeholder="Description"
                  rows="2"></textarea>
        <invalid name="meta_description"></invalid>
      </div>
    </div>
    <card-footer></card-footer>
  </form>
</template>

<script>
import form from '@/mixins/form'

export default {
  data() {
    return {
      form: {
        country_id: null,
        language_id: null,
        name: '',
        slug: '',
        feed: '',
        source: '',
        description: '',
        use_fulltext: 0,
        use_og: 0,
        is_active: 0,
        meta_title: '',
        meta_description: '',
      },
      countries: [{label: 'None', value: null}, ...this.shared('countries')],
      languages: [{label: 'None', value: null}, ...this.shared('languages')],
      oldLogo: null,
      resource: 'rss.channels'
    }
  },
  methods: {
    async submit() {
      let form = new FormData()

      if (this.isEdit) form.append('_method', 'PATCH')

      for (let field in this.form)
        if (this.form[field] !== null) {
          form.append(field, this.form[field])
        } else {
          form.append(field, '')
        }

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
    if (this.isEdit) {
      this.oldLogo = this.shared('channel').logo
    }
  },
  mixins: [form]
}
</script>

