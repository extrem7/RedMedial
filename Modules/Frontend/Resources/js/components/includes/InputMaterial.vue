<template>
  <div
    :class="{'form-group--last' : isLastChild, 'has-error':errors.length}"
    class="form-group form-group--material"
  >
     <span
       v-if="type==='password'"
       class="btn-show-password"
       @click="togglePassword">
         <SvgVue
           class="btn-show-password__icon"
           icon="eye"/>
    </span>
    <label
      :class="{'label--active': inFocus || value|| readonly}"
      :for="id"
      class="label label--material"
    >
      {{ placeholder }}
    </label>
    <slot :state="errors.length!==0?false:null">
      <input
        :id="id"
        :value="value"
        class="form-control"
        :class="[inputClass, {
          'form-control--has-icon': type==='password',
          'bg-transparent': readonly
        }]"
        :max="max"
        :min="min"
        :readonly="readonly"
        :required="required"
        :type="inputType"
        @input="$emit('input',$event.target.value)"
        @blur="inFocus = false"
        @focus="inFocus = true"
      >
    </slot>
    <div v-if="errors.length">
      <div
        v-for="(error,key) in errors"
        :key="key"
        class="invalid-feedback">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script>
/** @property bag */
export default {
  props: {
    value: String | Number,
    name: String,
    type: {
      type: String,
      default: 'text'
    },
    placeholder: {
      type: String
    },
    id: {
      type: String,
      required: false
    },
    min: Number,
    max: Number,
    inputClass: {
      type: String,
      required: false
    },
    isLastChild: {
      type: Boolean,
      default: false,
    },
    readonly: {
      type: Boolean,
      default: false
    },
    disabled: {
      type: Boolean,
      default: false
    },
    required: {
      type: Boolean,
      default: false
    },
  },
  inject: ['bag'],
  data() {
    return {
      inFocus: false,
      inputType: this.type
    }
  },
  computed: {
    errors() {
      const errors = []
      if (this.name) {
        const bag = this.bag.errors
        for (let key in bag) {
          if (bag.hasOwnProperty(key) && key.startsWith(this.name)) {
            errors.push(bag[key])
          }
        }
      }
      return errors
    }
  },
  methods: {
    togglePassword() {
      this.inputType = this.inputType === 'password' ? 'type' : 'password'
    }
  }
}
</script>
