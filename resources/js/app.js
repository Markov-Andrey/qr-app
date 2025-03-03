import { createApp } from 'vue';
import vuetify from './vuetify';
import router from './router';
import App from './app.vue';
import '../css/app.css';
import store from './store';

const app = createApp(App);

app.use(router);
app.use(vuetify);
app.use(store);

app.mount('#app');
