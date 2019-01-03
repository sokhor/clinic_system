<template>
  <div>
    <section class="flex justify-between items-center">
      <planner-mode />
      <div>
        <h1 class="text-xlg">{{ title }}</h1>
      </div>
      <date-navigator
        :current-date="currentDate"
        @navigate="onNavigateDate"
      />
    </section>
    <section class="mt-4">
      <planner-month
        :current-date="currentDate"
        @date-title="val => title = val"
      />
    </section>
  </div>
</template>

<script>
import PlannerMonth from './planner-month.vue'
import DateNavigator from './date-navigator.vue'
import PlannerMode from './planner-mode.vue'

export default {
  name: 'Planner',
  components: { PlannerMonth, DateNavigator, PlannerMode },
  data() {
    return {
      currentDate: this.$moment(),
      title: ''
    }
  },
  methods: {
    onNavigateDate(currentDate) {
      this.currentDate = currentDate
    }
  }
}
</script>
