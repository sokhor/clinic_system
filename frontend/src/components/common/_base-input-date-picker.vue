<template>
  <on-click-outside :do="close">
    <div class="relative">
      <base-input
        type="text"
        placeholder="DD-MM-YYYY"
        v-bind="$attrs"
        v-model="value"
        @focus="show"
      />
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
      value: null
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
