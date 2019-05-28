<template>
  <td class="ui-checkable">
    <BaseCheckbox
      v-model="$parent.checkedItems"
      :value="record"
      :disabled="$parent.checkableItems.length === 0"
      @change="$parent.checkItem()"
    ></BaseCheckbox>
  </td>
</template>

<script>
export default {
  name: 'CheckableColumn',
  props: ['record']
}
</script>
