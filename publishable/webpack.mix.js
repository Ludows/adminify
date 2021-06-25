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
mix.options({
    processCssUrls: false
});
mix.js('resources/js/argon.js', 'public/argon/js')
    .js('resources/js/extensions.js', 'public/argon/js')
    .js('resources/js/extensions-call.js', 'public/argon/js')
    .js('resources/js/searchable.js', 'public/argon/js')
    .vue('resources/js/app.js', 'public/argon/js')
    .sass('resources/sass/argon.scss', 'public/argon/css')
    .sass('resources/sass/extensions.scss', 'public/argon/css');
