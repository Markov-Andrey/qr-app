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

<script>
export default {
    name: "InputFile",
    props: {
        fileTypes: {
            type: Array,
            required: true,
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
    },
};
</script>
