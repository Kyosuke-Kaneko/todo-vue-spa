import { createRouter, createWebHistory } from 'vue-router'

import store from './store'

// ページコンポーネントをインポートする
import PhotoList from './pages/PhotoList.vue'
import Login from './pages/Login.vue'

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: PhotoList,
    },
    {
        path: '/login',
        component: Login,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next('/')
            } else {
                next()
            }
        }
        // beforeEnterは、定義されたルートにアクセスされてページコンポーネントが切り替わる直前に呼び出される関数
        // beforeEnterの第一引数のtoはアクセスされようとしているルートオブジェクト、
        // 第二引数fromはアクセス元のルート、
        // 第三引数nextはページの遷移先を決める関数

        // next()を引数なしで呼ぶとそのままページコンポーネントが切り替わる
        // 引数ありでnext()を呼ぶと、切り替わるはずのページコンポーネントは生成されず、引数のページに切り替わり、リダイレクトのようになる
        // TODO beforeEachを使用して実現できるようにする
    }
]

// VueRouterインスタンスを作成する
const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
    scrollBehavior() {
        return {top: 0};
    }
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router