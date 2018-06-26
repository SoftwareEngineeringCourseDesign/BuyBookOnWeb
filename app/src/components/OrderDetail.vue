<template>
  <div>
    <i-header></i-header>
    <h1 style="text-align: center; margin-top: 20px;">订单详情</h1>
    <div class="order">
      <h2 style="margin-bottom: 10px;">订单内容</h2>
      <i-table
        border
        :columns="columns"
        :data="book"
      >
      </i-table>
      <h2 style="margin-top: 20px;">订单信息</h2>
      <i-table
        border
        :columns="columns2"
        :data="orderList"
      >
      </i-table>
    </div>
    <div class="back">
      <i-button type="primary" @click="$router.back()">返回上一页</i-button>
    </div>
  </div>
</template>

<script>
import iHeader from './Header.vue'
import moment from 'moment'
import iView from 'iview'
export default {
  components: {
    iHeader
  },
  name: '',
  data () {
    return {
      order: [],
      orderList: [],
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
              h('b', params.row.msg.name)
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
          key: 'number'
        },
        {
          title: '优惠方式',
          key: 'discount'
        },
        {
          title: '总金额',
          key: 'sum'
        }
      ],
      columns2: [
        {
          title: '订单编号',
          key: 'id'
        },
        {
          title: '下单用户',
          key: 'username'
        },
        {
          title: '总金额',
          key: 'sum'
        },
        {
          title: '创建时间',
          key: 'createTime'
        },
        {
          title: '订单状态',
          key: 'step',
          render: (h, params) => {
            return h('div', this.GetStepMessage(params.row.step))
          }
        },
        {
          title: '操作',
          render: (h, params) => {
            return h('div', {
              style: {
                'text-align': 'center'
              }
            }, this.getContent(h))
          }
        }
      ],
      user: [],
      score: 0
    }
  },
  created: function () {
    this.$http.get('user/' + this.$store.state.auth.authUser, {params: {token: this.$store.state.auth.token}})
      .then((r) => {
        this.user = r.data
      })
      .catch((e) => {
        iView.Notice.error({title: '暂未登录'})
        this.$router.push({ name: 'Login' })
      })
    this.$http.get('order/' + this.$route.params.order_id, { params: {
      'token': this.$store.state.auth.token
    }})
      .then(r => {
        this.order = r.data
        this.$http.get('book/' + this.order.book.id)
          .then(r2 => {
            let b = r2.data
            b.category = b.category.name
            b.price = this.toDecimal2(b.price / 100)
            b.number = this.order.number
            b.sum = this.toDecimal2(this.order.price / 100)
            b.discount = '无优惠'
            b.msg = {
              img: r2.data.cover,
              name: r2.data.name
            }
            this.book = [b]
            this.order.sum = this.toDecimal2(this.order.price / 100)
            this.order.createTime = moment.unix(+this.order.created_at).format('YYYY-MM-DD')
            this.order.username = this.order.user.name
            this.orderList = [this.order]
          })
          .catch(e2 => {
            switch (e2.response.status) {
              case 401:
                iView.Notice.error({title: '您未登录'})
                this.$router.push({ name: 'Login' })
                break
              case 403:
                iView.Notice.error({title: '您没有权限'})
                this.$router.push({ name: 'UserInfo' })
                break
              case 404:
                iView.Notice.error({ title: '找不到该书' })
                this.$router.push({ name: 'UserInfo' })
            }
          })
      })
      .catch(e => {
        switch (e.response.status) {
          case 401:
            iView.Notice.error({title: '您未登录'})
            this.$router.push({ name: 'Login' })
            break
          case 403:
            iView.Notice.error({title: '您没有权限'})
            this.$router.push({ name: 'UserInfo' })
            break
          case 404:
            iView.Notice.error({ title: '找不到该订单' })
            this.$router.push({ name: 'UserInfo' })
        }
      })
    document.title = '订单详情' + window.title_suf
  },
  computed: {
  },
  methods: {
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
    getContent (h) {
      let button
      if (this.user.role.alias === 'root') button = []
      else if (this.user.role.alias === 'person') {
        if (this.order.step === 1) {
          button = [
            h('Button', {
              props: {
                type: 'error'
              },
              on: {
                click: () => {
                  this.Pay()
                }
              }
            }, '立即支付')
          ]
        } else if (this.order.step === 2) {
          button = [
            h('Button', {
              props: {
                type: 'error'
              },
              on: {
                click: () => {
                  this.$Message.info('已通知商家尽快发货')
                }
              }
            }, '催促商家发货')
          ]
        } else if (this.order.step === 3) {
          button = [
            h('Button', {
              props: {
                type: 'error'
              },
              on: {
                click: () => {
                  this.Receive()
                }
              }
            }, '确认收货')
          ]
        } else if (this.order.step === 4) {
          button = [
            h('Rate', {
              props: {
                value: this.score,
                'show-text': false,
                count: 5,
                'allow-half': true
              },
              on: {
                input: (value) => {
                  this.score = value
                }
              }
            }),
            h('Button', {
              props: {
                type: 'primary'
              },
              style: {
                'margin-top': '10px',
                'margin-bottom': '10px'
              },
              on: {
                click: () => {
                  this.Star()
                }
              }
            }, '提交评分')
          ]
        } else if (this.order.step === 5) {
          button = [
            h('Button', {
              props: {
                type: 'primary'
              },
              on: {
                click: () => {
                  this.$Message.info('暂未开放评论功能')
                }
              }
            }, '追加评论')
          ]
        }
      } else if (this.user.role.alias === 'bookseller') {
        if (this.order.step === 1) {
          button = [
            h('Button', {
              props: {
                type: 'error'
              },
              on: {
                click: () => {
                  this.$Message.info('已提醒用户付款')
                }
              }
            }, '提醒用户付款')
          ]
        } else if (this.order.step === 2) {
          button = [
            h('Button', {
              props: {
                type: 'error'
              },
              on: {
                click: () => {
                  this.Send()
                }
              }
            }, '确认发货')
          ]
        } else if (this.order.step === 3) {
          button = [
            h('Button', {
              props: {
                type: 'error'
              },
              on: {
                click: () => {
                  this.$Message.info('已提醒用户收货')
                }
              }
            }, '提醒用户收货')
          ]
        } else if (this.order.step === 4) {
          button = [
            h('Button', {
              props: {
                type: 'error'
              },
              on: {
                click: () => {
                  this.$Message.info('已提醒用户评分')
                }
              }
            }, '提醒用户评分')
          ]
        } else if (this.order.step === 5) {
          button = [
            h('Button', {
              props: {
                type: 'primary'
              },
              on: {
                click: () => {
                  this.$Message.info('暂未开放评论功能')
                }
              }
            }, '查看评论')
          ]
        }
      } else button = []
      return button
    },
    Pay () {
      this.$http.put('order/' + this.order.id + '/pay', {
        'token': this.$store.state.auth.token
      })
        .then(r => {
          this.$http.get('order/' + this.$route.params.order_id, { params: {
            'token': this.$store.state.auth.token
          }})
            .then(r2 => {
              this.order.step = r2.data.step
              this.$Notice.info({ title: '支付成功' })
            })
            .catch(e => {
              switch (e.response.status) {
                case 401:
                  iView.Notice.error({title: '您未登录'})
                  this.$router.push({ name: 'Login' })
                  break
                case 403:
                  iView.Notice.error({title: '您没有权限'})
                  this.$router.push({ name: 'UserInfo' })
                  break
                case 404:
                  iView.Notice.error({ title: '找不到该订单' })
                  this.$router.push({ name: 'UserInfo' })
              }
            })
        })
        .catch(e => {
          switch (e.response.status) {
            case 404:
              iView.Notice.error({ title: '找不到该订单' })
              break
            case 402:
              iView.Notice.error({ title: '该订单已支付成功' })
              break
            case 403:
              iView.Notice.error({ title: e.response.data.message })
              break
          }
        })
    },
    Receive () {
      this.$http.put('order/' + this.order.id + '/receive', {
        'token': this.$store.state.auth.token
      })
        .then(r => {
          this.$http.get('order/' + this.$route.params.order_id, { params: {
            'token': this.$store.state.auth.token
          }})
            .then(r2 => {
              this.order.step = r2.data.step
              this.$Notice.info({ title: '成功确认收货' })
            })
            .catch(e => {
              switch (e.response.status) {
                case 401:
                  iView.Notice.error({title: '您未登录'})
                  this.$router.push({ name: 'Login' })
                  break
                case 403:
                  iView.Notice.error({title: '您没有权限'})
                  this.$router.push({ name: 'UserInfo' })
                  break
                case 404:
                  iView.Notice.error({ title: '找不到该订单' })
                  this.$router.push({ name: 'UserInfo' })
              }
            })
        })
        .catch(e => {
          switch (e.response.status) {
            case 404:
              iView.Notice.error({ title: '找不到该订单' })
              break
            case 402:
              iView.Notice.error({ title: '该订单已支付成功' })
          }
        })
    },
    Star () {
      this.$http.put('order/' + this.order.id + '/evaluate', {
        'token': this.$store.state.auth.token,
        'score': Math.round(this.score * 2)
      })
        .then(r => {
          this.$http.get('order/' + this.$route.params.order_id, { params: {
            'token': this.$store.state.auth.token
          }})
            .then(r2 => {
              this.order.step = r2.data.step
              this.$Notice.info({ title: '成功评分' })
            })
            .catch(e => {
              switch (e.response.status) {
                case 401:
                  iView.Notice.error({title: '您未登录'})
                  this.$router.push({ name: 'Login' })
                  break
                case 403:
                  iView.Notice.error({title: '您没有权限'})
                  this.$router.push({ name: 'UserInfo' })
                  break
                case 404:
                  iView.Notice.error({ title: '找不到该订单' })
                  this.$router.push({ name: 'UserInfo' })
              }
            })
        })
        .catch(e => {
          switch (e.response.status) {
            case 404:
              iView.Notice.error({ title: '找不到该订单' })
              break
            case 402:
              iView.Notice.error({ title: '该订单已支付成功' })
          }
        })
    },
    Send () {
      this.$http.put('order/' + this.order.id + '/send', {
        'token': this.$store.state.auth.token
      })
        .then(r => {
          this.$http.get('order/' + this.$route.params.order_id, { params: {
            'token': this.$store.state.auth.token
          }})
            .then(r2 => {
              this.order.step = r2.data.step
              this.$Notice.info({ title: '发货成功' })
            })
            .catch(e => {
              switch (e.response.status) {
                case 401:
                  iView.Notice.error({title: '您未登录'})
                  this.$router.push({ name: 'Login' })
                  break
                case 403:
                  iView.Notice.error({title: '您没有权限'})
                  this.$router.push({ name: 'UserInfo' })
                  break
                case 404:
                  iView.Notice.error({ title: '找不到该订单' })
                  this.$router.push({ name: 'UserInfo' })
              }
            })
        })
        .catch(e => {
          switch (e.response.status) {
            case 404:
              iView.Notice.error({ title: '找不到该订单' })
              break
          }
        })
    }
  }
}
</script>

<style scoped>
  .back {
    margin: 50px;
    text-align: right;
  }
  .order {
    width: 90%;
    margin: 50px;
  }
</style>
