<template>
    <v-container>
        <v-stepper v-model="activeStep" alt-labels editable>
            <v-stepper-header>
                <v-stepper-item color="teal-darken-2" :complete="file" :value="1">
                    <template v-slot:title>Загрузить файл</template>
                </v-stepper-item>
                <v-divider opacity="1" :class="getDividerClass(1)" />
                <v-stepper-item color="teal-darken-2" :disabled="!file" :complete="activeStep > 2" :value="2">
                    <template v-slot:title>Предпросмотр</template>
                </v-stepper-item>
                <v-divider opacity="1" :class="getDividerClass(2)" />
                <v-stepper-item color="teal-darken-2" :disabled="!file" :complete="activeStep > 3" :value="3">
                    <template v-slot:title>Шаблон</template>
                </v-stepper-item>
                <v-divider opacity="1" :class="getDividerClass(3)" />
                <v-stepper-item color="teal-darken-2" :disabled="!file || !selectedTemplate" :complete="activeStep > 4" :value="4">
                    <template v-slot:title>Результат</template>
                </v-stepper-item>
            </v-stepper-header>

            <v-stepper-window>
                <v-stepper-window-item :value="1">
                    <InputFile
                        :fileTypes="fileTypes"
                        @update:modelValue="onFileChange"
                        v-model="file"
                    />
                </v-stepper-window-item>
                <v-stepper-window-item :value="2">
                    <v-card flat>
                        <PreviewComponent :file="file" />
                    </v-card>
                </v-stepper-window-item>
                <v-stepper-window-item :value="3">
                    <TemplateComponent @template="templateSelection" />
                </v-stepper-window-item>
                <v-stepper-window-item :value="4">
                    <QRCodeRenderer :file="file"/>
                </v-stepper-window-item>
            </v-stepper-window>

            <v-stepper-actions
                :next-text="'Далее'"
                :prev-text="'Назад'"
                @click:next="nextStep"
                @click:prev="prevStep"
            >
                <template #prev="{ props }">
                    <v-btn prepend-icon="mdi-chevron-left-circle" color="orange" @click="props.onClick" :disabled="activeStep === 1">
                        Назад
                    </v-btn>
                </template>
                <template #next="{ props }">
                    <v-btn append-icon="mdi-chevron-right-circle" color="primary" @click="props.onClick" :disabled="isNextDisabled">
                        Далее
                    </v-btn>
                </template>
            </v-stepper-actions>
        </v-stepper>
    </v-container>
</template>

<script setup>
import {computed, ref} from 'vue';
import InputFile from "../components/InputFile.vue";
import PreviewComponent from "../components/PreviewComponent.vue";
import TemplateComponent from "../components/TemplateComponent.vue";
import QRCodeRenderer from "../components/QRCodeRenderer.vue";

const fileTypes = ref(['.txt']);
const activeStep = ref(1);
const file = ref(null);
const selectedTemplate = ref(null);

const nextStep = () => {
    if (activeStep.value < 4) {
        activeStep.value++
    }
};
const prevStep = () => {
    if (activeStep.value > 1) {
        activeStep.value--
    }
};
const isNextDisabled = computed(() => {
    switch (activeStep.value) {
        case 1:
            return !file.value;
        case 2:
            return !file.value;
        case 3:
            return !(file.value && selectedTemplate.value);
        case 4:
            return true;
        default:
            return false;
    }
});
function templateSelection(template) {
    selectedTemplate.value = template;
}
function onFileChange(newFile) {
    file.value = newFile;
    if (file.value) activeStep.value = 2;
}
const getDividerClass = (step) => {
    return {
        'border-[1.5px] transition-all duration-300 ease-in-out': true,
        'border-teal-600': step < activeStep.value,
        'border-gray-300': step >= activeStep.value,
    };
};
</script>

<style scoped>
</style>
