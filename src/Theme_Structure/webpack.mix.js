const mix = require('laravel-mix');
const path = require('path');

mix.webpackConfig({
    resolve: {
      alias: {
        '@resource': path.join(process.cwd() , 'resources'),
        '@theme': path.join(process.cwd() , process.env.MIX_ADMINIFY_THEME_ROOT_FOLDER)
      }
    }
  });

console.log('theme', path.join(process.cwd() , 'resources'))

let dirpath = __dirname;
let lastFolderSplit = dirpath.split( path.sep );
let lastFolder = lastFolderSplit[ lastFolderSplit.length - 1 ];

mix.sass('resources/theme/'+ lastFolder +'/src/scss/app.scss', 'public/theme/spmeca/css');
mix.js('resources/theme/'+ lastFolder +'/src/js/app.js', 'public/theme/spmeca/js').vue({
    version : 3
});
