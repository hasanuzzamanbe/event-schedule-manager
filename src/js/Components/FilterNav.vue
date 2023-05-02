<template>
  <div class="speaker_filter_nav">
    <router-link to="/">All</router-link>
    <router-link to="/selected">Selected</router-link>
    <router-link to="/waiting">Waiting</router-link>
    <router-link to="/rejected">Rejected</router-link>
  </div>
</template>
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
