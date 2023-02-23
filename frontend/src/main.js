import { createApp } from 'vue'
// ルーティングの定義をインポートする
import router from './router'
// ルートコンポーネントをインポートする
import App from './App.vue'

createApp(App)
    .use(router)
    .mount('#app')
