<template>
    <v-card>
        <v-tabs v-model="tab" align-tabs="center" bg-color="teal-lighten-1">
            <v-tab value="history"><v-icon>mdi-history</v-icon>История</v-tab>
            <v-tab value="stat"><v-icon>mdi-chart-bar</v-icon>Статистика</v-tab>
        </v-tabs>

        <v-tabs-window v-model="tab">
            <v-tabs-window-item value="history">
                <HistoryComponent/>
            </v-tabs-window-item>

            <v-tabs-window-item value="stat">
                <v-card>
                    <v-card-text>
                        Здесь будет статистика пользователя.
                    </v-card-text>
                </v-card>
            </v-tabs-window-item>
        </v-tabs-window>
    </v-card>
</template>

<script setup>
import { ref } from 'vue';
import HistoryComponent from "../components/HistoryComponent.vue";

const tab = ref('history');
</script>

<style scoped>
</style>
