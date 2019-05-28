<template>
  <td class="expandable-row">
    <div
      class="expandable-row__icon"
      :class="{ 'expandable-row__expanded': $parent.expandableItems[index] }"
      @click="$parent.toggleExpandedRow(index)"
    >
      <i class="fa fa-caret-right" />
    </div>
  </td>
</template>

<script>
export default {
  name: 'ExpandableColumn',
  props: ['index']
}
</script>
