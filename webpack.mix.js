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

mix.js('Modules/Frontend/Resources/js/app.js', 'public/dist/js/')
  .vue()
  .svgVue({svgPath: 'Modules/Frontend/Resources/layout/src/svg'})

mix.js('Modules/Frontend/Resources/js/iframe.js', 'public/dist/js/')

mix.sass('Modules/Frontend/Resources/scss/app.scss', 'public/dist/css')

mix.copy('Modules/Frontend/Resources/layout/src/img', 'public/dist/img')

mix.sourceMaps(false)
  .version(['public/dist/js/app.js', 'public/dist/css/app.css'])
  .disableSuccessNotifications()
  .mergeManifest()
