const classColor = ({ color, flat, outline }) => {
  let colorStyle = {}

  if (flat) {
    colorStyle = Object.assign({}, colorStyle, {
      'btn-flat-default': color === undefined,
      'btn-flat-primary': color === 'primary',
      'btn-flat-accent': color === 'accent',
      'btn-flat-success': color === 'success',
      'btn-flat-danger': color === 'danger',
      'btn-flat-warning': color === 'warning',
      'btn-flat-info': color === 'info'
    })
  } else if (outline) {
    colorStyle = Object.assign({}, colorStyle, {
      'btn-outline-default': color === undefined,
      'btn-outline-primary': color === 'primary',
      'btn-outline-accent': color === 'accent',
      'btn-outline-success': color === 'success',
      'btn-outline-danger': color === 'danger',
      'btn-outline-warning': color === 'warning',
      'btn-outline-info': color === 'info'
    })
  } else {
    colorStyle = Object.assign({}, colorStyle, {
      'btn-default': color === undefined,
      'btn-primary': color === 'primary',
      'btn-accent': color === 'accent',
      'btn-success': color === 'success',
      'btn-danger': color === 'danger',
      'btn-warning': color === 'warning',
      'btn-info': color === 'info'
    })
  }

  return colorStyle
}

const classSize = ({ size, flat }) => {
  // if (flat) {
  //   return ''
  // }

  if (size === 'sm') {
    return 'btn-sm'
  } else if (size === 'md') {
    return 'btn-md'
  } else if (size === 'lg') {
    return 'btn-lg'
  }
}

const isWaiting = waiting => waiting === true || waiting.state === true

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
      type: Boolean | Object,
      default: false
    }
  },
  render(h, context) {
    const Spin = ({ props, data }) => {
      if (isWaiting(props.waiting))
        return <i class="fas fa-spinner spin" {...{ class: data.class }} />
    }

    return (
      <button
        type={context.props.type}
        {...{
          class: [
            'btn',
            classColor({ ...context.props }),
            classSize({ ...context.props }),
            context.data.staticClass
          ],
          attrs: Object.assign(
            { disabled: isWaiting(context.props.waiting) },
            context.data.attrs
          ),
          on: context.listeners
        }}
      >
        {(() => {
          if (
            typeof context.props.waiting === 'object' &&
            context.props.waiting.state === true &&
            context.props.waiting.hideText === true
          ) {
            return <Spin waiting={context.props.waiting} />
          } else {
            return [
              <Spin waiting={context.props.waiting} class="mr-2" />,
              context.children
            ]
          }
        })()}
      </button>
    )
  }
}
