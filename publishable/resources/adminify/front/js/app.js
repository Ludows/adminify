/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import {
    createLaravelLocalization
} from '@wesleyhf/laravel-localization-js';

window.createTranslationable = createLaravelLocalization;

require('./bootstrap');

import * as Vue from 'vue';
import {
    BootstrapVue,
    IconsPlugin
} from 'bootstrap-vue'
import Vuex from 'vuex'
import Swal from 'sweetalert2/dist/sweetalert2.js'

import Swup from 'swup';
import SwupHeadPlugin from '@swup/head-plugin';
import SwupJsPlugin from '@swup/js-plugin';
import SwupProgressPlugin from '@swup/progress-plugin';
import SwupScriptsPlugin from '@swup/scripts-plugin';
import SwupScrollPlugin from '@swup/scroll-plugin';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('comments', require('./components/Comments.vue').default);
Vue.component('comment-form', require('./components/CommentForm.vue').default);
Vue.component('update-comment', require('./components/CommentUpdateForm.vue').default);

Vue.prototype.$axios = require('axios');

Vue.prototype.$axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
};

Vue.prototype.$axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Vue.prototype.$swal = Swal;

Vue.prototype.$route = require('../../commons/js/Route').default;

const { getToken } = require('./methods/tokens');

Vue.prototype.$getToken = getToken;

/** ----------------------------------------------------------------------------
 * Inizialize Swup
 * -------------------------------------------------------------------------- */

const options = [];

const swup = new Swup({
    cache: false,
    containers: ["#swup"],
    plugins: [
        new SwupHeadPlugin(),
        new SwupJsPlugin(options),
        new SwupProgressPlugin(),
        new SwupScriptsPlugin({
            head: true,
            body: true
        }),
        new SwupScrollPlugin()
    ]
});

Vue.prototype.$swup = swup;

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

Vue.use(Vuex)


window.Vue = Vue;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



// VUE
let app = new Vue({
    el: '#app',
    store: store,
    created() {
        this.$getToken();
    },
    mounted() {


    },
    beforeDestroy() {
        // destroy all instance of other packages

    }
});




