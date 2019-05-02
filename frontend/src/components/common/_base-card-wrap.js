export default {
  name: 'BaseCardWrap',
  functional: true,
  render(h, context) {
    return (
      <div {...{ class: ['p-4', context.data.staticClass] }}>
        {context.children}
      </div>
    )
  }
}
