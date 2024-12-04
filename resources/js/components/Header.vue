<template>
    <v-app-bar app color="teal-darken-3">
        <v-container>
            <v-row align="center" justify="space-between">
                <v-col cols="auto" class="flex gap-2 items-center justify-center">
                    <QrLogo class="flex w-5 h-5 text-white" />
                    <span class="text-xl font-bold">QR-Gen</span>
                </v-col>
                <v-col v-if="!user" cols="auto" class="flex gap-4">
                    <v-btn variant="tonal" class="font-bold shadow-md" :to="{ path: '/login' }">Войти</v-btn>
                    <v-btn variant="tonal" class="font-bold shadow-md" :to="{ path: '/signup' }">Зарегистрироваться</v-btn>
                </v-col>
                <v-col v-if="user" cols="auto">
                    <v-menu>
                        <template #activator="{ props }">
                            <v-btn
                                v-bind="props"
                                color="teal-lighten-1"
                                class="text-white"
                                variant="text"
                            >
                                <div class="text-left">
                                    <div class="text-sm font-bold">{{ user.name }}</div>
                                    <div class="text-xs text-gray-400">{{ user.email }}</div>
                                </div>
                                <v-icon right>mdi-menu-down</v-icon>
                            </v-btn>
                        </template>

                        <v-list>
                            <v-list-item :to="{ path: '/profile' }">
                                <template #prepend>
                                    <v-icon color="teal-darken-1">mdi-account-circle</v-icon>
                                </template>
                                <v-list-item-title>Личный кабинет</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="logout()">
                                <template #prepend>
                                    <v-icon color="teal-darken-1">mdi-logout</v-icon>
                                </template>
                                <v-list-item-title>Выйти</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-col>
            </v-row>
        </v-container>
    </v-app-bar>
</template>

<script setup>
import {defineProps, onMounted, ref} from 'vue';
import QrLogo from "../components/QrLogo.vue";

const user = ref(null);
const props = defineProps({
    menuItems: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: Number,
        required: true,
    },
});

function logout() {
    localStorage.removeItem('user');
    localStorage.removeItem('auth_token');
    window.location.href = '/login';
}

onMounted(() => {
    const userData = localStorage.getItem('user');
    if (userData) {
        user.value = JSON.parse(userData);
    }
});
</script>

<style scoped>
.v-list-item .v-icon {
    opacity: 0.8 !important;
    transition: opacity 0.2s ease;
}
.v-list-item:hover .v-icon {
    opacity: 1 !important;
}
</style>
