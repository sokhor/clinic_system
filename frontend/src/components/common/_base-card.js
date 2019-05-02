export default {
  name: 'BaseCard',
  functional: true,
  render(h, context) {
    return (
      <div
        {...{
          class: [
            'bg-white shadow-md rounded overflow-hidden',
            context.data.staticClass
          ]
        }}
      >
        {context.children}
      </div>
    )
  }
}
