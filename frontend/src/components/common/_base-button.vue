<script>
export default {
  functional: true,
  name: 'BaseButton',
  props: {
    default: {
      type: Boolean,
      default: true
    },
    primary: {
      type: Boolean,
      default: false
    },
    accent: {
      type: Boolean,
      default: false
    },
    danger: {
      type: Boolean,
      default: false
    },
    waiting: {
      type: Boolean,
      default: false
    }
  },
  render(createElement, context) {
    let children = [createElement('slot', 'Button')]
    if (context.props.waiting) {
      children.unshift(
        createElement('span', { class: 'fas fa-spinner spinning mr-2' })
      )
    }

    let color = 'default'
    if (context.props.primary) {
      color = 'primary'
    } else if (context.props.accent) {
      color = 'accent'
    } else if (context.props.danger) {
      color = 'danger'
    }

    return createElement(
      'button',
      {
        class: {
          'py-2 px-4 rounded focus:outline-none focus:shadow-outline': true,
          'bg-grey-light hover:bg-grey': color === 'default',
          'bg-blue text-white': color === 'primary',
          'bg-green text-white': color === 'accent',
          'bg-red text-white': color === 'danger'
        }
      },
      children
    )
  }
}
</script>
