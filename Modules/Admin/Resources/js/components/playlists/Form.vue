<template>
    <form @submit.prevent class="card card-primary" ref="form">
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" id="title" placeholder="Title" type="text"
                       v-model="form.title" v-valid.title>
                <invalid name="name"></invalid>
            </div>
            <div class="form-group">
                <label for="title">Videos</label>
                <vue-repeater v-model="fields"></vue-repeater>
                <invalid name="videos"></invalid>
            </div>
            <div class="form-group">
                <label for="country_id">Country</label>
                <v-select :clearable="false" :options="countries" :reduce="label => label.value" :searchable="false"
                          class="form-control" inputId="country_id" placeholder="Country" v-model="form.country_id"
                          v-valid.country_id></v-select>
                <invalid name="country_id"></invalid>
            </div>
        </div>
        <card-footer @submit="submitForm" resource="playlists"></card-footer>
    </form>
</template>

<script>
    import Vue from 'vue'

    import form from "@/mixins/form"
    import VueRepeater from 'vue-repeater'

    import VideoField from "@/components/playlists/VideoField"

    Vue.component('video-field', VideoField)

    export default {
        data() {
            return {
                form: {
                    title: '',
                    country_id: null
                },
                fields: [
                    {
                        name: 'video-field',
                        value: {}
                    }
                ],
                countries: [{label: 'None', value: null}, ...this.shared('countries')],
                resource: 'playlists'
            }
        },
        methods: {
            submitForm() {
                if (this.$refs.form.reportValidity()) this.submit()
            },
            async submit() {
                let form
                if (this.isEdit) {
                    form = {
                        _method: 'PATCH',
                        ...this.form
                    }
                } else {
                    form = this.form
                }

                form.videos = this.fields.map(({value}) => value)

                try {
                    if (this.isEdit) {
                        const {status, data} = await this.send(this.route('admin.playlists.update', this.id), form)
                        if (status === 200) {
                            this.setupEdit(null, data.playlist)
                            this.$bus.emit('alert', {text: data.status})
                        }
                    } else {
                        const {status, data} = await this.send(this.route('admin.playlists.store'), form)

                        if (status === 201) {
                            this.$bus.emit('alert', {text: data.status})
                            setTimeout(() => {
                                window.location = this.route('admin.playlists.edit', data.id)
                            }, 2500)
                        }
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        },
        created() {
            const playlist = this.setupEdit('playlist')
            this.fields = playlist.videos.map(value => {
                return {
                    name: 'video-field',
                    value
                }
            })
        },
        mixins: [form],
        components: {
            VueRepeater
        }
    }
</script>

