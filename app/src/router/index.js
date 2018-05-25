import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Index',
      component: r => require(['../components/Index.vue'], r)
    },
    {
      path: '/login',
      name: 'Login',
      component: r => require(['../components/Login.vue'], r)
    }
  ]
})
