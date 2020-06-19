import Alert from "./includes/Alert"
import Invalid from "./includes/Invalid"

export default {
    Alert,
    Invalid,

    ArticleCreate: () => import('./articles/Create'),
    ArticleEdit: () => import('./articles/Edit'),
}
