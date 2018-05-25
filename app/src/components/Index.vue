<template>
  <div class="index">
    <!--<i-header>Header</i-header>-->
    <i-menu mode="horizontal" theme="light"
            :active-name="$route.name"
            @on-select="$router.push({ name: $event, params: {id: $store.state.auth.authUser.id} })"
            :default-active="$route.name" :accordion=true
            style="position: fixed; width: 100%;">
      <div class="layout-nav">
        <i-menu-item v-for="(item, idx) in menu" :name="item.to" :key="idx">
          <i-icon :type="item.icon"></i-icon>
          {{item.title}}
        </i-menu-item>
      </div>
      <div style="float: right; margin-right: 40px;">
        <div v-if="username">
          <i-avatar v-if="avatar" :src="avatar" size="large" shape="square" class="avatar"></i-avatar>
          <i-avatar v-else icon="person" size="large" shape="square" class="avatar"></i-avatar>
          <span class="Nickname">{{ nickname }}</span>
        </div>
        <div v-else>
          <i-button type="primary" @click="ToLogin()">登录</i-button>
          <i-button @click="ToRegister()">注册</i-button>
        </div>
      </div>
    </i-menu>
    <div style="height: 1000px;"></div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Index',
  data () {
    return {
      menu: [
        {
          title: '首页',
          icon: 'home',
          to: 'Index'
        },
        {
          title: '实体书',
          icon: '',
          to: 'Index2'
        },
        {
          title: '电子书',
          icon: '',
          to: 'Index3'
        },
        {
          title: '个人信息',
          icon: '',
          to: 'Index4'
        }
      ],
      username: this.username,
      avatar: this.avatar
    }
  },
  beforeMount: function () {
    this.token = this.$store.state.auth.token
    let auth = this.$store.state.auth.authUser
    this.nickname = auth.nickname
    this.avatar_name = auth.avatar
    if (this.avatar_name !== null && this.avatar_name !== undefined) {
      this.avatar = axios.defaults.baseURL + 'show/img/' + this.avatar_name
    } else {
      this.avatar = null
    }
    document.title = '首页' + window.title_suf
  },
  computed: {
  },
  methods: {
    ToLogin () {
      this.$Loading.start()
      this.$Loading.finish()
      this.$router.push({name: 'Login'})
      console.log(1)
      // to be done
    },
    ToRegister () {
      console.log(1)
      // to be done
    }
  }
}
</script>

<style scoped>
  .index {
    border: 1px solid #d7dde4;
    background: #f5f7f9;
    position: relative;
    border-radius: 4px;
    overflow: hidden;
  }
</style>
