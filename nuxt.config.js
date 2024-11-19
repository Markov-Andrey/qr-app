export default {
    buildDir: 'dist',

    devtools: { enabled: true },

    plugins: [
        '~/plugins/buefy.js'
    ],


    vite: {
        server: {
            proxy: {
                '/api': 'http://127.0.0.1:8000',
            },
        },
    },
};
