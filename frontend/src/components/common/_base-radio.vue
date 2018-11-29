<script>
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
          type="radio"
          class="absolute z--1 opacity-0"
          checked={isChecked(context)}
          disabled={context.props.disabled}
          onChange={context.listeners['change'] || (() => {})}
          onInput={event => onInput(event, context)}
        />
        <div
          class="box-radio absolute block w-4 h-4 rounded-full select-none pin-l border bg-white-grey-lighter"
          onClick={event => event.target.previousSibling.click()}
        />
        <label class="relative mb-0 whitespace-no-wrap">
          {context.children}
        </label>
      </div>
    )
  }
}
</script>

<style>
@tailwind utilities;

input[type='radio'],
input[type='radio'] {
  box-sizing: border-box;
  padding: 0;
}

input[type='radio']:checked ~ .box-radio {
  @apply text-white bg-blue;
}

input[type='radio']:checked ~ .box-radio:after {
  background-image: url(data:image/svg+xml;charset=utf8;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9Jy00IC00IDggOCc+PGNpcmNsZSByPSczJyBmaWxsPScjZmZmJy8+PC9zdmc+);
}

input[type='radio']:disabled ~ .box-radio {
  @apply bg-grey;
}

input[type='radio']:disabled ~ .box-radio:hover {
  @apply cursor-not-allowed;
}

.box-radio:hover {
  @apply cursor-pointer;
}

.box-radio:after {
  @apply absolute block w-4 h-4;
  content: '';
}

.box-radio:after {
  @apply bg-no-repeat bg-50%;
  background-position: 37% 32%;
}
</style>
