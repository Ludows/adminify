import path from 'path';

export default function(config = {}) {

    let defaults = {
        appFileFront : 'app.jsx', 
        appFileBack : 'index.jsx', 
    }

    config = Object.assign({}, defaults, config);

    const basePath = process.cwd();
    const resourcesPath = path.join(basePath, 'resources');
    const adminifyAppBackPath = path.join(resourcesPath, 'views', 'back', 'src', 'js', config.appFileBack);
    const extensions_js_back = path.join(resourcesPath, 'views', 'back', 'src', 'js', 'extensions.js');
    const adminifyAppCssBackPath = path.join(resourcesPath, 'views', 'back', 'src', 'sass', 'app.scss');
    const adminifyAppFrontPath = path.join(resourcesPath, 'views', 'front', 'src', 'js', config.appFileFront);
    const adminifyAppCssFrontPath = path.join(resourcesPath, 'views', 'front', 'src', 'sass', 'app.scss');
    const extensions_css_back = path.join(resourcesPath, 'adminify', 'back', 'js', 'extensions.scss');

    let sources = [adminifyAppBackPath, extensions_js_back, adminifyAppFrontPath, adminifyAppCssFrontPath, extensions_css_back, adminifyAppCssBackPath]
    console.log(sources)


    return sources
}