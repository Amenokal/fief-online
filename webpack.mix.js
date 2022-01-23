const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/lobby.js', 'public/js')
    .js('resources/js/game.js', 'public/js')
    .sass('resources/css/main.scss', 'public/css')

    // .postCss('resources/css/app.css', 'public/css', [
    // require('postcss-import'),
    // // require('tailwindcss'),
    // require('autoprefixer'),])

;
