const error = {
    namespaced: true,

    state() {
        return {
            code: null
        }
    },

    mutations: {
        setCodes(state, code) {
            state.code = code
        }
    }
}

export default error