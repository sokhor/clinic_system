<template>
  <on-click-outside :do="close">
    <div class="relative">
      <!-- <base-input
        type="text"
        placeholder="DD-MM-YYYY"
        v-bind="$attrs"
        v-model="value"
        @focus="show"
      /> -->
      <div class="flex items-center border rounded px-3 w-full date-input">
        <input class="appearance-none py-2 text-gray-800 leading-none focus:outline-none w-full" @focus="show" v-model="day" placeholder="DD"/> - 
        <input class="appearance-none py-2 text-gray-800 leading-none focus:outline-none w-full" @focus="show" v-model="month" placeholder="MM"/> - 
        <input class="appearance-none py-2 text-gray-800 leading-none focus:outline-none w-full" @focus="show" v-model="year" placeholder="YYYY"/>
      </div>
      <date-picker v-if="picker" class="absolute z-20" @change="selectDate" />
    </div>
  </on-click-outside>
</template>

<script>
import DatePicker from '@/components/date-picker.vue'
import OnClickOutside from '@/components/on-click-outside.vue'

export default {
  name: 'BaseDatePickerInput',
  inheritAttrs: false,
  components: { DatePicker, OnClickOutside },
  data() {
    return {
      picker: false,
      value: null,
      day: '',
      month: '',
      year: ''
    }
  },
  methods: {
    show() {
      this.picker = true
    },
    close() {
      this.picker = false
    },
    selectDate(date) {
      this.value = date.format('DD-MM-YYYY')
      
      let dateArray = this.value.split('-')
      this.day = dateArray[0]
      this.month = dateArray[1]
      this.year = dateArray[2]

      this.close()
    }
  },
  watch: {
    value(newVal) {
      this.$emit('input', newVal)
    }
  }
}
</script>

<style lang="sass">
.date-input
  @apply .shadow-outline
</style>
