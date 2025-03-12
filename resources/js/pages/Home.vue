<template>
    <div class="bg-gray-50 min-h-screen flex flex-col justify-center items-center py-10 px-6">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Генератор GS1 DataMatrix</h1>
            <p class="text-lg text-gray-600 leading-relaxed mb-4">
                Наш сервис позволяет быстро и удобно генерировать GS1 DataMatrix коды на основе шаблонов. Он предназначен для
                профессионалов, которым нужно быстро обработать данные и подготовить их к печати или скачиванию.
            </p>
            <router-link
                to="/form"
                class="mt-8 inline-block bg-teal-600 text-white text-lg font-semibold py-3 px-6 rounded-lg transition hover:bg-teal-700"
            >
                Приступить
            </router-link>
        </div>

        <div class="w-full max-w-3xl bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Пошаговая инструкция</h2>

            <div class="relative space-y-8">
                <div
                    v-for="(step, index) in steps"
                    :key="index"
                    class="relative bg-gray-100 rounded-lg p-6 shadow-md transition-all hover:bg-teal-500 group"
                >
                    <!-- Линия соединения между шагами -->
                    <div v-if="index !== steps.length - 1" class="absolute left-1/2 top-full w-1 h-10 bg-gray-300"></div>

                    <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-white mb-2">
                        {{ step.title }}
                    </h3>
                    <p class="text-gray-600 group-hover:text-white">
                        {{ step.description }}
                    </p>
                </div>

                <router-link
                    to="/form"
                    class="mt-8 inline-block bg-teal-600 text-white text-lg font-semibold py-3 px-6 rounded-lg transition hover:bg-teal-700"
                >
                    Приступить
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
const steps = [
    {
        title: "Шаг I: Загрузка файла",
        description: "Перетащите файл в область или нажмите, чтобы выбрать файл для загрузки.",
    },
    {
        title: "Шаг II: Предпросмотр",
        description: "Посмотрите на загруженные данные и убедитесь, что файл выбран правильно.",
    },
    {
        title: "Шаг III: Выбор шаблона",
        description: "Выберите шаблон, который будет использован для генерации DataMatrix кода.",
    },
    {
        title: "Шаг IV: Результат",
        description: "Подождите, пока файл обработается. Когда результат будет готов, вы сможете скачать или распечатать его.",
    },
];
</script>
