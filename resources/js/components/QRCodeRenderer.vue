<template>
    <div ref="printContent" class="flex flex-wrap gap-4">
        <div class="flex" v-for="(qr, index) in qrCodes" :key="index">
            <div v-if="qr" v-html="qr" />
        </div>
    </div>
</template>

<script setup>
import {ref, watch} from 'vue';
import {apiService} from "../api/apiService.js";

const props = defineProps({
    file: {
        type: File,
        required: true,
    },
});

const qrCodes = ref([]);

async function generateQRCodes(fileContent) {
    const codes = fileContent.split('\n');
    const response = await apiService.uploadFile({ codes });
    if (response && response.data) {
        qrCodes.value = response.data.map(qrCode => {
            return `<div class="qr-code">${qrCode}</div>`;
        });
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
