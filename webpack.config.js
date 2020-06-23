/* webpack config for better ide support */

const path = require('path')

module.exports = {
    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/js/route.js'),
            '~': path.resolve('resources/js/'),
            '@': path.resolve('resources/admin/js')
        },
    }
}
