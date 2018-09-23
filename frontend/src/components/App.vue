<template>
  <div class="flex flex-col h-screen bg-page-background">
    <template v-if="isAuthenticated">
      <AppHeader/>
      <div class="flex-grow flex">
        <NavDrawer v-show="drawer"/>
        <div class="p-4 w-full h-full">
          <router-view></router-view>
        </div>
      </div>
    </template>
    <template v-if="!isAuthenticated">
      <router-view></router-view>
    </template>
    <dialogs-wrapper tag="div"/>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import AppHeader from './layouts/Header.vue'
import NavDrawer from './layouts/NavDrawer/NavDrawer.vue'

export default {
  name: 'App',
  components: {
    AppHeader,
    NavDrawer
  },
  computed: {
    ...mapState(['drawer']),
    ...mapGetters('auth', ['isAuthenticated'])
  },
  created() {
    this.validateAuth()
  },
  methods: {
    validateAuth() {
      if (this.isAuthenticated) {
        this.$store.dispatch('auth/validate').catch(response => {
          if (response.status === 401) {
            this.$router.push('/login')
          }
        })
      }
    }
  }
}
</script>
