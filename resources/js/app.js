require('./bootstrap');

import router from './routes';
import Vue from 'vue';
import moment from 'moment';
import {Button, HasError, AlertError, AlertErrors, AlertSuccess} from 'vform/src/components/bootstrap4';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
import Gate from './Gate';
import _ from 'lodash';

Vue.prototype.$gate = new Gate(window.user);

window.Swal = Swal;
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});
window.Toast = Toast;

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
});

Vue.component(Button.name, Button);
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertErrors.name, AlertErrors);
Vue.component(AlertSuccess.name, AlertSuccess);

window.Vue = require('vue').default;

Vue.component('passport-clients', require('./components/passport/Clients.vue').default);

Vue.component('passport-authorized-clients', require('./components/passport/AuthorizedClients.vue').default);

Vue.component('passport-personal-access-tokens', require('./components/passport/PersonalAccessTokens.vue').default);

Vue.component('not-found', require('./components/NotFound.vue').default);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.filter('capitalize', function (text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('myDate', function (date) {
  return moment(date).format('DD-MM-YYYY');
});

window.Fire = new Vue();

const app = new Vue({
    el: '#app',
    router,
    data : {
      search : ''
    },
    methods: {
      searchit: _.debounce(() => {
        Fire.$emit('searching');
      },2000) 
    },
});
