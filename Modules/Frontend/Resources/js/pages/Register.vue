<template>
  <div class="box box--form box--sign">
    <div class="title title--cyan page-title">Sign up</div>
    <form class="box__inner"
          @submit.prevent="submit">
      <InputMaterial
        v-model="form.name"
        input-class="form-control--transparent"
        name="name"
        placeholder="Name"
        required/>
      <InputMaterial
        v-model="form.email"
        input-class="form-control--transparent"
        name="email"
        placeholder="E-mail address"
        required
        type="email"/>
      <InputMaterial
        v-model="form.media_name"
        input-class="form-control--transparent"
        name="media_name"
        placeholder="Name of media"
        required/>
      <InputMaterial
        v-model="form.url"
        input-class="form-control--transparent"
        name="url"
        placeholder="URL of media"
        required
        type="url"/>
      <InputMaterial
        v-model="form.phone"
        input-class="form-control--transparent"
        name="phone"
        placeholder="Phone"
        type="tel"/>
      <InputMaterial
        v-model="form.password"
        input-class="form-control--transparent"
        name="password"
        placeholder="Password"
        required
        type="password"/>
      <InputMaterial
        v-model="form.password_confirmation"
        input-class="form-control--transparent"
        is-last-child
        placeholder="Confirm password"
        required
        type="password"/>
      <div class="form-group">
        <button
          :disabled="processing"
          class="btn btn-cyan btn--size--134 semi-bold">
          Sign up
          <BSpinner
            v-if="processing"
            class="ml-2"
            small/>
        </button>
      </div>
      <div class="mt-3 small-size">
        Already have an account?
        <InertiaLink
          :href="route('frontend.login')"
          class="link link--cyan">
          Log in
        </InertiaLink>
      </div>
    </form>
  </div>
</template>

<script>
import form from '~/mixins/inertia-form'

export default {
  mixins: [form],
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        email: '',
        media_name: '',
        url: '',
        phone: '',
        password: '',
        password_confirmation: ''
      })
    }
  },
  methods: {
    async submit() {
      this.form.post(this.route('frontend.register.try'), {
        preserveScroll: true
      })
    }
  }
}
</script>
