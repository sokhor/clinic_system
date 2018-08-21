<template>
  <div class="flex flex-col h-screen bg-grey-lighter">
    <AppHeader/>
    <div class="flex-grow flex">
      <NavDrawer v-show="drawer"/>
      <div class="p-4 w-full h-full">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import AppHeader from './layouts/Header.vue';
import NavDrawer from './layouts/NavDrawer/NavDrawer.vue';

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