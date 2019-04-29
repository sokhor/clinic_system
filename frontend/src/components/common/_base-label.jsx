export default {
  name: 'BaseLabel',
  functional: true,
  render(h, context) {
    return (
      <label
        class="block text-gray-700 text-base font-semibold"
        {...{ class: context.data.staticClass }}
      >
        {context.children}
      </label>
    )
  }
}
