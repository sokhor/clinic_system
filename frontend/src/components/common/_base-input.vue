<script>
function onInputEvent(context, evt) {
  const listener = context.listeners['input'] || (() => {})

  if (Array.isArray(listener)) {
    return listener.forEach(_listener => _listener(evt.target.value))
  }

  return listener(evt.target.value)
}

function onFocusEvent(context, evt) {
  const listener = context.listeners['focus'] || (() => {})

  if (Array.isArray(listener)) {
    return listener.forEach(_listener => _listener(evt))
  }

  return listener(evt)
}

export default {
  name: 'BaseInput',
  functional: true,
  props: {
    value: {
      default: ''
    },
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
        class="appearance-none border rounded py-2 px-3 text-gray-800 leading-none focus:outline-none focus:shadow-outline w-full"
        type={context.props.type}
        value={context.props.value}
        disabled={context.props.disabled}
        placeholder={context.props.placeholder}
        vOn:input={evt => onInputEvent(context, evt)}
        vOn:focus={evt => onFocusEvent(context, evt)}
      />
    )
  }
}
</script>
