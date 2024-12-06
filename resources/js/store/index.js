import { createStore } from 'vuex';
import snackbar from './modules/snackbar';

export default createStore({
    modules: {
        snackbar,
    },
});
