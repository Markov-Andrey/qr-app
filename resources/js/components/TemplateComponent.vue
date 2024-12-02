<template>
    <v-card flat>
        <v-card-title>Шаблон</v-card-title>
        <v-card-text class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <v-img
                v-for="(template, index) in templates"
                :key="index"
                :src="template.src"
                class="m-2 cursor-pointer transition-all duration-300 ease-in-out rounded-lg"
                @click="selectTemplate(template)"
                :class="{
            'shadow-lg ring-2 ring-green-600': selectedTemplate === template,
            'scale-105': selectedTemplate === template,
            'hover:ring-2 hover:ring-orange-600': selectedTemplate !== template
        }"
                aspect-ratio="1.5"
            >
                <template v-slot:placeholder>
                    <v-row align="center" justify="center">
                        <v-icon>mdi-image</v-icon>
                    </v-row>
                </template>
            </v-img>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: "TemplateComponent",
    data() {
        return {
            templates: [
                { src: 'https://via.placeholder.com/200x150?text=Template+1', id: 1 },
                { src: 'https://via.placeholder.com/200x150?text=Template+2', id: 2 },
                { src: 'https://via.placeholder.com/200x150?text=Template+3', id: 3 },
            ],
            selectedTemplate: null
        };
    },
    methods: {
        selectTemplate(template) {
            if (this.selectedTemplate === template) {
                this.selectedTemplate = null;
                this.$emit('template', null);
            } else {
                this.selectedTemplate = template;
                this.$emit('template', template.id);
            }
        }
    }
}
</script>

<style scoped>
</style>
