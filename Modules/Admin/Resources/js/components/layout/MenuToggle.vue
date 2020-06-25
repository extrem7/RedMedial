<template>
    <a @click.prevent="toggle" class="nav-link" href="#">
        <i class="fas fa-bars"></i>
    </a>
</template>

<script>
    export default {
        methods: {
            toggle() {
                document.body.classList.toggle('sidebar-collapse')
                if (app.$cookies.get('sidebar-toggle-collapsed')) {
                    app.$cookies.remove('sidebar-toggle-collapsed')
                } else {
                    app.$cookies.set('sidebar-toggle-collapsed', 1, -1)
                }
            }
        }
    }
</script>
