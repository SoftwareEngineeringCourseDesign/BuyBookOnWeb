<template>
  <div>
    <Header class="layout-header-bar">
      <Breadcrumb>
        <BreadcrumbItem href="/bookseller">Home</BreadcrumbItem>
        <BreadcrumbItem>订单管理</BreadcrumbItem>
      </Breadcrumb>
    </Header>
    <i-content :style="{margin: '20px', background: '#fff', minHeight: '500px'}">
      <h1 style="width: 100%; text-align: center;">订单中心</h1>
      <i-row style="margin-top: 50px;">
        <i-col :span="24" align="right">
          选择书籍：
          <i-select v-model="Page.book" class="select-step" @on-change="ChangeStep">
            <i-option v-for="item in Books" :value="item.id" :key="item.id" :label="item.name">
              <span>{{ item.name }}</span>
            </i-option>
          </i-select>
          订单状态：
          <i-select v-model="Page.step" class="select-step" @on-change="ChangeStep">
            <i-option v-for="item in Steps" :value="item.step" :key="item.step" :label="item.title">
              <span>{{ item.title }}</span>
            </i-option>
          </i-select>
        </i-col>
      </i-row>
      <div class="order">
        <i-table
          border
          :columns="columns"
          :data="orders"
          no-data-text="暂无订单"
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
export default {
  name: '',
  data () {
    return {
      T: true,
      Loading: true,
      orders: [],
      columns: [
        {
          title: '订单编号',
          fixed: 'left',
          width: 100,
          key: 'id'
        },
        {
          title: '购买数量',
          width: 120,
          key: 'number'
        },
        {
          title: '总金额',
          width: 130,
          key: 'sum'
        },
        {
          title: '优惠方式',
          width: 120,
          key: 'discount'
        },
        {
          title: '创建时间',
          width: 150,
          key: 'createTime'
        },
        {
          title: '订单状态',
          key: 'step',
          width: 120,
          render: (h, params) => {
            return h('div', this.GetStepMessage(params.row.step))
          }
        },
        {
          title: '操作',
          fixed: 'right',
          width: 100,
          render: (h, params) => {
            return h('i-button', {
              props: {
                type: 'primary',
                size: 'small'
              },
              on: {
                click: () => {
                  this.OrderDetail(params.row.id)
                }
              }
            }, '查看详情')
          }
        }
      ],
      Page: {
        cur: 1,
        size: 10,
        total: 0,
        step: -1,
        book: -1
      },
      Steps: [
        {
          step: -1,
          title: '查看全部'
        },
        {
          step: 1,
          title: '未支付'
        },
        {
          step: 2,
          title: '待发货'
        },
        {
          step: 3,
          title: '已发货'
        },
        {
          step: 4,
          title: '已收货'
        },
        {
          step: 5,
          title: '已评分'
        }
      ],
      user: [],
      Books: [
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
    this.Page.step = +page[2] || -1
    this.Page.book = +page[3] || -1
    this.$http.get('user/' + this.$store.state.auth.authUser, {params: {token: this.$store.state.auth.token}})
      .then((r) => {
        this.user = r.data
        if (this.user.role.alias !== 'bookseller') {
          this.$Notice.error({ title: '您暂未成为书商' })
          this.$router.push({ name: 'Index' })
        }
        this.GetOrder()
        this.GetBook()
      })
      .catch((e) => {
        iView.Notice.error({title: '暂未登录'})
        this.$router.push({ name: 'Login' })
      })
    document.title = '订单管理' + window.title_suf
  },
  computed: {
  },
  watch: {
    Page: {
      handler (cur, old) {
        let page = this.Page.cur + ',' + this.Page.size + ',' + this.Page.step + ',' + this.Page.book
        this.$router.push({ query: { page } })
      },
      deep: true
    }
  },
  methods: {
    GetBook () {
      this.$http.get('book', {params: {
        token: this.$store.state.auth.token,
        user_id: this.user.id
      }})
        .then(r => {
          let key
          for (key in r.data) {
            if (r.data[key].passed === +1) {
              this.Books.push({
                name: r.data[key].name,
                id: r.data[key].id
              })
            }
          }
        })
        .catch(e => {
        })
    },
    GetStepMessage (step) {
      let s = ''
      switch (step) {
        case 1:
          s = '未支付'
          break
        case 2:
          s = '待发货'
          break
        case 3:
          s = '已发货'
          break
        case 4:
          s = '已收货'
          break
        case 5:
          s = '已评分'
          break
        default:
          s = '未知状态'
      }
      return s
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
    OrderDetail (id) {
      this.$router.push({ name: 'OrderDetail', params: { order_id: id } })
    },
    ChangeStep: function () {
      this.GetOrder()
    },
    GetOrder () {
      let params = {
        'token': this.$store.state.auth.token,
        'user_id': this.user.id,
        'limit': this.Page.size,
        'offset': this.Page.size * (this.Page.cur - 1),
        'bookseller': 1
      }
      if (this.Page.step !== -1) params.step = this.Page.step
      if (this.Page.book !== -1) {
        params.bookseller = 0
        params.book_id = this.Page.book
      }
      this.$http.get('order', {params: params})
        .then(r => {
          let key
          this.orders = []
          for (key in r.data) {
            let order = {}
            order.id = r.data[key].id
            order.number = r.data[key].number
            order.sum = this.toDecimal2(r.data[key].sum / 100)
            order.createTime = moment.unix(+r.data[key].created_at).format('YYYY-MM-DD')
            order.discount = '无优惠'
            order.step = r.data[key].step
            this.orders.push(order)
          }
          this.Loading = false
          this.Page.total = +r.headers['x-total']
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
  .order {
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
