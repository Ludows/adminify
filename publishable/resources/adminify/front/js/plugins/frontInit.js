import Swal from 'sweetalert2/dist/sweetalert2.js'

import Swup from 'swup';
import SwupHeadPlugin from '@swup/head-plugin';
import SwupJsPlugin from '@swup/js-plugin';
import SwupProgressPlugin from '@swup/progress-plugin';
import SwupScriptsPlugin from '@swup/scripts-plugin';
import SwupScrollPlugin from '@swup/scroll-plugin';
const { getToken, tokenFromLocalStorage, verifyToken, refreshToken } = require('./../methods/tokens');

// plugins/frontInit.js
export default {
    install: (app, options) => {

        /** ----------------------------------------------------------------------------
         * Inizialize Swup
         * -------------------------------------------------------------------------- */

        const SwupJsOptions = [];

        const swup = new Swup({
            cache: false,
            containers: ["#swup"],
            plugins: [
                new SwupHeadPlugin(),
                new SwupJsPlugin(SwupJsOptions),
                new SwupProgressPlugin(),
                new SwupScriptsPlugin({
                    head: true,
                    body: true
                }),
                new SwupScrollPlugin()
            ]
        });


        app.config.globalProperties.$swup = swup;


        // components
        app.component('comments', require('./../components/Comments.vue').default);
        app.component('comment-form', require('./../components/CommentForm.vue').default);
        app.component('update-comment', require('./../components/CommentUpdateForm.vue').default);
        app.component('root-sharing', require('./../components/RootSharingDatas.vue').default);

        app.config.globalProperties.$axios = require('axios');

        app.config.globalProperties.$axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        app.config.globalProperties.$axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        app.config.globalProperties.$swal = Swal;

        app.config.globalProperties.$route = require('../../../commons/js/Route').default;



        app.config.globalProperties.$getToken = getToken;
        app.config.globalProperties.$verifyToken = verifyToken;
        app.config.globalProperties.$refreshToken = refreshToken;
        app.config.globalProperties.$tokenFromLocalStorage = tokenFromLocalStorage;


    }
  }
