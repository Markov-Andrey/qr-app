import { createApp } from 'vue';
import vuetify from './vuetify.js';
import router from './router/index.js';
import App from './app.vue';
import '../css/app.css';
import store from './store/index.js';

const app = createApp(App);

app.use(router);
app.use(vuetify);
app.use(store);

app.mount('#app');
