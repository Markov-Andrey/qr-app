<template>
    <div class="bg-gray-100 p-4 rounded-md max-h-96 overflow-y-auto">
        <pre>{{ content || 'Нет данных для отображения' }}</pre>
    </div>
    <div class="m-4 flex gap-2">
        <v-btn prepend-icon="mdi-chevron-left-circle" color="primary">Назад</v-btn>
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
