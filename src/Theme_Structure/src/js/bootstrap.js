window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

 window.axios = require('axios');
//  window.gsap = require('gsap').gsap;

 window.Route = require('@resource/adminify/commons/js/Route').default;

 window.axios.defaults.headers.common = {
     'X-Requested-With': 'XMLHttpRequest',
     'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
 };

 window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

 import Swup from 'swup';
 import SwupHeadPlugin from '@swup/head-plugin';
 import SwupJsPlugin from '@swup/js-plugin';
 import SwupProgressPlugin from '@swup/progress-plugin';
 import SwupScriptsPlugin from '@swup/scripts-plugin';
 import SwupScrollPlugin from '@swup/scroll-plugin';

import {
    createLaravelLocalization
} from '@wesleyhf/laravel-localization-js';


// Check the presence of debugBar
let scriptDebugbar = document.querySelector('script[data-turbolinks-eval="false"][data-turbo-eval="false"]');
//check the possible presence of scripts which can be in conflitct with swup. Let's do to prevent this.
let scripts = document.body.querySelectorAll('script');
console.log(scripts)
if(scriptDebugbar) {
    scriptDebugbar.setAttribute('data-swup-ignore-script', 'data-swup-ignore-script');
    [...scripts].forEach((script) => {
        if(!script.hasAttribute('data-swup-ignore-script')) {
            script.setAttribute('data-swup-ignore-script', 'data-swup-ignore-script');
        }
    })
}

const SwupJsOptions = [{
    from: '(.*)',
    to: '(.*)',
    in: require('./swup-transitions/in').default,
    out: require('./swup-transitions/out').default
}];

let init = require('./swup-events/init').default;
let unload = require('./swup-events/unload').default;

const swup = new Swup({
    cache: false,
    containers: ["#app"],
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

swup.on('contentReplaced', init);
swup.on('willReplaceContent', unload);

window.createLaravelLocalization = createLaravelLocalization;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
