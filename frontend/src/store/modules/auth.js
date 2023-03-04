import axios from 'axios'
import { UNPROCESSABLE_ENTITY } from '@/util'

const auth = {
    namespaced: true,

    state() {
        return {
            user: null, // ログイン済みユーザーを保持する
            apiStatus: null,
        }
    },

    getters: {
        check(state) {
            return !! state.user
        },
        username(state) {
            return state.user ? state.user.name : ''
        },
        user(state) {
            return state.user
        }
    },

    mutations: {
        setUser(state, user) { // userステートの値を更新する
            state.user = user
        },
        setApiStatus(state, status) {
            state.apiStatus = status
        },
    },

    actions: {
        register(context, data) {
            return new Promise((resolve) => {
                axios.post('/api/register', data)
                    .then((response) => {
                        context.commit('setUser', response.data)
                        resolve(true)
                    })
            })
        },
        // アクション → コミットでミューテーション呼び出し → ステート更新

        login(context, data) {
            return new Promise((resolve) => {
                axios.get('/sanctum/csrf-cookie')
                    .then(() => {
                        axios.post('/api/login', data)
                            .then((response) => {
                                context.commit('setUser', response.data)
                                context.commit('setApiStatus', true)
                                resolve(true)
                            }).catch((error) => {
                            // eslint-disable-next-line no-empty
                                if (error.data === UNPROCESSABLE_ENTITY) {
                                }
                                context.commit('setApiStatus', false)
                                context.commit('error/setCodes', error.response.status, { root: true })
                            // あるストアモジュールから別のモジュールのミューテーションをcommitする場合、
                            // 第三引数に{ root:true }を追加する
                        })
                    })
            })
        },

        logout(context) {
            return new Promise((resolve) => {
                axios.post('/api/logout')
                    .then(() => {
                        context.commit('setUser', null)
                        resolve(true)
                    })
            })
        }
    }
}

export default auth

/*
Vuexは、Vueのために開発された状態管理ライブラリ
コンポーネントを跨いで参照したいデータを入れて置く場所
→ データを入れて置く場所を「ストア」という

Vuexのメリットは、親コンポーネントと子コンポーネントの間でデータのやり取りをショートカットできる
→ Vueコンポーネントの性質上、直接渡すことはできない

ストアの中に「ステート」「アクション」の構成要素が入っているのは、
APIとの通信やデータの管理をストアに集中させることで、どのコンポーネントからでもデータを更新・参照できるようになっている


・ステート
データの入れ物そのもの。
ログイン中のユーザーデータなど

・ゲッター
ステートの内容から算出される値。
データ変数や算出プロパティの関係と同様
→ ユーザーがログイン中であるかどうか

・ミューテーション
ステートを更新するためのメソッド。
コンポーネントはステートを直接変更することができないため、ミューテーションを介してステートを更新
ミューテーションは同期処理

・アクション
ミューテーションと同様にステートを更新するメソッド。
違いは非同期処理
アクションはAPIとの通信などの非同期処理を行った後にミューテーションを呼び出してステートを更新する

auth.jsは、ストアオブジェクトとしてエクスポートする
 */