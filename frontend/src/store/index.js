import {createStore} from 'vuex'
import createPersistedState from 'vuex-persistedstate'

import auth from './modules/auth'

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
        auth
    }
})