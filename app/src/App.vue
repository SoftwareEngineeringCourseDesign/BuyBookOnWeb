<template>
  <div id="app">
    <router-view :key="key"></router-view>
    <i-footer></i-footer>
    <i-back-top></i-back-top>
  </div>
</template>

<script>
import iFooter from '../src/components/Footer.vue'
export default {
  name: 'App',
  components: {
    iFooter
  },
  beforeMount: function () {
    this.$store.commit('SET_API_TOKEN', localStorage.token === undefined ? '' : JSON.parse(localStorage.token))
    this.$store.commit('SET_AUTH_USER', localStorage.authUser === undefined ? '' : JSON.parse(localStorage.authUser))
    console.log('-----------------------------\n' +
      '若想申请成为bookseller\n或是想参与开发该网站\n' +
      '请联系管理员\n' +
      'GitHub: https://github.com/qiankaihua\n' +
      '-----------------------------')
  },
  data () {
    return {
    }
  },
  computed: {
    key () {
      // add key to <router-view> to avoid re-use component
      console.log('re-generate key')
      return this.$route.name !== undefined
        ? this.$route.name + +new Date()
        : this.$route + +new Date()
    }
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
</style>
