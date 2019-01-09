<template>
  <div>
    <section class="flex justify-between items-center">
      <planner-mode v-model="mode" />
      <div>
        <h1 class="text-xlg">{{ title }}</h1>
      </div>
      <date-navigator
        :current-date="currentDate"
        :mode="mode"
        @navigate="onNavigateDate"
      />
    </section>
    <section class="mt-4">
      <planner-month
        :current-date="currentDate"
        :events="events"
        @date-title="val => title = val"
        v-if="mode === 'month'"
      />
      <planner-week
        :current-date="currentDate"
        :events="events"
        @date-title="val => title = val"
        v-if="mode === 'week'"
      />
      <planner-day
        :current-date="currentDate"
        :events="events"
        @date-title="val => title = val"
        v-if="mode === 'day'"
      />
    </section>
  </div>
</template>

<script>
import DateNavigator from './date-navigator.vue'
import PlannerMode from './planner-mode.vue'
import PlannerMonth from './planner-month.vue'
import PlannerWeek from './planner-week.vue'
import PlannerDay from './planner-day.vue'

export default {
  name: 'Planner',
  components: { DateNavigator, PlannerMode, PlannerMonth, PlannerWeek, PlannerDay },
  props: {
    events: { default: () => [] }
  },
  data() {
    return {
      currentDate: this.$moment(),
      title: '',
      mode: 'month'
    }
  },
  methods: {
    onNavigateDate(currentDate) {
      this.currentDate = currentDate
    }
  }
}
</script>
