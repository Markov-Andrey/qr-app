<template>
    <v-app>
        <Header />

        <v-main>
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
import Header from './components/header.vue';

export default {
    name: 'App',
    components: {
        Header,
    },
};
</script>

<style scoped>
</style>
