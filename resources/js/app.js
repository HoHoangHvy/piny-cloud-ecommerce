import './bootstrap';
import { createApp } from 'vue'
import app from './components/app.vue'
import router from './router/index.js'
import store from './store'
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'

createApp(app)
    .use(router)
    .use(store)
    .use(LaravelPermissionToVueJS)
    .mount('#app')
