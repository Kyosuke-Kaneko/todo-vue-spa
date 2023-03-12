<template>
  <div v-if="photo" class="photo-detail" :class="{ 'photo-detail--column': fullWidth }">
    <figure class="photo-detail__pane photo-detail__image" @click="fullWidth = ! fullWidth">
      <img :src="photo.url" alt="">
      <figcaption>Posted by {{ photo.owner.name }}</figcaption>
    </figure>
    <div class="photo-detail__pane">
      <button class="button button--like" title="Like photo">
        <i class="icon ion-md-heart"></i>12
      </button>
      <a
          :href="`/photos/${photo.id}/download`"
          class="button"
          title="Download photo"
      >
        <i class="icon ion-md-arrow-round-down"></i>Download
      </a>
      <h2 class="photo-detail__title">
        <i class="icon ion-md-chatboxes"></i>Comments
      </h2>
      <form @submit.prevent="addComment" class="form">
        <div v-if="commentErrors" class="errors">
          <ul v-if="commentErrors.content">
            <li v-for="msg in commentErrors.content" :key="msg">{{ msg }}</li>
          </ul>
        </div>

        <textarea class="form__item" v-model="commentContent"></textarea>
        <div class="form__button">
          <button type="submit" class="button button--inverse">submit comment</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import {UNPROCESSABLE_ENTITY} from "@/util"

export default {
  props: {
    id: {
      type: String,
      required: true,
    }
  },
  // propsをtrueに設定しているので、router.jsの:idの値が<PhotoDetail>コンポーネントにpropsとして渡される

  data () {
    return {
      photo: null,
      fullWidth: false,
      commentContent: '',
      commentErrors: null,
    }
  },

  methods: {
    async fetchPhoto () {
      await axios.get(`api/photo/${this.id}`).then((response) => {
        this.photo = response.data
      })
    },
    async addComment () {
      await axios.post(`/api/photo/${this.id}/comments`, {
        content: this.commentContent,
      }).then(() => {
        this.commentContent = ''
        this.commentErrors = null
      }).catch((error) => {
        if (error.response.status === UNPROCESSABLE_ENTITY) {
          this.commentErrors = error.response.data.errors
        } else {
          this.$store.commit('error/setCode', error.response.status)
          return false
        }
      })

      this.commentContent = ''
    }
  },

  watch: {
    $route: {
      async handler () {
        await this.fetchPhoto()
      },
      immediate: true
    }
  }
}

</script>