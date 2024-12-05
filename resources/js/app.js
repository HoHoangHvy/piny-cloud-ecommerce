import './bootstrap';
import '../assets/css/satoshi.css';
import '../assets/css/style.css';
import 'jsvectormap/dist/jsvectormap.min.css';
import 'flatpickr/dist/flatpickr.min.css';
import i18n from './i18n';
import {createApp, onMounted} from 'vue';
import App from './components/app.vue';
import router from './router/index.js';
import store from './store';
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs';
import { createPinia } from 'pinia';
import VueApexCharts from 'vue3-apexcharts';
import axios from 'axios';
import configuration from '@/config.js';
import Notifications from 'notiwind'

axios.defaults.withCredentials = true;
axios.defaults.baseURL = configuration.baseUrl;
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';
await axios.get('sanctum/csrf-cookie');

const token = localStorage.getItem('token'); // Example with localStorage
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}
// Axios interceptor for handling 401 errors globally
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response && error.response.status === 401) {
            router.push('/');
        }
        return Promise.reject(error);
    }
);

async function fetchUser() {
    try {
        const response = await axios.get('/api/auth/me');
        store.commit('setUser', response.data.data); // Example with Vuex; adjust as needed
    } catch (error) {
        // Handle 401 Unauthorized to redirect to login
        if (error.response && error.response.status === 401) {
            localStorage.removeItem('token');
            localStorage.removeItem('vuex');
            router.push('/');
        }
    }
}

async function initApp() {
    await fetchUser(); // Fetch user data before app creation
    const app = createApp(App);
    app.config.globalProperties.$lang = i18n.global.t;
    app.use(router);
    app.use(Notifications);
    app.use(store);
    app.use(i18n);
    app.use(LaravelPermissionToVueJS);
    app.use(createPinia());
    app.use(VueApexCharts);
    app.mount('#app');
}

// Initialize the app
initApp();
