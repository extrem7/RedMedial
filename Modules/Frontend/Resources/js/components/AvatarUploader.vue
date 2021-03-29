<template>
  <div class="avatar-loader">
    <input
      ref="input"
      accept="image/*"
      class="d-none"
      name="image"
      type="file"
      @change="setImage">
    <BModal
      id="logo-modal"
      ref="modal"
      centered
      hide-footer
      @shown="showFileChooser"
    >
      <template #modal-header="{ close }">
        <h5 class="title title--cyan page-title">Upload image</h5>
        <button
          aria-label="Close"
          class="modal-close"
          @click="close()"
        >
          <SvgVue icon="close"/>
        </button>
      </template>
      <button
        class="btn btn-cyan btn--size--134"
        @click.prevent="showFileChooser"
      >
        Select File
      </button>
      <div class="text-center mt-3">
        <VueCropper
          v-show="image"
          ref="cropper"
          :src="image"
          class="vue-cropper w-100"/>
        <div
          v-if="error"
          class="invalid-feedback">
          {{ error }}
        </div>
      </div>
      <div
        v-show="image"
        class="modal-actions"
      >
        <button
          class="btn btn-outline-cyan btn--size--134 semi-bold modal-actions__btn"
          @click="cancel"
        >
          Cancel
        </button>
        <button
          class="btn btn-cyan btn--size--134 semi-bold modal-actions__btn"
          :disabled="processing"
          @click="upload"
        >
          Upload
          <BSpinner
            v-if="processing"
            class="ml-2"
            small
          />
        </button>
      </div>
    </BModal>
  </div>
</template>

<script>
import VueCropper from 'vue-cropperjs'
import {BModal, BSpinner} from 'bootstrap-vue'

export default {
  components: {
    VueCropper,
    BModal,
    BSpinner
  },
  data() {
    return {
      imageName: null,
      image: null,
      processing: false
    }
  },
  computed: {
    error() {
      return this.$page.props.errors.logo || null
    }
  },
  methods: {
    async upload() {
      const form = new FormData
      const logo = await this.getBlob()
      form.append('logo', logo, this.imageName)

      this.processing = true
      this.$inertia.post(this.route('account.media.logo.update'), form, {
        onSuccess: page => {
          if (!page.props.errors.logo) {
            this.cancel()
          }
        },
        onFinish: () => {
          this.processing = false
        }
      })
    },
    cancel() {
      this.resetImage()
      this.$refs.modal.hide()
    },
    async getBlob() {
      return new Promise((resolve) => {
        if (!this.image) resolve(null)
        const canvas = this.$refs.cropper.getCroppedCanvas()
        if (canvas)
          canvas.toBlob((blob) => {
            blob.name = this.imageName
            resolve(blob)
          })

      })
    },
    resetImage() {
      this.image = null
      this.$refs.cropper.reset()
      this.errors = {}
    },
    setImage(e) {
      const file = e.target.files[0]
      if (file.type.indexOf('image/') === -1) {
        alert('Please select an image file')
        return
      }
      this.imageName = file.name
      const reader = new FileReader()
      reader.onload = (event) => {
        this.image = event.target.result
        this.$refs.cropper.replace(event.target.result)
      }
      reader.readAsDataURL(file)
    },
    showFileChooser() {
      this.$refs.input.click()
    },
    openModal() {
      this.isModalOpen = true
      this.$refs.input.click()
    }
  }
}
</script>

<style lang="scss" scoped>
@import '~cropperjs/dist/cropper.css';

.avatar-loader {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.btn-action-img {
  width: 26px;
  height: 26px;
  position: absolute;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  flex-shrink: 0;

  img {
    width: 13px;
  }
}

.profile-avatar {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  background-color: #EFECE8;
  border-radius: 50%;
  overflow: hidden;
  width: 130px;
  height: 130px;
  position: relative;
}

.profile-avatar-img {
  object-fit: cover;
  width: 100%;
  height: 100%;
}

.btn-upload-img {
  bottom: 3px;
  right: 15px;
}

.btn-delete {
  right: -5px;
  bottom: 30px;
}
</style>
