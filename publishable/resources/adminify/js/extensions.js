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

window.Route = require('./Route').default;

window.admin = {
    select2Fields : [],
    larabergFields : [],
    generatorPasswordFields: [],
    lfmFields : [],
    summernoteFields : []
}

