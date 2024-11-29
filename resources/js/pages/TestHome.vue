<template>
    <div>
        <v-tabs
            v-model="activeTemplate"
            bg-color="primary"
            color="orange-lighten-3"
            class="slider-custom"
        >
            <v-tab prepend-icon="mdi-upload" value="one">Загрузить файл</v-tab>
            <v-tab prepend-icon="mdi-eye" value="two" :disabled="!file">Предпросмотр</v-tab>
            <v-tab prepend-icon="mdi-monitor-screenshot" value="three" :disabled="!file">На экран</v-tab>
            <v-tab prepend-icon="mdi-download" value="four" :disabled="!file">Скачать</v-tab>
        </v-tabs>

        <v-card-text>
            <v-tabs-window v-model="activeTemplate">
                <v-tabs-window-item value="one">
                    <InputFile
                        :fileTypes="fileTypes"
                        :loading="loading"
                        @update:modelValue="onFileChange"
                        @upload="uploadFile"
                        v-model="file"
                    />
                </v-tabs-window-item>
                <v-tabs-window-item value="two">
                    <PreviewComponent :content="fileContent" />
                </v-tabs-window-item>
                <v-tabs-window-item value="three">
                    Three
                </v-tabs-window-item>
                <v-tabs-window-item value="four">
                    Four
                </v-tabs-window-item>
            </v-tabs-window>
        </v-card-text>
    </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue';
import { apiService } from '../api/apiService.js';
import InputFile from "../components/InputFile.vue";
import PreviewComponent from "../components/PreviewComponent.vue";

const activeTemplate = ref('one');
const file = ref(null);
const fileContent = ref('');
const qrCodes = ref([]);
const loading = ref(false);
const fileTypes = ref(['.txt']);

watchEffect(() => {
    if (file.value) {
        readFile(file.value);
        activeTemplate.value = 'two';
    } else {
        activeTemplate.value = 'one';
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
