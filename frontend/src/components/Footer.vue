<template>
  <footer class="footer">
    <button class="button button--link" @click="logout">Logout</button>
    <RouterLink class="button button--link" to="/login">
      Login / Register
    </RouterLink>
  </footer>
</template>

<script>
export default {
  methods: {
    logout () {
      this.$store.dispatch('auth/logout')
      this.$router.push('/login')
    },
  }
}
</script>