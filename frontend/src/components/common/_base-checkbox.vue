<template>
  <div
    class="ui-checkbox"
    :class="[{ checked: this.isChecked }, { disabled: this.disabled }]"
  >
    <input
      type="checkbox"
      class="ui-checkbox-input"
      :checked="isChecked"
      :disabled="disabled"
      :value="value"
      @change="event => onChange(event)"
    />
    <div
      class="box-checkbox"
      @click="event => event.target.previousSibling.click()"
    />
    <label class="ui-checkbox-label">
      <slot />
    </label>
  </div>
</template>

<script>
import { findIndex, isEqual, cloneDeep } from 'lodash'

export default {
  name: 'BaseCheckbox',
  model: {
    prop: 'checkedValue',
    event: 'change'
  },
  props: {
    value: {},
    checkedValue: {
      type: Boolean | Array,
      default: false
    },
    disabled: Boolean
  },
  computed: {
    isChecked() {
      return (
        (Array.isArray(this.checkedValue) &&
          findIndex(this.checkedValue, o => isEqual(o, this.value)) >= 0) ||
        this.checkedValue === true
      )
    }
  },
  methods: {
    onChange(event) {
      if (Array.isArray(this.checkedValue)) {
        let checkedValue = cloneDeep(this.checkedValue)

        if (event.target.checked) {
          checkedValue.push(this.value)
        } else {
          checkedValue.splice(checkedValue.indexOf(this.value), 1)
        }

        this.$emit('change', checkedValue)
      } else {
        this.$emit('change', event.target.checked)
      }
    }
  }
}
</script>
