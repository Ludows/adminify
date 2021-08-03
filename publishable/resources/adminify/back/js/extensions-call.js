// const { default: Route } = require("./RouteAbstract");

//call extensions

window.Select2InitFunction = require('./extensions/select2Field').default;
window.LarabergInitFunction = require('./extensions/larabergField').default;
window.PasswordGeneratorInitFunction = require('./extensions/generatorPasswordField').default;
window.lfmInitFunction = require('./extensions/lfmField').default;
window.summernoteInitFunction = require('./extensions/summernoteField').default;


jQuery(document).ready(function($) {

    if(window.admin.select2Fields.length > 0) {
        Select2InitFunction(window.admin.select2Fields);
    }
    if(window.admin.larabergFields.length > 0) {
        LarabergInitFunction(window.admin.larabergFields);
    }
    if(window.admin.generatorPasswordFields.length > 0) {
        PasswordGeneratorInitFunction(window.admin.generatorPasswordFields);
    }
    if(window.admin.lfmFields.length > 0) {
        lfmInitFunction(window.admin.lfmFields);
    }
    if(window.admin.summernoteFields.length > 0) {
        summernoteInitFunction(window.admin.summernoteFields);
    }
})
