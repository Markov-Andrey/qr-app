<template>
    <div class="p-4">
        <v-file-input
            variant="solo-filled"
            v-model="file"
            label="Выберите текстовый файл"
            accept=".txt, .pdf, .doc, .docx"
            @change="onFileChange"
            clearable
            prepend-icon=""
        >
            <template v-slot:details>
                <span class="text-sm text-gray-600">
                    Поддерживаемые форматы: .txt, .pdf, .doc, .docx
                </span>
            </template>
        </v-file-input>

        <div class="mb-4">
            <v-btn
                @click="setMode('svg')"
                :color="mode === 'svg' ? 'primary' : 'default'"
                class="mr-2"
            >
                SVG
            </v-btn>
            <v-btn
                @click="setMode('screen')"
                :color="mode === 'screen' ? 'primary' : 'default'"
            >
                На экран
            </v-btn>
        </div>

        <div v-if="mode === 'svg'" class="mt-4">
            <p class="text-lg font-semibold">Режим SVG</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100">
                <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" />
            </svg>
        </div>
        <div v-if="mode === 'screen'" class="mt-4">
            <p class="text-lg font-semibold">Режим на экран</p>
            <pre class="bg-gray-100 p-4 rounded-md">{{ fileContent }}</pre>
        </div>
    </div>
</template>

<script>
export default {
    name: 'index',
    data() {
        return {
            file: null,
            fileContent: '',
            mode: 'screen',
        };
    },
    methods: {
        onFileChange() {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.fileContent = e.target.result;
            };
            if (this.file) {
                reader.readAsText(this.file);
            }
        },
        setMode(newMode) {
            this.mode = newMode;
        },
    },
};
</script>

<style scoped>
</style>
