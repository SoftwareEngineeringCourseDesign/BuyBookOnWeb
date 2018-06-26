<template>
  <div class="book-detail">
    <i-row>
      <i-col span="8">
        <img v-if="book.cover" :src="book.cover" width="100%">
        <div v-else style="height: 500px;">该书暂无封面</div>
      </i-col>
      <i-col span="16">
        <p style="font-size: 18px; margin-top: 10px;">作者： {{ book.author }}</p>
        <p style="font-size: 12px; margin-top: 10px;">出版社： {{ book.publisher }}</p>
        <p style="width: 60%; font-size: 14px; word-break: break-all; word-wrap: break-word; margin-top: 10px;">简介：{{ book.introduction }}</p>
        <p style="margin-top: 10px;">评分： <i-star :score="book.score"></i-star> <span>(共 {{ book.peopleNumber }} 人评分) </span></p>
        <p style="margin-top: 10px;">销量: {{ book.sellNumber }} 本</p>
        <p style="margin-top: 20px;">价格： <span style="font-size: 24px; color: red">{{ book.price }}</span></p>
      </i-col>
    </i-row>
  </div>
</template>

<script>
import iStar from './Star.vue'
export default {
  props: ['book'],
  components: {
    iStar
  },
  name: 'iListBook',
  data () {
    return {
    }
  },
  computed: {
  },
  methods: {
  }
}
</script>

<style scoped>
</style>
