function emitClickEvent(context, evt) {
  const listener = context.listeners['click'] || (() => {})

  return listener(context.props.items.expand)
}

export default ({ props, listeners }) => {
  return (
    <tr>
      <td class="row-group-def" colspan={props.columnLength}>
        <a
          href="#"
          vOn:click_prevent={evt => emitClickEvent({ listeners, props }, evt)}
          class="mr-3"
        >
          <i
            class={
              props.items.expand ? 'far fa-minus-square' : 'far fa-plus-square'
            }
          />
        </a>
        <span>{props.itemKey}</span>
      </td>
    </tr>
  )
}
