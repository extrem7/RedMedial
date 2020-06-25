import AlertNotification from "~/components/includes/AlertNotification"

import RedHeader from "~/components/layout/Header"
import RedFooter from '~/components/layout/Footer'

import Social from "~/components/layout/Social"
//import RssItem from "~/components/layout/RssItem"
import YoutubePlayer from "~/components/layout/YoutubePlayer"
//import ArticlesList from "~/components/Articles/List"
import Article from "~/components/articles/Item"


export default {
    AlertNotification,

    RedHeader,
    RedFooter,

    Social,
    RssItem: () => import('./layout/RssItem'),
    YoutubePlayer,

    ArticlesList: () => import('./articles/List'),
    ArticleItem: Article,//temp

    FormContacto: () => import('./forms/Contacto'),
    FormRedDeMedios: () => import('./forms/RedDeMedios')
}
