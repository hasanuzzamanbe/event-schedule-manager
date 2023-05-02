<template>
  <div>
    <div class="speaker-menu">
        <router-link :to="{ params: { id: eventId }, name: 'applicants' }">Applicants</router-link>
        <router-link :to="{ params: { id: eventId }, name: 'slots' }">Slots</router-link>
    </div>
    <div class="speaker_filter_nav">
      <router-link :to="{ params: { id: eventId }, name: 'applicants' }"
        >All</router-link
      >
      <router-link :to="{ params: { id: eventId }, name: 'selected' }"
        >Selected</router-link
      >
      <router-link :to="{ params: { id: eventId }, name: 'waiting' }"
        >Waiting</router-link
      >
      <router-link :to="{ params: { id: eventId }, name: 'rejected' }"
        >Rejected</router-link
      >
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      eventId: ''
    }
  },
  mounted () {
    this.eventId = this.$route.params.id
  }
}
</script>
<style lang="scss">
.speaker_filter_nav {
  a {
    padding: 3px 18px;
    border: 1px solid;
    text-decoration: none;
  }
  .router-link-exact-active.active {
    background: #ebf808;
  }
}
</style>
