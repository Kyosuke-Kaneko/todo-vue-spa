import {createStore} from 'vuex'
import createPersistedState from 'vuex-persistedstate'

import auth from './modules/auth'
import error from './modules/error'
import message from './modules/message'

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
        message,
    }
})