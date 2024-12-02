<template>
    <div class="bg-gray-100 p-4 rounded-md max-h-96 overflow-y-auto">
        <pre>{{ fileContent || 'Нет данных для отображения' }}</pre>
    </div>
</template>

<script setup>
import {ref, watch} from 'vue';

const props = defineProps({
    file: {
        type: File,
        default: null
    }
});

const fileContent = ref('');

watch(() => props.file, (newFile) => {
    if (newFile) {
        readFile(newFile);
    } else {
        fileContent.value = '';
    }
}, {immediate: true});

function readFile(file) {
    const reader = new FileReader();
    reader.onload = () => {
        fileContent.value = reader.result;
    };
    reader.onerror = () => {
        fileContent.value = 'Ошибка при чтении файла';
    };
    if (file && file.type === 'text/plain') {
        reader.readAsText(file);
    } else {
        fileContent.value = 'Файл не поддерживается';
    }
}
</script>

<style scoped>
</style>
