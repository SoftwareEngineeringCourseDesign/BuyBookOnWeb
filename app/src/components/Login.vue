<template>
  <div id="login">
    <div style="width: 100%; height: 100px;"></div>
    <i-rol>
      <i-col :xs="{span: 16, offset: 4}" :md="{span: 8, offset: 15}">
        <i-card>
          <i-form ref="loginValidate" :model="formValidate" :rules="ruleValidate" :label-width="80" onsubmit="return false">
            <span>
                <i-form-item v-if="flag" label="用户名" prop="name">
                  <i-input v-model="formValidate.name" placeholder="Enter your name">
                <span slot="prepend">
                  <i-icon :size="16" type="person"></i-icon>
                </span>
                  </i-input>
                </i-form-item>
                <i-form-item v-else label="邮箱" prop="mail">
                  <i-input v-model="formValidate.mail" placeholder="Enter your e-mail">
                <span slot="prepend">
                  <i-icon :size="16" type="email"></i-icon>
                </span>
                  </i-input>
                </i-form-item>
            </span>
            <span>
                <i-form-item label="密码" prop="password">
                  <i-input v-model="formValidate.password" placeholder="Enter your password" :type="showPassword ? 'text' : 'password'">
                <span slot="prepend">
                  <i-icon :size="16" type="locked"></i-icon>
                </span>
                    <span slot="append">
                  <i-button style="padding: 3px 10px" @click="showPassword = !showPassword">
                    <i-icon :size="18" style="color:#2D8CF0" type="eye" v-if="showPassword"></i-icon>
                    <i-icon :size="18" type="eye" v-else></i-icon>
                  </i-button>
                </span>
                  </i-input>
                </i-form-item>
            </span>
            <span>
                <i-form-item prop="remember">
                  <i-checkbox v-model="formValidate.remember">记住我</i-checkbox>
                  <span style="color:grey">请不要在公共电脑勾选此项</span>
                </i-form-item>
            </span>
            <span>
              <span style="margin-left: 10%;">
                <i-button v-if="flag" type="ghost" @click="switchLogin()">使用邮箱登录</i-button>
                <i-button v-else type="ghost" @click="switchLogin()">使用账号登录</i-button>
              </span>
              <span style="margin-left: 4%;">
                <i-button html-type="submit" type="primary" @click="Login()">登录</i-button>
              </span>
              <span style="margin-left: 4%;">
                <i-button type="ghost" @click="ToRegister()">立即注册</i-button>
              </span>
            </span>
          </i-form>
        </i-card>
      </i-col>
    </i-rol>
  </div>
</template>

<script>
import store from 'store'
import iView from 'iview'
export default {
  name: '',
  data () {
    return {
      status: 'false',
      showPassword: false,
      flag: true,
      State: [],
      formValidate: {
        name: '',
        mail: '',
        password: '',
        remember: false
      },
      ruleValidate: {
        name: [
          { required: true, message: '用户名不能为空', trigger: 'blur' },
          { pattern: /^[a-zA-Z][a-zA-Z0-9_]{5,19}$/, message: '用户名只能由6-20位的字母,数字,下划线组成', trigger: 'blur' },
          { pattern: /^[a-zA-Z]/, message: '用户名只能由字母开头', trigger: 'blur' }
        ],
        mail: [
          { required: true, message: '邮箱不能为空', trigger: 'blur' },
          { type: 'email', message: '不合法的邮箱格式', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '密码不能为空', trigger: 'blur' },
          { pattern: /^[\x21-\x7e]{6,20}$/, message: '密码长度必须在6到20位之间', trigger: 'blur' },
          { pattern: /^[a-zA-Z]/, message: '密码必须由字母开头', trigger: 'blur' }
        ]
      }
    }
  },
  computed: {
  },
  beforeMount: function () {
    this.$http.get('check', {params: {token: this.$store.state.auth.token}})
      .then((response) => {
        this.$Notice.success({title: '登陆成功'})
        this.$router.push({ name: 'Home' })
        this.$Loading.finish()
      })
      .catch((e) => {
        console.log(e)
      })
    document.title = '登录' + window.title_suf
  },
  methods: {
    switchLogin () {
      this.flag = !this.flag
    },
    Login () {
      event.preventDefault()
      this.$refs.loginValidate.validate((valid) => {
        if (valid) {
          this.$Loading.start()
          let formData = new FormData()
          if (this.flag) {
            formData.append('username', this.formValidate.name)
          } else formData.append('email', this.formValidate.mail)
          let createHash = require('create-hash')
          let hash = createHash('sha1')
          hash.update(this.formValidate.password)
          this.formValidate.password = hash.digest('HEX')
          formData.append('password', this.formValidate.password)
          formData.append('remember', this.formValidate.remember)
          let config = {
            header: {
              'Content-Type': 'multipart/form-data'
            }
          }
          this.$http.post('auth/login', formData, config)
            .then(response => {
              let auth = {
                id: response.data.id,
                nickname: response.data.nickname,
                gender: response.data.gender,
                avatar: response.data.avatar
              }
              localStorage.clear()
              store.set('token', response.data.token)
              store.set('authUser', auth)
              store.set('status', true)
              this.$store.commit('SET_API_TOKEN', response.data.token)
              this.$store.commit('SET_AUTH_USER', auth)
              this.$store.commit('SET_STATUS', true)
              this.$Loading.finish()
              this.$Notice.success({ title: '登录成功' })
              this.$router.push({ name: 'Home' })
            })
            .catch(e => {
              iView.LoadingBar.error()
              switch (e.response.status) {
                case 401:
                  if (this.flag === true) iView.Notice.error({title: '用户名或密码错误'})
                  else iView.Notice.error({title: '邮箱或密码错误'})
                  break
                case 404:
                  if (!this.flag) iView.Notice.error({title: '该邮箱未注册'})
                  else iView.Notice.error({title: '该用户名未注册'})
              }
              this.formValidate.password = ''
              console.log(e)
            })
        }
      })
    },
    ToHome () {
      this.$Loading.start()
      this.$Loading.finish()
      this.$router.push({ name: 'Home' })
    },
    ToRegister () {
      this.$Loading.start()
      this.$Loading.finish()
      this.$router.push({ path: '/register' })
    }
  }
}
</script>

<style scoped>
  #login {
    height: 100vh;
    background: #FFEFDB;
    background-image: url("../../../../../title.jpg");
    background-repeat: no-repeat;
  }
</style>
