<template>
  <div>
    <h1 style="width: 100%; text-align: center;">个人信息</h1>
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
      <i-icon type="social-yen" :size="size"></i-icon>
      <span>余额： {{ user.money }}</span>
    </div>
    <div class="msg">
      <i-icon type="ios-time" :size="size"></i-icon>
      <span>创建时间： {{ user.createTime }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SelfInfo',
  props: ['user'],
  data () {
    return {
      size: 24
    }
  },
  computed: {
  },
  methods: {
  }
}
</script>

<style scoped>
  .msg {
    margin-top: 20px;
    font-size: 24px;
  }
</style>
