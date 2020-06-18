const path = require('path')

module.exports = {
    output: {chunkFilename: 'js/[name].js?id=[chunkhash]'},
    resolve: {
        alias: {
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/js/route.js'),
            '~': path.resolve('resources/js/'),
            '@': path.resolve('resources/admin/js')
        },
    }
}
