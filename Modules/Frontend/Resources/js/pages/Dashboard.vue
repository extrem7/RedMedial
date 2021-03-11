<template>
  <div class="cabinet-content__inner">
    <form
      class="row"
      @submit.prevent="submit"
    >
      <div class="col-md-6">
        <InputMaterial
          v-model="form.name"
          input-class="form-control--transparent"
          name="name"
          placeholder="Name of media"
          required
        />
        <InputMaterial
          v-model="form.url"
          input-class="form-control--transparent"
          name="url"
          placeholder="URL of media"
          required
          type="url"
        />
        <InputMaterial
          v-model="form.facebook"
          input-class="form-control--transparent"
          name="facebook"
          placeholder="Facebook of media"
          type="url"
        />
        <InputMaterial
          v-model="form.phone"
          input-class="form-control--transparent"
          name="phone"
          placeholder="Phone"
          required
          type="tel"
        />
        <InputMaterial
          v-model="form.instagram"
          input-class="form-control--transparent"
          name="instagram"
          placeholder="Instagram of Media"
        />
        <InputMaterial
          v-model="form.twitter"
          input-class="form-control--transparent"
          name="twitter"
          placeholder="Twitter of Media"
        />
      </div>
      <div class="col-md-6">
        <InputMaterial
          v-model="form.rss"
          input-class="form-control--transparent"
          name="rss"
          placeholder="Rss Media"
          type="url"
        />
        <div class="form-group form-group--material upload-box">
          <div class="upload-box__inner">
            <span class="label upload-box__label">Icon image of media</span>
            <a
              v-if="information.logo"
              :href="information.logo"
              class="upload-preview"
              target="_blank"
            >
              <img
                :src="information.logo"
                alt="icon"
                class="upload-preview__img"
              >
              <InertiaLink
                :href="route('account.logo.destroy')"
                as="button"
                class="btn upload-preview__btn-delete"
                method="delete"
              />
            </a>
            <button
              v-else
              v-b-modal.logo-modal
              class="btn btn-grey btn--size--134 semi-bold upload-box__btn"
              @click.prevent>
              Add
            </button>
          </div>
        </div>
        <div class="form-group form-group--material">
          <InputMaterial
            v-slot="{state}"
            name="comment">
            <BFormTextarea
              v-model="form.comment"
              :state="state"
              class="form-control"
              cols="30"
              placeholder="Editorial line"
              rows="4"
            />
          </InputMaterial>
        </div>
        <div class="form-group form-group--material upload-box upload-box-statistic">
          <div class="upload-box__inner mb-3">
            <div class="upload-box__label">
              <span class="label">statistical media</span>
              <p class="small-title mt-1">Please, take screenshot of your last month visits in analytics and attach
                here.</p>
            </div>
            <a
              v-if="information.statistic"
              :href="information.statistic"
              class="upload-preview"
              target="_blank"
            >
              <img
                :src="information.statistic"
                alt="icon"
                class="upload-preview__img"
              >
              <InertiaLink
                :href="route('account.statistic')"
                as="button"
                class="btn upload-preview__btn-delete"
                method="delete"
              />
            </a>
          </div>
          <InputMaterial
            v-slot="{state}"
            name="statisticImage"
          >
            <BFormFile
              v-model="form.statisticImage"
              :state="state"
            />
          </InputMaterial>
        </div>
        <div class="form-group">
          <button
            class="btn btn-grey btn--size--134 semi-bold"
            @click.prevent="assistance"
          >
            Need assistance
          </button>
        </div>
      </div>
      <div class="col-12">
        <div class="form-group">
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
      </div>
    </form>
    <AvatarUploader/>
  </div>
</template>

<script>
import AccountLayout from '~/layouts/Account'
import {BFormFile, BFormTextarea, BModal, VBModal} from 'bootstrap-vue'
import AvatarUploader from '~/components/AvatarUploader'
import form from '~/mixins/inertia-form'

export default {
  components: {
    BFormFile,
    BFormTextarea,
    BModal,
    AvatarUploader
  },
  mixins: [form],
  directives: {
    'b-modal': VBModal
  },
  props: {
    information: Object
  },
  layout: AccountLayout,
  data() {
    return {
      form: this.$inertia.form({
        name: '',
        url: '',
        facebook: '',
        phone: '',
        instagram: '',
        twitter: '',
        rss: '',
        comment: '',
        statisticImage: null
      })
    }
  },
  created() {
    for (let key in this.information) {
      const value = this.information[key]
      if (this.form.hasOwnProperty(key) && value) {
        this.form[key] = value
      }
    }
  },
  methods: {
    async submit() {
      this.form.post(this.route('account.update'), {
        preserveScroll: true,
        onSuccess: () => {
          this.form.statisticImage = null
        }
      })
    },
    async assistance() {
      this.$inertia.post(this.route('account.assistance'))
    }
  }
}
</script>

<style lang="scss" scoped>
.upload-box-statistic {
  .upload-preview {
    width: 200px;

    .upload-preview__img {
      border-radius: 0;
      object-fit: contain;
    }
  }
}
</style>
