<template>
    <InputFile
        :fileTypes="fileTypes"
        :loading="loading"
        @update:modelValue="onFileChange"
        @upload="uploadFile"
        v-model="file"
    />

    <div v-if="file" class="d-flex mt-[50px]">
        <div class="tabs-container text-white">
            <v-tabs
                height="60"
                slider-color="#f78166"
                v-model="activeTemplate"
                direction="vertical"
                color="orange-lighten-3"
                grow
                class="slider-right"
            >
                <v-tab class="bg-teal-500" value="template1">Шаблон 1</v-tab>
                <v-tab class="bg-teal-500" value="template2">Шаблон 2</v-tab>
                <v-tab class="bg-teal-500" value="template3">Шаблон 3</v-tab>
            </v-tabs>
        </div>

        <div class="content-container w-full mt-[-50px]">
            <v-tabs
                v-model="activeAction"
                class="bg-teal-600 text-white"
                slider-color="#f78166"
                color="orange-lighten-3"
                grow
            >
                <v-tab value="preview">Предпросмотр файла</v-tab>
                <v-tab value="screen" :disabled="!qrCodes.length">На экран</v-tab>
                <v-tab value="download" :disabled="!qrCodes.length">Скачать</v-tab>
            </v-tabs>

            <div class="content-area m-4">
                <div v-if="activeTemplate === 'template1'">
                    <div v-if="activeAction === 'preview'">
                        <PreviewComponent :content="fileContent" />
                    </div>
                    <div v-else-if="activeAction === 'screen'">
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
                        <div class="preview-container overflow-y-auto">
                            <div class="a4-sheet qr-renderer">
                                <QRCodeRenderer ref="qrRenderer" :sizeQr="selectedSize" :qrCodes="qrCodes" />
                            </div>
                        </div>
                    </div>
                    <div v-else-if="activeAction === 'download'">
                        <DownloadFileComponent/>
                    </div>
                </div>

                <div v-if="activeTemplate === 'template2'">
                    <div v-if="activeAction === 'preview'">
                        <PreviewComponent :content="fileContent" />
                    </div>
                    <div v-else-if="activeAction === 'screen'">
                        <h3>На экран - Шаблон 2</h3>
                        <p>Здесь отображается вывод на экран для Шаблона 2.</p>
                    </div>
                    <div v-else-if="activeAction === 'download'">
                        <DownloadFileComponent/>
                    </div>
                </div>

                <div v-if="activeTemplate === 'template3'">
                    <div v-if="activeAction === 'preview'">
                        <PreviewComponent :content="fileContent" />
                    </div>
                    <div v-else-if="activeAction === 'screen'">
                        <h3>На экран - Шаблон 3</h3>
                        <p>Здесь отображается вывод на экран для Шаблона 3.</p>
                    </div>
                    <div v-else-if="activeAction === 'download'">
                        <DownloadFileComponent/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import { apiService } from '../api/apiService.js';
import QRCodeRenderer from "../components/QRCodeRenderer.vue";
import InputFile from "../components/InputFile.vue";
import PreviewComponent from "../components/PreviewComponent.vue";
import DownloadFileComponent from "../components/DownloadFileComponent.vue";

const activeTemplate = ref('template1');
const activeAction = ref('preview');
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
.slider-right ::v-deep(.v-tab__slider) {
    right: 0 !important;
    left: auto;
    width: 5px;
}
</style>
