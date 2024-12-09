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
                <div>Сброс пароля</div>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation @keydown.enter="handleEnterKey">
                    <v-text-field
                        v-model="password"
                        label="Введите новый пароль"
                        type="password"
                        :rules="passwordRules"
                        required
                        outlined
                        class="mb-4 password-field"
                    />
                    <v-text-field
                        v-model="confirmPassword"
                        label="Повторите новый пароль"
                        type="password"
                        :rules="[v => v === password || 'Пароли не совпадают']"
                        required
                        outlined
                        class="mb-4 password-field"
                    />
                </v-form>
            </v-card-text>
            <v-card-actions>
                <router-link to="/login">
                    <v-btn
                        color="orange"
                        variant="tonal"
                    >
                        Вернуться к логину
                    </v-btn>
                </router-link>
                <v-spacer />
                <v-btn
                    :disabled="!valid"
                    color="teal-lighten-1"
                    variant="tonal"
                    @click="fetchResetPassword"
                >
                    Сохранить
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { apiService } from '../api/apiService.js';
import QrLogo from "../components/QrLogo.vue";
import store from "../store/index.js";

const password = ref('');
const confirmPassword = ref('');
const valid = ref(false);
const router = useRouter();
const route = useRoute();
const appName = import.meta.env.VITE_APP_NAME || '';

const token = route.query.token || '';

const passwordRules = [
    (v) => !!v || 'Обязательное поле',
    (v) => v.length >= 6 || 'Минимум 6 символов',
];

const fetchResetPassword = async () => {
    if (password.value !== confirmPassword.value) {
        await store.dispatch('snackbar/triggerSnackbar', {
            message: 'Пароли не совпадают',
            type: 'error',
        });
        return;
    }
    // TODO ДОДЕЛАТЬ НУЖНО!

    try {
        await apiService.updatePassword({
            token,
            password: password.value,
            password_confirmation: confirmPassword.value,
        });
        await store.dispatch('snackbar/triggerSnackbar', {
            message: 'Пароль успешно обновлён',
            type: 'success',
        });
        await router.push('/login');
    } catch (error) {
        await store.dispatch('snackbar/triggerSnackbar', {
            message: error.response?.data?.message || 'Ошибка при сбросе пароля',
            type: 'error',
        });
    }
};

const handleEnterKey = () => {
    if (valid.value) {
        fetchResetPassword();
    }
};
</script>

<style scoped>
</style>
