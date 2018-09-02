<script>
export default {
  functional: true,
  name: 'BaseButton',
  props: {
    color: {
      type: String,
      default: 'default'
    },
    waiting: {
      type: Boolean,
      default: false
    }
  },
  render(createElement, context) {
    let children = [context.children]
    if (context.props.waiting) {
      children.unshift(
        createElement('span', { class: 'fas fa-spinner spinning mr-2' })
      )
    }

    return createElement(
      'button',
      {
        class: {
          'py-2 px-4 rounded focus:outline-none focus:shadow-outline': true,
          'bg-grey-light hover:bg-grey': context.props.color === 'default',
          'bg-blue text-white': context.props.color === 'primary',
          'bg-green text-white': context.props.color === 'accent',
          'bg-green text-white': context.props.color === 'success',
          'bg-red text-white': context.props.color === 'danger',
          'bg-yellow text-white': context.props.color === 'warning',
          'bg-blue-light text-white': context.props.color === 'info'
        },
        attrs: context.props,
        on: context.listeners
      },
      children
    )
  }
}
</script>
