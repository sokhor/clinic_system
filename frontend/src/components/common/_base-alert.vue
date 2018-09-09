<script>
const classList = props => {
  if (props.type.toLowerCase().trim() === 'danger') {
    return {
      'bg-red-lightest': true,
      'border-red': true,
      'text-red-dark': true
    }
  } else if (props.type.toLowerCase().trim() === 'warning') {
    return {
      'bg-orange-lightest': true,
      'border-orange': true,
      'text-orange-dark': true
    }
  } else if (props.type.toLowerCase().trim() === 'info') {
    return {
      'bg-blue-lightest': true,
      'border-blue': true,
      'text-blue-dark': true
    }
  } else if (props.type.toLowerCase().trim() === 'success') {
    return {
      'bg-green-lightest': true,
      'border-green': true,
      'text-green-dark': true
    }
  } else {
    return {
      'bg-grey-lightest': true,
      'border-grey': true,
      'text-grey-dark': true
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
</script>
