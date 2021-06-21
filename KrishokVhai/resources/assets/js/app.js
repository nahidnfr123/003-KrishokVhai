window.Vue = require('vue');
import Vue from 'vue';

require('./bootstrap');

Vue.config.productionTip = false;

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

/*import CKEditor from '@ckeditor/ckeditor5-vue2';
Vue.use( CKEditor );*/

/*
import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)
Vue.component('apexchart', VueApexCharts)
*/

/*import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.use(BootstrapVue)
//Vue.use(IconsPlugin)
import BootstrapSideBar from 'b-sidebar';
Vue.use(BootstrapSideBar);*/

import App from './layouts/AppLayout.vue';
import router from './routes';
import store from './store/index';
// Register Components ...
import GlobalComponents from './globalComponents'

Vue.use(GlobalComponents)

// Filters ...
require('./filters');
// Day js ...
require('./day');
//Setup custom events
require('./customEvents');
//Import progressbar
require('./progressbar');
//require('./location');


//Import v-from
/*import { Form, HasError, AlertError } from 'vform';
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);*/


//Vue.component('frontend', require('./layouts/frontend/Frontend').default)


// Load data when main component loads ....
store.dispatch('auth/me').then(() => {
    new Vue({
        //el: '#app',
        router,
        store,
        render: h => h(App)
    }).$mount('#app')
});


/*const app = new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app');*/
// When page is reloaded redirects to login page ... even when user is logged in ...




