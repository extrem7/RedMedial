import AlertNotification from "./includes/AlertNotification"

import RedHeader from "./layout/Header"
import RedFooter from './layout/Footer'

import Social from "./layout/Social"
import CopyIframe from "./includes/CopyIframe"
//import RssItem from "~/components/layout/RssItem"
import YoutubePlayer from "./layout/YoutubePlayer"
//import ArticlesList from "~/components/Articles/List"
import Article from "./articles/Item"
import Share from "./includes/Share"

export default {
    AlertNotification,

    RedHeader,
    RedFooter,

    Social,
    CopyIframe,
    RssItem: () => import('./rss/channels/Channel'),
    YoutubePlayer,
    Share,

    ArticlesList: () => import('./articles/List'),
    ArticleItem: Article,//temp

    RssList: () => import('./rss/channels/List'),

    Playlists: () => import('./playlists/List'),

    FormContacto: () => import('./forms/Contacto'),
    FormRedDeMedios: () => import('./forms/RedDeMedios')
}
