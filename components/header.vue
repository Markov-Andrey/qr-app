<template>
    <v-app-bar app color="teal-lighten-2" dark>
        <v-container>
            <v-row align="center" justify="space-between">
                <v-col cols="auto" class="flex gap-2">
                    <v-btn
                        v-for="(item, index) in menuItems"
                        :key="index"
                        :to="item.to"
                        class="menu-btn"
                        :class="{ 'active-btn': isActive(item.to) }"
                        variant="text"
                    >
                        {{ item.label }}
                    </v-btn>
                </v-col>
                <v-col cols="auto" class="flex gap-4">
                    <v-btn variant="tonal" class="font-bold shadow-md" :to="{ path: '/login' }">Sign In</v-btn>
                    <v-btn variant="tonal" class="font-bold shadow-md" :to="{ path: '/signup' }">Sign Up Free</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-app-bar>
</template>

<script>
import { ref } from 'vue';
import { useRoute } from 'vue-router';

export default {
    name: 'Header',
    setup() {
        const route = useRoute();

        const menuItems = ref([
            { label: 'Шаблон 1', to: '/' },
            { label: 'Шаблон 2', to: '/about' },
            { label: 'Шаблон 3', to: '/contact' },
        ]);

        const isActive = (path) => route.path === path;

        return {
            menuItems,
            isActive,
        };
    },
};
</script>

<style scoped>
</style>
