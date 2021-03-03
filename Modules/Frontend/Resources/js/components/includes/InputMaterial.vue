<template>
  <div :class="{'form-group--last' : isLastChild, 'has-error':errors.length}"
       class="form-group form-group--material">
     <span v-if="type==='password'"
           class="btn-show-password"
           @click="togglePassword">
         <SvgVue
           class="btn-show-password__icon"
           icon="eye"/>
    </span>
    <label :class="{'label--active' : inFocus||value}"
           :for="id"
           class="label label--material">
      {{ placeholder }}
    </label>
    <input
      :id="id"
      :class="[inputClass, {'form-control--has-icon' : type==='password'}]"
      :required="required"
      :type="inputType"
      :value="value"
      class="form-control"
      @blur="inFocus = false"
      @focus="inFocus = true"
      @input="$emit('input',$event.target.value)"
    >
    <div v-if="errors.length">
    <span
      v-for="(error,key) in errors"
      :key="key"
      class="invalid-feedback">
      {{ error }}
    </span>
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
    inputClass: {
      type: String,
      required: false
    },
    isLastChild: {
      type: Boolean,
      default: false,
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
