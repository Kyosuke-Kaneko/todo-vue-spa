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
    <Pagination :current-page="currentPage" :last-page="lastPage" />
  </div>
</template>

<script>
import axios from 'axios'

import Photo from '../components/Photo.vue'
import Pagination from '../components/Pagination.vue'

export default {
  props: {
    page: {
      type: Number,
      required: false,
      default: 1,
    }
  },
  // ルーターから渡されるpageプロパティを受け取るため、propsを追加

  components: {
    Photo,
    Pagination,
  },

  data () {
    return {
      photos: [],
      currentPage: 0,
      lastPage: 0,
    }
  },

  methods: {
    async fetchPhotos () {
      await axios.get('/api/photo').then((response) => {
        this.photos = response.data.data
        this.currentPage = response.data.current_page
        this.lastPage = response.data.last_page
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