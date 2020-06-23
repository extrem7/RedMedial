<template>
    <b-alert
        :class="`fixed-${position}`"
        :variant="variant"
        class="position-fixed m-0 rounded-0 text-center"
        dismissible
        fade
        style="z-index: 2000;"
        v-model="showAlert">
        {{text}}
    </b-alert>
</template>

<script>

    export default {
        data() {
            return {
                showAlert: false,
                variant: null,
                text: null,
                position: null,
                delay: null,

                timeout: null,
            }
        },
        created() {
            this.$bus.on('alert', ({variant = 'success', text, position = 'top', delay = 5}) => {
                clearTimeout(this.timeout)

                this.variant = variant
                this.text = text
                this.position = position

                this.showAlert = true
                this.timeout = setTimeout(() => {
                    this.showAlert = false
                }, delay * 1000)
            })
        }
    }
</script>
