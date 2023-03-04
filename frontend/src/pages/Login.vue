<template>
  <div class="container--small">
    <ul class="tab">
      <li
          class="tab__item"
          :class="{'tab__item--active': tab === 1 }"
          @click="tab = 1"
      >Login</li>
      <li
          class="tab__item"
          :class="{'tab__item--active': tab === 2 }"
          @click="tab = 2"
      >Register</li>
    </ul>

    <div class="panel" v-show="tab === 1">
      <form class="form" @submit.prevent="login">
      <!--
      formタグ宣言時に設定する
      @submitに続く.preventはイベント修飾子と呼ばれる
      .preventを記述することは、イベントハンドラでevent.preventDefault()を呼び出すのと同じ効果がある
      これにより、デフォルトのフォーム送信のょどうをキャンセルし、ページをリロードする
      -->
        <label for="login-email">Email</label>
        <input type="text" class="form__item" id="login-email" v-model="loginForm.email">
        <!--
        v-modelは、入力値をデータと同期する
        -->
        <div v-if="loginErrors">
          <ul v-if="loginErrors.email" class="errors">
            <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <label for="login-password">Password</label>
        <input type="password" class="form__item" id="login-password" v-model="loginForm.password">

        <div v-if="loginErrors">
          <ul v-if="loginErrors.password" class="errors">
            <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <div class="form__button">
          <button type="submit" class="button button--inverse">login</button>
        </div>
      </form>
    </div>

    <div class="panel" v-show="tab === 2">
      <form class="form" @submit.prevent="register">
        <label for="username">Name</label>
        <input type="text" class="form__item" id="username" v-model="registerForm.name">
        <div v-if="registerErrors">
          <ul v-if="registerErrors.name" class="errors">
            <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
          </ul>
        </div>

        <label for="email">Email</label>
        <input type="text" class="form__item" id="email" v-model="registerForm.email">
        <div v-if="registerErrors">
          <ul v-if="registerErrors.email" class="errors">
            <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
          </ul>
        </div>

        <label for="password">Password</label>
        <input type="password" class="form__item" id="password" v-model="registerForm.password">
        <div v-if="registerErrors">
          <ul v-if="registerErrors.password" class="errors">
            <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
          </ul>
        </div>

        <label for="password-confirmation">Password (confirm)</label>
        <input type="password" class="form__item" id="password-confirmation" v-model="registerForm.password_confirmation">
        <div v-if="registerErrors">
          <ul v-if="registerErrors.password_confirmation" class="errors">
            <li v-for="msg in registerErrors.password_confirmation" :key="msg">{{ msg }}</li>
          </ul>
        </div>

        <div class="form__button">
          <button type="submit" class="button button--inverse">register</button>
        </div>
      </form>
    </div>
    <!--
    v-showディレクティブを使えば、tabが特定の値の時のみ表示される
    -->
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  data () {
    return {
      tab: 1,
      loginForm: {
        email: '',
        password: ''
      },
      registerForm: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },

  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus,
      loginErrors: state => state.auth.loginErrorMessages,
      registerErrors: state => state.auth.registerErrorMessages
    }),
  },

  methods: {
    login () {
      this.$store.dispatch('auth/login', this.loginForm)
      if (this.apiStatus) {
        // apiStatusが成功したとき、トップページに遷移
        this.$router.push('/')
      }
    },
    register () {
      // authストアのregisterアクションを呼び出す
      this.$store.dispatch('auth/register', this.registerForm)
      // アクションを呼び出すにはdispatchメソッド
      // dispatchメソッドの第一引数はアクションの名前
      // authストアを作成した時にnamespacedをtrueとして名前空間を有効化させたので、
      // モジュール名を頭につけたauth/registerをいう名前でアクションを指定

      if (this.apiStatus) {
        this.$router.push('/')
      }
    },
    clearError () {
      this.$store.commit('auth/setLoginErrorMessages', null)
      this.$store.commit('auth/setRegisterErrorMessages', null)
    }
  },

  mounted () {
    this.clearError()
  }
}
</script>