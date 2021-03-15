import Alert from './includes/Alert'
import Logout from './layout/Logout'
import MenuToggle from './layout/MenuToggle'

export default {
  Alert,
  Logout,
  MenuToggle,

  ModelsMultiselect: () => import('./settings/ModelsMultiselect'),

  PagesIndex: () => import('./pages/Index'),
  PageForm: () => import('./pages/Form'),

  ArticlesIndex: () => import('./articles/Index'),
  ArticleForm: () => import('./articles/Form'),

  UsersIndex: () => import('./users/Index'),
  UserForm: () => import('./users/Form'),

  RssChannelsIndex: () => import('./rss/channels/Index'),
  RssChannelForm: () => import('./rss/channels/Form'),
  RssChannelsSort: () => import('./rss/channels/Sort'),

  RssCountriesIndex: () => import('./rss/countries/Index'),
  RssCountryForm: () => import('./rss/countries/Form'),

  RssLanguagesIndex: () => import('./rss/languages/Index'),
  RssLanguageForm: () => import('./rss/languages/Form'),

  RssCategoriesIndex: () => import('./rss/categories/Index'),
  RssCategoryForm: () => import('./rss/categories/Form'),

  PlaylistsIndex: () => import('./playlists/Index'),
  PlaylistForm: () => import('./playlists/Form'),
}
