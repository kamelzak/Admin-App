require('./bootstrap');

import router from './routes';
import Vue from 'vue';

import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
  } from 'vform/src/components/bootstrap4';
  Vue.component(Button.name, Button)
  Vue.component(HasError.name, HasError)
  Vue.component(AlertError.name, AlertError)
  Vue.component(AlertErrors.name, AlertErrors)
  Vue.component(AlertSuccess.name, AlertSuccess)

window.Vue = require('vue').default;

const app = new Vue({
    el: '#app',

    router
});
