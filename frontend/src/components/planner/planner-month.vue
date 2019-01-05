<template>
  <div>
    <div class="flex">
      <span class="w-1/7 border py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">MON</span>
      <span class="w-1/7 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">TUE</span>
      <span class="w-1/7 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">WED</span>
      <span class="w-1/7 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">THU</span>
      <span class="w-1/7 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">FRI</span>
      <span class="w-1/7 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">SAT</span>
      <span class="w-1/7 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">SUN</span>
    </div>
    <div class="flex" v-for="(dates, index7days) in datesOfMonth">
      <div
        v-for="(date, indexDay) in dates"
        class="w-1/7 h-32 border border-t-0 text-center"
        :class="[{'border-l-0': indexDay>0}]"
        @click="addEvent(date)"
      >
        <div class="flex justify-center items-center mt-1">
          <span
            class="block h-8 w-8 leading-loose font-semibold"
            :class="[
              {'text-grey-darkest': inCurrentMonth(date)},
              {'text-grey': !inCurrentMonth(date)},
              {'bg-blue text-white rounded-full shadow': isToday(date)}
            ]"
          >
            {{ date.format('D') }}
          </span>
        </div>
        <div class="text-left mr-2">
          <span
            v-for="event in specificDaysEvents(date)"
            class="block bg-indigo text-white text-xs p-1 mt-1 rounded truncate"
            :title="event.text"
          >
            {{ event.text }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PlannerMonth',
  props: {
    currentDate: {},
    events: { default: () => [] }
  },
  computed: {
    datesOfMonth() {
      let date = []

      for (
        let i = this.$moment(this.currentDate)
          .startOf('month')
          .weekday();
        i > 0;
        i--
      ) {
        date.push(
          this.$moment(this.currentDate)
            .startOf('month')
            .add(i * -1, 'days')
        )
      }

      for (
        let j = 0;
        j <
        this.$moment(this.currentDate)
          .endOf('month')
          .format('DD');
        j++
      ) {
        date.push(
          this.$moment(this.currentDate)
            .startOf('month')
            .add(j, 'days')
        )
      }

      for (
        let k = 1;
        k <=
        6 -
          this.$moment(this.currentDate)
            .endOf('month')
            .weekday();
        k++
      ) {
        date.push(
          this.$moment(this.currentDate)
            .endOf('month')
            .add(k, 'days')
        )
      }

      return _.chunk(date, 7)
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
    specificDaysEvents: vm => date => {
      return vm.events.filter(ev =>
        date.isSame(vm.$moment(ev.date, 'DD-MM-YYYY HH:mm:ss'), 'day')
      )
    }
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
    }
  }
}
</script>
