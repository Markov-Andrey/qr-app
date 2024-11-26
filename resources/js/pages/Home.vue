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

            <v-btn icon="mdi-upload-box" :disabled="!file" @click="uploadFile" color="primary"/>
        </div>

        <div class="mb-4">
            <v-btn @click="setMode('svg')" :color="mode === 'svg' ? 'primary' : 'default'" class="mr-2">
                SVG
            </v-btn>
            <v-btn @click="setMode('screen')" :color="mode === 'screen' ? 'primary' : 'default'">
                На экран
            </v-btn>
        </div>

        <div v-if="mode === 'svg'">
            <QRCodeRenderer class="qr-renderer" ref="qrRenderer" :qrCodes="qrCodes" />
        </div>

        <div v-if="mode === 'screen'" class="mt-4">
            <p class="text-lg font-semibold">Режим на экран</p>
            <pre class="bg-gray-100 p-4 rounded-md">{{ fileContent }}</pre>
        </div>

        <v-btn :disabled="qrCodes.length === 0" @click="printQRCode" class="mt-4" color="primary">
            Печать
        </v-btn>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { apiService } from '../api/apiService.js';
import QRCodeRenderer from "../components/QRCodeRenderer.vue";

const file = ref(null);
const fileContent = ref('');
const mode = ref('screen');
const qrCodes = ref([]);
const fileTypes = ref(['.txt', '.pdf', '.doc', '.docx']);

function setMode(newMode) {
    mode.value = newMode;
}
async function uploadFile() {
    const formData = new FormData();
    formData.append('file', file.value);
    const response = await apiService.uploadFile(formData);
    qrCodes.value = response.data;
}
function printQRCode() {
    // Ссылка на компонент QRCodeRenderer
    const qrRenderer = document.querySelector('.qr-renderer'); // Используем правильный класс для контейнера
    if (!qrRenderer) {
        console.error('QRCodeRenderer не найден!');
        return;
    }

    // Создаём новое окно для печати
    const printWindow = window.open('', '_blank');
    if (!printWindow) {
        console.error('Не удалось открыть окно для печати!');
        return;
    }

    // Наполняем окно содержимым QR-кодов
    printWindow.document.write(`
        <html>
        <head>
            <title>Печать QR-кодов</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                    padding: 20px;
                }
                .qr-item {
                    margin-bottom: 20px;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            ${qrRenderer.innerHTML}
        </body>
        </html>
    `);

    // Завершаем построение и запускаем печать
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();

    // Опционально, закрываем окно после печати
    printWindow.onafterprint = () => {
        printWindow.close();
    };
}
</script>

<style scoped>
</style>
