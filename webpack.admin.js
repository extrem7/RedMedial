const mix = require('laravel-mix')
const config = require('./webpack.config')

require('laravel-mix-svg-vue')
require('laravel-mix-merge-manifest')

mix.webpackConfig({
    output: {chunkFilename: 'admin/js/chunks/[name].js?id=[chunkhash]'},
    ...config
})

mix.options({processCssUrls: false})

mix.sass('resources/admin/scss/app.scss', 'public/admin/css').version().sourceMaps()

mix.js('resources/admin/js/app.js', 'public/admin/js').svgVue({svgPath: 'resources/admin/svg'}).version().sourceMaps()

mix.copy('node_modules/pace-js/themes/blue/pace-theme-minimal.css', 'public/admin/css/pace.css')
mix.copy('node_modules/pace-js/pace.min.js', 'public/admin/js/pace.js')

mix.scripts([
    'node_modules/admin-lte/plugins/jquery/jquery.min.js',
    'node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'node_modules/bs-custom-file-input/dist/bs-custom-file-input.min.js',
    'node_modules/admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.js',
    'node_modules/admin-lte/dist/js/adminlte.min.js',
    //'node_modules/jquery-ui-dist/jquery-ui.js',
    //'node_modules/sortablejs/Sortable.min.js',
    'resources/admin/js/main.js'
], 'public/admin/js/main.js').version()

mix.copy('resources/admin/img', 'public/admin/img')

mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/admin/webfonts')

mix.mergeManifest()
