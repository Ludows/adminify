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
mix.js('resources/adminify/back/js/argon.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/extensions.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/extensions-call.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/searchable.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/listings.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/menuBuilder.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/confirmation.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/editor.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/editor/GalleryWidget.js', 'public/adminify/back/js/editor')
    .js('resources/adminify/back/js/editor/ImageWidget.js', 'public/adminify/back/js/editor')
    .js('resources/adminify/back/js/editor/RowWidget.js', 'public/adminify/back/js/editor')
    .js('resources/adminify/back/js/editor/titleWidget.js', 'public/adminify/back/js/editor')
    .js('resources/adminify/back/js/editor/TemplateWidget.js', 'public/adminify/back/js/editor')
    .js('resources/adminify/back/js/editor/helpers.js', 'public/adminify/back/js/editor')
    .js('resources/adminify/back/js/sendMail.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/formbuilder.js', 'public/adminify/back/js')
    .vue('resources/adminify/front/js/app.js', 'public/adminify/front/js')
    .sass('resources/adminify/front/sass/argon.scss', 'public/adminify/front/css')
    .sass('resources/adminify/back/sass/argon.scss', 'public/adminify/back/css')
    .sass('resources/adminify/front/sass/front.scss', 'public/adminify/front/css')
    .sass('resources/adminify/back/sass/extensions.scss', 'public/adminify/back/css');

    mix.copy('resources/adminify/back/font/summernote.ttf', 'public/adminify/back/css/font/summernote.ttf');
    mix.copy('resources/adminify/back/font/summernote.eot', 'public/adminify/back/css/font/summernote.eot');
    mix.copy('resources/adminify/back/font/summernote.woff', 'public/adminify/back/css/font/summernote.woff');
    mix.copy('resources/adminify/back/font/summernote.woff2', 'public/adminify/back/css/font/summernote.woff2');

