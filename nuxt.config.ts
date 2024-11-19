export default defineNuxtConfig({
    devtools: { enabled: true },
    compatibilityDate: "2024-11-19",
    vite: {
        server: {
            proxy: {
                '/api': 'http://127.0.0.1:8000',
            },
        },
    },
});
