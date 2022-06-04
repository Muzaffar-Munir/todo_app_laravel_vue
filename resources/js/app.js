require('./bootstrap');
window.Vue = require('vue');

require('./bootstrap');
import VueRouter from "vue-router";
import router from "./routes";
window.Vue = require('vue');
import Index from './Index';
import ValidationErrors from './components/common/ValidationErrors';
import axios from "axios";

const VueUploadComponent = require('vue-upload-component');

import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'

Vue.use(VueGoodTablePlugin);

Vue.component('pagination', require('laravel-vue-pagination'));



Vue.use(VueRouter);
Vue.component('app-header-component', require('./components/common/header.vue').default);
Vue.component('app-footer-component', require('./components/common/footer.vue').default);
Vue.component("v-errors", ValidationErrors);
Vue.component('file-upload', VueUploadComponent)

window.axios.interceptors.response.use(
    response => {
        return response
    },
    error => {
        if (error.response.status == 401 || error.response.status == 403) {
            axios.post("/index.php/logout");
            localStorage.removeItem("admin_user");
            localStorage.removeItem("current_user");
            localStorage.removeItem("isLoggedIn");
            localStorage.removeItem("isAdmin");
            localStorage.removeItem("show_subscription_update_modal");
            const logoutError = "Please login again to continue.";
            router.push({ name: 'home', params: { logoutError: logoutError } });
        }

        return Promise.reject(error);
    });

const app = new Vue({
    el: '#app',
    router,
    components: {
        'index': Index
    },
});
