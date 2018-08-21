<template>
  <header class="header flex items-center bg-white border-b border-grey h-14">
    <div class="inline-block md:pl-8 md:pr-10 order-2 md:order-1 flex-auto md:flex-none text-center">
      <router-link to="/">
        <img src="../../assets/logo.svg" width="89" class="inline-block">
      </router-link>
    </div>
    <button type="button" @click="toggleNavigation" class="flex items-center text-grey-dark ml-4 md:ml-0 focus:outline-none order-1 md:order-2">
      <svg class="fill-current h-5 w-5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <title>Menu</title>
        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
      </svg>
    </button>
    <div class="flex-auto order-3 hidden md:inline-block"></div>
    <ul class="list-reset pr-4 order-5">
      <li>
        <button type="button" class="focus:outline-none">
          <img src="../../assets/user.png" alt="Avatar" class="rounded-full h-10">
        </button>
        <!-- <div aria-labelledby="__BVID__39__BV_button_" class="dropdown-menu dropdown-menu-right">
          <a role="menuitem" href="#" target="_self" class="dropdown-item"><i class="fa fa-lock"></i> Logout</a>
        </div> -->
      </li>
    </ul>
  </header>
</template>

<script>
import { mapMutations } from 'vuex';

export default {
  name: 'Header',
  methods: {
    ...mapMutations([
      'toggleNavigation'
    ])
  }
}
</script>