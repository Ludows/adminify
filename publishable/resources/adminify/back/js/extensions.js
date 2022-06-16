// Show packages.json
window.jQuery = window.$ = require('jquery');

import {
    createLaravelLocalization
} from '@wesleyhf/laravel-localization-js';

import Sortable from 'sortablejs';

window.Sortable = Sortable;

window.createLaravelLocalization = createLaravelLocalization;

require('select2');

require('adminify_bootstrap_admin');

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
    // summernoteFields : [],
    VisualEditorFields : [],
    tiptapFields : [],
    modalPicker : []
}

