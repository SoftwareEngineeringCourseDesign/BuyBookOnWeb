<template>
  <div>
    <i-header></i-header>
    <i-row>
      <i-col :xs="12" :ms="8" :md="8">
        <div class="avatar-content">
          <img :src="getHash(user.email)" width="100px;">
          <p style="font-size: 24px; text-align: center; width: 100px;">{{ user.username }}</p>
        </div>
        <div style="margin-left: 20%; width: 150px;">
          <i-menu theme="light"
                  mode="vertical"
                  :active-name="select"
                  @on-select="changePage($event)"
                  :default-active="select" :accordion=true
                  >
            <div class="layout-nav">
              <i-menu-item v-for="(item, idx) in menu" :name="item.to" :key="idx">
                <i-icon :type="item.icon"></i-icon>
                {{item.title}}
              </i-menu-item>
            </div>
          </i-menu>
        </div>
      </i-col>
      <i-col :xs="12" :ms="16" :md="16">
        <i-self-info v-show="selectMenu.selfInfo" :user="user"></i-self-info>
        <i-order-center v-show="selectMenu.orderCenter" :user="user"></i-order-center>
        <i-safe-center v-show="selectMenu.safeCenter" :user="user"></i-safe-center>
        <i-set-center v-show="selectMenu.setCenter" :user="user"></i-set-center>
      </i-col>
    </i-row>
  </div>
</template>

<script>
import iView from 'iview'
import moment from 'moment'
import iHeader from '../Header.vue'
import iSelfInfo from './SelfInfo.vue'
import iSafeCenter from './SafeCenter.vue'
import iSetCenter from './SetCenter.vue'
import iOrderCenter from './OrderCenter.vue'
export default {
  name: 'Information',
  components: {
    iHeader,
    iSelfInfo,
    iSafeCenter,
    iSetCenter,
    iOrderCenter
  },
  data () {
    return {
      select: 'selfInfo',
      selectMenu: {
        selfInfo: true,
        setCenter: false,
        safeCenter: false,
        orderCenter: false
      },
      menu: [
        {
          title: '个人信息',
          icon: 'ios-person',
          to: 'selfInfo'
        },
        {
          title: '设置中心',
          icon: 'settings',
          to: 'setCenter'
        },
        {
          title: '安全中心',
          icon: 'ios-locked',
          to: 'safeCenter'
        },
        {
          title: '订单中心',
          icon: 'ios-cart',
          to: 'orderCenter'
        }
      ],
      user: {
        id: 0,
        name: '',
        email: '',
        created_at: 0,
        role: {
          alias: '',
          name: '',
          id: 0
        },
        createTime: '1970-01-01 08:00:00'
      }
    }
  },
  created: function () {
    let now = this.$route.query.now
    this.changePage(now)
    this.$http.get('user/' + this.$store.state.auth.authUser, {params: {token: this.$store.state.auth.token}})
      .then((r) => {
        this.user = r.data
        this.user.money = this.toDecimal2(this.user.money)
        this.user.createTime = moment.unix(+r.data.created_at).format('YYYY-MM-DD HH:mm:ss')
      })
      .catch((e) => {
        iView.Notice.error({title: '暂未登录'})
        this.$router.push({ name: 'Login' })
      })
  },
  computed: {
  },
  watch: {
    select: {
      handler (cur, old) {
        let now = this.select
        let page = (this.$route.query.page || '').split(',')
        let Page = {
          cur: 1,
          size: 10,
          step: -1
        }
        Page.cur = +page[0] || 1
        Page.size = +page[1] || 10
        Page.step = +page[2] || -1
        page = Page.cur + ',' + Page.size + ',' + Page.step
        this.$router.push({ query: { now, page } })
      },
      deep: true
    }
  },
  methods: {
    changePage (to) {
      this.select = to
      let key
      for (key in this.selectMenu) {
        this.selectMenu[key] = false
      }
      this.selectMenu[to] = true
      for (key in this.menu) {
        if (this.menu[key].to === to) {
          document.title = this.menu[key].title + window.title_suf
        }
      }
    },
    getHash (email) {
      let hashCode = '' + email
      hashCode = hashCode.replace(/^\s+|\s+$/g, '').toLowerCase()
      let createHash = require('create-hash')
      let hash = createHash('md5')
      hash.update(hashCode)
      hashCode = hash.digest('HEX')
      return 'http://www.gravatar.com/avatar/' + hashCode + '?d=retro'
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
    }
  }
}
</script>

<style scoped>
  .avatar-content {
    margin-left: 40%;
    margin-top: 50px;
  }
</style>
