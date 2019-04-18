<script>
const inputValue = context => {
  if (context.data.model !== undefined) return context.data.model.value
  else if (context.data.attrs !== undefined) return context.data.attrs.value

  return ''
}

const onInput = (event, context) => {
  let emitInputEvent = context.listeners['input'] || (() => {})
  let modelValue = event.target.value

  if (Array.isArray(emitInputEvent)) {
    return emitInputEvent.forEach(e => e(modelValue, event))
  }

  return emitInputEvent(modelValue, event)
}

export default {
  name: 'BaseInput',
  functional: true,
  props: {
    type: {
      type: String,
      default: 'text'
    },
    disabled: {
      type: Boolean,
      default: false
    },
    placeholder: {
      type: String,
      default: undefined
    }
  },
  render(h, context) {
    return (
      <input
        {...{
          class: [
            'appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full',
            context.data.staticClass
          ]
        }}
        type={context.props.type}
        value={inputValue(context)}
        onInput={event => onInput(event, context)}
        disabled={context.props.disabled}
        placeholder={context.props.placeholder}
      />
    )
  }
}
</script>
