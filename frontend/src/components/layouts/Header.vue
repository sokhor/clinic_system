<template>
  <header class="header flex items-center bg-blue-dark border-b border-blue-darker h-14">
    <div class="inline-block md:pl-8 md:pr-10 order-2 md:order-1 flex-auto md:flex-none text-center">
      <router-link to="/">
        <img src="../../assets/logo.svg" width="89" class="inline-block">
      </router-link>
    </div>
    <button type="button" @click="toggleNavigation" class="flex items-center text-white ml-4 md:ml-0 focus:outline-none order-1 md:order-2">
      <svg class="fill-current h-5 w-5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <title>Menu</title>
        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
      </svg>
    </button>
    <div class="flex-auto order-3 hidden md:inline-block"></div>
    <ul class="list-reset pr-4 order-5">
      <li>
        <BaseDropDown>
          <BaseButton flat class="focus:outline-none text-xl">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-5 h-5">
              <circle cx="16" cy="7.5" r="7.4"/>
              <path d="M16,18C7.7,18,1,24.3,1,32h30C31,24.3,24.3,18,16,18z"/>
            </svg>
          </BaseButton>
          <ul class="list-reset" slot="dropdown-items">
            <li class="whitespace-no-wrap">
              <a href="#" class="no-underline text-grey-darkest" @click.prevent="logOut">
                <i class="fas fa-sign-out-alt"></i> Signout
              </a>
            </li>
          </ul>
        </BaseDropDown>
      </li>
    </ul>
  </header>
</template>

<script>
import { mapMutations } from 'vuex'

export default {
  name: 'Header',
  methods: {
    ...mapMutations(['toggleNavigation']),
    async logOut() {
      await this.$store.dispatch('auth/logOut')

      this.$router.push('/login')
    }
  }
}
</script>
