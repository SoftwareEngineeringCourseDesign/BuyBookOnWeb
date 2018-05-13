// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import iView from 'iview'
import 'iview/dist/styles/iview.css'
// import State from './components/State.vue'
import lodash from 'lodash'
import axios from 'axios'

Vue.use(iView)

Vue.config.productionTip = false

axios.defaults.baseURL = '/api/'
Vue._ = Vue.prototype._ = window._ = Window.prototype._ = lodash
Vue.$http = Vue.prototype.$http = axios

window.title_suf = '|网上书店'
// Vue.prototype.GLOBAL = State

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
}).$mount('#app')
