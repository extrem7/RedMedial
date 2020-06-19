import Alert from "./includes/Alert"
import Invalid from "./includes/Invalid"

export default {
    Alert,
    Invalid,

    ArticlesIndex: () => import('./articles/Index'),
    ArticleCreate: () => import('./articles/Create'),
    ArticleEdit: () => import('./articles/Edit'),
}
