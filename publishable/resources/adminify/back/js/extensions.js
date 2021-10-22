// Show packages.json
window.jQuery = window.$ = require('jquery');

require('jquery-validation');

import {
    createLaravelLocalization
} from '@wesleyhf/laravel-localization-js';

import Sortable from 'sortablejs';

window.Sortable = Sortable;

window.createLaravelLocalization = createLaravelLocalization;

require('select2');

require('bootstrap');

require('summernote');
require('summernote/dist/summernote-bs4.js');
// require('bootstra');
require('./serializeAsObject')
require('./clearValues')
require('./setResponseFromAjax')
require('./menuThree')

window.Swal = require('sweetalert2');

window.Route = require('../../commons/js/Route').default;

window.admin = {
    select2Fields : [],
    larabergFields : [],
    generatorPasswordFields: [],
    lfmFields : [],
    summernoteFields : [],
}

