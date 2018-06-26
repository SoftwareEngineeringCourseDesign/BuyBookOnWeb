<template>
  <p style="display: inline-block;">
    <span>
      <i-icon type="ios-star" v-for="i in Star.full" :key="i" color="#fb0" size="24"></i-icon>
      <i-icon type="ios-star-half" v-if="Star.half" color="#fb0" size="24"></i-icon>
      <i-icon type="ios-star-outline" v-for="i in Star.null" :key="i * 10" color="#fb0" size="24"></i-icon>
      {{ Star.score }}
    </span>
  </p>
</template>

<script>
export default {
  props: ['score'],
  name: 'Star',
  data () {
    return {
    }
  },
  computed: {
    Star: function () {
      let star = Math.round(this.score)
      let full = Math.floor(star / 2)
      let half = !!Math.round(star % 2)
      let outline = 5 - full - (half ? 1 : 0)
      let score = this.toDecimal2(this.score)
      return {
        full: full,
        half: half,
        null: outline,
        score: score
      }
    }
  },
  methods: {
    toDecimal2: function (x) {
      let f = Math.round(x * 10) / 10
      let s = f.toString()
      let rs = s.indexOf('.')
      if (rs < 0) {
        rs = s.length
        s += '.'
      }
      while (s.length <= rs + 1) {
        s += '0'
      }
      return s
    }
  }
}
</script>

<style scoped>
</style>
