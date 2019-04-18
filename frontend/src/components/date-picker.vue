<template>
  <div class="bg-white shadow rounded p-4">
    <div class="box-body">
      <div class="calendar">
        <div class="calendar-header">
          <div class="flex justify-between">
            <a href="#" class="text-gray-800" @click.prevent="previous">
              <i class="fas fa-chevron-left"></i>
            </a>
            <div class="uppercase text-gray-800 font-bold">
              {{ month }} {{ year }}
            </div>
            <a href="#" class="text-gray-800" @click.prevent="next">
              <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>
        <div class="mt-5">
          <div class="flex">
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-grey-dark"
            >
              Mon
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-grey-dark"
            >
              Tue
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-grey-dark"
            >
              Wed
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-grey-dark"
            >
              Thu
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-grey-dark"
            >
              Fri
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-grey-dark"
            >
              Sat
            </div>
            <div
              class="w-1/7 uppercase text-sm font-semibold text-center text-grey-dark"
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
              class="w-1/7 text-center p-3 cursor-pointer"
              :class="[
                inCurrentMonth(date) ? 'text-gray-800' : 'text-grey',
                { 'last-day-of-week': indexDay === dates.length - 1 }
              ]"
              @click="selectDate(date)"
            >
              <span
                :class="{
                  'text-white rounded-full block bg-red w-6 h-6': isToday(date)
                }"
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
    inCurrentMonth: vm => date => {
      return date.format('MM') === moment(vm.currentDate).format('MM')
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
