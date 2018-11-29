<script>
const classColorScheme = ({
  flat = false,
  outline = false,
  colorType = 'default'
}) => {
  let colorScheme = {}

  if (flat) {
    colorScheme = Object.assign({}, colorScheme, {
      'text-grey hover:text-grey-light': colorType === 'default',
      'text-blue hover:text-blue-light': colorType === 'primary',
      'text-green hover:text-green-light':
        colorType === 'accent' || colorType === 'success',
      'text-red hover:text-red-light': colorType === 'danger',
      'text-yellow hover:text-yellow-light': colorType === 'warning',
      'text-blue-light hover:text-blue-lighter': colorType === 'info'
    })
  } else if (outline) {
    colorScheme = Object.assign({}, colorScheme, {
      'text-grey border-2 rounded border-grey hover:text-grey-light hover:border-grey-light':
        colorType === 'default',
      'text-blue border-2 rounded border-blue hover:text-blue-light hover:border-blue-light':
        colorType === 'primary',
      'text-green border-2 rounded border-green hover:text-green-light hover:border-green-light':
        colorType === 'accent' || colorType === 'success',
      'text-red border-2 rounded border-red hover:text-red-light hover:border-red-light':
        colorType === 'danger',
      'text-yellow border-2 rounded border-yellow hover:text-yellow-light hover:border-yellow-light':
        colorType === 'warning',
      'text-blue-light border-2 rounded border-blue-light hover:text-blue-lighter hover:border-blue-lighter':
        colorType === 'info'
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
