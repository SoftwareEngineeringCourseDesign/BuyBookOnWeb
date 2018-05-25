<template>
  <div id="user-register">
    <div style="height: 100px; width: 100%;"></div>
    <i-row>
      <i-col :xs="{span: 16, offset: 4}" :md="{span: 8, offset: 15}">
        <i-card>
          <i-form ref="RegisterValidate" :model="formValidate" :rules="ruleValidate" :label-width="80" onsubmit="return false">
            <span>
                <i-form-item v-if="flag" label="用户名" prop="name">
                  <i-input v-model="formValidate.name" placeholder="Enter your username">
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
    </i-row>
  </div>
</template>

<script>
export default {
  name: '',
  data () {
    return {
    }
  },
  computed: {
  },
  methods: {
  }
}
</script>

<style scoped>
  #user-register {
    height: 100vh;
    background: #FFEFDB;
    background-image: url("../../../../../../title.jpg");
    background-repeat: no-repeat;
  }
</style>
