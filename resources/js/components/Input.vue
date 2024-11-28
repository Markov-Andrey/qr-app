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
</template>

<script>
export default {
    name: "Input",
    props: {
        fileTypes: {
            type: Array,
            required: true,
        },
        loading: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            file: null,
        };
    },
    methods: {
        onFileChange(newFile) {
            this.$emit('update:modelValue', newFile);
        },

        uploadFile() {
            this.$emit('upload', this.file);
        },
    },
};
</script>
