<template>
  <div>
    <Header class="layout-header-bar">
      <Breadcrumb>
        <BreadcrumbItem href="/admin">Home</BreadcrumbItem>
        <BreadcrumbItem>书商申请管理</BreadcrumbItem>
      </Breadcrumb>
    </Header>
    <i-content :style="{margin: '20px', background: '#fff', minHeight: '500px'}">
      BooksellerManager
    </i-content>
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
  .layout-header-bar{
    background: #fff;
    box-shadow: 0 1px 1px rgba(0,0,0,.1);
  }
</style>
