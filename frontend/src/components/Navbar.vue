<template>
  <nav className="navbar">
    <RouterLink class="navbar__brand" to="/">
      Vuesplash
    </RouterLink>
    <div className="navbar__menu">
      <div v-if="isLogin" className="navbar__item">
        <button class="button" @click="showForm = !showForm">
          <i class="icon ion-md-add"></i>
          Submit a photo
        </button>
      </div>
      <span v-if="isLogin" className="navbar__item">
        {{ username }}
      </span>
      <div v-else className="navbar__item">
        <RouterLink class="button button--link" to="/login">
          Login / Register
        </RouterLink>
      </div>
    </div>
    <PhotoForm v-model:value="showForm" value />
<!--    子コンポーネントで「value」と定義されているので、valueを：の後に指定する-->
  </nav>
</template>

<!--
RouterLinkはRouterViewと同様、VueRouterから提供されているコンポーネント
役割はアンカーリンクとほぼ同じで、HTML的にも<a>要素が描画される
だが、普通のアンカーリンクと違うのは通常の画面遷移（サーバーサイドへのGETリクエスト）が発生しないこと

RouterLinkで描画したリンクをクリックすると、VueRouterによるコンポーネントの切り替わりが発生
-->

<script>
import PhotoForm from './PhotoForm.vue'

export default {
  components: {
    PhotoForm,
  },

  data () {
    return {
      showForm: false,
    }
  },

  computed: {
    isLogin() {
      return this.$store.getters['auth/check']
    },
    username() {
      return this.$store.getters['auth/username']
    }
  }
}
</script>