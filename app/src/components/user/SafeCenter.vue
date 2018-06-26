<template>
  <div>
    <h1 style="width: 100%; text-align: center;">安全中心</h1>
    <div class="msg">
      <i-icon type="ios-person" :size="size"></i-icon>
      <span>用户名: {{ user.username }}</span>
    </div>
    <div class="msg">
      <i-icon type="ios-email" :size="size"></i-icon>
      <span>邮箱： {{ user.email }}</span>
    </div>
    <div class="msg">
      <i-icon type="key" :size="size"></i-icon>
      <span>角色： {{ user.role.name }}</span>
    </div>
    <div class="msg">
      <i-icon type="ios-locked" :size="size"></i-icon>
      <span v-show="!changePassword">密码：**********</span>
      <span v-if="changePassword">新密码：</span>
      <input v-if="changePassword" class="password ivu-input" type="password" @blur="validate()" v-model="newPassword" placeholder="输入新密码" />
      <p v-show="error.non" class="error">新密码不能为空</p>
      <p v-show="error.len" class="error">新密码长度必须在4到20位之间</p>
      <p v-show="error.beg" class="error">新密码必须由字母开头</p>
      <span @click="changePassword = !changePassword">
        <i-icon v-show="!changePassword" type="edit" :size="size" class="edit"></i-icon>
      </span>
    </div>
    <div class="msg">
      <i-icon type="ios-unlocked"></i-icon>
      <span>确认原密码:</span>
      <input class="password ivu-input" type="password" v-model="oldPassword" placeholder="输入原密码" />
    </div>
    <div style="text-align: center; margin-top: 30px;">
      <i-button type="primary" @click="Change()">提交修改</i-button>
    </div>
  </div>
</template>

<script>
import iView from 'iview'
export default {
  props: ['user'],
  name: 'SafeCenter',
  data () {
    return {
      error: {
        non: false,
        len: false,
        beg: false
      },
      size: 24,
      oldPassword: '',
      newPassword: '',
      changePassword: false
    }
  },
  computed: {
  },
  methods: {
    Change () {
      if (!this.validate()) return
      this.$Loading.start()
      let createHash = require('create-hash')
      let hash = createHash('sha1')
      hash.update(this.oldPassword)
      this.oldPassword = hash.digest('HEX')
      let createHash2 = require('create-hash')
      let hash2 = createHash2('sha1')
      hash2.update(this.newPassword)
      this.newPassword = hash2.digest('HEX')
      console.log({
        'token': this.$store.state.auth.token,
        'password_new': this.newPassword,
        'password_old': this.oldPassword
      })
      this.$http.put('user/' + this.user.id, {
        'token': this.$store.state.auth.token,
        'password_new': this.newPassword,
        'password_old': this.oldPassword
      })
        .then(r => {
          localStorage.clear()
          this.$store.commit('SET_API_TOKEN', '')
          this.$store.commit('SET_AUTH_USER', '')
          this.$Loading.finish()
          this.$Notice.success({ title: '密码修改成功，请重新登录' })
          this.$router.push({ name: 'Login' })
        })
        .catch(e => {
          iView.LoadingBar.error()
          switch (e.response.status) {
            case 401:
              iView.Notice.error({title: '您未登录或会话超时'})
              this.$router.push({ name: 'Login' })
              break
            case 403:
              iView.Notice.error({title: '您没有权限'})
              break
            case 444:
              iView.Notice.error({title: '密码错误'})
              break
          }
          this.oldPassword = this.newPassword = ''
        })
    },
    validate () {
      let regex1 = /^[\x21-\x7e]{4,20}$/
      let regex2 = /^[a-zA-Z]/
      this.error.non = this.error.len = this.error.beg = false
      if (this.newPassword === '') {
        this.error.non = true
        return false
      } else if (!regex1.test(this.newPassword)) {
        this.error.len = true
        return false
      } else if (!regex2.test(this.newPassword)) {
        this.error.beg = true
        return false
      }
      return true
    }
  }
}
</script>

<style scoped>
  .msg {
    margin-top: 20px;
    font-size: 24px;
  }
  .edit {
    margin-left: 30px;
    color: #2D8CF0;
    cursor: pointer;
  }
  .password {
    display: inline-block !important;
    width: 400px !important;
    margin-right: 20px;
    margin-left: 20px;
  }
  .error {
    color: red;
    margin-left: 20%;
    margin-top: 5px;
    font-size: 12px;
  }
</style>
