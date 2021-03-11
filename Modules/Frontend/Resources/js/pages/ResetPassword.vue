<template>
  <div class="box box--form box--sign">
    <div v-if="!successful" class="title title--cyan page-title">Password Reset</div>
    <div v-else class="title title--cyan page-title">Password Reset success</div>

    <p v-if="!successful" class="mt-3">Enter your Redmedial email address that you used to register.
      We'll send you an email with a your new password.</p>
    <p v-else class="mt-3">New password has been sent to your email: {{ form.email }}</p>

    <form v-if="!successful"
          class="box__inner"
          @submit.prevent="submit">
      <InputMaterial
        v-model="form.email"
        input-class="form-control--transparent"
        name="email"
        placeholder="E-mail address"
        required
        type="email"/>
      <div class="form-group">
        <button class="btn btn-cyan btn--size--134 semi-bold">Reset</button>
      </div>
      <div class="mt-3 small-size">
        If you still need help, please contact <a class="link link--cyan" href="/contacto">Redmedial Support.</a>
      </div>
    </form>
    <div v-else class="mt-3">
      <a :href="route('home')"
         class="btn btn-cyan btn--size--134 semi-bold">
        Back to main
      </a>
    </div>
  </div>
</template>

<script>
import form from '~/mixins/inertia-form'

export default {
  mixins: [form],
  data() {
    return {
      form: this.$inertia.form({
        email: ''
      }),
      successful: false
    }
  },
  methods: {
    async submit() {
      this.form.post(this.route('password_reset.try'), {
        preserveScroll: true,
        onSuccess: () => {
          this.successful = true
        }
      })
    }
  }
}
</script>
