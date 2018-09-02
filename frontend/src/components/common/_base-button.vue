<script>
const classColorScheme = ({ flat = false, colorType = 'default' }) =>  {
  let colorScheme = {}

  if(flat) {
    colorScheme = Object.assign({}, colorScheme, {
      'text-grey hover:text-grey-light': colorType === 'default',
      'text-blue hover:text-blue-light': colorType === 'primary',
      'text-green hover:text-green-light': colorType === 'accent',
      'text-green hover:text-green-light': colorType === 'success',
      'text-red hover:text-red-light': colorType === 'danger',
      'text-yellow hover:text-yellow-light': colorType === 'warning',
      'text-blue-light hover:text-blue-lighter': colorType === 'info'
    })
  } else {
    colorScheme = Object.assign({}, colorScheme, {
      'rounded shadow': true,
      'bg-grey-light hover:bg-grey': colorType === 'default',
      'bg-blue text-white hover:bg-blue-light': colorType === 'primary',
      'bg-green text-white hover:bg-green-light': colorType === 'accent',
      'bg-green text-white hover:bg-grey-light': colorType === 'success',
      'bg-red text-white hover:bg-red-light': colorType === 'danger',
      'bg-yellow text-white hover:bg-yellow-light': colorType === 'warning',
      'bg-blue-light text-white hover:bg-blue-lighter': colorType === 'info'
    })
  }

  return colorScheme
}

const classSize = ({ size = 'md', flat = false}) => {
  if(flat) {
    return ''
  }

  if(size === 'sm') {
    return 'px-4 py-2'
  } else if(size === 'md') {
    return 'px-5 py-3'
  } else if(size === 'lg') {
    return 'px-6 py-4'
  }
}
export default {
  functional: true,
  name: 'BaseButton',
  props: {
    color: {
      type: String,
      default: 'default'
    },
    flat: {
      type: Boolean,
      default: false
    },
    sm: {
      type: Boolean,
      default: false
    },
    md: {
      type: Boolean,
      default: false
    },
    lg: {
      type: Boolean,
      default: false
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
        class: [
          'focus:outline-none',
          classColorScheme({flat: context.props.flat, colorType: context.props.color}),
          classSize({
            size: context.props.lg ? 'lg' : (context.props.md ? 'md' : (context.props.sm ? 'sm' : undefined)),
            flat: context.props.flat
          }),
          context.data.staticClass
        ],
        attrs: context.props,
        on: context.listeners
      },
      children
    )
  }
}
</script>
