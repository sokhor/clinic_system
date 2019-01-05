<template>
  <div class="h-10 overflow-hidden">
    <a
      href="#"
      class="inline-flex items-center justify-center w-24 h-full no-underline text-center text-sm rounded-l"
      :class="[buttonStateMonth]"
      @click.prevent="toggle('month')"
    >Month</a>
    <a
      href="#"
      class="inline-flex items-center justify-center w-24 h-full no-underline text-center text-sm"
      :class="[buttonStateWeek]"
      @click.prevent="toggle('week')"
    >Week</a>
    <a
      href="#"
      class="inline-flex items-center justify-center w-24 h-full no-underline text-center text-sm rounded-r"
      :class="[buttonStateDay]"
      @click.prevent="toggle('day')"
    >Day</a>
  </div>
</template>

<script>
export default {
  name: 'PlannerMode',
  props: ['buttonState'],
  model: {
    prop: 'buttonState',
    event: 'button-state-change'
  },
  computed: {
    buttonStateMonth() {
      if (this.buttonState === 'month') {
        return {
          'text-blue cursor-default border-l-2 border-t-2 border-b-2 border-blue': true
        }
      }

      return {
        'text-white bg-blue hover:bg-blue-light shadow': true
      }
    },
    buttonStateWeek() {
      if (this.buttonState === 'week') {
        return {
          'text-blue cursor-default border-t-2 border-b-2 border-blue': true
        }
      }

      return {
        'text-white bg-blue hover:bg-blue-light shadow': true
      }
    },
    buttonStateDay() {
      if (this.buttonState === 'day') {
        return {
          'text-blue cursor-default border-r-2 border-t-2 border-b-2 border-blue': true
        }
      }

      return {
        'text-white bg-blue hover:bg-blue-light shadow': true
      }
    }
  },
  methods: {
    toggle(buttonState) {
      if (this.buttonState === buttonState) return

      this.$emit('button-state-change', buttonState)
    }
  }
}
</script>
