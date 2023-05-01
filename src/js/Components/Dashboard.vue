<template>
  <div>
    <h1>Applications:</h1>
    <filter-nav></filter-nav>
    <Speaker @fetch="fetch" :speakers="speakers"></Speaker>
  </div>
</template>

<script>
import Speaker from './Speaker.vue'
import FilterNav from './FilterNav.vue'
export default {
  name: 'App',
  components: {},
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
        route: 'get_data'
        // options: {
        // //   not_status: ['rejected', 'approved']
        // }
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

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

li.speaker_applicant {
  text-align: left;
  max-width: 444px;
  flex: 0 1 auto;
  width: 100%;
}

.speaker-menu {
  text-align: center;
  padding: 19px;
  a {
    padding: 8px;
  }
  a.router-link-exact-active {
    background: yellow;
  }
  a::focus {
    outline: none;
  }
}

.speakers {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  justify-content: space-between;

  .applied-at {
    font-size: 12px;
  }

  img.avatar {
    border-radius: 50%;
  }

  .profile-section {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;

    .profile-left-col {
      width: 75%;
      text-align: left;
      font-size: 14px;
    }

    .profile-right-col {
      width: 25%;
    }
  }

  p.application-status {
    &-waiting {
      background: #d7d59d;
      padding: 2px 6px;
      border-radius: 5px;
    }
    &-approved {
      background: #a3d7a3;
      padding: 2px 6px;
      border-radius: 5px;
    }
    &-rejected {
      background: #f66565;
      color: white;
      padding: 2px 6px;
      border-radius: 5px;
    }
  }

  .action {
    cursor: pointer;
    color: forestgreen;
    font-weight: 500;
  }
}
</style>
