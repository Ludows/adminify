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
mix.js('resources/adminify/back/js/argon.js', 'public/argon/back/js')
    .js('resources/adminify/back/js/extensions.js', 'public/argon/back/js')
    .js('resources/adminify/back/js/extensions-call.js', 'public/argon/back/js')
    .js('resources/adminify/back/js/searchable.js', 'public/argon/back/js')
    .js('resources/adminify/back/js/listings.js', 'public/argon/back/js')
    .js('resources/adminify/back/js/menuBuilder.js', 'public/argon/back/js')
    .js('resources/adminify/back/js/sendMail.js', 'public/argon/back/js')
    .vue('resources/adminify/front/js/app.js', 'public/argon/front/js')
    .sass('resources/adminify/front/sass/argon.scss', 'public/argon/front/css')
    .sass('resources/adminify/back/sass/argon.scss', 'public/argon/back/css')
    .sass('resources/adminify/front/sass/front.scss', 'public/argon/front/css')
    .sass('resources/adminify/back/sass/extensions.scss', 'public/argon/back/css');
