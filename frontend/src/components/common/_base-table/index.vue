<template>
  <table class="ui-table">
    <thead>
      <slot name="thead">
        <tr>
          <CheckableHead v-if="showCheckbox" />
          <ExpandableHead v-if="expandable" />
          <slot name="columns">
            <th v-for="(column, key) in columns">
              {{ showColumnName(column) }}
            </th>
          </slot>
        </tr>
      </slot>
    </thead>
    <tbody>
      <template v-for="(items, itemKey) in dataTable">
        <ShouldGroup
          :items="items"
          :itemKey="itemKey"
          v-slot:group="{ record, index }"
        >
          <tr :key="keyName !== null ? record[keyName] : index">
            <CheckableColumn :record="record" v-if="showCheckbox" />
            <ExpandableColumn :index="index" v-if="expandable" />
            <slot :record="record" :index="index"></slot>
          </tr>
          <ExpandableRow v-if="expandableItems[index]">
            <slot name="expand" :record="record" :index="index"></slot>
          </ExpandableRow>
        </ShouldGroup>
      </template>
    </tbody>
  </table>
</template>

<script>
import { sortBy, debounce, transform, groupBy, reduce } from 'lodash'
import CheckableHead from './CheckableHead.vue'
import ExpandableHead from './ExpandableHead.vue'
import CheckableColumn from './CheckableColumn.vue'
import ExpandableColumn from './ExpandableColumn.vue'
import ExpandableRow from './ExpandableRow.vue'
import ShouldGroup from './ShouldGroup.vue'

export default {
  name: 'BaseTable',
  components: {
    CheckableHead,
    ExpandableHead,
    CheckableColumn,
    ExpandableColumn,
    ExpandableRow,
    ShouldGroup
  },
  props: {
    columns: {
      type: Array,
      default: () => []
    },
    records: {
      type: Array,
      default: () => []
    },
    showCheckbox: {
      type: Boolean,
      default: false
    },
    checkableCondition: {
      default: null
    },
    keyName: {
      type: String,
      default: null
    },
    expandable: {
      type: Boolean,
      default: false
    },
    rowGroup: {
      type: Object
    }
  },
  data() {
    return {
      dataTable: [],
      checkedItems: [],
      allItemsChecked: false,
      expandableItems: [],
      sortedColumn: null
    }
  },
  computed: {
    checkableItems() {
      return this.records.filter(item => this.shouldShowBox(item))
    },
    columnLength() {
      let length = this.columns.length

      if (this.showCheckbox) {
        ++length
      }

      if (this.expandable) {
        ++length
      }

      return length
    }
  },
  created() {
    this.records.forEach((item, index) => {
      this.expandableItems[index] = false
    })
  },
  methods: {
    getDataTable() {
      let dataTable = this.getSortDataTable()

      if (this.rowGroup !== undefined) {
        dataTable = transform(
          groupBy(dataTable, this.iterateeGroupBy),
          (result, value, key) => {
            result[key] = {
              data: value,
              expand: true
            }
          },
          {}
        )
      }

      return dataTable
    },
    getSortDataTable() {
      const nestedColumnValueReducer = (carrier, accumulator) => {
        return reduce(
          carrier,
          (carry, key) => {
            if (carry === null || carry === undefined) return

            return carry[key]
          },
          accumulator
        )
      }

      if (this.sortedColumn !== null) {
        try {
          if (this.sortedColumn.order === 1) {
            return sortBy(this.records, o => {
              let sortVal = nestedColumnValueReducer(
                this.sortedColumn.sortKey.split('.'),
                o
              )

              if (sortVal === undefined) throw 'No sort data'

              return sortVal
            })
          }

          if (this.sortedColumn.order === -1) {
            return sortBy(this.records, o => {
              let sortVal = nestedColumnValueReducer(
                this.sortedColumn.sortKey.split('.'),
                o
              )

              if (sortVal === undefined) throw 'No sort data'

              return sortVal
            }).reverse()
          }
        } catch (e) {
          console.log(e)
        }
      }

      return this.records
    },
    iterateeGroupBy(record) {
      const itemKeys = this.rowGroup.field.split('.')

      return reduce(itemKeys, (item, key) => item[key], record)
    },
    toggleCheckingAllItems() {
      if (this.allItemsChecked === true) {
        this.checkedItems = this.checkableItems
      } else {
        this.checkedItems = []
      }
    },
    checkItem() {
      this.allItemsChecked = this.checkedItems.length === this.records.length
    },
    raisedCheckItemsEvent() {
      this.$emit('check-items', this.checkedItems)
    },
    shouldShowBox(item) {
      if (this.checkableCondition === null) {
        return true
      }

      return item[this.checkableCondition[0]] == this.checkableCondition[1]
    },
    toggleExpandedRow(index) {
      this.$set(this.expandableItems, index, !this.expandableItems[index])
    },
    showColumnName(column) {
      if (column instanceof Object) {
        return column.name
      }

      return column
    },
    showColumnStyle(column) {
      if (column instanceof Object) {
        return column.style
      }

      return {}
    },
    filterable(column) {
      return column instanceof Object && column.filter !== undefined
    },
    getNestedPropertyValue(item, propsString) {
      let props = propsString.split('.'),
        temp = item[props[0]]

      for (let i = 1; i < props.length; i++) {
        temp = temp[props[i]]
      }

      return temp
    },
    setSortedColumn(sortedColumn) {
      this.sortedColumn = sortedColumn
      this.$forceUpdate()
    },
    fireFilterEvent: debounce(function($event, $filterName) {
      this.$emit($filterName, $event.target.value)
    }, 1000)
  },
  watch: {
    checkedItems: function() {
      this.raisedCheckItemsEvent()
    },
    records: {
      handler(records) {
        this.dataTable = this.getDataTable()
      },
      deep: true,
      immediate: true
    }
  }
}
</script>
