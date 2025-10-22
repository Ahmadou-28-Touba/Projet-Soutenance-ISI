import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Dashboard from '../components/Dashboard.vue'; // ✅ IMPORTANT

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard, // ✅ CE DOIT ÊTRE Dashboard
        meta: { requiresAuth: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// Garde d'authentification
router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('auth_token');

    if (to.meta.requiresAuth && !token) {
        next('/');
    } else {
        next();
    }
});

export default router;
