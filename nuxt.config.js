export default defineNuxtConfig({
    buildDir: 'dist',

    devtools: { enabled: true },
    postcss: {
        plugins: {
            tailwindcss: {},
            autoprefixer: {},
        },
    },
    app: {
        head: {
            link: [
                {
                    rel: 'stylesheet',
                    href: 'https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap'
                }
            ]
        }
    },
    vite: {
        server: {
            proxy: {
                '/api': 'http://127.0.0.1:8000',
            },
        },
        ssr: {
            noExternal: ['vuetify'],
        },
    },
    css: [
        '/assets/css/tailwind.css',
        'vuetify/styles',
    ],

    build: {
        transpile: ['vuetify'],
    },
});
