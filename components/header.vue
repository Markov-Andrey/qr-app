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
                <v-col v-if="menuItems.length === 0" class="text-center">
                    <p>Меню не загружено</p>
                </v-col>
            </v-row>
        </v-container>
    </v-app-bar>
</template>

<script>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { apiService } from '~/services/apiService';

export default {
    name: 'Header',
    setup() {
        const route = useRoute();
        const menuItems = ref([]);

        onMounted(async () => {
            const response = await apiService.menuItems();
            menuItems.value = response.data;
        });
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
