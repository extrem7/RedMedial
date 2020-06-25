<template>
    <div class="d-flex">
        <a :href="route(`admin.${resource}.edit`,id)" class="btn btn-outline-primary">
            Edit
        </a>
        <button @click.prevent="$emit('delete')" class="btn btn-outline-danger ml-2">
            Delete
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            id: Number,
            resource: String
        }
    }
</script>

