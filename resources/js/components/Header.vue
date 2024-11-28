<template>
    <v-app-bar app color="teal-darken-3">
        <v-container>
            <v-row align="center" justify="space-between">
                <v-col cols="auto" class="flex gap-2 items-center justify-center">
                    <QrLogo class="flex w-5 h-5 text-white" />
                    <span class="text-xl font-bold">QR-Gen</span>
                </v-col>
                <v-col cols="auto" class="flex gap-4">
                    <v-btn variant="tonal" class="font-bold shadow-md" :to="{ path: '/login' }">Войти</v-btn>
                    <v-btn variant="tonal" class="font-bold shadow-md" :to="{ path: '/signup' }">Зарегистрироваться</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-app-bar>
</template>

<script setup>
import { defineProps } from 'vue';
import QrLogo from "../components/QrLogo.vue";

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
</script>

<style scoped>
</style>
