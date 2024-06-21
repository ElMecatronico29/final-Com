const mix = require('laravel-mix');
require('dotenv').config();

mix.js('resources/js/app.js', 'public/js')
   .vue()
   // .sass('resources/sass/app.scss', 'public/css')
   .webpackConfig({
       resolve: {
           alias: {
               'vue$': 'vue/dist/vue.esm-bundler.js'
           }
       }
   });