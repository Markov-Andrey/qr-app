<template>
    <div ref="printContent" class="flex flex-wrap gap-4 relative min-h-36">
        <div
            v-if="loading"
            class="absolute inset-0 flex items-center justify-center bg-white/50 backdrop-blur-lg z-10"
        >
            <v-progress-circular
                indeterminate
                size="64"
                color="primary"
            />
        </div>
        <div class="flex" v-for="(qr, index) in qrCodes" :key="index">
            <div v-if="qr" v-html="qr" />
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { apiService } from "../api/apiService.js";

const props = defineProps({
    file: {
        type: File,
        required: true,
    },
});

const qrCodes = ref([]);
const loading = ref(false);

async function generateQRCodes(fileContent) {
    loading.value = true;
    try {
        const codes = fileContent.split('\n');
        const response = await apiService.uploadFile({ codes });

        if (response && response.data) {
            qrCodes.value = response.data.map(qrCode => {
                return `<div class="qr-code">${qrCode}</div>`;
            });
        }
    } catch (error) {
        console.error("Ошибка при генерации QR-кодов:", error);
    } finally {
        loading.value = false;
    }
}
watch(() => props.file, (newFile) => {
    if (newFile) {
        const reader = new FileReader();
        reader.onload = () => {
            const content = reader.result;
            generateQRCodes(content);
        };
        reader.readAsText(newFile);
    }
}, { immediate: true });
</script>

<style scoped>
.backdrop-blur-lg {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}
</style>
