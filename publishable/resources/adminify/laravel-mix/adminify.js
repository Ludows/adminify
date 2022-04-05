const path = require('path');
const fs = require('fs');

module.exports = function(Mix) {

    loadDefaults(Mix);
    loopOverThemes(Mix);
    return Mix;
}

function loadDefaults(Mix) {
    Mix.js('resources/adminify/back/js/argon.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/extensions.js', 'public/adminify/back/js')
    Mix.js('resources/adminify/back/js/extensions-call.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/searchable.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/listings.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/menuBuilder.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/confirmation.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/sendMail.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/metas.js', 'public/adminify/back/js')
    .js('resources/adminify/back/js/formbuilder.js', 'public/adminify/back/js')
    Mix.js('resources/adminify/front/js/app.js', 'public/adminify/front/js').vue({ version: 3 })
    Mix.js('resources/adminify/back/js/editor.js', 'public/adminify/back/js').react()
    .sass('resources/adminify/front/sass/argon.scss', 'public/adminify/front/css')
    .sass('resources/adminify/back/sass/argon.scss', 'public/adminify/back/css')
    .sass('resources/adminify/front/sass/front.scss', 'public/adminify/front/css')
    .sass('resources/adminify/back/sass/extensions.scss', 'public/adminify/back/css');

    Mix.copy('resources/adminify/back/font/summernote.ttf', 'public/adminify/back/css/font/summernote.ttf');
    Mix.copy('resources/adminify/back/font/summernote.eot', 'public/adminify/back/css/font/summernote.eot');
    Mix.copy('resources/adminify/back/font/summernote.woff', 'public/adminify/back/css/font/summernote.woff');
    Mix.copy('resources/adminify/back/font/summernote.woff2', 'public/adminify/back/css/font/summernote.woff2');
}

function loopOverThemes(Mix) {
    let required_env = process.env.MIX_ADMINIFY_THEME_ROOT_FOLDER;
    let file_to_bind = 'webpack.mix.js';
    if(required_env) {
        console.log('run')
        let dirPath = path.join(process.cwd(), required_env);

        if(!fs.existsSync(dirPath)) {
            return false;
        }

        let dirs = fs.readdirSync(dirPath);

        dirs.forEach((dir) => {

            let resolved_path = path.join(dirPath, dir);
            let stat = fs.statSync(resolved_path);

            if(stat.isDirectory()) {
                let theme_files = fs.readdirSync(resolved_path);
                console.log(theme_files);

                if(theme_files.includes(file_to_bind)) {
                    // just require
                    require( path.join(resolved_path, file_to_bind) );
                }
            }
        })

    }
}
