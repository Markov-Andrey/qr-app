<template>
    <div ref="printContent" class="flex flex-wrap gap-4">
        <div class="flex" v-for="(qr, index) in qrCodes" :key="index">
            <div v-html="qr"></div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    qrCodes: {
        type: Array,
        required: true,
    },
});
</script>

<style scoped>
</style>
