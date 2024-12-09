// resources/js/router/index.js

import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Register from "../pages/Register.vue";
import Profile from "../pages/Profile.vue";
import Forgot from "../pages/Forgot.vue";
import ResetPassword from "../pages/ResetPassword.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/signup',
        name: 'Register',
        component: Register,
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile,
    },
    {
        path: '/forgot',
        name: 'Forgot',
        component: Forgot,
    },
    {
        path: '/reset-password',
        name: 'ResetPassword',
        component: ResetPassword,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
