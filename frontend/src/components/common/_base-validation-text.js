export default {
  name: 'BaseValidationText',
  functional: true,
  props: {
    success: {
      type: Boolean,
      default: false
    }
  },
  render(h, context) {
    return (
      <label
        {...{
          class: [
            'block text-xs italic',
            context.props.success ? 'text-green-500' : 'text-red-500',
            context.data.staticClass
          ]
        }}
      >
        {context.children}
      </label>
    )
  }
}
