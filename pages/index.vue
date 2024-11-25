<template>
    <div class="p-4">
        <!-- File input -->
        <v-file-input
            variant="solo-filled"
            v-model="file"
            :label="`Выберите файл (${fileTypes.join(', ')})`"
            :accept="fileTypes.join(', ')"
            @change="onFileChange"
            clearable
            prepend-icon=""
        >
            <template v-slot:details>
        <span class="text-sm text-gray-600">
          Поддерживаемые форматы: {{ fileTypes.join(', ') }}
        </span>
            </template>
        </v-file-input>

        <!-- Mode Switch -->
        <div class="mb-4">
            <v-btn @click="setMode('svg')" :color="mode === 'svg' ? 'primary' : 'default'" class="mr-2">
                SVG
            </v-btn>
            <v-btn @click="setMode('screen')" :color="mode === 'screen' ? 'primary' : 'default'">
                На экран
            </v-btn>
        </div>

        <!-- Display QR codes in SVG format -->
        <div v-if="mode === 'svg'" class="mt-4">
            <p class="text-lg font-semibold">Режим SVG</p>
            <div v-for="(qr, index) in qrCodes" :key="index" class="mb-16 w-[120px] h-[120px]">
                <img class="w-full" :src="qr" alt="QR Code" />
            </div>
        </div>

        <!-- Display file content in Screen mode -->
        <div v-if="mode === 'screen'" class="mt-4">
            <p class="text-lg font-semibold">Режим на экран</p>
            <pre class="bg-gray-100 p-4 rounded-md">{{ fileContent }}</pre>
        </div>

        <v-btn @click="printQRCode" class="mt-4" color="primary">
            Печать
        </v-btn>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { apiService } from '~/services/apiService';

const file = ref(null);
const fileContent = ref('');
const mode = ref('screen');
const qrCodes = ref([]);
const fileTypes = ref(['.txt', '.pdf', '.doc', '.docx']);

async function onFileChange() {
    const reader = new FileReader();
    reader.onload = async (e) => {
        fileContent.value = e.target.result;
        await fetchQr(e.target.result);
    };
    if (file.value) {
        reader.readAsText(file.value);
    }
}

async function fetchQr(fileContent) {
    try {
        const formData = new FormData();
        formData.append('file', file.value);

        const response = await apiService.uploadFile(formData);

        qrCodes.value = response.data.qrImages;
    } catch (error) {
        console.error('Ошибка при отправке файла на сервер:', error);
    }
}

function setMode(newMode) {
    mode.value = newMode;
}

function printQRCode() {
    const printWindow = window.open('', '_blank', 'width=800,height=600');
    printWindow.document.write('<html><head><title>QR-коды</title></head><body>');
    printWindow.document.write('<h1>QR-коды</h1>');

    qrCodes.value.forEach((qr) => {
        printWindow.document.write(`<img class="w-full" src="${qr}" />`);
    });

    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
</script>

<style scoped>
</style>
