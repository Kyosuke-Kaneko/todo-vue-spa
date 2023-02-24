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
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'

export default {
  components: {
    Navbar,
    Footer
  }
}
</script>