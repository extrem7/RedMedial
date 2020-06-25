<template>
    <div class="card-footer">
        <a :href="route(`admin.${resource}.index`)" class="btn btn-outline-secondary">Back</a>
        <button class="btn btn-outline-success float-right" type="submit">{{isEdit?'Save':'Create'}}
            <b-spinner small v-show="isLoading"></b-spinner>
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            resource: String
        },
        data() {
            return {
                isEdit: this.$parent.isEdit,
            }
        },
        computed: {
            isLoading() {
                return this.$parent.isLoading
            }
        }
    }
</script>
