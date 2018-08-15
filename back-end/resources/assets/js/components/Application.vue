<template>
  <div class="flex flex-col h-screen bg-grey-lighter">
    <AppHeader/>
    <div class="flex-grow flex">
      <NavDrawer/>
      <div>
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import AppHeader from './Header.vue';
import NavDrawer from './NavDrawer.vue';

export default {
  name: 'Application',
  components: {
    AppHeader,
    NavDrawer
  }
}
</script>