export default defineNuxtConfig({
    buildDir: 'dist',

    devtools: { enabled: true },
    postcss: {
        plugins: {
            tailwindcss: {},
            autoprefixer: {},
        },
    },
    vite: {
        server: {
            proxy: {
                '/api': 'http://127.0.0.1:8000',
            },
        },
        ssr: {
            noExternal: ['vuetify'], // Добавьте для работы SSR
        },
    },
    css: [
        '/assets/css/tailwind.css',
        'vuetify/styles',
    ],

    build: {
        transpile: ['vuetify'], // Добавьте для обработки Vuetify на этапе сборки
    },
});
