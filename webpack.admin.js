const mix = require('laravel-mix')
const config = require('./webpack.config')

require('laravel-mix-svg-vue')
require('laravel-mix-merge-manifest')

mix.webpackConfig({
  output: {chunkFilename: 'admin/js/chunks/[name].js?id=[chunkhash]'},
  ...config
})

mix.options({
  processCssUrls: false,
  terser: {
    extractComments: false,
  }
})

mix.js('Modules/Admin/Resources/js/app.js', 'public/admin/js')
  .vue()
  .svgVue({svgPath: 'Modules/Admin/Resources/assets/svg'})

mix.sass('Modules/Admin/Resources/scss/app.scss', 'public/admin/css')

mix.copy('node_modules/pace-js/themes/blue/pace-theme-minimal.css', 'public/admin/css/pace.css')
mix.copy('node_modules/pace-js/pace.min.js', 'public/admin/js/pace.js')

mix.copy('Modules/Admin/Resources/assets/img', 'public/admin/img')

mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/admin/webfonts')

mix.sourceMaps()
  .version(['public/admin/js/app.js', 'public/admin/css/app.css'])
  .disableSuccessNotifications()
  .mergeManifest()
