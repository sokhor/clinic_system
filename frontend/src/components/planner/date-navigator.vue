<template>
  <div class="rounded border h-10">
    <a
      href="#"
      @click.prevent="navigate('previous')"
      class="inline-flex items-center justify-center w-16 h-full no-underline text-center text-gray-800 text-sm hover:bg-grey-lightest border-r"
      >&lt;</a
    >
    <a
      href="#"
      @click.prevent="navigate('today')"
      class="inline-flex items-center justify-center w-16 h-full no-underline text-center text-gray-800 text-sm hover:bg-grey-lightest border-r"
      >Today</a
    >
    <a
      href="#"
      @click.prevent="navigate('next')"
      class="inline-flex items-center justify-center w-16 h-full no-underline text-center text-gray-800 text-sm hover:bg-grey-lightest"
      >&gt;</a
    >
  </div>
</template>

<script>
export default {
  name: 'DateNavigator',
  props: {
    currentDate: {},
    mode: { type: String, default: 'month' }
  },
  computed: {
    previous() {
      return this.$moment(this.currentDate).add(-1, this.mode)
    },
    next() {
      return this.$moment(this.currentDate).add(1, this.mode)
    }
  },
  methods: {
    navigate(value) {
      if (value === 'previous') {
        this.$emit('navigate', this.previous)
      } else if (value === 'today') {
        this.$emit('navigate', this.$moment())
      } else if (value === 'next') {
        this.$emit('navigate', this.next)
      }
    }
  }
}
</script>
