try {
    window.$ = window.jQuery = require('jquery');
    // window.Popper = require('popper.js').default;

    require('bootstrap');
} catch (e) {}


window._ = require('lodash');
window.axios = require('axios');

// Configuring Axios ....
const BaseUrl = process.env.MIX_BASE_URL;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = BaseUrl;
window.axios.defaults.withCredentials = true;

let token = document.head.querySelector('meta[name="csrf-token"]');
/*if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found!');
}*/


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true
});
