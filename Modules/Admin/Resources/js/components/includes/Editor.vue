<template>
    <div>
        <editor :init="init" :initial-value="initial" :value="value" @input="$emit('input',$event)"
                api-key="no-api-key"/>
    </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue'

    export default {
        props: {
            name: {
                type: String
            },
            initial: {
                type: String,
                default: ''
            },
            height: {
                type: Number,
                default: 500
            },
            placeholder: {
                type: String,
                default: ''
            },
            value: String
        },
        data() {
            return {
                init: {
                    height: null,
                    placeholder: this.placeholder,
                    plugins: [
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table paste imagetools wordcount"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                    content_css: [
                        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                        '//www.tiny.cloud/css/codepen.min.css'
                    ],
                    skin: "oxide-dark",
                    convert_urls: false,
                    images_upload_handler: async (blobInfo, success, failure) => {
                        const formData = new FormData()
                        formData.append('image', blobInfo.blob(), blobInfo.filename())
                        try {
                            const {data} = await this.axios.post(this.route('admin.media.upload'), formData, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            success(data.location)
                        } catch ({response}) {
                            if (response.status === 422) {
                                failure('Error: ' + response.data.errors.image.join('\n'));
                            } else {
                                failure('HTTP Error: ' + response.status);
                            }
                        }
                    }
                }
            }
        },
        created() {
            this.init.height = this.height
            this.text = this.initial
        },
        components: {
            'editor': Editor
        }
    }
</script>
