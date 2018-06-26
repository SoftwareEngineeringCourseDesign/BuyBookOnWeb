<template>
  <div class="Select">
    <i-header></i-header>
    <i-row style="margin-top: 50px; margin-left: 20px;">
      <i-row>
        <i-col>
          价格区间：
          <i-row span="4" class="price">
            <input class="ivu-input" v-model="minPrice" @change="MinPrice()" placeholder="最低价" />
          </i-row>
          ~
          <i-row span="4" class="price">
            <input class="ivu-input" v-model="maxPrice" @change="MaxPrice()" placeholder="最高价" />
          </i-row>
          (0~0代表不限制)
        </i-col>
      </i-row>
      <i-row style="margin-top: 10px">
        <i-col>
          排序方式：
          <i-radio-group v-model="selected.sort" type="button">
            <i-radio class="tag" v-for="(method, idx) in sortMethods" :label="method.alias" :key="idx">{{ method.name }}</i-radio>
          </i-radio-group>
        </i-col>
      </i-row>
      <i-row style="margin-top: 10px">
        <i-col>
          升降序：
          <i-radio-group v-model="selected.order" type="button">
            <i-radio class="tag" v-for="(or, idx) in order" :label="or.alias" :key="idx">{{ or.name }}</i-radio>
          </i-radio-group>
        </i-col>
      </i-row>
      <i-row style="margin-top: 10px;">
        <i-col>
          关键词：
          <i-row class="keyword">
            <input class="ivu-input" v-model="keyword" @change="KeyWord()" placeholder="关键词" />
          </i-row>
        </i-col>
      </i-row>
      <i-row style="margin-top: 10px">
        <i-col>
          图书分类：
          <i-radio-group v-model="selected.category" type="button">
            <i-radio class="tag" v-for="(cate, idx) in category" :label="'' + cate.id" :key="idx">{{ cate.name }}</i-radio>
          </i-radio-group>
        </i-col>
      </i-row>
    </i-row>
    <i-row style="margin-top: 50px;">
      <i-col>
        <div style="height: 50px;">
          <i-page
            :total="total"
            show-total
            show-elevator
            show-sizer
            :current="selected.cur"
            :page-size="selected.size"
            @on-change="selected.cur=$event"
            @on-page-size-change="selected.size=$event"
            class="page"
          ></i-page>
        </div>
        <i-card v-for="(book, idx) in books" :id="'select_' + idx" :key="'select_' + idx" class="books">
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
        <div style="height: 50px;">
          <i-page
            :total="total"
            show-total
            show-elevator
            show-sizer
            :current="selected.cur"
            :page-size="selected.size"
            @on-change="selected.cur=$event"
            @on-page-size-change="selected.size=$event"
            class="page"
          ></i-page>
        </div>
      </i-col>
    </i-row>
  </div>
</template>

