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


axios.defaults.withCredentials = true;
axios.defaults.baseURL = configuration.baseUrl;
const token = localStorage.getItem('auth_token'); // Example with localStorage
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
        const response = await axios.get('/api/me');
        store.commit('setUser', response.data); // Example with Vuex; adjust as needed
    } catch (error) {
        // Handle 401 Unauthorized to redirect to login
        if (error.response && error.response.status === 401) {
            router.push('/');
        }
    }
}

async function initApp() {
    await fetchUser(); // Fetch user data before app creation
    const app = createApp(App);
    app.use(router);
    app.use(store);
    app.use(i18n);
    app.use(LaravelPermissionToVueJS);
    app.use(createPinia());
    app.use(VueApexCharts);
    app.mount('#app');
}

// Initialize the app
initApp();
