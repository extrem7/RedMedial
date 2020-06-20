import Alert from "./includes/Alert"

export default {
    Alert,

    PagesIndex: () => import('./pages/Index'),
    PageCreate: () => import('./pages/Create'),
    PageEdit: () => import('./pages/Edit'),

    ArticlesIndex: () => import('./articles/Index'),
    ArticleCreate: () => import('./articles/Create'),
    ArticleEdit: () => import('./articles/Edit'),

    UsersIndex: () => import('./users/Index'),
    UserCreate: () => import('./users/Create'),
    UserEdit: () => import('./users/Edit'),
}
