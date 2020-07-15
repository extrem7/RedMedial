<template>
    <b-dropdown class="language" right variant="outline">
        <template v-slot:button-content>
            <img :alt="currentLang"
                 :src="`/dist/img/flags/${currentLang}.png`">
            <span ref="currentLang">{{languages[currentLang]}}</span>
        </template>
        <b-dropdown-item :key="code" @click="translate(code)" v-for="(lang,code) in languages">
            <img :alt="code" :src="`/dist/img/flags/${code}.png`">
            <span>{{lang}}</span>
        </b-dropdown-item>
        <div id="google_translate_element" ref="translator"></div>
    </b-dropdown>
</template>

<script>
    import {BDropdown, BDropdownItem} from 'bootstrap-vue'

    export default {
        data() {
            return {
                currentLang: 'es',
                languages: {
                    'zh-CN': 'Chinese (Simplified)',
                    nl: 'Dutch',
                    en: 'English',
                    fr: 'French',
                    de: 'German',
                    it: 'Italian',
                    pt: 'Portuguese',
                    ru: 'Russian',
                    es: 'Spanish'
                }
            }
        },
        methods: {
            translate(code = null) {
                new google.translate.TranslateElement({
                    pageLanguage: 'es',
                }, 'google_translate_element')

                if (code == null) {
                    code = this.$ls.get('lang')
                } else if (code !== 'es') {
                    this.$ls.set('lang', code)
                } else {
                    this.$ls.remove('lang')
                }

                this.currentLang = code

                this.$refs.currentLang.innerHTML = this.languages[this.currentLang]

                setTimeout(() => {
                    const select = this.$refs.translator.querySelector('.goog-te-combo')
                    select.value = code
                    select.dispatchEvent(new Event('change'))
                }, 100)

            }
        },
        mounted() {
            const apiScript = document.createElement('script')
            apiScript.src = '//translate.google.com/translate_a/element.js'
            document.head.append(apiScript)

            apiScript.onload = () => {
                setTimeout(() => {
                    if (this.$ls.get('lang')) this.translate()
                }, 100)
            }
        },
        components: {
            BDropdown,
            BDropdownItem
        }
    }
</script>
