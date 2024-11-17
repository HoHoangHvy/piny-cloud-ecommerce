import {createRouter, createWebHistory} from "vue-router";
import home from '../components/page/homePage.vue'
import about from '../components/page/aboutPage.vue'
import AdminLayout from "../layouts/AdminLayout.vue";
import AdminLogin from "../components/admin/adminLogin.vue";
import CustomerLayout from "../layouts/CustomerLayout.vue";
import SigninView from "../../views/admin/Authentication/SigninView.vue";
import SignupView from "../../views/admin/Authentication/SignupView.vue";
import BasicChartView from "../../views/admin/Charts/BasicChartView.vue";
import SettingsView from "../../views/admin/Pages/SettingsView.vue";
import TablesView from "../../views/admin/TablesView.vue";
import FormLayoutView from "../../views/admin/Forms/FormLayoutView.vue";
import FormElementsView from "../../views/admin/Forms/FormElementsView.vue";
import ProfileView from "../../views/admin/ProfileView.vue";
import CalendarView from "../../views/admin/CalendarView.vue";
import ECommerceView from "../../views/admin/Dashboard/ECommerceView.vue";
import UserManagement from "@/js/components/admin/UserManagement/UserManagement.vue";
import productDetailPage from "../components/admin/productDetailPage.vue";
import UserInfoPage from "../components/admin/UserInfoPage.vue";
import MenuView from "@/js/components/page/MenuView.vue";
import OrderPage from "../components/page/orderPage.vue";

import store from "@/js/store/index.js";

const routes = [
    {
        path: '/',
        component: CustomerLayout,
        meta: {
            permission: 'owner',
        },
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
            },
            {
                path: 'productdetail',
                name: 'Product Detail',
                component: productDetailPage,
                meta: {
                    permission: 'owner'
                }
            },
            {
                path: 'userinfo',
                name: 'User Info',
                component: UserInfoPage,
                meta: {
                    permission: 'owner'
                }
            },
            {
                path: 'menu',
                name: 'Menu',
                component: MenuView,
                meta: {
                    permission: 'owner'
                }
            },
            {
                path: "order",
                name: 'Order page',
                component: OrderPage,
                meta: {
                    permission: "owner"
                }
            },
        ]
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: {
            requiresAuthAdmin: true
        },
        children: [
            {
                path: '',  // This empty path makes it the default child route
                name: 'admin-dashboard',
                component: ECommerceView,
                meta: {
                    permission: 'owner'
                }
            },
            {
                path: 'calendar',
                name: 'calendar',
                component: CalendarView,
                meta: {
                    title: 'Calendar'
                }
            },
            {
                path: 'profile',
                name: 'profile',
                component: ProfileView,
                meta: {
                    title: 'Profile'
                }
            },
            {
                path: 'forms/form-elements',
                name: 'formElements',
                component: FormElementsView,
                meta: {
                    title: 'Form Elements'
                }
            },
            {
                path: 'forms/form-layout',
                name: 'formLayout',
                component: FormLayoutView,
                meta: {
                    title: 'Form Layout'
                }
            },
            {
                path: 'tables',
                name: 'tables',
                component: TablesView,
                meta: {
                    title: 'Tables'
                }
            },
            {
                path: 'pages/settings',
                name: 'settings',
                component: SettingsView,
                meta: {
                    title: 'Settings'
                }
            },
            {
                path: 'charts/basic-chart',
                name: 'basicChart',
                component: BasicChartView,
                meta: {
                    title: 'Basic Chart'
                }
            },
            {
                path: 'auth/signin',
                name: 'signin',
                component: SigninView,
                meta: {
                    title: 'Signin'
                }
            },
            {
                path: 'auth/signup',
                name: 'signup',
                component: SignupView,
                meta: {
                    title: 'Signup'
                }
            },
            {
                path: 'users',
                name: 'users',
                component: UserManagement,
                meta: {
                    title: 'User Management'
                }
            }
        ]
    },
    {
        path: '/admin/login',
        name: 'admin-login',
        component: AdminLogin,
        meta: {
            permission: 'owner',
            requiresAuth: false
        }
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes
})
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuthAdmin)) {
        if (store.getters.isLoggedIn && store.getters.userType === 'user') {
            next()
            return
        }
        next('admin/login')
    } else {
        if(to.matched.some(record => record.meta.requiresAuth)) {
            if (store.getters.isLoggedIn && store.getters.userType === 'customer') {
                next()
                return
            }
            next('/login')
        } else {
            next()
        }
    }

});
export default router
