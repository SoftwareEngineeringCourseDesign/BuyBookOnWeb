<template>
  <div class="layout">
    <i-header style="position: fixed; width: 100%; z-index: 999; margin-top: -2px;"></i-header>
    <Layout style="margin-top: 58px;">
      <Sider breakpoint="md" collapsible :collapsed-width="78" v-model="isCollapsed">
        <i-menu
          theme="dark"
          width="auto"
          :class="menuitemClasses"
          :active-name="$route.name"
          @on-select="$router.push({ name: $event, params: {id: $store.state.auth.authUser.id} })"
          :default-active="$route.name" :accordion=true>
          <i-menu-item v-for="(side, idx) in SideBar" :name="side.name" :key="idx">
            <i-icon :type="side.icon"></i-icon>
            <span>{{ side.title }}</span>
          </i-menu-item>
        </i-menu>
        <div slot="trigger"></div>
      </Sider>
      <Layout>
          <router-view></router-view>
      </Layout>
    </Layout>
  </div>
</template>

<script>
import iHeader from '../Header.vue'
import iView from 'iview'
export default {
  components: {
    iHeader
  },
  name: '',
  data () {
    return {
      isCollapsed: false,
      user: [],
      SideBar: [
        {
          name: 'DashboardBookSeller',
          icon: 'home',
          title: '主页'
        },
        {
          name: 'NewBook',
          icon: 'ios-navigate',
          title: '新书上架申请'
        },
        {
          name: 'BookSellerBookManager',
          icon: 'search',
          title: '书籍管理'
        },
        {
          name: 'BookSellerOrderManager',
          icon: 'settings',
          title: '订单管理'
        }
      ]
    }
  },
  created: function () {
    this.$http.get('user/' + this.$store.state.auth.authUser, {params: {token: this.$store.state.auth.token}})
      .then((r) => {
        this.user = r.data
        if (this.user.role.alias !== 'bookseller') {
          this.$Notice.error({ title: '您暂未成为书商' })
          this.$router.push({ name: 'Index' })
        }
      })
      .catch((e) => {
        iView.Notice.error({title: '暂未登录'})
        this.$router.push({ name: 'Login' })
      })
    document.title = '管理界面' + window.title_suf
  },
  computed: {
    menuitemClasses: function () {
      return [
        'menu-item',
        this.isCollapsed ? 'collapsed-menu' : ''
      ]
    }
  },
  methods: {
  }
}
</script>

<style scoped>
  .layout{
    border: 1px solid #d7dde4;
    background: #f5f7f9;
    position: relative;
    border-radius: 4px;
    overflow: hidden;
  }
  .menu-item span{
    display: inline-block;
    overflow: hidden;
    width: 100px;
    text-overflow: ellipsis;
    white-space: nowrap;
    vertical-align: bottom;
    transition: width .2s ease .2s;
  }
  .menu-item i{
    transform: translateX(0px);
    transition: font-size .2s ease, transform .2s ease;
    vertical-align: middle;
    font-size: 16px;
  }
  .collapsed-menu span{
    width: 0px;
    transition: width .2s ease;
  }
  .collapsed-menu i{
    transform: translateX(5px);
    transition: font-size .2s ease .2s, transform .2s ease .2s;
    vertical-align: middle;
    font-size: 22px;
  }
</style>
