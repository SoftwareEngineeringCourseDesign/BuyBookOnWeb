<template>
  <div id="user-register">
    <div style="height: 100px; width: 100%;"></div>
    <i-row>
      <i-col :xs="{span: 16, offset: 4}" :md="{span: 8, offset: 15}">
        <i-card>
          <i-form ref="registerValidate" :model="formValidate" :rules="ruleValidate" :label-width="80" onsubmit="return false">
            <span>
                <i-form-item label="用户名" prop="username">
                  <i-input v-model="formValidate.username" placeholder="Enter your username">
                    <span slot="prepend">
                      <i-icon :size="16" type="person"></i-icon>
                    </span>
                  </i-input>
                </i-form-item>
                <i-form-item label="邮箱" prop="email">
                  <i-input v-model="formValidate.email" placeholder="Enter your e-mail">
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
                <i-form-item label="确认密码" prop="rePassword">
                  <i-input v-model="formValidate.rePassword" placeholder="Confirm your password" type="password">
                    <span slot="prepend">
                      <i-icon :size="16" type="locked"></i-icon>
                    </span>
                  </i-input>
                </i-form-item>
            </span>
            <span>
              <span style="margin-left: 24%;">
                <i-button html-type="submit" type="primary" @click="Register()">注册</i-button>
              </span>
              <span style="margin-left: 4%;">
                <i-button type="ghost" @click="ToLogin()">已有账号，登录</i-button>
              </span>
            </span>
          </i-form>
        </i-card>
      </i-col>
    </i-row>
  </div>
</template>

<script>
import store from 'store'
import iView from 'iview'
export default {
  name: '',
  data () {
    const valideRePassword = (rule, value, callback) => {
      if (value !== this.formValidate.password) {
        callback(new Error('两次输入密码不一致'))
      } else {
        callback()
      }
    }
    return {
      showPassword: false,
      avatar: null,
      formValidate: {
        username: '',
        email: '',
        password: '',
        rePassword: ''
      },
      ruleValidate: {
        username: [
          { required: true, message: '用户名不能为空', trigger: 'blur' },
          { pattern: /^[a-zA-Z][a-zA-Z0-9_]{3,19}$/, message: '用户名只能由4-20位的字母,数字,下划线组成', trigger: 'blur' },
          { pattern: /^[a-zA-Z]/, message: '用户名只能由字母开头', trigger: 'blur' }
        ],
        email: [
          { required: true, message: '邮箱不能为空', trigger: 'blur' },
          { type: 'email', message: '不合法的邮箱格式', trigger: 'blur' }
        ],
        password: [
          { required: true, message: '密码不能为空', trigger: 'blur' },
          { pattern: /^[\x21-\x7e]{3,20}$/, message: '密码长度必须在4到20位之间', trigger: 'blur' },
          { pattern: /^[a-zA-Z]/, message: '密码必须由字母开头', trigger: 'blur' }
        ],
        rePassword: [
          { required: true, message: '重复密码不能为空', trigger: 'blur' },
          { validator: valideRePassword, trigger: 'blur' }
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
        this.$Loading.finish()
        this.$router.back()
      })
      .catch((e) => {
      })
    document.title = '注册' + window.title_suf
  },
  methods: {
    ToLogin () {
      this.$Loading.start()
      this.$Loading.finish()
      this.$router.push({ name: 'Login' })
    },
    Register () {
      event.preventDefault()
      this.$refs.registerValidate.validate((valid) => {
        if (valid) {
          this.$Loading.start()
          let formData = new FormData()
          formData.append('email', this.formValidate.email)
          formData.append('username', this.formValidate.username)
          let createHash = require('create-hash')
          let hash = createHash('sha1')
          hash.update(this.formValidate.password)
          this.formValidate.password = hash.digest('HEX')
          formData.append('password', this.formValidate.password)
          let config = {
            header: {
              'Content-Type': 'multipart/form-data'
            }
          }
          this.$http.post('auth/register', formData, config)
            .then(r => {
              store.set('token', r.data.token)
              store.set('auth', r.data.user_id)
              this.$store.commit('SET_API_TOKEN', r.data.token)
              this.$store.commit('SET_AUTH_USER', r.data.user_id)
              this.$Notice.success({ title: '注册成功' })
              this.$Loading.finish()
              this.$router.back()
            })
            .catch(e => {
              iView.LoadingBar.error()
              switch (e.response.status) {
                case 422:
                  if (e.response.data.hasOwnProperty('username')) {
                    iView.Notice.error({title: '该用户名已被注册'})
                  } else if (e.response.data.hasOwnProperty('email')) {
                    iView.Notice.error({title: '该邮箱已被注册'})
                  }
                  break
              }
              this.formValidate.password = ''
              this.formValidate.rePassword = ''
            })
        }
      })
    }
  }
}
</script>

<style scoped>
  #user-register {
    height: 100vh;
    /*background: #FFEFDB;*/
    background-image: url("../../../../../title.jpg");
    background-repeat: no-repeat;
  }
</style>
