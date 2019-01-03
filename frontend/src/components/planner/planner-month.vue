<template>
  <div>
    <div class="flex">
      <span class="flex-1 border py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">MON</span>
      <span class="flex-1 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">TUE</span>
      <span class="flex-1 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">WED</span>
      <span class="flex-1 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">THU</span>
      <span class="flex-1 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">FRI</span>
      <span class="flex-1 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">SAT</span>
      <span class="flex-1 border border-l-0 py-1 text-center text-grey-dark text-sm bg-grey-lighter font-semibold">SUN</span>
    </div>
    <div class="flex" v-for="(dates, index7days) in datesOfMonth">
      <div
        v-for="(date, indexDay) in dates"
        class="flex-1 h-32 border border-t-0 text-center cursor-pointer"
        :class="[{'border-l-0': indexDay>0}]"
      >
        <div class="flex justify-center items-center mt-1">
          <span
            class="block h-8 w-8 leading-loose font-semibold"
            :class="[
              {'text-grey-darkest': inCurrentMonth(date)},
              {'text-grey': !inCurrentMonth(date)},
              {'bg-blue text-white rounded-full': isToday(date)}
            ]"
          >
            {{ date.format('D') }}
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
    currentDate: {}
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
      return date.format('MM') === vm.$moment(vm.currentDate).format('MM')
    },
    isToday: vm => date => {
      return (
        vm.$moment().format('DD-MM-YYYY') ==
        vm.$moment(date).format('DD-MM-YYYY')
      )
    },
    title() {
      return (
        this.currentDate.format('MMMM') + ' ' + this.currentDate.format('YYYY')
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
  }
}
</script>
