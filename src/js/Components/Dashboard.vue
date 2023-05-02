<template>
  <div>
    <router-link :to="{name: 'events'}">Back to all events</router-link> /  {{ path }}
    
    <router-view></router-view>
  </div>
</template>
<script>
export default {
  name: 'Dashboard',
  data () {
    return {
      path: ''
    }
  },
  mounted () {
    this.path = this.$route.params.id
  }
}
</script>
