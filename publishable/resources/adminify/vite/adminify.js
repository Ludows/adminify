import path from 'path';

export default function(config = {}) {

    let defaults = {
        theme : '',
        appFileFront : 'app.js', 
        appFileBack : 'index.jsx', 
    }

    config = Object.assign({}, defaults, config);

    const basePath = process.cwd();
    const resourcesPath = path.join(basePath, 'resources');
    const adminifyAppBackPath = path.join(resourcesPath, 'adminify', 'back', 'js', config.appFileBack);
    const adminifyAppCssBackPath = path.join(resourcesPath, 'adminify', 'back', 'sass', 'app.scss');
    const adminifyAppFrontPath = path.join(resourcesPath, 'theme', config.theme, 'src', 'js', config.appFileFront);
    const adminifyAppCssFrontPath = path.join(resourcesPath, 'theme', config.theme, 'src', 'sass', 'app.scss');

    return [adminifyAppBackPath, adminifyAppFrontPath, adminifyAppCssFrontPath, adminifyAppCssBackPath]
}