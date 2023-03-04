import {createStore} from 'vuex'
import createPersistedState from 'vuex-persistedstate'

import auth from './modules/auth'
import error from './modules/error'

export default createStore({
    plugins: [
        createPersistedState({
            key: 'Vuesplash',
            paths: [
                'auth',
            ],
        })
    ],

    modules: {
        auth,
        error,
    }
})