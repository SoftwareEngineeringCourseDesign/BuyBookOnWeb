<template>
  <div class="index">
    <iHeader></iHeader>
    <div class="search-box">
      <div class="head-search">
        <input v-model="search"
                 placeholder="关键词搜索书名/作者/出版社"
                 style="height: 36px; width: 60%;" />
        <i-button type="primary"
                  @click="Search()"
                  style="">搜索</i-button>
      </div>
    </div>
    <i-row>
      <i-col :xs="0" :ms="6" :md="4">
        <div class="category-box">
          <h6 style="font-size: 16px; margin-left: 10px; margin-bottom: 10px;">
            图书分类
          </h6>
          <i-row v-for="(cate, idx) in category" :id="getId(idx, 'cate')" :key="getId(idx, 'cate')" class="category">
            <i-col>
              <a class="category-link" :href="'/select?query=category,' + cate.id" target="_blank">{{cate.name}}</a>
            </i-col>
          </i-row>
        </div>
      </i-col>
      <i-col :xs="24" ms="18" :md="20">
        <div style="margin-left: 25px;">
          <div class="title">
            畅销榜
          </div>
          <i-card v-for="(book, idx) in hotBooks" :id="getId(idx, 'hot')" :key="getId(idx, 'hot')" class="books">
            <p slot="title">
              <i-icon type="ios-book-outline"></i-icon>
              {{book.name}}
            </p>
            <p slot="extra">
              <i-star :score="book.score"></i-star>
              <i-button slot="extra" @click="ToBookDetail(book.id)">查看详情</i-button>
            </p>
            <i-row>
              <i-col span="10">
                <img v-if="hasImg(book.cover)" :src="book.cover" class="cover">
                <div v-else class="cover">该书暂无图片</div>
              </i-col>
              <i-col span="14">
                作者： {{ book.author }}<br>
                分类： <a >{{ book.category.name }}</a><br>
                出版社： {{ book.publisher }}<br>
                价格： ￥{{ toDecimal2(book.price / 100) }}<br>
                销量： {{ book.sell_number }}本
              </i-col>
            </i-row>
          </i-card>
          <div style="height: 50px;"></div>
          <div class="title">
            新书上架
          </div>
          <div>
            <i-card v-for="(book, idx) in newBooks" :id="getId(idx, 'new')" :key="getId(idx, 'new')"  class="books">
              <p slot="title">
                <i-icon type="ios-book-outline"></i-icon>
                {{book.name}}
              </p>
              <p slot="extra">
                <i-star :score="book.score"></i-star>
                <i-button slot="extra" @click="ToBookDetail(book.id)">查看详情</i-button>
              </p>
              <i-row>
                <i-col span="10">
                  <img v-if="hasImg(book.cover)" :src="book.cover" class="cover">
                  <div v-else class="cover">该书暂无图片</div>
                </i-col>
                <i-col span="14">
                  作者： {{ book.author }}<br>
                  分类： <a >{{ book.category.name }}</a><br>
                  出版社： {{ book.publisher }}<br>
                  价格： ￥{{ toDecimal2(book.price / 100) }}<br>
                  销量： {{ book.sell_number }}本
                </i-col>
              </i-row>
            </i-card>
          </div>
          <div style="height: 50px;"></div>
          <div class="title">
            猜你喜欢
            <span class="change-rand-book" @click="changeRandBook()">
              <i-icon type="ios-loop-strong" color="blue"></i-icon>
              换一批
            </span>
          </div>
          <i-card v-for="(book, idx) in randomBooks" :id="getId(idx, 'rand')" :key="getId(idx, 'rand')" class="books">
            <p slot="title">
              <i-icon type="ios-book-outline"></i-icon>
              {{book.name}}
            </p>
            <p slot="extra">
              <i-star :score="book.score"></i-star>
              <i-button slot="extra" @click="ToBookDetail(book.id)">查看详情</i-button>
            </p>
            <i-row>
              <i-col span="10">
                <img v-if="hasImg(book.cover)" :src="book.cover" class="cover">
                <div v-else class="cover">该书暂无图片</div>
              </i-col>
              <i-col span="14">
                作者： {{ book.author }}<br>
                分类： <a >{{ book.category.name }}</a><br>
                出版社： {{ book.publisher }}<br>
                价格： ￥{{ toDecimal2(book.price / 100) }}<br>
                销量： {{ book.sell_number }}本
              </i-col>
            </i-row>
          </i-card>
        </div>
        <div style="height: 50px;"></div>
      </i-col>
    </i-row>
  </div>
</template>

<script>
import iHeader from './Header.vue'
import iStar from './Star.vue'
export default {
  name: 'Index',
  components: {
    iHeader,
    iStar
  },
  data () {
    return {
      search: '',
      avatar: '',
      category: [],
      hotBooks: [],
      newBooks: [],
      randomBooks: []
    }
  },
  beforeMount: function () {
    this.GetCategory()
    this.GetHotBook()
    this.GetNewBook()
    this.GetRandomBook()
    document.title = '首页' + window.title_suf
  },
  computed: {
  },
  methods: {
    getId (idx, word) {
      return word + '-' + idx.toString()
    },
    Search () {
      let query = 'keyword,' + this.search
      this.$router.push({ name: 'Select', query: { query } })
      console.log(this.search)
    },
    GetCategory () {
      this.$http.get('category', {
        params: {}
      })
        .then(r => {
          this.category = r.data
        })
        .catch(e => {
        })
    },
    GetHotBook () {
      this.$http.get('book', {
        params: {
          order: 'volume',
          direction: 'desc',
          limit: 10
        }
      })
        .then(r => {
          this.hotBooks = r.data
        })
        .catch(e => {
        })
    },
    GetNewBook () {
      this.$http.get('book', {
        params: {
          limit: 10
        }
      })
        .then(r => {
          this.newBooks = r.data
        })
        .catch(e => {
        })
    },
    GetRandomBook () {
      this.$http.get('book', {
        params: {
          order: 'random',
          limit: 10
        }
      })
        .then(r => {
          this.randomBooks = r.data
        })
        .catch(e => {
        })
    },
    changeRandBook () {
      event.preventDefault()
      this.GetRandomBook()
    },
    ToBookDetail (bookId) {
      event.preventDefault()
      this.$Loading.start()
      this.$router.push({ name: 'BookDetail', params: { book_id: bookId } })
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
    hasImg (cover) {
      if (cover === null || cover === 'null' || cover === 'NULL') return false
      return true
    }
  }
}
</script>

<style scoped>
  .index {
    min-height: 1000px;
    /*border: 1px solid #d7dde4;*/
    background: #f5f7f9;
    position: relative;
    border-radius: 4px;
    overflow: hidden;
  }
  .head-search {
    margin-left: 20%;
    height: 70px;
    font-size: 24px;
  }
  .search-box {
    margin-top: 80px;
    height: 70px;
    width: 100%;
  }
  .category-box {
    box-sizing: border-box;
    border-right: 1px solid #7f7f7f;
  }
  .category {
    margin-left: 30px;
    margin-top: 5px;
    font-size: 14px;
  }
  .category-link {
    color: black;
  }
  .category-link:hover {
    color: #e47911;
    text-decoration: underline;
  }
  .books {
    width: 400px;
    display: inline-block;
    margin-right: 10px;
    margin-top: 10px;
  }
  .title {
    font-size: 16px;
  }
  .cover {
    max-width: 100%;
    max-height: 200px;
    min-height: 150px;
  }
  .change-rand-book {
    cursor: pointer;
    color: #5555ff;
  }
</style>
