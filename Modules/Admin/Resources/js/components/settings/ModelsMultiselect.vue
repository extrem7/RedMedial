<template>
    <div>
        <vue-tags-input :add-from-paste="false"
                        :add-only-from-autocomplete="true"
                        :autocomplete-items="filteredItems"
                        :tags="selected"
                        @tags-changed="newTags => selected = newTags"
                        class="bg-dark"
                        v-model="name"></vue-tags-input>
        <input :name="inputName" :value="value" type="hidden">
    </div>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input'

    export default {
        props: {
            inputName: String
        },
        data() {
            return {
                name: '',
                selected: [],
                channels: this.shared(this.inputName)
            }
        },
        computed: {
            value() {
                return this.selected.map(({id}) => id).join(',')
            },
            filteredItems() {
                return this.channels.filter(i => {
                    return i.text.toLowerCase().indexOf(this.name.toLowerCase()) !== -1;
                });
            },
        },
        created() {
            this.selected = this.channels.filter(({selected}) => selected)
        },
        components: {
            VueTagsInput
        }
    }
</script>
