<template>
    <div>
        <div class="flex mb-4">
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn class="w-[175px]" v-bind="props" color="primary">
                        Размер {{ selectedSize.text }}
                        <v-icon class="mr-1">mdi-menu-down</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item
                        v-for="(item, index) in items"
                        :key="index"
                        @click="selectSize(item)"
                        :class="{'bg-primary text-white': selectedSize.text === item.text}"
                    >
                        <v-list-item-title>{{ item.text }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>

            <v-divider class="border-opacity-100 mx-3" vertical />

            <v-btn @click="printQRCode" color="primary">
                <v-icon class="mr-2">mdi-printer</v-icon>
                Печать
            </v-btn>

            <v-divider class="border-opacity-100 mx-3" vertical />

            <v-btn color="primary">
                <v-icon class="mr-2">mdi-download</v-icon>
                Скачать
            </v-btn>
        </div>
    </div>
    <div id="qr-renderer">
        <div class="flex flex-wrap gap-4 relative min-h-36">
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
            <div v-for="(qr, index) in qrCodes" :key="index">
                <div v-if="qr" v-html="qr" />
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref, watch, defineEmits} from 'vue';
import { apiService } from "../api/apiService.js";

const props = defineProps({
    file: {
        type: File,
        default: null,
    },
});

const qrCodes = ref([]);
const loading = ref(false);
const items = ref([
    { text: '10x10', value: [1, 1] },
    { text: '20x20', value: [2, 2] },
    { text: '30x30', value: [3, 3] },
    { text: '40x40', value: [4, 4] },
    { text: '50x50', value: [5, 5] },
]);
const selectedSize = ref(items.value[0]);
const emit = defineEmits();

function selectSize(item) {
    selectedSize.value = item;
}
async function generateQRCodes(fileContent) {
    loading.value = true;
    try {
        const codes = fileContent.split('\n');
        const response = await apiService.uploadFile({ codes });

        if (response && response.data) {
            qrCodes.value = response.data;
            checkAttempts();
        }
    } catch (error) {
        console.error("Ошибка при генерации QR-кодов:", error);
    } finally {
        loading.value = false;
    }
}
function checkAttempts() {
    let attempts = parseInt(localStorage.getItem('processingAttempts') || '0', 10);
    attempts += 1;
    localStorage.setItem('processingAttempts', attempts.toString());
    emit('attempts-updated');
}
function printQRCode() {
    const qrRenderer = document.querySelector('#qr-renderer');
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
