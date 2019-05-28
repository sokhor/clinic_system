<template>
  <th class="ui-checkable">
    <BaseCheckbox
      v-model="$parent.allItemsChecked"
      :disabled="$parent.checkableItems.length === 0"
      @change="$parent.toggleCheckingAllItems()"
    ></BaseCheckbox>
  </th>
</template>

<script>
export default {
  name: 'CheckableHead'
}
</script>
