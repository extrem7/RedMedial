<template>
    <form @submit.prevent="$emit('search')" class="form-group w-25 d-flex">
        <input :value="value" @input="$emit('input',$event.target.value)" class="form-control" placeholder="Search"
               type="search">
        <button class="btn btn-outline-primary ml-1">Search</button>
    </form>
</template>

<script>
    export default {
        props: {
            value: String
        }
    }
</script>
