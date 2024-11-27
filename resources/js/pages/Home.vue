<template>
    <div class="p-4">
        <div class="flex gap-4">
            <v-file-input
                variant="solo-filled"
                v-model="file"
                :label="`Выберите файл`"
                :accept="fileTypes.join(', ')"
                clearable
                prepend-icon=""
            >
                <template v-slot:details>
                    <span class="text-sm text-gray-600">
                        Поддерживаемые форматы: {{ fileTypes.join(', ') }}
                    </span>
                </template>
            </v-file-input>

            <v-btn class="flex items-center justify-center gap-2" :loading="loading" :disabled="!file" @click="uploadFile" color="primary">
                <v-icon class="mr-2">mdi-upload</v-icon>
                Загрузить
            </v-btn>
        </div>

        <div v-if="file" class="m-4">
            <p v-if="fileContent" class="text-lg font-semibold">Содержимое файла:</p>
            <div class="bg-gray-100 p-4 rounded-md max-h-48 overflow-y-auto">
                <pre>{{ fileContent }}</pre>
            </div>
        </div>

        <div class="mb-4">
            <v-btn @click="setMode('screen')" :color="mode === 'screen' ? 'primary' : 'default'" class="mr-2">
                На экран
            </v-btn>
            <v-btn @click="setMode('download')" :color="mode === 'download' ? 'primary' : 'default'">
                Скачать
            </v-btn>
        </div>

        <div class="m-4" v-if="mode === 'screen'">
            <div>
                <v-btn :disabled="qrCodes.length === 0" @click="printQRCode" class="mt-4" color="primary">
                    Печать
                </v-btn>
                <div class="border border-teal-300 rounded max-h-96 overflow-y-auto p-4">
                    <QRCodeRenderer class="qr-renderer" ref="qrRenderer" :qrCodes="qrCodes" />
                </div>
            </div>
        </div>

        <div v-if="mode === 'download'" class="mt-4">
            <div>Скачать</div>
        </div>
    </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import { apiService } from '../api/apiService.js';
import QRCodeRenderer from "../components/QRCodeRenderer.vue";

const file = ref(null);
const fileContent = ref('');
const mode = ref('screen');
const qrCodes = ref([]);
const loading = ref(false);
const fileTypes = ref(['.txt']);

function setMode(newMode) {
    mode.value = newMode;
}

async function uploadFile() {
    loading.value = true;
    const formData = new FormData();
    formData.append('file', file.value);
    const response = await apiService.uploadFile(formData);
    qrCodes.value = response.data;
    loading.value = false;
}

watchEffect(() => {
    if (file.value) readFile(file.value);
});

function readFile(file) {
    const reader = new FileReader();

    if (file.type === 'text/plain') {
        reader.readAsText(file);
    }
    reader.onload = (event) => {
        fileContent.value = event.target.result;
    };
    reader.onerror = () => {
        fileContent.value = 'Ошибка при чтении файла';
    };
}

function printQRCode() {
    const qrRenderer = document.querySelector('.qr-renderer');
    const printWindow = window.open('', '_blank');

    printWindow.document.write(`
        <html>
        <head>
            <title>Печать QR-кодов</title>
        </head>
        <body>
            ${qrRenderer.innerHTML}
        </body>
        </html>
    `);

    printWindow.focus();
    printWindow.print();
    printWindow.close();

    printWindow.onafterprint = () => {
        printWindow.close();
    };
}
</script>

<style scoped>
</style>
