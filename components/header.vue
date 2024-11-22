<template>
    <v-app-bar app color="teal-lighten-2" dark>
        <v-container>
            <v-row align="center" justify="space-between">
                <v-col
                    v-for="(item, index) in menuItems"
                    :key="index"
                    class="text-center"
                >
                    <v-btn
                        :to="item.to"
                        class="menu-btn"
                        :class="{ 'active-btn': isActive(item.to) }"
                        variant="text"
                    >
                        {{ item.label }}
                    </v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-app-bar>
</template>

<script>
import { useRoute } from "vue-router";
// import { apiService } from '~/services/apiService';

export default {
    name: "Header",
    async setup() {
        const route = useRoute();
        // const menuItems = await apiService.menuItems();

        const menuItems = [
            {label: "Шаблон 1", to: "/"},
            {label: "Шаблон 2", to: "/about"},
            {label: "Шаблон 3", to: "/contact"},
        ];

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
