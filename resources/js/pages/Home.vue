<template>
    <v-container v-if="blocked" class="text-center my-4">
        <v-card variant="text" class="pa-4" outlined>
            <v-card-title class="headline flex justify-center gap-2">
                <v-icon left>mdi-lock</v-icon>
                <div>Лимит обработанных файлов достигнут</div>
            </v-card-title>
            <v-card-subtitle>
                Пожалуйста, попробуйте снова завтра. Мы ценим вашу активность!
            </v-card-subtitle>
        </v-card>
    </v-container>
    <v-container v-else>
        <v-stepper v-model="activeStep" alt-labels editable>
            <v-stepper-header>
                <v-stepper-item
                    color="teal-darken-2"
                    :complete="!!file"
                    :value="1"
                >
                    <template v-slot:title>Загрузить файл</template>
                </v-stepper-item>
                <v-divider opacity="1" :class="getDividerClass(1)" />
                <v-stepper-item
                    color="teal-darken-2"
                    :disabled="!file"
                    :complete="activeStep > 2"
                    :value="2"
                >
                    <template v-slot:title>Предпросмотр</template>
                </v-stepper-item>
                <v-divider opacity="1" :class="getDividerClass(2)" />
                <v-stepper-item
                    color="teal-darken-2"
                    :disabled="!file"
                    :complete="activeStep > 3"
                    :value="3"
                >
                    <template v-slot:title>Шаблон</template>
                </v-stepper-item>
                <v-divider opacity="1" :class="getDividerClass(3)" />
                <v-stepper-item
                    color="teal-darken-2"
                    :disabled="!file || !selectedTemplate"
                    :complete="activeStep > 4"
                    :value="4"
                >
                    <template v-slot:title>Результат</template>
                </v-stepper-item>
            </v-stepper-header>

            <v-stepper-window>
                <v-stepper-window-item :value="1">
                    <InputFile :fileTypes="fileTypes" @update:modelValue="onFileChange" v-model="file" />
                </v-stepper-window-item>
                <v-stepper-window-item :value="2"><v-card flat><PreviewComponent :file="file" /></v-card></v-stepper-window-item>
                <v-stepper-window-item :value="3"><TemplateComponent v-model="selectedTemplate" /></v-stepper-window-item>
                <v-stepper-window-item v-if="file && selectedTemplate" :value="4"><QRCodeRenderer @attempts-updated="handleAttemptsUpdated" :file="file" /></v-stepper-window-item>
            </v-stepper-window>

            <v-stepper-actions>
                <template #prev="{ props }">
                    <v-btn prepend-icon="mdi-chevron-left-circle" color="orange" @click="activeStep--" :disabled="activeStep === 1">Назад</v-btn>
                </template>
                <template #next="{ props }">
                    <v-btn v-if="activeStep !== 4" append-icon="mdi-chevron-right-circle" color="primary" @click="activeStep++" :disabled="isNextDisabled">Далее</v-btn>
                    <v-btn v-if="activeStep === 4" append-icon="mdi-refresh" color="primary" @click="restartStepper" :disabled="isNextDisabled">Начать заново</v-btn>
                </template>
            </v-stepper-actions>
        </v-stepper>
    </v-container>
</template>

<script setup>
import {computed, onMounted, ref} from 'vue';
import InputFile from "../components/InputFile.vue";
import PreviewComponent from "../components/PreviewComponent.vue";
import TemplateComponent from "../components/TemplateComponent.vue";
import QRCodeRenderer from "../components/QRCodeRenderer.vue";

const fileTypes = ref(['.txt']);
const activeStep = ref(1);
const file = ref(null);
const selectedTemplate = ref(null);
const blocked = ref(false);

const isNextDisabled = computed(() => {
    switch (activeStep.value) {
        case 1: case 2: return !file.value;
        case 3: return !selectedTemplate.value;
        default: return false;
    }
});
onMounted(() => {
    resetProcessingAttemptsAtMidnight();
    handleAttemptsUpdated();
});
function handleAttemptsUpdated() {
    const attempts = parseInt(localStorage.getItem('processingAttempts') || '0', 10);
    blocked.value = attempts >= 5;
}
function resetProcessingAttemptsAtMidnight() {
    const lastResetDate = localStorage.getItem('reset');
    const currentDate = new Date().toLocaleDateString();
    if (lastResetDate !== currentDate) {
        localStorage.removeItem('processingAttempts');
        localStorage.setItem('reset', currentDate);
    }
}
const restartStepper = () => {
    activeStep.value = 1;
    file.value = null;
    selectedTemplate.value = null;
};

const onFileChange = (newFile) => {
    file.value = newFile;
    if (file.value) activeStep.value = 2;
};

const getDividerClass = (step) => ({
    'border-[1.5px] transition-all duration-300 ease-in-out': true,
    'border-teal-600': step < activeStep.value,
    'border-gray-300': step >= activeStep.value,
});
</script>

<style scoped>
</style>
