import DatesIndex from "./components/DatesIndex.vue";


require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);
import App from "./App.vue";

import CorralsIndex from './components/CorralsIndex.vue';
import SingleReport from "./components/SingleReport.vue";


const routes = [
    {
        name: 'corrals',
        path: '/',
        component: CorralsIndex
    },
    {
        name: 'dates',
        path: '/reports',
        component: DatesIndex
    },
    {
        name: 'report',
        path: '/report/:key',
        component: SingleReport
    },

];

const router = new VueRouter({mode: 'history', routes: routes});

const app = new Vue(Vue.util.extend({router}, App)).$mount('#app');