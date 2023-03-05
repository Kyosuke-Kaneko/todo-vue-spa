<template>
  <div v-show="value" class="photo-form">
    <h2 class="title">Submit a photo</h2>
    <form class="form">

      <input class="form__item" type="file" @change="onFileChange">

      <div class="form__button">
        <button type="submit" class="button button--inverse">submit</button>
      </div>
    </form>
  </div>
</template>
<!--
表示・非表示の切り替え
ボタンをクリックすると表示され、もう一度押下すると隠れる

v-modelを用いて実装。
v-modelは基本的には入力要素と一緒に用いられるが、他のカスタムコンポーネントでも使用できる
valueをpropsに取って、inputイベントを$emitするコンポーネントにはv-modelを指定できる

Navbar → (props: value) → PhotoForm
PhotoForm → $emit('input', ...) → Navbar

-->

<script>
export default {
  props: {
    value: {
      type: Boolean,
      required: true,
      default: false,
    }
  },
  // valueを受け取れるようにスクリプトブロックにpropsを追加
  // valueは表示/非表示を審議地で表現するためboolean型と定義する
  // テンプレートの一番外側の要素にv-showの記述を追加する
  // → コンポーネントの表示/非表示を(valueを渡す)親コンポーネント側で制御できるようになる
}
</script>

<style scoped>

</style>