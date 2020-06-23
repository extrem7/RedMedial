const mix = require('laravel-mix')
const config = require('./webpack.config')

require('laravel-mix-svg-vue')
require('laravel-mix-merge-manifest')

mix.webpackConfig({
    output: {chunkFilename: 'dist/js/chunks/[name].js?id=[chunkhash]'},
    ...config
})

mix.options({processCssUrls: false})

mix.sass('resources/scss/app.scss', 'public/dist/css').version().sourceMaps()

    .copy('resources/frontend/src/img', 'public/dist/img')

    .js('resources/js/app.js', 'public/dist/js/').svgVue({
    svgPath: 'resources/frontend/src/svg',
}).version().sourceMaps()

    .mergeManifest()
