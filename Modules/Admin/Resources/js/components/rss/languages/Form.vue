<template>
  <form class="card card-primary" @submit.prevent="submit">
    <div class="card-body">
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
        <label for="code">ISO code (visit <a
          href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes"
          target="_blank">Wiki</a>)</label>
        <input id="code" v-model="form.code"
               v-valid.slug
               class="form-control" placeholder="Code" type="text">
        <invalid name="code"></invalid>
      </div>

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
    <card-footer resource="rss.languages"></card-footer>
  </form>
</template>

<script>
import form from '@/mixins/form'

export default {
  data() {
    return {
      form: {
        name: '',
        slug: '',
        code: '',
        meta_title: '',
        meta_description: '',
      },
      resource: 'rss.languages'
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
          const {status, data} = await this.send(this.route('admin.rss.languages.update', this.id), form)
          if (status === 200) {
            this.setupEdit(null, data.languge)
            this.$bus.emit('alert', {text: data.status})
          }
        } else {
          const {status, data} = await this.send(this.route('admin.rss.languages.store'), form)

          if (status === 201) {
            this.$bus.emit('alert', {text: data.status})
            setTimeout(() => {
              window.location = this.route('admin.rss.languages.edit', data.id)
            }, 2500)
          }
        }
      } catch (e) {
        console.log(e)
      }
    }
  },
  created() {
    this.setupEdit('language')
  },
  mixins: [form]
}
</script>

