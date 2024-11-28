<template>
    <div class="bg-gray-100 p-4 rounded-md max-h-96 overflow-y-auto">
        <pre>{{ content || 'Нет данных для отображения' }}</pre>
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
