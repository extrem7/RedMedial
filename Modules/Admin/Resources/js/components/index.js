import Alert from "./includes/Alert"
import Logout from "./layout/Logout"
import MenuToggle from "./layout/MenuToggle"

export default {
    Alert,
    Logout,
    MenuToggle,

    PagesIndex: () => import('./pages/Index'),
    PageForm: () => import('./pages/Form'),

    ArticlesIndex: () => import('./articles/Index'),
    ArticleForm: () => import('./articles/Form'),

    UsersIndex: () => import('./users/Index'),
    UserForm: () => import('./users/Form'),

    RssCountriesIndex: () => import('./rss/countries/Index'),
    RssCountryForm: () => import('./rss/countries/Form'),

    RssChannelsIndex: () => import('./rss/channels/Index'),
    RssChannelForm: () => import('./rss/channels/Form'),
}
