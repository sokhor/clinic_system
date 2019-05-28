<template>
  <tr>
    <td class="expandable-column" :colspan="$parent.columnLength">
      <slot />
    </td>
  </tr>
</template>

<script>
export default {
  name: 'ExpandableRow'
}
</script>
