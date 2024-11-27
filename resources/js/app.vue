<template>
    <v-app>
        <!-- Передаем меню и активный таб в хэдер -->
        <Header
            :menuItems="menuItems"
            :modelValue="activeTab"
            @update:modelValue="handleTabChange"
            @navigate="handleNavigation"
        />

        <!-- Контент страницы -->
        <v-main>
            <router-view />
            <router-view />
            <router-view />
            <router-view />
            <router-view />
            <router-view />
            <router-view />
        </v-main>
    </v-app>
</template>

<script>
import { ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Header from './components/Header.vue';

export default {
    name: 'App',
    components: {
        Header,
    },
    setup() {
        const route = useRoute();
        const router = useRouter();

        // Меню с роутами
        const menuItems = ref([
            { label: 'Шаблон 1', to: '/' },
            { label: 'Шаблон 2', to: '/template2' },
            { label: 'Шаблон 3', to: '/template3' },
        ]);

        // Определение активного таба
        const activeTab = ref(
            menuItems.value.findIndex(item => item.to === route.path)
        );

        // Следим за изменением маршрута
        watch(
            () => route.path,
            (newPath) => {
                activeTab.value = menuItems.value.findIndex(
                    item => item.to === newPath
                );
            }
        );

        // Обработка навигации
        const handleNavigation = (path) => {
            router.push(path);
        };

        // Обработка изменения активного таба
        const handleTabChange = (newTabIndex) => {
            activeTab.value = newTabIndex;
        };

        return {
            menuItems,
            activeTab,
            handleNavigation,
            handleTabChange,
        };
    },
};
</script>
