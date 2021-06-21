export default {
    namespaced: true,

    state: {
        showNotification: false,
        showMessage: false,
        credentialsModal: true,
    },
    init() {
    },
    getters: {},
    mutations: {
        toggleNotification(state) {
            const nextState = !state.showNotification;
            localStorage.showNotification = nextState;
            state.showNotification = nextState;
        },
        toggleMessage(state) {
            const nextState = !state.showMessage;
            localStorage.showMessage = nextState;
            state.showMessage = nextState;
        },
        closeNotification(state){
            state.showNotification = false;
        },
        closeMessage(state){
            state.showMessage = false;
        }
    },
    actions: {
        toggleNotification({commit}) {
            commit('toggleNotification');
        },
        closeNotification({commit}){
            commit('closeNotification');
        },
        toggleMessage({commit}) {
            commit('toggleMessage');
        },
        closeMessage({commit}){
            commit('closeMessage');
        },
    }
}

