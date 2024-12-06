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
                <div>Регистрация</div>
            </v-card-title>

            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation @keydown.enter="handleEnterKey">
                    <v-text-field
                        v-model="name"
                        variant="outlined"
                        label="Имя"
                        :rules="nameRules"
                        required
                        outlined
                        class="mb-4"
                    />
                    <v-text-field
                        v-model="email"
                        variant="outlined"
                        label="Email"
                        type="email"
                        :rules="emailRules"
                        required
                        outlined
                        class="mb-4"
                    />
                    <v-text-field
                        v-model="password"
                        variant="outlined"
                        :type="showPassword ? 'text' : 'password'"
                        label="Пароль"
                        :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append="togglePassword"
                        :rules="passwordRules"
                        required
                        outlined
                        class="mb-4"
                    />
                    <v-text-field
                        v-model="confirmPassword"
                        variant="outlined"
                        :type="showConfirmPassword ? 'text' : 'password'"
                        label="Подтвердите пароль"
                        :append-icon="showConfirmPassword ? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append="toggleConfirmPassword"
                        :rules="confirmPasswordRules"
                        required
                        outlined
                        class="mb-4"
                    />
                </v-form>
            </v-card-text>

            <v-card-actions>
                <v-spacer />
                <v-btn
                    :disabled="!valid"
                    color="teal-lighten-1"
                    variant="tonal"
                    @click="register"
                >
                    Зарегистрироваться
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

const appName = import.meta.env.VITE_APP_NAME || '';
const router = useRouter();

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const showPassword = ref(false);
const showConfirmPassword = ref(false);
const valid = ref(false);

const nameRules = [
    (v) => !!v || 'Имя обязательно',
    (v) => v.length >= 2 || 'Имя должно быть не менее 2 символов',
];
const emailRules = [
    (v) => !!v || 'Email обязателен',
    (v) => /.+@.+\..+/.test(v) || 'Некорректный email',
];
const passwordRules = [
    (v) => !!v || 'Пароль обязателен',
    (v) => v.length >= 6 || 'Пароль должен быть не менее 6 символов',
];
const confirmPasswordRules = [
    (v) => !!v || 'Подтверждение пароля обязательно',
    (v) => v === password.value || 'Пароли не совпадают',
];
const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
const toggleConfirmPassword = () => {
    showConfirmPassword.value = !showConfirmPassword.value;
};
const register = async () => {
    if (password.value !== confirmPassword.value) {
        await store.dispatch('snackbar/triggerSnackbar', {
            message: 'Пароли не совпадают',
            type: 'error',
        });
        return;
    }

    try {
        const response = await apiService.register({
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: confirmPassword.value,
        });
        const data = response.data;

        if (data.success) {
            await router.push('/login');
        }
    } catch (error) {
        await store.dispatch('snackbar/triggerSnackbar', {
            message: 'Произошла ошибка. Попробуйте снова.',
            type: 'error',
        });
    }
};
const handleEnterKey = () => {
    if (valid.value) {
        register();
    }
};
</script>

<style scoped>
</style>
