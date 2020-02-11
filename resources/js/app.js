
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Bootstrap
 |--------------------------------------------------------------------------
 |
 | First, we will load all of the "core" dependencies for Spark which are
 | libraries such as Vue and jQuery. This also loads the Spark helpers
 | for things such as HTTP calls, forms, and form validation errors.
 |
 | Next, we'll create the root Vue application for Spark. This will start
 | the entire application and attach it to the DOM. Of course, you may
 | customize this script as you desire and load your own components.
 |
 */

require('spark-bootstrap');

require('./components/bootstrap');

window.Vue = require('vue');

import _ from 'lodash'

window.toastr = require('toastr');
toastr.options.closeButton = true;

import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
})

import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
Vue.use(Datetime)
Vue.component('datetime', Datetime);

Vue.component('permissions-data', require('./views/Auth/Permission.vue').default);
Vue.component('roles-data', require('./views/Auth/Role.vue').default);
Vue.component('users-data', require('./views/Auth/User.vue').default);
Vue.component('app-data', require('./views/App.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));

// Mixins
import mixin from './mixin.js'
Vue.mixin(mixin)
// Routes
import router from './routes.js'

var app = new Vue({
    mixins: [require('spark')],
    router
});
