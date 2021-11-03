require('./bootstrap');

import router from './routes';

window.Vue = require('vue').default;

const app = new Vue({
    el: '#app',

    router
});
