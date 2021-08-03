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
mix.js('resources/adminify/back/js/argon.js', 'public/argon/js')
    .js('resources/adminify/back/js/extensions.js', 'public/argon/js')
    .js('resources/adminify/back/js/extensions-call.js', 'public/argon/js')
    .js('resources/adminify/back/js/searchable.js', 'public/argon/js')
    .js('resources/adminify/back/js/listings.js', 'public/argon/js')
    .js('resources/adminify/back/js/menuBuilder.js', 'public/argon/js')
    .js('resources/adminify/back/js/sendMail.js', 'public/argon/js')
    .vue('resources/adminify/front/js/app.js', 'public/argon/js')
    .sass('resources/adminify/front/sass/argon.scss', 'public/argon/css')
    .sass('resources/adminify/back/sass/argon.scss', 'public/argon/css')
    .sass('resources/adminify/front/sass/front.scss', 'public/argon/css')
    .sass('resources/adminify/back/sass/extensions.scss', 'public/argon/css');
