<template>
    <v-container class="flex gap-4">
        <v-file-input
            variant="solo-filled"
            v-model="file"
            :label="`Выберите файл`"
            :accept="fileTypes.join(', ')"
            clearable
            prepend-icon=""
            @update:modelValue="onFileChange"
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
    </v-container>

    <v-container v-if="file">
        <v-tabs v-model="tab" background-color="primary" dark>
            <v-tab value="template1">
                Предпросмотр
            </v-tab>
            <v-tab value="template2" :disabled="!qrCodes.length">
                На экран
            </v-tab>
            <v-tab value="template3" :disabled="!qrCodes.length">
                Скачать
            </v-tab>
        </v-tabs>

        <v-card-text>
            <v-tabs-window v-model="tab">
                <v-tabs-window-item value="template1">
                    <div v-if="file" class="m-4">
                        <p v-if="fileContent" class="text-lg font-semibold">Содержимое файла:</p>
                        <div class="bg-gray-100 p-4 rounded-md max-h-48 overflow-y-auto">
                            <pre>{{ fileContent }}</pre>
                        </div>
                    </div>
                </v-tabs-window-item>
                <v-tabs-window-item value="template2">
                    <div>
                        <v-btn :disabled="qrCodes.length === 0" @click="printQRCode" class="mt-4" color="primary">
                            Печать
                        </v-btn>
                        <div class="border border-teal-300 rounded max-h-96 overflow-y-auto p-4">
                            <QRCodeRenderer class="qr-renderer" ref="qrRenderer" :qrCodes="qrCodes" />
                        </div>
                    </div>
                </v-tabs-window-item>
                <v-tabs-window-item value="template3">
                    <div class="m-4">
                        <h3>Скачать</h3>
                    </div>
                </v-tabs-window-item>
            </v-tabs-window>
        </v-card-text>
    </v-container>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import { apiService } from '../api/apiService.js';
import QRCodeRenderer from "../components/QRCodeRenderer.vue";

const file = ref(null);
const fileContent = ref('');
const qrCodes = ref([]);
const loading = ref(false);
const fileTypes = ref(['.txt']);
const tab = ref('template1');

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

function onFileChange() {
    qrCodes.value = [];
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
