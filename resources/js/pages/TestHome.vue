<template>
    <v-container>
        <v-stepper v-model="activeStep" alt-labels>
            <v-stepper-header>
                <v-stepper-item :value="1">
                    <template v-slot:title>Загрузить файл</template>
                </v-stepper-item>
                <v-divider />
                <v-stepper-item :value="2">
                    <template v-slot:title>Предпросмотр</template>
                </v-stepper-item>
                <v-divider />
                <v-stepper-item :value="3">
                    <template v-slot:title>Шаблон</template>
                </v-stepper-item>
                <v-divider />
                <v-stepper-item :value="4">
                    <template v-slot:title>На экран</template>
                </v-stepper-item>
                <v-divider />
                <v-stepper-item :value="5">
                    <template v-slot:title>Скачать</template>
                </v-stepper-item>
            </v-stepper-header>

            <v-stepper-window>
                <v-stepper-window-item :value="1">
                    <v-card flat>
                        <v-card-title>Загрузить файл</v-card-title>
                        <v-card-text>Контент для загрузки файла.</v-card-text>
                    </v-card>
                </v-stepper-window-item>
                <v-stepper-window-item :value="2">
                    <v-card flat>
                        <v-card-title>Предпросмотр</v-card-title>
                        <v-card-text>Контент для предпросмотра.</v-card-text>
                    </v-card>
                </v-stepper-window-item>
                <v-stepper-window-item :value="3">
                    <v-card flat>
                        <v-card-title>Шаблон</v-card-title>
                        <v-card-text>Контент для выбора шаблона.</v-card-text>
                    </v-card>
                </v-stepper-window-item>
                <v-stepper-window-item :value="4">
                    <v-card flat>
                        <v-card-title>На экран</v-card-title>
                        <v-card-text>Контент для вывода на экран.</v-card-text>
                    </v-card>
                </v-stepper-window-item>
                <v-stepper-window-item :value="5">
                    <v-card flat>
                        <v-card-title>Скачать</v-card-title>
                        <v-card-text>Контент для скачивания файла.</v-card-text>
                    </v-card>
                </v-stepper-window-item>
            </v-stepper-window>

            <v-stepper-actions
                :next-text="'Далее'"
                :prev-text="'Назад'"
                @click:next="nextStep"
                @click:prev="prevStep"
            />
        </v-stepper>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';

const activeStep = ref(1);

const nextStep = () => {
    if (activeStep.value < 5) activeStep.value++;
};

const prevStep = () => {
    if (activeStep.value > 1) activeStep.value--;
};
</script>

<style scoped>
.slider-custom ::v-deep(.v-tab__slider) {
    right: 0;
    height: 100%;
    left: auto;
    width: 6px;
}
</style>
