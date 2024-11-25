export default defineNuxtConfig({
    devtools: { enabled: true },

    postcss: {
        plugins: {
            tailwindcss: {},
            autoprefixer: {},
        },
    },
    vite: {
        server: {
            proxy: { '/api': 'http://127.0.0.1:9000' },
        },
        ssr: { noExternal: ['vuetify'] },
    },

    css: [
        'vuetify/styles',
        '/assets/css/tailwind.css',
    ],

    build: {
        transpile: ['vuetify'],
    },

    plugins: [
        '~/plugins/vuetify.js',
    ],
    app: {
        head: {
            link: [
                { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
            ],
        },
    },
    compatibilityDate: '2024-11-21',
});
