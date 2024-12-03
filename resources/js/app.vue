<template>
    <v-app>
        <Header
            v-if="!isHiddenRoute"
            :menuItems="menuItems"
            :modelValue="activeTab"
            @update:modelValue="handleTabChange"
            @navigate="handleNavigation"
        />
        <v-main>
            <router-view />
        </v-main>
    </v-app>
</template>

<script>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Header from './components/Header.vue';

export default {
    name: 'App',
    components: { Header },
    setup() {
        const route = useRoute();
        const router = useRouter();
        const menuItems = [
            { label: 'Шаблон 1', to: '/' },
            { label: 'Шаблон 2', to: '/template2' },
            { label: 'Шаблон 3', to: '/template3' },
        ];

        const hiddenRoutes = ['/login', '/signup'];
        const isHiddenRoute = computed(() => hiddenRoutes.includes(route.path));
        const activeTab = computed(() =>
            menuItems.findIndex(item => item.to === route.path)
        );

        const handleNavigation = (path) => router.push(path);
        const handleTabChange = (newTabIndex) => {
            if (menuItems[newTabIndex]) router.push(menuItems[newTabIndex].to);
        };

        return { menuItems, activeTab, isHiddenRoute, handleNavigation, handleTabChange };
    },
};
</script>
