<template>
  <div>
    <h1>Selected</h1>
    <filter-nav></filter-nav>
    <speaker @fetch="fetch" :speakers="speakers"></speaker>
  </div>
</template>
<script>
import Speaker from './Speaker.vue'
import FilterNav from './FilterNav.vue'
export default {
  name: 'Rejected',
  data () {
    return {
      speakers: []
    }
  },
  components: {
    Speaker,
    FilterNav
  },
  methods: {
    fetch () {
      this.$get({
        action: 'speakers_admin_ajax',
        route: 'get_data',
        options: {
          status: ['approved']
        }
      }).then(response => {
        this.speakers = response.data
      })
    }
  },
  mounted () {
    this.fetch()
  }
}
</script>
