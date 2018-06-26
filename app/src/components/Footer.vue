<template>
  <div class="Footer">
    <i-row style="height: auto">
      <i-col v-for="(data, idx) in List" :name="data.name" :key="idx" span="6" style="margin-top: 20px;">
        <div>{{data.name}}</div>
        <a v-for="(link, idx) in data.subLink" :href="link.link" :key="idx" onclick="false">
          {{link.name}}
        </a>
      </i-col>
    </i-row>
    <i-row style="height: auto; margin-top: 20px;">
      <i-col>
        <div>2018 &copy; Qian Kaihua, Wu Beichen, Zhong Xiangjie</div>
      </i-col>
    </i-row>
  </div>
</template>

<script>
export default {
  name: 'Footer',
  components: {
  },
  data () {
    return {
      List: [
        {
          name: '关于我们',
          subLink: [
            {
              name: '留言板',
              link: 'javascript:void(0);'
            },
            {
              name: '联系我们',
              link: 'javascript:void(0);'
            },
            {
              name: '关于网站',
              link: 'javascript:void(0);'
            }
          ]
        },
        {
          name: '购物指南',
          subLink: [
            {
              name: '购物流程',
              link: 'javascript:void(0);'
            },
            {
              name: '发票制度',
              link: 'javascript:void(0);'
            },
            {
              name: '账户管理',
              link: 'javascript:void(0);'
            },
            {
              name: '会员优惠',
              link: 'javascript:void(0);'
            }
          ]
        },
        {
          name: '快捷入口',
          subLink: [
            {
              name: '出版商管理',
              link: '/bookseller'
            },
            {
              name: '后台管理',
              link: '/admin'
            }
          ]
        },
        {
          name: '帮助中心',
          subLink: [
            {
              name: '常见问题',
              link: 'javascript:void(0);'
            },
            {
              name: '付款方式',
              link: 'javascript:void(0)'
            }
          ]
        }
      ]
    }
  }
}
</script>

<style scoped>
  .Footer {
    text-align: center;
    background-color: #C0C0C0;
    height: 250px;
    width: 100%;
    font-size: 150%;
    z-index: -1;
  }
  a {
    display: block;
    font-size: 12px;
    height: 24px;
    color: #6f6f6f;
  }
  a:hover {
    color: red;
    text-decoration: underline;
  }
</style>
