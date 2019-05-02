const classColor = ({ color, flat, outline }) => {
  let colorStyle = {}

  if (flat) {
    colorStyle = Object.assign({}, colorStyle, {
      'text-gray-500 hover:text-gray-500': color === 'default',
      'text-blue-500 hover:text-blue-500': color === 'primary',
      'text-indigo-500 hover:text-indigo-500': color === 'accent',
      'text-green-500 hover:text-green-500': color === 'success',
      'text-red-500 hover:text-red-500': color === 'danger',
      'text-yellow-500 hover:text-yellow-500': color === 'warning',
      'text-blue-500 hover:text-blue-300': color === 'info'
    })
  } else if (outline) {
    colorStyle = Object.assign({}, colorStyle, {
      'text-gray-700 border rounded border-gray-600 hover:text-gray-600 hover:border-gray-500':
        color === 'default',
      'text-blue-500 border rounded border-blue-500 hover:text-blue-500 hover:border-blue-500':
        color === 'primary',
      'text-indigo-500 border rounded border-indigo-500 hover:text-indigo-500 hover:border-indigo-500':
        color === 'accent',
      'text-green-500 border rounded border-green-500 hover:text-green-500 hover:border-green-500':
        color === 'success',
      'text-red-500 border rounded border-red-500 hover:text-red-500 hover:border-red-500':
        color === 'danger',
      'text-yellow-500 border rounded border-yellow-500 hover:text-yellow-500 hover:border-yellow-500':
        color === 'warning',
      'text-blue-500 border rounded border-blue-500 hover:text-blue-300 hover:border-blue-300':
        color === 'info'
    })
  } else {
    colorStyle = Object.assign({}, colorStyle, {
      'rounded shadow': true,
      'bg-gray-500 hover:bg-gray-500': color === 'default',
      'bg-blue-500 text-white hover:bg-blue-500': color === 'primary',
      'bg-indigo-500 text-white hover:bg-indigo-500': color === 'accent',
      'bg-green-500 text-white hover:bg-gray-500': color === 'success',
      'bg-red-500 text-white hover:bg-red-500': color === 'danger',
      'bg-yellow-500 text-white hover:bg-yellow-500': color === 'warning',
      'bg-blue-500 text-white hover:bg-blue-300': color === 'info'
    })
  }

  return colorStyle
}

const classSize = ({ size, flat }) => {
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
    type: {
      type: String,
      default: 'button'
    },
    color: {
      type: String
    },
    size: {
      type: String,
      default: 'sm'
    },
    flat: {
      type: Boolean,
      default: false
    },
    outline: {
      type: Boolean,
      default: false
    },
    waiting: {
      type: Boolean,
      default: false
    }
  },
  render(h, context) {
    const Spin = ({ props }) => {
      if (props.waiting) return <i class="fas fa-spinner spin mr-2" />
    }

    return (
      <button
        type={context.props.type}
        {...{
          class: [
            classColor({ ...context.props }),
            classSize({ ...context.props }),
            context.data.staticClass
          ],
          on: context.listeners
        }}
      >
        <Spin waiting={context.props.waiting} />
        {context.children}
      </button>
    )
  }
}
