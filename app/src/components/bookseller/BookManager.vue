<template>
  <div>
    <Header class="layout-header-bar">
      <Breadcrumb>
        <BreadcrumbItem href="/bookseller">Home</BreadcrumbItem>
        <BreadcrumbItem>书籍管理</BreadcrumbItem>
      </Breadcrumb>
    </Header>
    <i-content :style="{margin: '20px', background: '#fff', minHeight: '500px'}">
      <h1 style="width: 100%; text-align: center;">书籍中心</h1>
      <i-row style="margin-top: 50px;">
        <i-col :span="24" align="right">
          选择分类：
          <i-select v-model="Page.category" class="select-step" @on-change="ChangeStep">
            <i-option v-for="item in Category" :value="item.id" :key="item.id" :label="item.name">
              <span>{{ item.name }}</span>
            </i-option>
          </i-select>
          书籍状态：
          <i-select v-model="Page.passed" class="select-step" @on-change="ChangeStep">
            <i-option v-for="item in Passed" :value="item.passed" :key="item.passed" :label="item.name">
              <span>{{ item.name }}</span>
            </i-option>
          </i-select>
        </i-col>
      </i-row>
      <div class="book">
        <i-table
          border
          :columns="columns"
          :data="Books"
          no-data-text="暂无书籍"
          :stripe="T"
          :loading="Loading"
        >
        </i-table>
      </div>
      <i-row style="margin-bottom: 50px; margin-right: 100px;">
        <i-col :span="24" align="right">
          <i-page
            size="small" show-elevator show-sizer show-total
            :current="Page.cur"
            :page-size="Page.size"
            :total="Page.total"
            @on-change="Page.cur=$event"
            @on-page-size-change="Page.size=$event"
          ></i-page>
        </i-col>
      </i-row>
    </i-content>
  </div>
</template>

<script>
import moment from 'moment'
import iView from 'iview'
import iListBook from '../ListBook.vue'
export default {
  components: {
    iListBook
  },
  name: '',
  data () {
    return {
      T: true,
      Loading: true,
      orders: [],
      columns: [
        {
          type: 'expand',
          width: 50,
          render: (h, params) => {
            return h(iListBook, {
              props: {
                book: params.row
              }
            })
          }
        },
        {
          title: '书籍编号',
          key: 'id'
        },
        {
          title: '书籍名称',
          key: 'name'
        },
        {
          title: '书籍分类',
          render: (h, params) => {
            return h('div', params.row.category.name)
          }
        },
        {
          title: '上传时间',
          key: 'createTime'
        },
        {
          title: '通过时间',
          key: 'updateTime'
        },
        {
          title: '书籍状态',
          render: (h, params) => {
            return h('div', this.GetPassedMessage(params.row.passed))
          }
        }
      ],
      Page: {
        cur: 1,
        size: 10,
        total: 0,
        passed: -1,
        category: -1
      },
      Passed: [
        {
          passed: -1,
          name: '查看全部'
        },
        {
          passed: 1,
          name: '未通过'
        },
        {
          passed: 2,
          name: '已通过'
        }
      ],
      user: [],
      Books: [],
      Category: [
        {
          name: '查看全部',
          id: -1
        }
      ]
    }
  },
  created: function () {
    let page = (this.$route.query.page || '').split(',')
    this.Page.cur = +page[0] || 1
    this.Page.size = +page[1] || 10
    this.Page.passed = +page[2] || -1
    this.Page.category = +page[3] || -1
    this.$http.get('user/' + this.$store.state.auth.authUser, {params: {token: this.$store.state.auth.token}})
      .then((r) => {
        this.user = r.data
        if (this.user.role.alias !== 'bookseller') {
          this.$Notice.error({ title: '您暂未成为书商' })
          this.$router.push({ name: 'Index' })
        }
        this.GetBook()
        this.GetCategory()
      })
      .catch((e) => {
        iView.Notice.error({title: '暂未登录'})
        this.$router.push({ name: 'Login' })
      })
    document.title = '书籍管理' + window.title_suf
  },
  computed: {
  },
  watch: {
    Page: {
      handler (cur, old) {
        let page = this.Page.cur + ',' + this.Page.size + ',' + this.Page.passed + ',' + this.Page.category
        this.$router.push({ query: { page } })
      },
      deep: true
    }
  },
  methods: {
    GetPassedMessage (passed) {
      if (+passed === 0) return '暂未通过'
      else return '已通过'
    },
    GetCategory () {
      this.$http.get('category')
        .then(r => {
          let key
          for (key in r.data) {
            this.Category.push({
              name: r.data[key].name,
              id: r.data[key].id
            })
          }
        })
        .catch(e => {
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
      return '￥' + s
    },
    BookDetail (id) {
      this.$router.push({ name: 'BookDetail', params: { book_id: id } })
    },
    ChangeStep: function () {
      this.GetBook()
    },
    GetBook () {
      let params = {
        'token': this.$store.state.auth.token,
        'user_id': this.user.id,
        'limit': this.Page.size,
        'offset': this.Page.size * (this.Page.cur - 1)
      }
      if (this.Page.category !== -1) params.category_id = this.Page.category
      if (this.Page.passed !== -1) params.passed = this.Page.passed - 1
      this.$http.get('book', {params: params})
        .then(r => {
          let key
          this.Books = []
          for (key in r.data) {
            let book = {}
            book.id = r.data[key].id
            book.name = r.data[key].name
            book.author = r.data[key].author
            book.createTime = moment.unix(+r.data[key].created_at).format('YYYY-MM-DD')
            if (r.data[key].passed === 1) book.updateTime = moment.unix(+r.data[key].updated_at).format('YYYY-MM-DD')
            else book.updateTime = '-'
            book.price = this.toDecimal2(r.data[key].price / 100)
            book.introduction = r.data[key].introduction
            book.publisher = r.data[key].publisher
            book.score = r.data[key].score
            book.sellNumber = r.data[key].sell_number
            book.peopleNumber = r.data[key].people_number
            book.cover = r.data[key].cover
            book.user = r.data[key].user
            book.category = r.data[key].category
            book.passed = r.data[key].passed
            this.Books.push(book)
          }
          this.Loading = false
          this.Page.total = +r.headers['x-total']
          console.log(this.Books)
        })
        .catch(e => {
        })
    }
  }
}
</script>

<style scoped>
  .layout-header-bar{
    background: #fff;
    box-shadow: 0 1px 1px rgba(0,0,0,.1);
  }
  .book {
    width: 90%;
    margin-top: 50px;
    margin-right: 50px;
    margin-bottom: 50px;
  }
  .select-step {
    margin-right: 100px;
    width: 200px;
  }
</style>
