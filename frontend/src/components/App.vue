<template>
  <div
    class="flex flex-col bg-page-background"
    :style="{ 'min-height': windowHeight }"
  >
    <template v-if="isAuthenticated">
      <AppHeader class="fixed inset-x-0 z-50" />
      <NavDrawer
        class="fixed inset-l-0 inset-y-0 z-40 mt-16 nav-drawer"
        :class="{ 'nav-drawer__open': drawer }"
      />
      <div
        class="flex-grow flex min-h-screen pt-16 content-wrapper"
        :class="{ 'content-wrapper__open': drawer }"
      >
        <div class="p-8 w-full">
          <router-view></router-view>
        </div>
      </div>
    </template>
    <template v-if="!isAuthenticated">
      <router-view></router-view>
    </template>
    <dialogs-wrapper tag="div" />
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
import AppHeader from './Header.vue'
import NavDrawer from './NavDrawer/NavDrawer.vue'

export default {
  name: 'App',
  components: {
    AppHeader,
    NavDrawer
  },
  data() {
    return {
      windowHeight: null
    }
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

<style lang="sass">
.nav-drawer
  overflow-y: auto
  margin-left: -200px
  transition: margin-left 0.5s ease

  &__open
    margin-left: 0

.content-wrapper
  margin-left: 0
  transition: margin-left 0.5s ease

  &__open
    margin-left: 200px
</style>
