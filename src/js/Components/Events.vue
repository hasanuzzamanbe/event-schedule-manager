<template>
  <div>
    <ul class="event_card_wrapper">
        <h3>All Events</h3>
      <li v-for="event in events" :key="event.id">
        <router-link :to="'/' + event.id + '/all'">
          <div class="event_card">
            {{ event.title }}
          </div>
        </router-link>
      </li>
    </ul>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  data () {
    return {
      events: [
        {
          id: 1,
          title: 'Event 1'
        },
        {
          id: 2,
          title: 'Event 2'
        }
      ]
    }
  }
}
</script>
<style>
.event_card_wrapper {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  flex-direction: column;
  align-content: space-around;
}

.event_card {
  padding: 23px;
  border: 1px solid #ccc;
  width: 300px;
}
</style>
