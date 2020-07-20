import Vue from 'vue'

import './plugins'
import './filters'

import components from './components'

const app = new Vue({
    el: '#app',
    data() {
        return {
            singleYoutube: {
                title: 'El Ciudadano TV (ECTV)',
                lists: [
                    {
                        name: 'Grupo 1de música recauda fondos para apoyar a personal médico de México',
                        time: '22:44',
                        thumb: 'https://img.youtube.com/vi/YRhSjA31mmA/default.jpg',
                        alt: 'alt',
                        src: 'https://www.youtube.com/embed/KLLe7N9453s'
                    },
                ]
            },
            youtube: [
                {
                    title: 'El Ciudadano TV (ECTV)',
                    lists: [
                        {
                            name: 'Grupo 1de música recauda fondos para apoyar a personal médico de México',
                            time: '22:44',
                            thumb: 'https://img.youtube.com/vi/YRhSjA31mmA/default.jpg',
                            alt: 'alt',
                            src: 'https://www.youtube.com/embed/KLLe7N9453s'
                        },
                        {
                            name: 'Grupo 1de música recauda fondos para apoyar a personal médico de México',
                            time: '22:44',
                            thumb: 'https://img.youtube.com/vi/YRhSjA31mmA/default.jpg',
                            alt: 'alt'
                        },
                        {
                            name: 'Grupo 1de música recauda fondos para apoyar a personal médico de México',
                            time: '22:44',
                            thumb: 'https://img.youtube.com/vi/YRhSjA31mmA/default.jpg',
                            alt: 'alt'
                        },
                        {
                            name: 'Grupo 1de música recauda fondos para apoyar a personal médico de México',
                            time: '22:44',
                            thumb: 'https://img.youtube.com/vi/YRhSjA31mmA/default.jpg',
                            alt: 'alt'
                        },
                        {
                            name: 'Grupo 1de música recauda fondos para apoyar a personal médico de México',
                            time: '22:44',
                            thumb: 'https://img.youtube.com/vi/YRhSjA31mmA/default.jpg',
                            alt: 'alt'
                        },
                        {
                            name: 'Grupo 1de música recauda fondos para apoyar a personal médico de México',
                            time: '22:44',
                            thumb: 'https://img.youtube.com/vi/YRhSjA31mmA/default.jpg',
                            alt: 'alt'
                        }
                    ]
                },
            ],
            singleRss: {
                id: 258,
                name: 'Лига информ',
                slug: "liga-inform",
                link: 'https://ligainform.net',
                logo: 'http://redmedial.loc/dist/img/no-image.jpg',
                posts: [
                    {
                        title: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                        slug: 'v-dnepre-oficer-policii-vystrelila-sebe-v-golovu-nahodyas-na-sluzhbe'
                    },
                ]
            },
        }
    },
    computed: {
        myList: {
            get() {
                return this.$store.state.myList
            },
            set(value) {
                this.$store.commit('updateList', value)
            }
        }
    },
    components,
})
