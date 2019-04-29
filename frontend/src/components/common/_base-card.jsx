export default {
  name: 'BaseCard',
  functional: true,
  render(h, context) {
    return (
      <div
        class="bg-white shadow-md rounded overflow-hidden"
        {...{ class: context.data.staticClass }}
      >
        {context.children}
      </div>
    )
  }
}
