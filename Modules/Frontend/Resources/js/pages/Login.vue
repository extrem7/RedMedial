<template>
  <div class="box box--form box--sign">
    <div class="title title--cyan page-title">Sign In</div>
    <form
      class="box__inner"
      @submit.prevent="submit"
    >
      <InputMaterial
        v-model="form.email"
        input-class="form-control--transparent"
        name="email"
        placeholder="Email"
        required
        type="email"
      />
      <InputMaterial
        v-model="form.password"
        input-class="form-control--transparent"
        is-last-child
        name="password"
        placeholder="password"
        required
        type="password"
      />
      <BFormCheckbox
        v-model="form.rememberMe"
        class="mt-3"
      >
        Remember me
      </BFormCheckbox>
      <div class="text-right small-size">
        <InertiaLink
          :href="route('password_reset')"
          class="link link--inherit link--with-line"
        >
          Forgot your
          password?
        </InertiaLink>
      </div>
      <div class="form-group mt-3">
        <button
          :disabled="processing"
          class="btn btn-cyan btn--size--134 semi-bold"
        >
          Log In
          <BSpinner
            v-if="processing"
            class="ml-2"
            small
          />
        </button>
      </div>
      <div class="mt-3 small-size">
        Dont have an account?
        <InertiaLink
          :href="route('register')"
          class="link link--cyan"
        >
          Sign up for Redmedial
        </InertiaLink>
      </div>
    </form>
  </div>
</template>

<script>
import {BFormCheckbox} from 'bootstrap-vue'
import form from '~/mixins/inertia-form'

export default {
  components: {
    BFormCheckbox
  },
  mixins: [form],
  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        rememberMe: false
      })
    }
  },
  methods: {
    async submit() {
      this.form.post(this.route('login.try'), {
        preserveScroll: true
      })
    }
  }
}
</script>
