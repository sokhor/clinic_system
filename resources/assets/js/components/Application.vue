<template>
  <div class="flex flex-col h-screen">
    <AppHeader/>
    <div class="flex-grow flex">
      <Sidebar/>
      <div>
        <router-view></router-view>
      </div>
    </div>
    <AppFooter/>
  </div>
</template>

<script>
import AppHeader from './Header.vue';
import AppFooter from './Footer.vue';
import Sidebar from './Sidebar.vue';

export default {
  name: 'Application',
  components: {
    AppHeader,
    AppFooter,
    Sidebar
  }
}
</script>