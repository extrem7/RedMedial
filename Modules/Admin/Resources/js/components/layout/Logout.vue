<template>
    <li>
        <a @click.prevent="logout" class="btn btn-outline-secondary float-right logout" href="#">Logout</a>
        <form :action="route('admin.logout')" class="d-none" method="POST" ref="form">
            <input :value="csrf" name="_token" type="hidden">
        </form>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                csrf: this.shared('csrf')
            }
        },
        methods: {
            logout() {
                this.$refs.form.submit()
            }
        }
    }
</script>

