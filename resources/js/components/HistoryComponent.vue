<template>
    <v-table>
        <thead>
        <tr>
            <th class="text-left">ID</th>
            <th class="text-left w-3/4">Данные</th>
            <th class="text-left">Создано</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in historyData" :key="item.id">
            <td>{{ item.id }}</td>
            <td>
                <div class="max-h-[300px] overflow-y-auto block">
                    <div v-for="(code, index) in parseProcessedData(item.processed_data)" :key="index">
                        <span>{{ code }}</span>
                    </div>
                </div>
            </td>
            <td>{{ formatDate(item.created_at) }}</td>
        </tr>
        </tbody>
    </v-table>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { apiService } from "../api/apiService.js";

const historyData = ref([]);

const fetchData = async () => {
    const historyResponse = await apiService.history();
    historyData.value = historyResponse.data;
};

const parseProcessedData = (data) => {
    if (Array.isArray(data)) {
        return data;
    }
    return [];
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleDateString('ru-RU', options);
};

onMounted(fetchData);
</script>

<style scoped>
</style>
