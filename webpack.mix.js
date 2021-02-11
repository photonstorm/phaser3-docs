const mix = require('laravel-mix');

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

mix.react('resources/js/app.js', 'public/js')
    .react('resources/js/docs.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/docs.scss', 'public/css')
    .webpackConfig({
        devServer: {
            proxy: {
                '*': 'http://localhost:8000'
            }
        }
    });
