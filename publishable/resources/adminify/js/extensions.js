// Show packages.json
window.jQuery = window.$ = require('jquery');

require('select2');

require('bootstrap');
// require('bootstra');
require('./serializeAsObject')
require('./clearValues')
require('./setResponseFromAjax')
require('./menuThree')

window.Swal = require('sweetalert2');

window.Dropzone = require('dropzone');
window.Quill = require('quill');

window.Route = require('./Route').default;

Dropzone.autoDiscover = false;

window.admin = {
    select2Fields : [],
    quillEditorFields: [],
    mediaLibraryFields: [],
    editUploadFields : [],
    larabergFields : [],
    generatorPasswordFields: [],
    lfmFields : []
}

