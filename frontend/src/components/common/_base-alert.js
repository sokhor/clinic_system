const classList = props => {
  if (props.type.toLowerCase().trim() === 'danger') {
    return {
      'bg-red-200': true,
      'border-red-500': true,
      'text-red-700': true
    }
  } else if (props.type.toLowerCase().trim() === 'warning') {
    return {
      'bg-orange-200': true,
      'border-orange-500': true,
      'text-orange-700': true
    }
  } else if (props.type.toLowerCase().trim() === 'info') {
    return {
      'bg-blue-200': true,
      'border-blue': true,
      'text-blue-700': true
    }
  } else if (props.type.toLowerCase().trim() === 'success') {
    return {
      'bg-green-200': true,
      'border-green-500': true,
      'text-green-700': true
    }
  } else {
    return {
      'bg-gray-200': true,
      'border-gray-500': true,
      'text-gray-700': true
    }
  }
}

export default {
  name: 'BaseAlert',
  functional: true,
  props: {
    type: {
      type: String,
      default: ''
    }
  },
  render(h, { data, props, children }) {
    return (
      <div
        class="border-l-4 p-4"
        {...{ class: [classList(props), data.staticClass] }}
      >
        {children}
      </div>
    )
  }
}
