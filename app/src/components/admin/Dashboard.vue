<template>
  <div>
    <Header class="layout-header-bar">
      <Breadcrumb>
        <BreadcrumbItem>Home</BreadcrumbItem>
        <BreadcrumbItem>DashBoard</BreadcrumbItem>
      </Breadcrumb>
    </Header>
    <i-content :style="{margin: '20px', background: '#fff', minHeight: '500px'}">
      <div class="canvas-content">
        <schart :canvasId="table1.canvasId" :type="table1.type"
                :data="table1.data" :options="table1.options"
                class="canvas"
        ></schart>
      </div>
      <div class="canvas-content">
        <schart :canvasId="table2.canvasId" :type="table2.type"
                :data="table2.data" :options="table2.options"
                class="canvas"
        ></schart>
      </div>
    </i-content>
  </div>
</template>

<script>
import Schart from 'vue-schart'
export default {
  components: {
    Schart
  },
  name: '',
  data () {
    return {
      table1: {
        canvasId: 'order',
        type: 'bar',
        data: [
          {name: '2014', value: 1342},
          {name: '2015', value: 1548},
          {name: '2016', value: 1654},
          {name: '2017', value: 1795},
          {name: '2018', value: 1879}
        ],
        options: {
          padding: 50,
          bgColor: '#FFFFFF',
          title: '各年订单数据',
          titleColor: '#000000',
          titlePosition: 'top',
          yEqual: 5,
          fillColor: '#1E9FFF',
          contentColor: '#eeeeee',
          axisColor: '#666666'
        }
      },
      table2: {
        canvasId: 'user',
        type: 'line',
        data: [
          {name: '2014', value: 235},
          {name: '2015', value: 346},
          {name: '2016', value: 516},
          {name: '2017', value: 1325},
          {name: '2018', value: 1879}
        ],
        options: {
          padding: 50,
          bgColor: '#FFFFFF',
          title: '用户总数',
          titleColor: '#000000',
          titlePosition: 'top',
          yEqual: 5,
          fillColor: '#1E9FFF',
          contentColor: '#eeeeee',
          axisColor: '#666666'
        }
      }
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
    box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
  }
  .canvas {
    width: 400px;
    height: 400px;
  }
  .canvas-content {
    display: inline-block !important;
    margin-left: 90px;
    margin-top: 50px;
  }
</style>
