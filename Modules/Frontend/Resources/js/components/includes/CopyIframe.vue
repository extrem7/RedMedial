<template>
    <a @click.prevent="copy" class="red-color copy-iframe" href="">
        <img alt="copy" class="mr-2" src="/dist/img/icons/copy.svg">
        {{text}}
    </a>
</template>

<script>
    import {copyTextToClipboard} from '~/helpers/helpers'

    export default {
        props: {
            text: String,
            iframe: String
        },
        methods: {
            copy() {
                copyTextToClipboard(this.iframe, () => {
                    this.$bus.emit('alert', {
                        text: 'Iframe code has been copied to the clipboard. You can put it to your site.',
                        delay: 8
                    })
                })
            }
        }
    }
</script>
