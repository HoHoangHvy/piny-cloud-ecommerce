import {createRouter, createWebHistory} from "vue-router";
import home from '../components/homePage.vue'
import about from '../components/aboutPage.vue'
import notFound from '../components/notFoundPage.vue'
import AdminLayout from "../layouts/AdminLayout.vue";
import AdminDashboard from "../components/admin/adminDashboard.vue";
import AdminLogin from "../components/admin/adminLogin.vue";
import CustomerLayout from "../layouts/CustomerLayout.vue";
import SigninView from "../../views/admin/Authentication/SigninView.vue";
import ButtonsView from "../../views/admin/UiElements/ButtonsView.vue";
import SignupView from "../../views/admin/Authentication/SignupView.vue";
import AlertsView from "../../views/admin/UiElements/AlertsView.vue";
import BasicChartView from "../../views/admin/Charts/BasicChartView.vue";
import SettingsView from "../../views/admin/Pages/SettingsView.vue";
import TablesView from "../../views/admin/TablesView.vue";
import FormLayoutView from "../../views/admin/Forms/FormLayoutView.vue";
import FormElementsView from "../../views/admin/Forms/FormElementsView.vue";
import ProfileView from "../../views/admin/ProfileView.vue";
import CalendarView from "../../views/admin/CalendarView.vue";
import ECommerceView from "../../views/admin/Dashboard/ECommerceView.vue";
import UserManagement from "@/js/components/admin/UserManagement/UserManagement.vue";

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
                path: 'ui-elements/alerts',
                name: 'alerts',
                component: AlertsView,
                meta: {
                    title: 'Alerts'
                }
            },
            {
                path: 'ui-elements/buttons',
                name: 'buttons',
                component: ButtonsView,
                meta: {
                    title: 'Buttons'
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
            permission: 'owner'
        }
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
