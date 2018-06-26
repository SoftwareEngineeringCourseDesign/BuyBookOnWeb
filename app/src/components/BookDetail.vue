<template>
  <div class="book-detail">
    <i-header></i-header>
    <i-breadcrumb style="margin-top: 20px; margin-bottom: 20px; margin-left: 20px;">
      <i-breadcrumb-item to="/">首页</i-breadcrumb-item>
      <i-breadcrumb-item :to="'/select?query=category,' + book.category.id">{{ book.category.name }}</i-breadcrumb-item>
      <i-breadcrumb-item>{{ book.name }}</i-breadcrumb-item>
    </i-breadcrumb>
    <i-row>
      <i-col span="8">
        <img v-if="book.cover" :src="book.cover" width="100%">
        <div v-else style="height: 500px;">该书暂无封面</div>
      </i-col>
      <i-col span="16">
        <h1 style="font-size: 36px;">{{ book.name }}</h1>
        <p style="font-size: 18px; margin-top: 10px;">作者： {{ book.author }}</p>
        <p style="font-size: 12px; margin-top: 10px;">出版社： {{ book.publisher }}</p>
        <p style="font-size: 12px; margin-top: 10px;">上架时间： {{ book.created_at }}</p>
        <p style="width: 60%; font-size: 14px; word-break: break-all; word-wrap: break-word; margin-top: 10px;">简介：{{ book.introduction }}</p>
        <p style="margin-top: 10px;">评分： <i-star :score="book.score"></i-star> <span>(共 {{ book.peopleNumber }} 人评分) </span></p>
        <p style="margin-top: 10px;">销量: {{ book.sellNumber }} 本</p>
        <p style="margin-top: 20px;">价格： <span style="color: red;">￥</span><span style="font-size: 24px; color: red">{{ book.price }}</span></p>
        <i-button type="error" @click="Buy()" style="margin-top: 10px; margin-bottom: 10px;">立即购买</i-button>
        <i-button @click="$router.back()" style="margin-top: 10px; margin-bottom: 10px;">返回</i-button>
      </i-col>
    </i-row>
  </div>
</template>

<script>
import iHeader from './Header.vue'
import iStar from './Star.vue'
import iView from 'iview'
import moment from 'moment'
export default {
  name: 'BookDetail',
  components: {
    iHeader,
    iStar
  },
  data () {
    return {
      book_id: 0,
      book: {
        cover: '',
        category: {
          id: 0,
          name: '未知'
        },
        created_at: 0,
        id: 0,
        introduction: '',
        name: '',
        price: 0,
        publisher: '',
        score: 0,
        sellNumber: '',
        updated_at: 0,
        peopleNumber: '',
        author: ''
      }
    }
  },
  beforeMount: function () {
    this.book_id = this.$route.params.book_id
    this.GetBook(this.book_id)
  },
  computed: {
  },
  methods: {
    GetBook (bookId) {
      this.$http.get('book/' + bookId)
        .then(r => {
          this.book.cover = r.data.cover
          if (this.book.cover === null || this.book.cover === 'NULL' || this.book.cover === 'null' || this.book.cover === '') this.book.cover = false
          if (r.data.category) this.book.category = r.data.category
          this.book.id = r.data.id
          this.book.introduction = r.data.introduction
          this.book.name = r.data.name
          this.book.price = this.toDecimal2(r.data.price / 100)
          this.book.score = r.data.score
          this.book.sellNumber = r.data.sell_number
          this.book.publisher = r.data.publisher
          this.book.peopleNumber = r.data.people_number
          this.book.author = r.data.author
          this.book.created_at = moment.unix(r.data.created_at).format('YYYY-MM-DD')
          this.book.updated_at = moment.unix(r.data.updated_at).format('YYYY-MM-DD HH:mm:ss')
          this.$Loading.finish()
          document.title = this.book.name + window.title_suf
        })
        .catch(e => {
          iView.LoadingBar.error()
          switch (e.response.status) {
            case 404:
              iView.Notice.error({ title: '这本书不存在, 将在5秒后返回上一页面' })
          }
          let that = this
          setTimeout(function () {
            that.$router.back()
          }, 5000)
        })
    },
    toDecimal2: function (x) {
      let f = Math.round(x * 100) / 100
      let s = f.toString()
      let rs = s.indexOf('.')
      if (rs < 0) {
        rs = s.length
        s += '.'
      }
      while (s.length <= rs + 2) {
        s += '0'
      }
      return s
    },
    ToString (id) {
      id = id * 117 + 215
      return id
    },
    Buy () {
      let bookId = this.book_id
      bookId = this.ToString(bookId)
      this.$router.push({ name: 'CreateOrder', params: { book_id: bookId } })
    }
  }
}
</script>

<style scoped>
  .book-detail{
  }
</style>
