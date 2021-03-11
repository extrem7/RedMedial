<template>
  <form
    class="row cabinet-content__inner"
    @submit.prevent="submit"
  >
    <div class="col-md-6">
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
    </div>
    <div class="col-md-6">
      <InputMaterial
        v-model="form.password"
        input-class="form-control--transparent"
        name="password"
        placeholder="Password"
        type="password"/>
      <InputMaterial
        v-model="form.password_confirmation"
        input-class="form-control--transparent"
        is-last-child
        placeholder="Confirm password"
        type="password"/>
    </div>
    <div class="col-12">
      <button
        :disabled="processing"
        class="btn btn-cyan btn--size--134 semi-bold"
      >
        Save
        <BSpinner
          v-if="processing"
          class="ml-2"
          small
        />
      </button>
    </div>
  </form>
</template>

<script>
import AccountLayout from '~/layouts/Account'
import form from '~/mixins/inertia-form'

export default {
  mixins: [form],
  props: {
    user: Object
  },
  layout: AccountLayout,
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      })
    }
  },
  created() {
    this.fillForm(this.user)
  },
  methods: {
    async submit() {
      this.form.post(this.route('account.settings.update'), {
        preserveScroll: true,
        onSuccess: () => {
          this.form.password = null
          this.form.password_confirmation = null
        }
      })
    }
  }
}
</script>
