<template>
    <div class="form-group redmedial-cropper">
        <input @change="setImage" accept="image/*" name="image" ref="input" type="file">
        <div class="d-flex justify-content-around mb-3">
            <a @click.prevent="showFileChooser" class="btn btn-outline-primary" href="#">Choose image</a>
            <a @click.prevent="resetImage" class="btn btn-outline-danger" href="#" v-if="image">Reset</a>
        </div>
        <img :src="old" alt="old-image" class="old-image" v-if="!image">
        <vue-cropper :src="image" ref="cropper" v-show="image"></vue-cropper>
        <invalid :name="validate" deep is-array v-if="validate"></invalid>
    </div>
</template>

<script>
    import VueCropper from 'vue-cropperjs'
    import Invalid from "./Invalid"

    export default {
        props: {
            old: String,
            validate: String,
            errors: Object
        },
        data() {
            return {
                imageName: null,
                image: null,
            }
        },
        methods: {
            async getBlob() {
                return new Promise((resolve) => {
                    if (!this.image) resolve(null)
                    const canvas = this.$refs.cropper.getCroppedCanvas()
                    if (canvas)
                        canvas.toBlob((blob) => {
                            blob.name = this.imageName
                            resolve(blob)
                        })

                })
            },
            resetImage() {
                this.image = null
                this.$refs.cropper.reset()
            },
            setImage(e) {
                const file = e.target.files[0]
                if (file.type.indexOf('image/') === -1) {
                    alert('Please select an image file')
                    return
                }
                this.imageName = file.name
                const reader = new FileReader()
                reader.onload = (event) => {
                    this.image = event.target.result
                    this.$refs.cropper.replace(event.target.result)
                }
                reader.readAsDataURL(file)
            },
            showFileChooser() {
                this.$refs.input.click()
            },
        },
        components: {
            Invalid,
            VueCropper
        }
    }
</script>
