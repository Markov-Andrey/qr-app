function defineNuxtConfig(param: {compatibilityDate: string; vite: {server: {proxy: {"/api": string}}}; buildDir: string; devtools: {enabled: boolean}}) {

}

export default defineNuxtConfig({
    buildDir: '.output',
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
