<template>
    <v-app-bar app color="teal-darken-3">
        <v-container>
            <v-row align="center" justify="space-between">
                <v-col cols="auto" class="flex gap-2">
                    <span class="text-xl font-bold">QR-Gen</span>
                </v-col>
                <v-col cols="auto" class="flex gap-4">
                    <v-btn variant="tonal" class="font-bold shadow-md" :to="{ path: '/login' }">Войти</v-btn>
                    <v-btn variant="tonal" class="font-bold shadow-md" :to="{ path: '/signup' }">Зарегистрироваться</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-app-bar>
    <v-app-bar app color="teal-lighten-1" density="compact">
        <v-tabs :modelValue="activeTab" align-tabs="start" @update:modelValue="updateActiveTab">
            <v-tab
                v-for="(item, index) in menuItems"
                :key="index"
                :value="index"
                @click="$emit('navigate', item.to)"
            >
                {{ item.label }}
            </v-tab>
        </v-tabs>
    </v-app-bar>
</template>

<script setup>
import { computed, defineProps, defineEmits } from 'vue';

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

const emit = defineEmits();
const activeTab = computed(() => props.modelValue);

const updateActiveTab = (newValue) => {
    emit('update:modelValue', newValue);
};
</script>

<style scoped>
</style>
