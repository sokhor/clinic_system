<script>
const classColorScheme = ({
  flat = false,
  outline = false,
  colorType = 'default'
}) => {
  let colorScheme = {}

  if (flat) {
    colorScheme = Object.assign({}, colorScheme, {
      'text-gray-500 hover:text-gray-400': colorType === 'default',
      'text-blue-500 hover:text-blue-400': colorType === 'primary',
      'text-green-500 hover:text-green-400':
        colorType === 'accent' || colorType === 'success',
      'text-red-500 hover:text-red-400': colorType === 'danger',
      'text-yellow-500 hover:text-yellow-400': colorType === 'warning',
      'text-blue-400 hover:text-blue-300': colorType === 'info'
    })
  } else if (outline) {
    colorScheme = Object.assign({}, colorScheme, {
      'text-gray-700 border rounded border-gray-600 hover:text-gray-600 hover:border-gray-500':
        colorType === 'default',
      'text-blue-500 border rounded border-blue-500 hover:text-blue-400 hover:border-blue-400':
        colorType === 'primary',
      'text-green-500 border rounded border-green-500 hover:text-green-400 hover:border-green-400':
        colorType === 'accent' || colorType === 'success',
      'text-red-500 border rounded border-red-500 hover:text-red-400 hover:border-red-400':
        colorType === 'danger',
      'text-yellow-500 border rounded border-yellow-500 hover:text-yellow-400 hover:border-yellow-400':
        colorType === 'warning',
      'text-blue-400 border rounded border-blue-400 hover:text-blue-300 hover:border-blue-300':
        colorType === 'info'
    })
  } else {
    colorScheme = Object.assign({}, colorScheme, {
      'rounded shadow': true,
      'bg-gray-400 hover:bg-gray-500': colorType === 'default',
      'bg-blue-500 text-white hover:bg-blue-400': colorType === 'primary',
      'bg-green-500 text-white hover:bg-green-400': colorType === 'accent',
      'bg-green-500 text-white hover:bg-gray-400': colorType === 'success',
      'bg-red-500 text-white hover:bg-red-400': colorType === 'danger',
      'bg-yellow-500 text-white hover:bg-yellow-400': colorType === 'warning',
      'bg-blue-400 text-white hover:bg-blue-300': colorType === 'info'
    })
  }

  return colorScheme
}

const classSize = ({ size = 'md', flat = false }) => {
  if (flat) {
    return ''
  }

  if (size === 'sm') {
    return 'px-4 py-2'
  } else if (size === 'md') {
    return 'px-6 py-3'
  } else if (size === 'lg') {
    return 'px-8 py-4'
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
    outline: {
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
    },
    title: {
      type: String,
      default: undefined
    },
    type: {
      type: String,
      default: 'button'
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
          'focus:outline-none font-semibold',
          classColorScheme({
            flat: context.props.flat,
            outline: context.props.outline,
            colorType: context.props.color
          }),
          classSize({
            size: context.props.lg
              ? 'lg'
              : context.props.md
              ? 'md'
              : context.props.sm
              ? 'sm'
              : undefined,
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
