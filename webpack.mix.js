const mix = require('laravel-mix')
const config = require('./webpack.config')

require('laravel-mix-svg-vue')
require('laravel-mix-merge-manifest')

mix.webpackConfig({
  output: {chunkFilename: 'dist/js/chunks/[name].js?id=[chunkhash]'},
  ...config
})

mix.options({
  processCssUrls: false,
  terser: {
    extractComments: false,
  }
})

mix.sass('Modules/Frontend/Resources/scss/app.scss', 'public/dist/css').version().sourceMaps()

mix.copy('Modules/Frontend/Resources/layout/src/img', 'public/dist/img')

mix.js('Modules/Frontend/Resources/js/app.js', 'public/dist/js/').svgVue({
  svgPath: 'Modules/Frontend/Resources/layout/src/svg',
}).sourceMaps().version()

mix.mergeManifest()
