import { findIndex, isEqual } from 'lodash'

const isChecked = context => {
  return (
    (Array.isArray(context.data.model.value) &&
      findIndex(context.data.model.value, o =>
        isEqual(o, context.data.attrs.value)
      ) >= 0) ||
    context.data.model.value === true ||
    (context.data.attrs && context.data.attrs.checked)
  )
}

const onInput = (event, context) => {
  let emitInputEvent = context.listeners['input'] || (() => {})
  let modelValue = context.data.model.value

  if (Array.isArray(modelValue)) {
    if (event.target.checked) {
      modelValue.push(context.data.attrs.value)
    } else {
      modelValue.splice(modelValue.indexOf(context.data.attrs.value), 1)
    }
  } else {
    modelValue = event.target.checked
  }

  if (Array.isArray(emitInputEvent)) {
    return emitInputEvent.forEach(e => e(modelValue, event))
  }

  return emitInputEvent(modelValue, event)
}

export default {
  name: 'BaseCheckbox',
  functional: true,
  props: {
    disabled: {
      type: Boolean,
      default: false
    }
  },
  render(h, context) {
    return (
      <div
        class="relative block h-6 w-6 pl-6 flex items-center"
        {...{
          class: [
            context.data.staticClass,
            { checked: isChecked(context) },
            { disabled: context.props.disabled }
          ]
        }}
      >
        <input
          type="checkbox"
          class="absolute z--1 opacity-0"
          checked={isChecked(context)}
          disabled={context.props.disabled}
          vOn:change={context.listeners['change'] || (() => {})}
          vOn:input={event => onInput(event, context)}
        />
        <div
          class="box-checkbox absolute block w-4 h-4 rounded select-none left-0 border bg-gray-300"
          vOn:click={event => event.target.previousSibling.click()}
        />
        <label class="relative mb-0 whitespace-no-wrap">
          {context.children}
        </label>
      </div>
    )
  }
}
