<template>
    <v-container>
        <v-tabs
            v-model="activeTemplate"
            bg-color="primary"
            color="orange-lighten-3"
            class="slider-custom rounded-full"
            grow
        >
            <v-tab prepend-icon="mdi-upload" :value="1">Загрузить файл</v-tab>
            <v-tab prepend-icon="mdi-eye" :value="2" :disabled="!file">Предпросмотр</v-tab>
            <v-tab prepend-icon="mdi-qrcode" :value="3" :disabled="!file">Шаблон</v-tab>
            <v-tab prepend-icon="mdi-monitor-screenshot" :value="4" :disabled="!file">На экран</v-tab>
            <v-tab prepend-icon="mdi-download" :value="5" :disabled="!file">Скачать</v-tab>
        </v-tabs>

        <v-card-text>
            <v-tabs-window v-model="activeTemplate">
                <v-tabs-window-item :value="1">
                    <InputFile
                        :fileTypes="fileTypes"
                        :loading="loading"
                        @update:modelValue="onFileChange"
                        @upload="uploadFile"
                        v-model="file"
                    />
                </v-tabs-window-item>
                <v-tabs-window-item :value="2">
                    <PreviewComponent :content="fileContent" />
                </v-tabs-window-item>
                <v-tabs-window-item :value="3">
                    Three
                </v-tabs-window-item>
                <v-tabs-window-item :value="4">
                    <PreviewComponent :content="fileContent" />
                </v-tabs-window-item>
                <v-tabs-window-item :value="5">
                    5
                </v-tabs-window-item>
            </v-tabs-window>
        </v-card-text>
    </v-container>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import { apiService } from '../api/apiService.js';
import InputFile from "../components/InputFile.vue";
import PreviewComponent from "../components/PreviewComponent.vue";

const activeTemplate = ref(1);
const file = ref(null);
const fileContent = ref('');
const qrCodes = ref([]);
const loading = ref(false);
const fileTypes = ref(['.txt']);

watchEffect(() => {
    if (file.value) {
        readFile(file.value);
        activeTemplate.value = 2;
    } else {
        activeTemplate.value = 1;
    }
});

async function uploadFile() {
    loading.value = true;
    const formData = new FormData();
    formData.append('file', file.value);
    const response = await apiService.uploadFile(formData);
    qrCodes.value = response.data;
    loading.value = false;
}

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
</script>

<style scoped>
.slider-custom ::v-deep(.v-tab__slider) {
    right: 0;
    height: 100%;
    left: auto;
    width: 6px;
}
</style>
