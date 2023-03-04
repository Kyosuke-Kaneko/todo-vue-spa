<template>
  <div>
    <header>
      <Navbar />

      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather|Roboto:400">
      <link rel="stylesheet" href="https://unpkg.com/ionicons@4.2.2/dist/css/ionicons.min.css">
      <link rel="stylesheet" href="https://hypertext-candy.s3-ap-northeast-1.amazonaws.com/posts/vue-laravel-tutorial/app.css">
    </header>
    <main>
      <div class="container">
        <RouterView />
        <!--
        ルートとマッチしたコンポーネントがここで描画される
        -->
      </div>
    </main>
    <Footer />
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from './util'

import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'

export default {
  components: {
    Navbar,
    Footer
  },

  computed: {
    errorCode () {
      return this.$store.state.error.code
    },
  },

  watch: {
    errorCode: {
      handler (val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        }
      },

      immediate: true
    },

    $route () {
      this.$store.commit('error/setCodes', null)
    }
  },
  // watchオプションは、Vueコンポーネント内のデータの変更を監視し、その変更に応じて実行する関数を定義
  // 特定のデータプロパティの値が変更されたときに、自動的に処理を実行できる

}
</script>