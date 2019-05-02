const isChecked = context => {
  return context.data.model.value === context.data.attrs.value
}

const onInput = (event, context) => {
  let emitInputEvent = context.listeners['input'] || (() => {})
  let modelValue = context.data.attrs.value

  if (Array.isArray(emitInputEvent)) {
    return emitInputEvent.forEach(e => e(modelValue, event))
  }

  return emitInputEvent(modelValue, event)
}

export default {
  name: 'BaseRadio',
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
        {...{
          class: [
            'relative pl-6 flex items-center',
            context.data.staticClass,
            { checked: isChecked(context) },
            { disabled: context.props.disabled }
          ]
        }}
      >
        <input
          type="radio"
          class="absolute z--1 opacity-0"
          checked={isChecked(context)}
          disabled={context.props.disabled}
          onChange={context.listeners['change'] || (() => {})}
          onInput={event => onInput(event, context)}
        />
        <div
          {...{
            class: [
              'box-radio absolute block w-4 h-4 rounded-full select-none left-0 bg-gray-300',
              { border: !isChecked(context) }
            ]
          }}
          onClick={event => event.target.previousSibling.click()}
        />
        <label class="relative mb-0 whitespace-no-wrap">
          {context.children}
        </label>
      </div>
    )
  }
}
