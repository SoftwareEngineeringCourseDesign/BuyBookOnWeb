<template>
  <div>
    <i-header></i-header>
    <h1 style="text-align: center; margin-top: 20px; margin-left: -60px;">新建订单</h1>
    <div class="order">
      <i-table
        border
        :columns="columns"
        :data="book"
      >
      </i-table>
      <div class="create">
        <i-button type="error" @click="Create()">创建订单</i-button>
      </div>
    </div>
  </div>
</template>

<script>
import iHeader from '../Header.vue'
import iView from 'iview'
import moment from 'moment'
export default {
  components: {
    iHeader
  },
  name: '',
  data () {
    return {
      book_id: 0,
      book: [],
      columns: [
        {
          title: '购买书籍',
          key: 'msg',
          render: (h, params) => {
            return h('div', [
              h('img', {
                attrs: {
                  height: '100px',
                  src: params.row.msg.img
                }
              }),
              h('span', params.row.msg.name)
            ])
          }
        },
        {
          title: '分类',
          key: 'category'
        },
        {
          title: '出版商',
          key: 'publisher'
        },
        {
          title: '单价',
          key: 'price'
        },
        {
          title: '数量',
          key: 'number',
          render: (h, params) => {
            return h('div', [
              h('span', {
                style: {
                  'margin-right': '15px',
                  cursor: 'pointer'
                },
                on: {
                  click: () => {
                    this.book[0].number = +this.book[0].number - 1
                    this.book[0].sum = this.toDecimal2(this.book[0].number * this.book[0].truePrice / 100)
                  }
                }
              }, [
                h('Icon', {
                  props: {
                    type: 'chevron-left'
                  }
                })
              ]),
              params.row.number,
              h('span', {
                style: {
                  'margin-left': '15px',
                  cursor: 'pointer'
                },
                on: {
                  click: () => {
                    this.book[0].number = +this.book[0].number + 1
                    this.book[0].sum = this.toDecimal2(this.book[0].number * this.book[0].truePrice / 100)
                  }
                }
              }, [
                h('Icon', {
                  props: {
                    type: 'chevron-right'
                  }
                })
              ])
            ])
          }
        },
        {
          title: '优惠方式',
          key: 'discount'
        },
        {
          title: '总金额',
          key: 'sum'
        }
      ]
    }
  },
  created: function () {
    this.$http.get('user/' + this.$store.state.auth.authUser, {params: {token: this.$store.state.auth.token}})
      .then((r) => {
        this.user = r.data
        this.user.createTime = moment.unix(+r.data.created_at).format('YYYY-MM-DD HH:mm:ss')
      })
      .catch((e) => {
        iView.Notice.error({title: '暂未登录'})
        this.$router.push({ name: 'Index' })
      })
    this.book_id = this.FromString(this.$route.params.book_id)
    this.$http.get('book/' + this.book_id)
      .then(r => {
        let book = {
          msg: {
            img: r.data.cover,
            name: r.data.name
          },
          category: r.data.category.name,
          publisher: r.data.publisher,
          truePrice: r.data.price,
          price: this.toDecimal2(r.data.price / 100),
          number: 1,
          discount: '无优惠',
          sum: this.toDecimal2(r.data.price / 100)
        }
        this.book = [
          book
        ]
      })
      .catch(e => {
      })
    document.title = '新建订单' + window.title_suf
  },
  computed: {
  },
  methods: {
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
    FromString (id) {
      id = Math.round((id - 215) / 117)
      return id
    },
    Create () {
      this.$Loading.start()
      let formData = new FormData()
      formData.append('book_id', this.book_id)
      formData.append('number', this.book[0].number)
      formData.append('price', this.book[0].number * this.book[0].truePrice)
      let config = {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Api-Token': this.$store.state.auth.token
        }
      }
      this.$http.post('order/new', formData, config)
        .then(r => {
          this.$Loading.finish()
          this.$Notice.success({ title: '创建成功' })
          let now = 'orderCenter'
          this.$router.push({ name: 'UserInfo', query: { now } })
        })
        .catch(e => {
          iView.LoadingBar.error()
          iView.Notice.error({title: '出现了一个错误'})
        })
    }
  }
}
</script>

<style scoped>
  .order {
    width: 90%;
    margin: 50px;
  }
  .create {
    margin-top: 20px;
    margin-right: 20px;
    text-align: right;
  }
</style>
