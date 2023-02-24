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

        <label for="login-password">Password</label>
        <input type="password" class="form__item" id="login-password" v-model="loginForm.password">

        <div class="form__button">
          <button type="submit" class="button button--inverse">login</button>
        </div>
      </form>
    </div>
    <div class="panel" v-show="tab === 2">Register Form</div>
    <!--
    v-showディレクティブを使えば、tabが特定の値の時のみ表示される
    -->
  </div>
</template>

<script>
export default {
  data () {
    return {
      tab: 1,
      loginForm: {
        email: '',
        password: ''
      },
    }
  },
  methods: {
    login () {
      console.log(this.loginForm)
    }
  }
}
</script>