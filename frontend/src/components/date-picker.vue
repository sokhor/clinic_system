<template>
  <div class="bg-white shadow-lg rounded p-4">
    <div class="box-body">
      <div class="calendar">
        <div class="calendar-header">
          <div class="flex justify-between">
            <a href="#" class="text-gray-700" @click.prevent="previous">
              <i class="fas fa-chevron-left"></i>
            </a>
            <div class="uppercase text-gray-700 font-bold">
              {{ month }} {{ year }}
            </div>
            <a href="#" class="text-gray-700" @click.prevent="next">
              <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>
        <div class="mt-5">
          <div class="flex">
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-gray-600"
            >
              Mon
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-gray-600"
            >
              Tue
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-gray-600"
            >
              Wed
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-gray-600"
            >
              Thu
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-gray-600"
            >
              Fri
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-gray-600"
            >
              Sat
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-gray-600"
            >
              Sun
            </div>
          </div>
          <div
            v-for="(dates, index7days) in datesOfMonth"
            :key="index7days"
            class="flex"
            :class="{
              'last-week-of-month': index7days === datesOfMonth.length - 1
            }"
          >
            <div
              v-for="(date, indexDay) in dates"
              :key="indexDay"
              class="group w-1/7 text-center p-1 cursor-pointer"
              :class="[
                inCurrentMonth(date) ? 'text-gray-800' : 'text-gray-500',
                { 'last-day-of-week': indexDay === dates.length - 1 }
              ]"
              @click="selectDate(date)"
            >
              <span
                :class="[
                  'flex items-center justify-center w-8 h-8 rounded-full',
                  isToday(date)
                    ? 'text-white bg-red-500'
                    : 'group-hover:bg-gray-300 group-hover:opacity-75'
                ]"
              >
                {{ date.format('D') }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment'
import { chunk } from 'lodash'

export default {
  data() {
    return {
      currentDate: moment()
    }
  },
  computed: {
    datesOfMonth() {
      let date = []

      for (
        let i = moment(this.currentDate)
          .startOf('month')
          .weekday();
        i > 0;
        i--
      ) {
        date.push(
          moment(this.currentDate)
            .startOf('month')
            .add(i * -1, 'days')
        )
      }

      for (
        let j = 0;
        j <
        moment(this.currentDate)
          .endOf('month')
          .format('DD');
        j++
      ) {
        date.push(
          moment(this.currentDate)
            .startOf('month')
            .add(j, 'days')
        )
      }

      for (
        let k = 1;
        k <=
        6 -
          moment(this.currentDate)
            .endOf('month')
            .weekday();
        k++
      ) {
        date.push(
          moment(this.currentDate)
            .endOf('month')
            .add(k, 'days')
        )
      }

      return chunk(date, 7)
    },
    isPreviousMonth: vm => date => {
      return (
        date.format('MM') < moment(vm.currentDate).format('MM') ||
        date.format('YYYY') < moment(vm.currentDate).format('YYYY')
      )
    },
    inCurrentMonth: vm => date => {
      return (
        date.format('MM') === moment(vm.currentDate).format('MM') &&
        date.format('YYYY') === moment(vm.currentDate).format('YYYY')
      )
    },
    isNextMonth: vm => date => {
      return (
        date.format('MM') > moment(vm.currentDate).format('MM') ||
        date.format('YYYY') > moment(vm.currentDate).format('YYYY')
      )
    },
    month() {
      return this.currentDate.format('MMMM')
    },
    year() {
      return this.currentDate.format('YYYY')
    },
    isToday: () => date => {
      return moment().format('DD-MM-YYYY') == moment(date).format('DD-MM-YYYY')
    }
  },
  methods: {
    previous() {
      this.currentDate = moment(this.currentDate).add(-1, 'months')
    },
    next() {
      this.currentDate = moment(this.currentDate).add(1, 'months')
    },
    calculateDayInterval(fromDate, toDate) {
      return moment.duration(moment(toDate).diff(moment(fromDate))).as('days')
    },
    selectDate(date) {
      this.$emit('change', date)
    }
  }
}
</script>
