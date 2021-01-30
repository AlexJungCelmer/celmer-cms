window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
// axios.defaults.headers.common['Authorization'] = 'Bearer 1|pSy5skBdWlPpYj931mV9ATQE8fUll6ZYQQR6NPV9';

if (document.cookie.split(';')[0].split('=')[0] == '_token') {
    axios.defaults.headers.common['Authorization'] = document.cookie.split(';')[0].split('=')[1];
}else{
    axios.defaults.headers.common['Authorization'] = '';
}
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

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
