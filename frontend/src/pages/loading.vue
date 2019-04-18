<script>
export default {
  page: {
    title: 'Loading page...',
    meta: [{ name: 'description', content: 'Loading page...' }]
  }
}
</script>

<template>
  <Transition appear>
    <BaseIcon :class="$style.loadingIcon" name="fa-spinner" spin />
  </Transition>
</template>

<style lang="scss" module>
.loadingIcon {
  display: block;
  margin: 0 auto;

  &:global(.v-enter-active) {
    transition: opacity 1s;
  }

  &:global(.v-enter) {
    opacity: 0;
  }
}
</style>
