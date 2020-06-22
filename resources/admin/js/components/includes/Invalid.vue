<template>
    <div>
        <span class="invalid-feedback" v-for="error in array" v-if="isArray && array.length">{{error}}</span>
        <span class="invalid-feedback" v-if="!isArray && name in parentErrors">{{parentErrors[name]}}</span>
    </div>
</template>

<script>
    export default {
        props: {
            name: String,
            isArray: {
                type: Boolean,
                default: false
            },
            deep: Boolean
        },
        computed: {
            parentErrors() {
                return this.deep ? this.$parent.$parent.errors : this.$parent.errors
            },
            array() {
                const parentErrors = this.parentErrors
                const errors = []
                if (Object.keys(parentErrors).length && this.isArray) {
                    for (let key in parentErrors) {
                        if (key.includes(this.name)) {
                            errors.push(parentErrors[key])
                        }
                    }
                }
                return errors
            }
        }
    }
</script>

<style scoped>
    .invalid-feedback {
        display: block !important;
        font-weight: bold;
        font-size: 100%;
    }
</style>
