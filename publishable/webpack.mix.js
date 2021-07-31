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
mix.js('resources/adminify/js/argon.js', 'public/argon/js')
    .js('resources/adminify/js/extensions.js', 'public/argon/js')
    .js('resources/adminify/js/extensions-call.js', 'public/argon/js')
    .js('resources/adminify/js/searchable.js', 'public/argon/js')
    .js('resources/adminify/js/listings.js', 'public/argon/js')
    .js('resources/adminify/js/menuBuilder.js', 'public/argon/js')
    .js('resources/adminify/js/sendMail.js', 'public/argon/js')
    .vue('resources/adminify/js/app.js', 'public/argon/js')
    .sass('resources/adminify/sass/argon.scss', 'public/argon/css')
    .sass('resources/adminify/sass/front.scss', 'public/argon/css')
    .sass('resources/adminify/sass/extensions.scss', 'public/argon/css');
