<template>
    <div class="form-group">
        <a :href="route(`admin.${$parent.resource}.create`)" class="btn btn-outline-success">Create</a>
    </div>
</template>
<script>
    export default {}
</script>
