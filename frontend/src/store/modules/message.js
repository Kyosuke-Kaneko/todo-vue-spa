const message = {
    namespaced: true,

    state() {
        return {
            content: '',
        }
    },

    mutations: {
        setContent (state, {content, timeout}) {
            state.content = content

            if (typeof timeout === 'undefined') {
                timeout = 3000
            }

            setTimeout(() => (state.content = ''), timeout)
            // メッセージが一定時間経過後に自動的にクリアされる
        }
    }
}

export default message