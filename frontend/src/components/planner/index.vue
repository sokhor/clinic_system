<template>
  <div>
    <section class="flex justify-between items-center">
      <planner-mode v-model="buttonState" />
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
        :events="events"
        @date-title="val => title = val"
        v-if="buttonState === 'month'"
      />
      <planner-week
        :current-date="currentDate"
        :events="events"
        @date-title="val => title = val"
        v-if="buttonState === 'week'"
      />
    </section>
  </div>
</template>

<script>
import DateNavigator from './date-navigator.vue'
import PlannerMode from './planner-mode.vue'
import PlannerMonth from './planner-month.vue'
import PlannerWeek from './planner-week.vue'

export default {
  name: 'Planner',
  components: { DateNavigator, PlannerMode, PlannerMonth, PlannerWeek },
  props: {
    events: { default: () => [] }
  },
  data() {
    return {
      currentDate: this.$moment(),
      title: '',
      buttonState: 'month'
    }
  },
  methods: {
    onNavigateDate(currentDate) {
      this.currentDate = currentDate
    }
  }
}
</script>
