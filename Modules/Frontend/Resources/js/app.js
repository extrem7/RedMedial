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
            sidebarChannel: this.shared('sidebarChannel') || null,
            sidebarChannels: this.shared('sidebarChannels') || [],
        }
    },
    methods: {
        mapVisible(visible) {
            if (visible) {
                setTimeout(() => {
                    this.$refs.map.src = 'https://www.arcgis.com/apps/opsdashboard/index.html#/bda7594740fd40299423467b48e9ecf6'
                }, 3000)
            }
        }
    },
    components,
})
