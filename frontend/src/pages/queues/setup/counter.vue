<template>
  <base-card class="w-32 h-32 flex justify-center items-center">
    <p class="text-center">
      <span class="block text-grey-light text-sm">Counter</span>
      <span>{{ counter.label }}</span>
    </p>
  </base-card>
</template>

<script>
export default {
  name: 'QueueCounter',
  props: ['counter']
}
</script>
