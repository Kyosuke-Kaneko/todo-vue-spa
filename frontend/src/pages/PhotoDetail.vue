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

      <ul v-if="photo.comments.length > 0" class="photo-detail__comments">
        <li
          v-for="comment in photo.comments"
          :key="comment.content"
          class="photo-detail__commentItem"
        >
          <p class="photo-detail__commentBody">
            {{ comment.content }}
          </p>

          <p class="photo-detail__commentInfo">
            {{ comment.author.name }}
          </p>
        </li>
      </ul>
      <p v-else>No comments yet.</p>

      <form v-if="isLogin" @submit.prevent="addComment" class="form">
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
      photo: null, // Object
      fullWidth: false,
      commentContent: '',
      commentErrors: null,
    }
  },

  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
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
      }).then((response) => {
        this.commentContent = ''
        this.commentErrors = null

        this.photo.comments = [
          ...response.data
        ]
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