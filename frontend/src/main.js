import { createApp } from 'vue'
// ルーティングの定義をインポートする
import router from './router'
// ルートコンポーネントをインポートする
import App from './App.vue'

import store from './store'

createApp(App)
    .use(router)
    .use(store)
    .mount('#app')
