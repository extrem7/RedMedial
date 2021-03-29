<template>
  <AccountLayout>
    <div class="row cabinet-content__inner">
      <div class="col-xl-4">
        <div class="iframe-info">
          <div class="iframe-info__item form-group form-group--material">
            <div class="label iframe-info__title">Language</div>
            <BFormSelect
              v-model="language"
              :options="languages"
              class="form-control form-control--transparent"
            />
          </div>
          <div class="iframe-info__item form-group form-group--material">
            <div class="label iframe-info__title">Country</div>
            <BFormSelect
              v-model="country"
              :options="countries"
              class="form-control form-control--transparent"
            />
          </div>
          <div class="iframe-info__item form-group form-group--material">
            <div class="label iframe-info__title">Topic</div>
            <BFormSelect
              v-model="topic"
              :options="topics"
              class="form-control form-control--transparent"
            />
          </div>
          <div class="iframe-info__item form-group form-group--material">
            <div class="label iframe-info__title">Number of posts</div>
            <BFormSelect
              v-model="limit"
              :options="limits"
              class="form-control form-control--transparent"
            />
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="generator-iframe">
          <div class="generator-iframe__header">
            <div class="title">IFrame Code Generator</div>
          </div>
          <div class="generator-iframe__body list-fields">
            <div class="list-fields__row">
              <div class="list-fields__col col-12">
                <InputMaterial
                  :value="url"
                  placeholder="Iframe url"
                  readonly
                  @click.native="selectUrl"
                />
              </div>
            </div>
            <div class="list-fields__row">
              <div class="list-fields__col form-group form-group--material d-flex align-items-center">
                <div class="label">Border</div>
                <div class="custom-control custom-switch ml-3">
                  <input
                    id="borderEnabled"
                    v-model="options.borderEnabled"
                    class="custom-control-input"
                    type="checkbox"
                  >
                  <label class="custom-control-label" for="borderEnabled">
                    {{ options.borderEnabled ? 'On' : 'Off' }}
                  </label>
                </div>
              </div>
            </div>
            <div class="list-fields__row">
              <div class="col-md-6 list-fields__col">
                <InputMaterial
                  v-model="options.title"
                  input-class="form-control--transparent"
                  placeholder="Iframe title"
                />
              </div>
              <div class="col-md-2 col-9 list-fields__col">
                <InputMaterial
                  v-model.number="options.width"
                  :max="options.widthType==='%'?100:null"
                  :min="1"
                  input-class="form-control--transparent"
                  placeholder="Width"
                  type="number"
                />
              </div>
              <div class="col-md-1 col-3 list-fields__col list-fields__col--no-padding">
                <div class="form-group form-group--material">
                  <BFormSelect
                    v-model="options.widthType"
                    :options="['%','px']"
                    class="form-control form-control--transparent"
                  />
                </div>
              </div>
              <div class="col-md-2 col-9 list-fields__col">
                <InputMaterial
                  v-model.number="options.height"
                  :max="options.heightType==='%'?100:null"
                  :min="1"
                  input-class="form-control--transparent"
                  placeholder="Height"
                  type="number"
                />
              </div>
              <div class="col-md-1 col-3 list-fields__col list-fields__col--no-padding">
                <div class="form-group form-group--material">
                  <BFormSelect
                    v-model="options.heightType"
                    :options="['%','px']"
                    class="form-control form-control--transparent"
                  />
                </div>
              </div>
            </div>
            <div class="list-fields__row">
              <div class="col-md-4 list-fields__col">
                <div class="form-group form-group--material">
                  <div class="label label--like-material">Border Type</div>
                  <BFormSelect
                    v-model="options.border.type"
                    :options="borderTypes"
                    class="form-control form-control--transparent"
                  />
                </div>
              </div>
              <div class="col-md-4 list-fields__col">
                <InputMaterial
                  v-model="options.border.size"
                  :max="20"
                  :min="1"
                  input-class="form-control--transparent"
                  placeholder="Border size"
                  type="number"
                />
              </div>
              <div class="col-md-4 list-fields__col">
                <div class="form-group form-group--material">
                  <div class="label label--like-material">Border color</div>
                  <BFormInput
                    v-model="options.border.color"
                    type="color"
                    lazy
                  />
                </div>
              </div>
            </div>
            <div class="text-center">
              <button
                :disabled="!url"
                class="btn btn-cyan semi-bold"
                @click.prevent="copyUrl"
              >
                Click here to copy iframe code
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <template #end>
      <div class="d-flex justify-content-center">
        <iframe
          v-if="url"
          ref="iframe"
          :src="url"
          :style="iframeStyles"
        />
      </div>
    </template>
  </AccountLayout>
</template>

<script>
import AccountLayout from '~/layouts/Account'
import InputMaterial from '~/components/includes/InputMaterial'

import form from '~/mixins/inertia-form'
import {BFormInput, BFormSelect} from 'bootstrap-vue'
import {copyTextToClipboard} from '~/helpers/helpers'

export default {
  components: {
    AccountLayout,
    InputMaterial,
    BFormInput,
    BFormSelect
  },
  mixins: [form],
  props: {
    languages: Array,
    countries: Array,
    topics: Array
  },
  layout: null,
  data() {
    return {
      language: null,
      country: null,
      topic: null,
      limit: 4,
      options: {
        title: 'RedMedial',
        borderEnabled: false,
        height: null,
        heightType: '%',
        width: null,
        widthType: '%',
        border: {
          type: 'solid',
          size: 1,
          color: '#c7c9cb'
        }
      },
      limits: [4, 8, 12, 16],
      borderTypes: ['', 'solid', 'dashed', 'dotted', 'double']
    }
  },
  computed: {
    url() {
      let url = null

      const parameters = {}

      if (this.language) {
        parameters.language = this.language
      }
      if (this.country) {
        parameters.country = this.country
      }
      if (this.topic) {
        parameters.topic = this.topic
      }
      if (this.limit !== 4) {
        parameters.limit = this.limit
      }
      if (this.options.title) {
        parameters.title = this.options.title
      }

      const borderParameters = {}
      if (this.options.borderEnabled) {
        borderParameters.borderType = this.options.border.type
        borderParameters.borderSize = this.options.border.size
        borderParameters.borderColor = this.options.border.color
      }

      url = this.route('iframe.custom', {
        ...parameters,
        ...borderParameters
      })

      return url
    },
    iframeStyles() {
      return {
        width: this.options.width ? `${this.options.width}${this.options.widthType}` : '100%',
        'min-height': this.options.height ? `${this.options.height}${this.options.heightType}` : '371px'
      }
    }
  },
  watch: {
    'options.width'(width) {
      if (this.widthType === '%' && width > 100) {
        this.options.width = 100
      }
    },
    'options.height'(height) {
      if (this.heightType === '%' && height > 100) {
        this.options.height = 100
      }
    }
  },
  methods: {
    selectUrl(e) {
      e.target.setSelectionRange(0, e.target.value.length)
    },
    copyUrl() {
      if (this.url) {
        copyTextToClipboard(this.$refs.iframe.outerHTML, () => {
          this.notify('Iframe code has been copied to the clipboard. You can put it to your site.')
        })
      }
    }
  }
}
</script>
