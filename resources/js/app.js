import Vue from 'vue'

import './plugins'
import './filters'

import components from './components'

import store from './store'

const app = new Vue({
    el: '#app',
    data() {
        return {
            singleRss: {
                name: 'The Gray Zone',
                link: 'https://',
                linkArchive: 'https://',
                img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                alt: 'alt',
                news: [
                    {
                        name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                        time: '04:50',
                        link: 'https://'
                    },
                    {
                        name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                        time: '04:50',
                    },
                    {
                        name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                        time: '04:50',
                        link: 'https://'
                    },
                    {
                        name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                        time: '04:50',
                        link: 'https://'
                    },
                    {
                        name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                        time: '04:50',
                        link: 'https://'
                    }
                ]
            },
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
            rssList: [
                {
                    name: 'The Gray Zone',
                    link: 'https://',
                    linkArchive: 'https://',
                    img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                    alt: 'alt',
                    news: [
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        }
                    ]
                },
                {
                    name: 'The Gray Zone',
                    link: 'https://',
                    linkArchive: 'https://',
                    img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                    alt: 'alt',
                    news: [
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        }
                    ]
                },
                {
                    name: 'The Gray Zone',
                    link: 'https://',
                    linkArchive: 'https://',
                    img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                    alt: 'alt',
                    news: [
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        }
                    ]
                },
                {
                    name: 'The Gray Zone',
                    link: 'https://',
                    linkArchive: 'https://',
                    img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                    alt: 'alt',
                    news: [
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        }
                    ]
                },
                {
                    name: 'The Gray Zone',
                    link: 'https://',
                    linkArchive: 'https://',
                    img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                    alt: 'alt',
                    news: [
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        }
                    ]
                },
                {
                    name: 'The Gray Zone',
                    link: 'https://',
                    linkArchive: 'https://',
                    img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                    alt: 'alt',
                    news: [
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        }
                    ]
                },
                {
                    name: 'The Gray Zone',
                    link: 'https://',
                    linkArchive: 'https://',
                    img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                    alt: 'alt',
                    news: [
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        }
                    ]
                },
                {
                    name: 'The Gray Zone',
                    link: 'https://',
                    linkArchive: 'https://',
                    img: 'https://redmedial.com/wp-content/uploads/2019/08/Captura-de-pantalla-2019-08-15-a-las-23.07.00.png',
                    alt: 'alt',
                    news: [
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        },
                        {
                            name: 'Queiroz, envolvido em “rachadinha” no gabinete de Flávio Bolsonaro, é preso em SP',
                            time: '04:50',
                            link: 'https://'
                        }
                    ]
                },
            ],
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
            isLoading: true,
            name: '',
            email: ''
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
    store
})

store.app = app
