<template>
    <div ref="printContent">
        <div v-for="(qr, index) in qrCodes" :key="index">
            <div class="flex gap-2" v-html="qr"></div>
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
.qr-item {
    margin-bottom: 20px;
}
</style>
