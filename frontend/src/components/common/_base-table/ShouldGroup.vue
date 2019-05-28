<script>
import GroupExpandRow from './GroupExpandRow'

export default {
  name: 'ShouldGroup',
  functional: true,
  props: ['items', 'itemKey'],
  render(h, context) {
    if (context.parent.rowGroup) {
      return [
        <GroupExpandRow
          columnLength={context.parent.columnLength}
          items={context.props.items}
          itemKey={context.props.itemKey}
          vOn:click={expand => (context.props.items.expand = !expand)}
        />,
        context.props.items.data.map((record, index) => {
          if (context.props.items.expand) {
            return context.scopedSlots.group({
              record: record,
              index: `${context.props.itemKey}__${index}`
            })
          }
        })
      ]
    }

    return context.scopedSlots.group({
      record: context.props.items,
      index: context.props.itemKey
    })
  }
}
</script>
