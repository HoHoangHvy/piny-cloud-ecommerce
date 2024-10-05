import './bootstrap';
import '../assets/css/satoshi.css'
import '../assets/css/style.css'
import 'jsvectormap/dist/jsvectormap.min.css'
import 'flatpickr/dist/flatpickr.min.css'
import i18n from './i18n';

import { createApp } from 'vue'
import app from './components/app.vue'
import router from './router/index.js'
import store from './store'
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
import { createPinia } from 'pinia'
import VueApexCharts from 'vue3-apexcharts'

createApp(app)
    .use(router)
    .use(store)
    .use(i18n)
    .use(LaravelPermissionToVueJS)
    .use(createPinia())
    .use(VueApexCharts)
    .mount('#app')
