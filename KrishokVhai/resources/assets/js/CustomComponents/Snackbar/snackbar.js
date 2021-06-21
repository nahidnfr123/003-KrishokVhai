// Works using vuex ...

export default {
    namespaced: true,
    state: {
        snacks: [],
    },
    getters: {
        snack(state) {
            return state.snacks
        }
    },
    mutations: {
        SET_SNACK(state, snack) {
            state.snacks.push({
                ...snack,
                id: (Math.random().toString(36) + Date.now().toString(36)).substr(2),
            })
        },
        REMOVE_SNACK(state, snackToRemove) {
            state.snacks = state.snacks.filter(snack => {
                return snack.id != snackToRemove.id
            })
        }
    },
    actions: {
        addSnack({commit}, snack) {
            commit('SET_SNACK', snack)
        },
        removeSnack({commit}, snack) {
            commit('REMOVE_SNACK', snack)
        }
    }
}
