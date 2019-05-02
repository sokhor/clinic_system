const colorClass = color => {
  if (color.toLowerCase() === 'blue') {
    return 'bg-blue-500 text-white'
  } else if (color.toLowerCase() === 'red') {
    return 'bg-red-500 text-white'
  } else if (color.toLowerCase() === 'green') {
    return 'bg-green-500 text-white'
  }
}

export default {
  name: 'BaseBadge',
  functional: true,
  props: {
    color: {
      type: String,
      default: ''
    }
  },
  render(h, context) {
    return (
      <span
        class="p-1 mt-1 rounded inline-block font-bold leading-none text-center align-baseline whitespace-no-wrap text-xs"
        {...{ class: context.data.staticClass }}
        {...{ class: colorClass(context.props.color) }}
      >
        {context.children}
      </span>
    )
  }
}
