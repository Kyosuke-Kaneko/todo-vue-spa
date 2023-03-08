<template>
  <div class="photo-list">
    <div class="grid">
      <Photo
          class="grid__item"
          v-for="photo in photos"
          :key="photo.id"
          :item="photo"
      />
    </div>
  </div>
</template>

<script>
import axios from 'axios'

import Photo from '../components/Photo.vue'

export default {
  components: {
    Photo,
  },

  data () {
    return {
      photos: [],
    }
  },

  methods: {
    async fetchPhotos () {
      await axios.get('/api/photo').then((response) => {
        this.photos = response.data.data
      })
    }
  },

  watch: {
    $route: {
      async handler() {
        await this.fetchPhotos()
      },
      immediate: true
    }
    // $routeを監視して、ページが切り替わった時にfetchPhotosが実行されるようにする
    // immediateオプションがtrueだと、コンポーネントが生成されたタイミングでも実行される
    // → コンポーネントは同じだがページが異なる場合を考慮
  }
}

</script>