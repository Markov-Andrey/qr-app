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
          proxy: { '/api': 'http://127.0.0.1:8000' },
      },
      ssr: { noExternal: ['vuetify'] },
  },

  css: [
      '/assets/css/tailwind.css',
      'vuetify/styles',
  ],

  build: {
      transpile: ['vuetify'],
  },

  compatibilityDate: '2024-11-21',
});
