const snackbar = {
    namespaced: true,
    state: () => ({
        isVisible: false,
        message: '',
        color: '',
        timerId: null,
    }),
    mutations: {
        showSnackbar(state, { message, type = 'info' }) {
            const colors = {
                info: 'blue lighten-1',
                warning: 'orange darken-2',
                error: 'red lighten-1',
                success: 'green lighten-1',
            };
            state.isVisible = true;
            state.message = message;
            state.color = colors[type] || 'blue lighten-1';

            if (state.timerId) clearTimeout(state.timerId);

            state.timerId = setTimeout(() => {
                state.isVisible = false;
                state.message = '';
            }, 3000);
        },
    },
    actions: {
        triggerSnackbar({ commit }, payload) {
            commit('showSnackbar', payload);
        },
    },
};

export default snackbar;
