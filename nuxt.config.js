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
    hooks: {
        'build:before': () => {
            if (process.server) {
                const fs = require('fs');
                const path = require('path');
                const outputDir = path.resolve(__dirname, '.output');
                if (fs.existsSync(outputDir)) {
                    fs.rmSync(outputDir, { recursive: true, force: true });
                }
            }
        },
    },
});
