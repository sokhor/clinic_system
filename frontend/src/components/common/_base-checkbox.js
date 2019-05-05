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
  },
  render(h) {
    return (
      <div
        {...{
          class: [
            'relative block h-6 w-6 pl-6 flex items-center',
            { checked: this.isChecked },
            { disabled: this.disabled }
          ]
        }}
      >
        <input
          type="checkbox"
          class="absolute z--1 opacity-0"
          checked={this.isChecked}
          disabled={this.disabled}
          value={this.value}
          vOn:change={event => this.onChange(event)}
        />
        <div
          class="box-checkbox absolute block w-4 h-4 rounded select-none left-0 border bg-gray-300"
          vOn:click={event => event.target.previousSibling.click()}
        />
        <label class="relative mb-0 whitespace-no-wrap">
          {this.$slots.default[0]}
        </label>
      </div>
    )
  }
}
