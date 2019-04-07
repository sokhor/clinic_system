<template>
	<on-click-outside :do="close">
		<div class="relative">
			<input
				type="text"
				placeholder="DD-MM-YYYY"
				class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
				v-bind="$attrs"
				v-model="value"
				@focus="show"
			/>
			<date-picker v-if="picker" class="absolute z-20" @change="event => value = event.format('DD-MM-YYYY')"/>
		</div>
	</on-click-outside>
</template>

<script>
import DatePicker from '@/components/date-picker.vue'
import OnClickOutside from '@/components/on-click-outside.vue'

export default {
  name: 'BaseInputDatePickerInput',
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
    }
  },
  watch: {
    value(newVal) {
      this.$emit('input', newVal)
    }
  }
}
</script>
