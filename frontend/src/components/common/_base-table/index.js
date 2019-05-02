import { sortBy, debounce, transform, groupBy, reduce } from 'lodash'

export default {
  name: 'Table',
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
    },
    dataTable() {
      let dataTable = this.sortDataTable

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
    sortDataTable() {
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
          /* eslint-disable no-unused-vars */
          /* eslint-enable no-unused-vars */
        }
      }

      return this.records
    }
  },
  created() {
    this.records.forEach((item, index) => {
      this.expandableItems[index] = false
    })
  },
  methods: {
    iterateeGroupBy(record) {
      return record[this.rowGroup.field]
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
    }
  },
  /* eslint-disable no-unused-vars */
  render(h) {
    return (
      <table class="ui-table">
        <thead>
          {(() =>
            this.$slots.thead !== undefined ? (
              this.$slots.thead
            ) : (
              <tr>
                {(() => {
                  if (this.showCheckbox) {
                    return (
                      <th class="ui-checkable">
                        <input
                          type="checkbox"
                          vModel={this.allItemsChecked}
                          vOn:change={() => this.toggleCheckingAllItems()}
                          disabled={this.checkableItems.length === 0}
                        />
                      </th>
                    )
                  }
                })()}
                {(() => {
                  if (this.expandable) {
                    return <th style="width: 50px;" />
                  }
                })()}
                {this.columns.map((column, key) => {
                  return (
                    <th key={key} style={this.showColumnStyle(column)}>
                      {this.showColumnName(column)}
                    </th>
                  )
                })}
              </tr>
            ))()}
        </thead>
        <tbody>
          {(() => {
            if (this.rowGroup) {
              return this.dataTable.map((items, key) => {
                return [
                  <tr>
                    <td class="row-group-def" colspan={this.columnLength}>
                      <a
                        href="#"
                        vOn:click_prevent={(items.expand = !items.expand)}
                        class="mr-1"
                      >
                        <i
                          class="far"
                          class={
                            items.expand ? 'fa-minus-square' : 'fa-plus-square'
                          }
                        />
                      </a>
                      <span>{key}</span>
                    </td>
                  </tr>,
                  items.data.map((record, index) => {})
                ]
              })
            } else {
              return this.dataTable.map((record, index) => {
                return [
                  <tr
                    key={this.keyName !== null ? record[this.keyName] : index}
                  >
                    {(() => {
                      if (this.showCheckbox) {
                        return (
                          <td class="ui-checkable">
                            {(() => {
                              if (this.shouldShowBox(record)) {
                                return (
                                  <input
                                    type="checkbox"
                                    vModel={this.checkedItems}
                                    value={record}
                                    vOn:change={() => this.checkItem()}
                                  />
                                )
                              }
                            })()}
                          </td>
                        )
                      }
                    })()}
                    {(() => {
                      if (this.expandable) {
                        return (
                          <td class="expandable-row" style="width: 40px;">
                            <div
                              class="expandable-row__icon"
                              {...{
                                class: {
                                  'expandable-row__expanded': this
                                    .expandableItems[index]
                                }
                              }}
                              vOn:click={() => this.toggleExpandedRow(index)}
                            >
                              <i class="fa fa-caret-right" />
                            </div>
                          </td>
                        )
                      }
                    })()}
                    {this.$scopedSlots.default({
                      record: record,
                      index: index
                    })}
                  </tr>,
                  (() => {
                    if (this.expandableItems[index]) {
                      return (
                        <tr>
                          <td
                            colspan={this.columnLength}
                            class="expandable-column"
                          >
                            {this.$scopedSlots.expand({
                              record: record,
                              index: index
                            })}
                          </td>
                        </tr>
                      )
                    }
                  })()
                ]
              })
            }
          })()}
        </tbody>
      </table>
    )
  }
  /* eslint-enable no-unused-vars */
}
