<template>
  <li class="relative m-0" :class="classList" @click="hideMobile">
    <slot></slot>
  </li>
</template>

<script>
  export default {
    name: 'sidebar-nav-item',
    props: {
      classes: {
        type: String,
        default: ''
      }
    },
    computed: {
      classList () {
        return [
          'nav-item',
          ...this.itemClasses
        ]
      },
      itemClasses () {
        return this.classes ? this.classes.split(' ') : ''
      }
    },
    methods: {
      hideMobile () {
        if (document.body.classList.contains('sidebar-mobile-show')) {
          document.body.classList.toggle('sidebar-mobile-show')
        }
      }
    }
  }
</script>

<style lang="scss">
.nav-item {
  // transition: background .3s ease-in-out;
}
</style>