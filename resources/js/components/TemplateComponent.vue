<template>
    <v-card flat>
        <v-card-title>Шаблон</v-card-title>
        <v-card-text class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <v-img
                v-for="(template, index) in templates"
                :key="index"
                :src="template.src"
                class="m-2 cursor-pointer transition-all duration-300 ease-in-out rounded-lg relative"
                @click="selectTemplate(template)"
                :class="{
                    'shadow-lg ring-2 ring-green-600': selectedTemplate === template,
                    'scale-105': selectedTemplate === template,
                    'hover:ring-2 hover:ring-orange-600': selectedTemplate !== template
                }"
                aspect-ratio="1.5"
            >
                <v-icon
                    v-show="selectedTemplate === template"
                    class="absolute top-1 right-1"
                    color="teal-darken-1"
                    icon="mdi-check-circle"
                    size="x-large"
                />

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
    props: {
        modelValue: {
            type: [Object, null],
            default: null
        }
    },
    data() {
        return {
            templates: [
                { src: '/template-example/example1.jpg', id: 1 },
                { src: '/template-example/example2.jpg', id: 2 },
                { src: '/template-example/example3.jpg', id: 3 },
            ]
        };
    },
    computed: {
        selectedTemplate: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            }
        }
    },
    methods: {
        selectTemplate(template) {
            this.selectedTemplate = this.selectedTemplate === template ? null : template;
        }
    }
};
</script>

<style scoped>
</style>
