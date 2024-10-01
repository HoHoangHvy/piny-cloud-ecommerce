import {createRouter, createWebHistory} from "vue-router";
import home from '../components/homePage.vue'
import about from '../components/aboutPage.vue'
import notFound from '../components/notFoundPage.vue'
import AdminLayout from "../layouts/AdminLayout.vue";
import AdminDashboard from "../components/admin/adminDashboard.vue";
import AdminLogin from "../components/admin/adminLogin.vue";
import CustomerLayout from "../layouts/CustomerLayout.vue";

const routes = [
    {
        path: '/',
        component: CustomerLayout,
        children: [
            {
                path: '',
                name: 'Landing Page',
                component: home,
                meta: {
                    permission: 'owner'
                }
            },
            {
                path: 'about',
                name: 'About us',
                component: about,
                meta: {
                    permission: 'owner'
                }
            }
        ]
    },
    {
        path: '/admin',
        component: AdminLayout,
        children: [
            {
                path: '',  // This empty path makes it the default child route
                name: 'admin-dashboard',
                component: AdminDashboard,
                meta: {
                    permission: 'owner'
                }
            },
            {
                path: 'login',
                name: 'admin-login',
                component: AdminLogin,
                meta: {
                    permission: 'owner'
                }
            }
        ]
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
