const mix = require('laravel-mix');

const adminifyConfig = require('./resources/adminify/laravel-mix/adminify.js');

// console.log(adminifyConfig);
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

adminifyConfig(mix);


