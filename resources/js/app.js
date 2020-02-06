
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

window.toastr = require('toastr');
toastr.options.closeButton = true;

import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect);

console.log(toastr.options)

Vue.component('permissions-data', require('./views/Permission.vue').default);
Vue.component('roles-data', require('./views/Role.vue').default);

var app = new Vue({
    mixins: [require('spark')]
});
