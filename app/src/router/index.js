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
    },
    {
      path: '/register',
      name: 'Register',
      component: r => require(['../components/Register.vue'], r)
    },
    {
      path: '/select',
      name: 'Select',
      component: r => require(['../components/Select.vue'], r)
    },
    {
      path: '/book/:book_id',
      name: 'BookDetail',
      component: r => require(['../components/BookDetail.vue'], r)
    },
    {
      path: '/user',
      name: 'UserInfo',
      component: r => require(['../components/user/Information.vue'], r)
    },
    {
      path: '/create-order/:book_id',
      name: 'CreateOrder',
      component: r => require(['../components/user/CreateOrder.vue'], r)
    },
    {
      path: '/order/:order_id',
      name: 'OrderDetail',
      component: r => require(['../components/OrderDetail.vue'], r)
    },
    {
      path: '/user/new-book-seller',
      name: 'NewBookSeller',
      component: r => require(['../components/user/NewBookSeller.vue'], r)
    },
    {
      path: '/admin',
      component: r => require(['../components/admin/Layout.vue'], r),
      children: [
        {
          path: '/',
          name: 'Dashboard',
          component: r => require(['../components/admin/Dashboard.vue'], r)
        },
        {
          path: 'orderManager',
          name: 'OrderManager',
          component: r => require(['../components/admin/OrderManager.vue'], r)
        },
        {
          path: 'bookManager',
          name: 'BookManager',
          component: r => require(['../components/admin/BookManager.vue'], r)
        },
        {
          path: 'booksellerManager',
          name: 'BooksellerManager',
          component: r => require(['../components/admin/BooksellerManager.vue'], r)
        }
      ]
    },
    {
      path: '/bookSeller',
      component: r => require(['../components/bookseller/Layout.vue'], r),
      children: [
        {
          path: '/',
          name: 'DashboardBookSeller',
          component: r => require(['../components/bookseller/Dashboard.vue'], r)
        },
        {
          path: 'new-book',
          name: 'NewBook',
          component: r => require(['../components/bookseller/NewBook.vue'], r)
        },
        {
          path: 'orderManager',
          name: 'BookSellerOrderManager',
          component: r => require(['../components/bookseller/OrderManager.vue'], r)
        },
        {
          path: 'bookManager',
          name: 'BookSellerBookManager',
          component: r => require(['../components/bookseller/BookManager.vue'], r)
        }
      ]
    }
  ]
})