<script>
import iHeader from './Header.vue'
import iStar from './Star.vue'
export default {
  name: 'Select',
  components: {
    iHeader,
    iStar
  },
  data () {
    return {
      books: [],
      category: [],
      minPrice: 0.00,
      maxPrice: 0.00,
      keyword: '',
      sortMethods: [
        {
          name: '价格',
          alias: 'price'
        },
        {
          name: '销量',
          alias: 'volume'
        },
        {
          name: '评分',
          alias: 'score'
        },
        {
          name: '上架顺序',
          alias: 'time'
        }
      ],
      order: [
        {
          name: '降序',
          alias: 'desc'
        },
        {
          name: '升序',
          alias: 'asc'
        }
      ],
      total: 0,
      selected: {
        category: '0',
        maxPrice: '0',
        minPrice: '0',
        sort: 'time',
        order: 'desc',
        cur: 1,
        size: 10,
        keyword: ''
      }
    }
  },
  computed: {
  },
  beforeMount: function () {
    let query = (this.$route.query.query || '').split('-')
    let key
    let qs
    let q
    for (key in query) {
      qs = query[key]
      if (qs !== '') {
        q = qs.split(',')
        if (q[0] !== '') {
          this.selected[q[0]] = q[1]
        }
      }
    }
    this.minPrice = this.toDecimal2(+this.selected.minPrice / 100)
    this.maxPrice = this.toDecimal2(+this.selected.maxPrice / 100)
    this.selected.cur = +this.selected.cur
    this.selected.size = +this.selected.size
    this.keyword = this.selected.keyword
    if (this.selected.sort === 'time') {
      this.order.pop()
      this.selected.order = 'desc'
    }
    this.GetCategory()
    this.GetBook()
    document.title = '图书检索' + window.title_suf
  },
  watch: {
    selected: {
      handler (cur, old) {
        let query = ''
        let key
        for (key in this.selected) {
          query = query + key + ',' + this.selected[key] + '-'
        }
        this.$router.replace({ query: { query } })
      },
      deep: true
    }
  },
  methods: {
    GetCategory () {
      this.$http.get('category', {
        params: {}
      })
        .then(r => {
          this.category = r.data
          this.category.splice(0, 0, {
            id: 0,
            name: '不限种类'
          })
        })
        .catch(e => {
        })
    },
    GetBook () {
      let p = {
        order: this.selected.sort,
        direction: this.selected.order,
        limit: 10
      }
      if (+this.selected.category !== 0) p['category_id'] = +this.selected.category
      if (+this.selected.minPrice !== 0) p['min_price'] = this.selected.minPrice
      if (+this.selected.maxPrice !== 0) p['max_price'] = this.selected.maxPrice
      if (this.selected.keyword !== '') p['keyword'] = this.selected.keyword
      p['limit'] = +this.selected.size
      p['offset'] = (+this.selected.cur - 1) * (+this.selected.size)
      this.$http.get('book', {
        params: p
      })
        .then(r => {
          this.total = +r.headers['x-total']
          this.books = r.data
        })
        .catch(e => {
        })
    },
    hasImg (cover) {
      if (cover === null || cover === 'null' || cover === 'NULL') return false
      return true
    },
    MinPrice () {
      let t = this.toDecimal2(this.minPrice)
      if (t - this.maxPrice > 1e-6) {
        t = this.maxPrice
      }
      if (t < 0) {
        t = 0.00
      }
      this.minPrice = t
      this.selected.minPrice = Math.round(t * 100)
    },
    MaxPrice () {
      let t = this.toDecimal2(this.maxPrice)
      if (this.minPrice - t > 1e-6) {
        t = this.minPrice
      }
      if (t < 0) {
        t = 0.00
      }
      if (t > 100000) {
        t = 100000
      }
      this.maxPrice = t
      this.selected.maxPrice = Math.round(t * 100)
    },
    KeyWord () {
      this.selected.keyword = this.keyword
    },
    ToBookDetail (bookId) {
      event.preventDefault()
      this.$Loading.start()
      this.$router.push({ name: 'BookDetail', params: { book_id: bookId } })
    },
    toDecimal2: function (input) {
      let x = parseFloat(input)
      if (isNaN(x)) {
        x = 0
      }
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
    }
  }
}
</script>

<style scoped>
  .Select {
  }
  .price {
    display: inline-block !important;
    max-width: 150px !important;
    margin-right: 20px;
    margin-left: 20px;
  }
  .keyword {
   display: inline-block !important;
   width: 500px !important;
   margin-right: 20px;
   margin-left: 20px;
 }
  .books {
    width: 370px;
    display: inline-block;
    margin-right: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    margin-left: 20px;
  }
  .cover {
    max-width: 100%;
    max-height: 200px;
    min-height: 140px;
  }
  .tag {
    margin-right: 10px;
  }
  .page {
    margin-left: 20px;
    margin-right: 100px;
    float: right;
  }
</style>
