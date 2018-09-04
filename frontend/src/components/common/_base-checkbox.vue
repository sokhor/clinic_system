<script>
const isChecked = context => {
  return (
    (Array.isArray(context.data.model.value) &&
      context.data.model.value.indexOf(context.data.attrs.value) >= 0) ||
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

  emitInputEvent(modelValue, event)
}

export default {
  name: 'BaseCheckbox',
  functional: true,
  render(h, context) {
    return (
      <div
        class="relative block h-6 w-6 pl-6 flex items-center"
        {...{
          class: [isChecked(context) ? 'checked' : '', context.data.staticClass]
        }}
      >
        <input
          type="checkbox"
          class="absolute z--1 opacity-0"
          checked={isChecked(context)}
          onInput={event => onInput(event, context)}
        />
        <div
          class="box-checkbox absolute block w-4 h-4 rounded cursor-pointer select-none bg-grey pin-l"
          onClick={event => event.target.previousSibling.click()}
        />
        <label class="relative mb-0">{context.children}</label>
      </div>
    )
  }
}
</script>

<style>
@tailwind utilities;

input[type='checkbox'],
input[type='radio'] {
  box-sizing: border-box;
  padding: 0;
}

input[type='checkbox']:checked ~ .box-checkbox {
  @apply text-white bg-blue;
}

input[type='checkbox']:checked ~ .box-checkbox:after {
  background-image: url(data:image/svg+xml;charset=utf8;base64,PHN2ZyB4bWxucz0naHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmcnIHZpZXdCb3g9JzAgMCA4IDgnPjxwYXRoIGZpbGw9JyNmZmYnIGQ9J002LjU2NC43NWwtMy41OSAzLjYxMi0xLjUzOC0xLjU1TDAgNC4yNiAyLjk3NCA3LjI1IDggMi4xOTN6Jy8+PC9zdmc+);
}

.box-checkbox:after {
  @apply absolute block w-4 h-4;
  content: '';
}

.box-checkbox:after {
  @apply bg-no-repeat bg-center bg-50%;
}
</style>
