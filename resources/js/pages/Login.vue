<template>
    <div class="flex items-center justify-center w-full h-screen bg-gray-200">
        <v-card class="p-6 w-full max-w-md rounded-lg border-2 border-transparent
                shadow-[1px_5px_1px_1px_#0d9488]
                transition-all duration-300 ease-in-out"
        >
            <v-card-title class="text-center text-white bg-teal-600 mb-4 rounded-lg py-3">
                <div class="flex gap-2 justify-center">
                    <QrLogo class="flex w-5 h-5" />
                    <span class="text-xl font-bold">{{ appName }}</span>
                </div>
                <div>Логин</div>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-text-field
                        v-model="email"
                        label="Email"
                        type="email"
                        :rules="emailRules"
                        required
                        outlined
                        class="mb-4 email-field"
                    />
                    <v-text-field
                        v-model="password"
                        label="Password"
                        type="password"
                        :rules="passwordRules"
                        required
                        outlined
                        class="mb-4 password-field"
                    />
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    :disabled="!valid"
                    color="teal-lighten-1"
                    variant="tonal"
                    @click="fetchLogin"
                >
                    Войти
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { apiService } from '../api/apiService.js';
import QrLogo from "../components/QrLogo.vue";

const email = ref('');
const password = ref('');
const valid = ref(false);
const router = useRouter();
const appName = import.meta.env.VITE_APP_NAME || '';

const emailRules = [
    (v) => !!v || 'Email is required',
    (v) => /.+@.+\..+/.test(v) || 'E-mail must be valid',
];
const passwordRules = [
    (v) => !!v || 'Password is required',
    (v) => v.length >= 3 || 'Password must be at least 3 characters long',
];

const fetchLogin = async () => {
    const response = await apiService.login({ email: email.value, password: password.value });
    const data = response.data;
    if (data && data.token) {
        localStorage.setItem('auth_token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));
        await router.push('/');
    } else {
        console.error('Invalid response: No token');
    }
    email.value = '';
    password.value = '';
};

onMounted(() => {
    const token = localStorage.getItem('auth_token');
    if (token) {
        console.log('Token found:', token);
    } else {
        console.log('No token found');
    }
});
</script>

<style scoped>
</style>
