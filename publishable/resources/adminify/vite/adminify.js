import path from 'path';

function getPaths(config = {}) {
    let defaults = {
        appFileFront : 'app.jsx', 
        appFileBack : 'app.jsx', 
    }

    config = Object.assign({}, defaults, config);

    const basePath = process.cwd();
    const resourcesPath = path.join(basePath, 'resources');
    // const adminifyAppBackPath = path.join(resourcesPath, 'views', 'back', 'src', 'js', config.appFileBack);
    // const extensions_js_back = path.join(resourcesPath, 'views', 'back', 'src', 'js', 'extensions.js');

    const adminifyAppBackPath_2 = path.join(resourcesPath, 'adminify', 'back', 'js', config.appFileBack);
    const extensions_js_back_2 = path.join(resourcesPath, 'adminify', 'back' , 'js', 'extensions.js');

    const adminifyAppCssBackPath = path.join(resourcesPath, 'views', 'back', 'src', 'sass', 'app.scss');
    const adminifyAppFrontPath = path.join(resourcesPath, 'views', 'front', 'src', 'js', config.appFileFront);
    const adminifyAppCssFrontPath = path.join(resourcesPath, 'views', 'front', 'src', 'sass', 'app.scss');
    const extensions_css_back = path.join(resourcesPath, 'adminify', 'back', 'js', 'extensions.scss');

    let sources = [adminifyAppBackPath_2, extensions_js_back_2, adminifyAppFrontPath, adminifyAppCssFrontPath, extensions_css_back, adminifyAppCssBackPath]
    console.log(sources)


    return sources
}
function getAliases(customPath = null) {

    let basePath = customPath ? customPath : __dirname;
    console.log('basePath', basePath);

    return {
        '@' : path.resolve(basePath, 'resources/adminify'),
        '~front' : path.resolve(basePath, 'resources/views/front/src/'),
        '~back' : path.resolve(basePath, 'resources/views/back/src/'),
        '~choices': path.resolve(basePath, 'node_modules/choices.js'),
        '~dropzone': path.resolve(basePath, 'node_modules/dropzone/'),
        '~bootstrap': path.resolve(basePath, 'node_modules/bootstrap/'),
        '~bootstrap-icons': path.resolve(basePath, 'node_modules/bootstrap-icons/'),
    }
}
function getConfig() {

}

let methods = {
    getPaths,
    getAliases,
    getConfig
}

export default () => methods;

// export default function(config = {}) {

//     let defaults = {
//         appFileFront : 'app.jsx', 
//         appFileBack : 'index.jsx', 
//     }

//     config = Object.assign({}, defaults, config);

//     const basePath = process.cwd();
//     const resourcesPath = path.join(basePath, 'resources');
//     const adminifyAppBackPath = path.join(resourcesPath, 'views', 'back', 'src', 'js', config.appFileBack);
//     const extensions_js_back = path.join(resourcesPath, 'views', 'back', 'src', 'js', 'extensions.js');
//     const adminifyAppCssBackPath = path.join(resourcesPath, 'views', 'back', 'src', 'sass', 'app.scss');
//     const adminifyAppFrontPath = path.join(resourcesPath, 'views', 'front', 'src', 'js', config.appFileFront);
//     const adminifyAppCssFrontPath = path.join(resourcesPath, 'views', 'front', 'src', 'sass', 'app.scss');
//     const extensions_css_back = path.join(resourcesPath, 'adminify', 'back', 'js', 'extensions.scss');

//     let sources = [adminifyAppBackPath, extensions_js_back, adminifyAppFrontPath, adminifyAppCssFrontPath, extensions_css_back, adminifyAppCssBackPath]
//     console.log(sources)


//     return sources
// }