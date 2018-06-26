<template>
  <div class="Header">
    <i-menu mode="horizontal" theme="light"
            :active-name="$route.name"
            @on-select="$router.push({ name: $event, params: {id: $store.state.auth.authUser.id} })"
            :default-active="$route.name" :accordion=true
            style="width: 100%; min-width: 700px; position: relative;">
      <div class="layout-nav">
        <i-menu-item v-for="(item, idx) in menu" :name="item.to" :key="idx">
          <i-icon :type="item.icon"></i-icon>
          {{item.title}}
        </i-menu-item>
      </div>
      <div style="float: right; margin-right: 40px;">
        <div v-if="username">
          <i-avatar :src="getHash(email)" size="large" shape="square" class="avatar"></i-avatar>
          <span class="Username">{{ username }}</span>
          <i-button type="error" @click="LogOut()" style="margin-left: 20px;">退出登录</i-button>
        </div>
        <div v-else>
          <i-button type="primary" @click="ToLogin()">登录</i-button>
          <i-button @click="ToRegister()">注册</i-button>
        </div>
      </div>
    </i-menu>
  </div>
</template>

<script>
export default {
  name: 'Header',
  data () {
    return {
      menu: [
        {
          title: '首页',
          icon: 'home',
          to: 'Index'
        },
        {
          title: '图书检索',
          icon: '',
          to: 'Select'
        },
        {
          title: '个人信息',
          icon: '',
          to: 'UserInfo'
        },
        {
          title: '我要开店',
          icon: '',
          to: 'NewBookSeller'
        }
      ],
      username: '',
      email: '',
      avatar: ''
    }
  },
  computed: {
  },
  beforeMount: function () {
    this.token = this.$store.state.auth.token
    this.userId = this.$store.state.auth.authUser
    this.$http.get('user/' + this.userId, {
      params: {
        token: this.token
      }
    })
      .then(r => {
        this.username = r.data.username
        this.email = r.data.email
        if (r.data.role.alias === 'bookseller') {
          this.menu[3] = {
            title: '我的店铺',
            icon: '',
            to: 'DashboardBookSeller'
          }
        }
      })
      .catch(e => {
      })
  },
  methods: {
    ToLogin () {
      this.$Loading.start()
      this.$Loading.finish()
      this.$router.push({ name: 'Login' })
    },
    ToRegister () {
      this.$Loading.start()
      this.$Loading.finish()
      this.$router.push({ name: 'Register' })
    },
    LogOut () {
      event.preventDefault()
      localStorage.clear()
      this.$store.commit('SET_API_TOKEN', '')
      this.$store.commit('SET_AUTH_USER', '')
      this.token = ''
      this.userId = ''
      this.username = ''
      this.$router.push({ name: 'Index' })
    },
    getHash (email) {
      let hashCode = '' + email
      hashCode = hashCode.replace(/^\s+|\s+$/g, '').toLowerCase()
      let createHash = require('create-hash')
      let hash = createHash('md5')
      hash.update(hashCode)
      hashCode = hash.digest('HEX')
      return 'http://www.gravatar.com/avatar/' + hashCode + '?d=retro'
    }
  }
}
</script>

<style scoped>
  .Header {
    background: #f5f7f9;
    position: relative;
    border-radius: 4px;
    overflow: hidden;
  }
</style>
