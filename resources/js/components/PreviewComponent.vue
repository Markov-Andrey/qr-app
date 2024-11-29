<template>
    <div class="bg-gray-100 p-4 rounded-md max-h-96 overflow-y-auto">
        <pre>{{ content || 'Нет данных для отображения' }}</pre>
    </div>
    <div class="my-4 flex justify-between gap-2">
        <v-btn prepend-icon="mdi-chevron-left-circle" color="orange">Назад</v-btn>
        <v-btn append-icon="mdi-chevron-right-circle" color="primary">Далее</v-btn>
    </div>
</template>

<script>
export default {
    name: "PreviewComponent",
    props: {
        content: {
            type: String,
            default: null,
        },
    },
};
</script>

<style scoped>
</style>
