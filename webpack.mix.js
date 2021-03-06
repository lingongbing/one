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

mix.js('resources/assets/homes/js/app.js', 'public/homes/js')
    .sass('resources/assets/homes/sass/app.scss', 'public/homes/css').version();

mix.js('resources/assets/admins/js/app.js', 'public/admins/js')
    .sass('resources/assets/admins/sass/app.scss', 'public/admins/css').version();