<template>
    <Input
        :fileTypes="fileTypes"
        :loading="loading"
        @update:modelValue="onFileChange"
        @upload="uploadFile"
        v-model="file"
    />

    <v-container v-if="file">
        <v-tabs v-model="tab" background-color="primary" dark>
            <v-tab value="view">
                Предпросмотр
            </v-tab>
            <v-tab value="screen" :disabled="!qrCodes.length">
                На экран
            </v-tab>
            <v-tab value="files" :disabled="!qrCodes.length">
                Скачать
            </v-tab>
        </v-tabs>

        <v-card-text>
            <v-tabs-window v-model="tab">
                <v-tabs-window-item value="view">
                    <div v-if="file" class="m-4">
                        <p v-if="fileContent" class="text-lg font-semibold">Содержимое файла:</p>
                        <div class="bg-gray-100 p-4 rounded-md max-h-48 overflow-y-auto">
                            <pre>{{ fileContent }}</pre>
                        </div>
                    </div>
                </v-tabs-window-item>
                <v-tabs-window-item value="screen">
                    <div>
                        <div class="flex gap-4">
                            <v-btn :disabled="qrCodes.length === 0" @click="printQRCode" class="mt-4" color="primary">
                                <v-icon class="mr-2">mdi-printer</v-icon>
                                Печать {{ selectedSize.text }}
                            </v-btn>
                            <div class="w-[150px]">
                                <v-select
                                    color="primary"
                                    variant="solo"
                                    v-model="selectedSize"
                                    :items="items"
                                    item-title="text"
                                    item-value="value"
                                    label="Select"
                                    persistent-hint
                                    return-object
                                    single-line
                                />
                            </div>
                        </div>
                        <div>
                            <h1 class="font-bold text-xl p-4">Предпросмотр:</h1>
                            <div class="preview-container overflow-y-auto">
                                <div class="a4-sheet qr-renderer">
                                    <QRCodeRenderer ref="qrRenderer" :sizeQr="selectedSize" :qrCodes="qrCodes" />
                                </div>
                            </div>
                        </div>
                    </div>
                </v-tabs-window-item>
                <v-tabs-window-item value="files">
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
import Input from "../components/Input.vue";

const file = ref(null);
const fileContent = ref('');
const qrCodes = ref([]);
const loading = ref(false);
const fileTypes = ref(['.txt']);
const tab = ref('view');
const items = ref([
    { text: '10x10', value: [1, 1] },
    { text: '20x20', value: [2, 2] },
    { text: '30x30', value: [3, 3] },
    { text: '40x40', value: [4, 4] },
    { text: '50x50', value: [5, 5] },
]);
const selectedSize = ref(items.value[0]);

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
    tab.value = 'template1';
}

function printQRCode() {
    const qrRenderer = document.querySelector('.qr-renderer');
    const printWindow = window.open('', '_blank');

    const styles = Array.from(document.styleSheets)
        .map((sheet) => {
            try {
                return Array.from(sheet.cssRules)
                    .map((rule) => rule.cssText)
                    .join('');
            } catch (e) {
                console.warn('Cannot access stylesheet:', sheet, e);
                return '';
            }
        })
        .join('');

    printWindow.document.write(`
        <html>
        <head>
            <title>Печать QR-кодов</title>
            <style>${styles}</style>
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
.preview-container {
    position: relative;
    width: 100%;
    max-width: 794px;
    height: calc(794px * 297 / 210);
    border: 1px solid #4fd1c5;
    border-radius: 8px;
    overflow: hidden;
    background-color: white;
    box-sizing: border-box;
    transform-origin: top left;
}
.a4-sheet {
    padding: 28px 28px;
    gap: calc(5px * (794 / 210));
    box-sizing: border-box;
}
</style>
