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
    </v-container>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
    fileTypes: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: [File, null],
        default: null,
    },
});

const emit = defineEmits();
const file = ref(props.modelValue);

watch(() => props.modelValue, (newFile) => {
    file.value = newFile;
});

const onFileChange = (newFile) => {
    emit('update:modelValue', newFile);
};
</script>
