<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Appointment</h1>
    </div>
    <div class="flex -mx-4">
      <div class="w-5/7 px-4">
        <base-card class="p-4">
          <calendar-planner />
        </base-card>
      </div>
      <div class="w-2/7 px-4"></div>
    </div>
  </div>
</template>

<script>
import CalendarPlanner from '@/components/planner/index.vue'

export default {
  name: 'Appointment',
  components: { CalendarPlanner }
}
</script>
