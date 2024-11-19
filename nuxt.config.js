export default {
  buildDir: 'dist',
  devtools: { enabled: true },

  vite: {
      server: {
          proxy: {
              '/api': 'http://127.0.0.1:8000'
          }
      }

  },
};
