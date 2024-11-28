<template>
    <div ref="printContent" class="flex flex-wrap gap-4">
        <div class="flex" v-for="(qr, index) in qrCodes" :key="index">
            <div
                v-if="qr"
                :style="{
                    width: sizeQr.value[0] * 37.795 + 'px',
                    height: sizeQr.value[1] * 37.795 + 'px'
                }"
                v-html="qr"
            ></div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    qrCodes: {
        type: Array,
        required: true,
    },
    sizeQr: {
        type: Array,
        required: true,
    },
});
</script>

<style scoped>
svg {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
}
</style>
