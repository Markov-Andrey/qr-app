<template>
    <v-snackbar
        v-model="isVisible"
        :timeout="3000"
        :color="color"
        outlined
        class="text-white mb-12"
    >
        {{ message }}
    </v-snackbar>
</template>

<script>
import { mapState } from 'vuex';

export default {
    computed: {
        ...mapState('snackbar', ['isVisible', 'message', 'color']),
    },
};
</script>
