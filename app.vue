<template>
    <NuxtLayout>
        <v-app>
            <Header v-if="!isHeaderHidden" />
            <NuxtPage />
        </v-app>
    </NuxtLayout>
</template>

<script setup>
import { useRoute } from "vue-router";
import Header from "~/components/Header.vue";

const hiddenRoutes = ["/login"];
const route = useRoute();

const isHeaderHidden = hiddenRoutes.includes(route.path);
</script>

<style>
</style>
