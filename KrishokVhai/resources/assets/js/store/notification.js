export default {
    namespaced: true,
    state: {
        newMessage: null,
    },
    getters: {
        getNewMessage(state) {
            return state.newMessage
        },
    },
    mutations: {
        setNewMessage(state, newMessage) {
            state.todos = newMessage;
        },
    },
    actions: {
        newMessage(context, data) {
            context.commit('setNewMessage', data)
        }
    }
}


