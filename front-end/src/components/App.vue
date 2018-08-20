<template>
  <div class="flex flex-col h-screen bg-grey-lighter">
    <AppHeader/>
    <div class="flex-grow flex">
      <NavDrawer v-show="drawer"/>
      <div>
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import AppHeader from './Header.vue';
import NavDrawer from './NavDrawer/NavDrawer.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    NavDrawer
  },
  computed: {
    ...mapState([
      'drawer'
    ])
  }
}
</script>