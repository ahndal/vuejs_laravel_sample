let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'resources/assets/admin/css/font-awesome.min.css',
    'resources/assets/admin/css/simple-line-icons.min.css',
    'resources/assets/admin/css/style.css',
], 'public/css/admin.css')
.scripts([
    'resources/assets/admin/js/jquery.min.js',
    'resources/assets/admin/js/popper.min.js',
    'resources/assets/admin/js/bootstrap.min.js',
    'resources/assets/admin/js/Chart.min.js',
    'resources/assets/admin/js/pace.min.js',
    'resources/assets/admin/js/template.js',
], 'public/js/admin.js')
.js([
    'resources/assets/js/app.js'
], 'public/js/app.js');
