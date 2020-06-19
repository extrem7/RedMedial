<template>
    <span class="invalid-feedback" v-html="$parent.errors[name]" v-if="name in $parent.errors"></span>
</template>

<script>
    export default {
        props: {
            name: String
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
