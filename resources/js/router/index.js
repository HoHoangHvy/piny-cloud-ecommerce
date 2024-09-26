import {createRouter, createWebHistory} from "vue-router";
import home from '../components/homePage.vue'
import about from '../components/aboutPage.vue'
import notFound from '../components/notFoundPage.vue'

const routes = [
    {
        path: '/',
        component: home
    },
    {
        path: '/about',
        component: about
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router
