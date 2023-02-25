import { createApp } from 'vue'
// ルーティングの定義をインポートする
import router from './router'
// ルートコンポーネントをインポートする
import App from './App.vue'

import store from './store'
import axios from "axios";

axios.defaults.baseURL = 'http://localhost:80/'
axios.defaults.withCredentials = true;

createApp(App)
    .use(router)
    .use(store)
    .mount('#app')
