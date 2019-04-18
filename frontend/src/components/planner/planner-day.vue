<template>
  <div>
    <div class="flex">
      <div
        class="border py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold w-24"
      ></div>
      <div class="flex flex-grow">
        <div
          class="w-full border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold"
          :class="{ 'text-blue': isToday(currentDate) }"
        >
          {{ currentDate.format('ddd M/D').toUpperCase() }}
        </div>
      </div>
    </div>
    <simplebar
      class="planner-scrollbar"
      data-simplebar-auto-hide="true"
      ref="simple-scrollbar"
    >
      <div class="flex">
        <div>
          <div
            v-for="timeOfDay in timesOfDay"
            class="w-24 h-16 border border-t-0 py-1 text-center text-grey-dark text-sm font-semibold"
          >
            {{ timeOfDay.format('hha') }}
          </div>
        </div>
        <div class="flex-grow">
          <div
            v-for="timeOfDay in timesOfDay"
            class="h-16 border border-t-0 border-l-0 py-1 text-center text-grey-dark text-sm"
            @click.stop="addEvent(timeOfDay)"
          >
            <div class="text-left mr-2">
              <span
                v-for="event in specificTimeEvents(timeOfDay)"
                class="block bg-indigo text-white text-xs p-1 mt-1 rounded truncate cursor-pointer"
                :title="event.text"
                @click.stop="eventClick(event)"
              >
                {{ event.text }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </simplebar>
  </div>
</template>

<script>
import simplebar from '@/components/simple-scrollbar.vue'

export default {
  name: 'PlannerDay',
  components: {
    simplebar
  },
  props: {
    currentDate: {},
    events: { default: () => [] }
  },
  computed: {
    datesOfWeek() {
      let dates = []
      const diffBeforeDays = this.currentDate.diff(
        this.$moment(this.currentDate).startOf('week'),
        'days'
      )
      const diffAfterDays = this.$moment(this.currentDate)
        .endOf('week')
        .diff(this.currentDate, 'days')

      for (let i = 0; i < diffBeforeDays; i++) {
        dates.push(
          this.$moment(this.currentDate)
            .startOf('week')
            .add(i, 'days')
        )
      }

      dates.push(this.currentDate)

      for (let i = 1; i <= diffAfterDays; i++) {
        dates.push(this.$moment(this.currentDate).add(i, 'days'))
      }

      return dates
    },
    timesOfDay() {
      const startTime = this.$moment(this.currentDate).startOf('day')
      const endTime = this.$moment(this.currentDate).endOf('day')
      const interval = endTime.diff(startTime, 'hour')
      let times = []

      for (let i = 0; i <= interval; i++) {
        times.push(this.$moment(startTime).add(i, 'hours'))
      }

      return times
    },
    inCurrentMonth: vm => date => {
      return vm.currentDate.isSame(date, 'month')
    },
    isToday: vm => date => {
      return vm.$moment().isSame(date, 'day')
    },
    title() {
      return (
        this.currentDate.format('MMMM') + ' ' + this.currentDate.format('YYYY')
      )
    },
    specificTimeEvents: vm => timeOfDay => {
      return vm.events.filter(
        ev =>
          vm
            .$moment(vm.currentDate)
            .isSame(vm.$moment(ev.date, 'DD-MM-YYYY HH:mm:ss'), 'day') &&
          timeOfDay.format('HH') ===
            vm.$moment(ev.date, 'DD-MM-YYYY HH:mm:ss').format('HH')
      )
    }
  },
  mounted() {
    this.moveScrollToCurrentTime()
  },
  watch: {
    title: {
      handler(val) {
        this.$emit('date-title', val)
      },
      immediate: true
    }
  },
  methods: {
    addEvent(date) {
      this.$parent.$emit('add-new-event', date)
    },
    eventClick(event) {
      this.$parent.$emit('event-click', event)
    },
    moveScrollToCurrentTime() {
      const el = this.$refs['simple-scrollbar'].$el.SimpleBar
      const interval = this.$moment().diff(
        this.$moment().startOf('day'),
        'hour'
      )

      el.contentEl.scrollTop =
        4 *
        parseFloat(getComputedStyle(document.documentElement).fontSize) *
        interval
    }
  }
}
</script>

<style>
.planner-scrollbar {
  height: calc(4rem * 12);
}
</style>
