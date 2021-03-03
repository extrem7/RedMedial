<template>
  <form class="form-feedback" @submit.prevent="submit">
    <div class="form-group">
      <input id="name"
             v-model="form.name"
             v-valid.name
             class="form-control"
             placeholder=" "
             type="text">
      <label class="label" for="name">name</label>
      <Invalid name="name"/>
    </div>
    <div class="form-group">
      <input id="email"
             v-model="form.email"
             v-valid.email
             class="form-control"
             placeholder=" "
             required
             type="email">
      <label class="label" for="email">Email</label>
      <Invalid name="email"/>
    </div>
    <div class="form-group">
            <textarea v-model="form.message"
                      v-valid.message
                      class="form-control"
                      placeholder="Text message"
                      rows="6"/>
      <Invalid name="message"/>
    </div>
    <div class="form-group">
      <button class="btn btn-cyan">
        Send
        <span v-if="isLoading" class="spinner-border spinner-border-sm ml-2"/>
      </button>
    </div>
  </form>
</template>

<script>
import form from '../../mixins/form'

export default {
  mixins: [form],
  data() {
    return {
      form: {
        name: '',
        email: '',
        message: '',
      }
    }
  }
}
</script>

