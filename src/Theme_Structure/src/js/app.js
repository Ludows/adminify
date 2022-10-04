/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 import {
    createLaravelLocalization
} from '@wesleyhf/laravel-localization-js';

window.createLaravelLocalization = createLaravelLocalization;

require('./bootstrap');

import { createApp } from 'vue';

import Store from "./store";
import frontInitPlugin from './plugins/frontInit';

function init() {
    let app = createApp({
        created() {
            if(localStorage.getItem('api-token') == null) {
                this.$getToken();
            }
            else {
                this.$verifyToken();
            }
        },
        mounted() {
            let self = this;
            console.log('app mounted', this);
            self.$swup.on('contentReplaced', () => {
                // self.$swup.off();
                init();
            });
            self.$swup.on('willReplaceContent', () => {
                app.unmount();
            })
        },
        beforeDestroy() {
            // destroy all instance of other packages
        }
    });

    let appSelector = '#app';

    app.use(Store);
    app.use(frontInitPlugin, {});

    // app.component('hero', require('./components/Hero.vue').default);

    app.mount(appSelector);

    window.app = app;
}

init();