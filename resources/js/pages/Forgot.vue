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
                <div>Восстановление пароля</div>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation @keydown.enter="handleEnterKey">
                    <v-text-field
                        v-model="email"
                        label="Введите ваш Email"
                        type="email"
                        :rules="emailRules"
                        required
                        outlined
                        class="mb-4 email-field"
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
                    Отправить
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { apiService } from '../api/apiService.js';
import QrLogo from "../components/QrLogo.vue";
import store from "../store/index.js";

const email = ref('');
const valid = ref(false);
const router = useRouter();
const appName = import.meta.env.VITE_APP_NAME || '';

const emailRules = [
    (v) => !!v || 'Обязательное поле',
    (v) => /.+@.+\..+/.test(v) || 'Не валидный E-mail',
];

const fetchResetPassword = async () => {
    try {
        await apiService.resetPassword({ email: email.value });
        await store.dispatch('snackbar/triggerSnackbar', {
            message: 'Ссылка для восстановления отправлена на ваш email',
            type: 'success',
        });
        email.value = '';
        await router.push('/login');
    } catch (error) {
        await store.dispatch('snackbar/triggerSnackbar', {
            message: error.response?.data?.message || 'Ошибка при восстановлении пароля',
            type: 'error',
        });
        email.value = '';
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
