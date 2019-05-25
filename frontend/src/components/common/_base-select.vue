<template>
  <on-click-outside :do="close">
    <div class="search-select" :class="{ 'is-active': isOpen }">
      <button
        ref="button"
        @click="open"
        type="button"
        class="search-select-input"
        :class="[{ 'search-select-input__disabled': disabled }]"
        :disabled="disabled"
      >
        <span v-if="option !== null" class="search-select-text">{{
          typeof option === 'object' ? option.text : option
        }}</span>
        <span v-else class="search-select-placeholder">--Select--</span>
        <span
          class="search-select__arrow"
          :class="{ 'search-select__arrow__open': isOpen }"
        ></span>
      </button>
      <div ref="dropdown" v-show="isOpen" class="search-select-dropdown">
        <input
          class="search-select-search"
          v-model="search"
          ref="search"
          @keydown.esc="close"
          @keydown.up="highlightPrev"
          @keydown.down="highlightNext"
          @keydown.enter.prevent="selectHighlighted"
          @input="searchText"
        />
        <ul
          ref="options"
          v-show="filteredOptions.length > 0"
          class="search-select-options"
        >
          <li
            class="search-select-option"
            v-for="(option, i) in filteredOptions"
            :key="typeof option === 'object' ? option.value : option"
            @click="select(option, i)"
            :class="{ 'is-active': i === highlightedIndex }"
          >
            {{ typeof option === 'object' ? option.text : option }}
          </li>
        </ul>
        <div v-show="filteredOptions.length === 0" class="search-select-empty">
          <slot name="no-result" :search="search">
            No results found for
            <b>" {{ search }}"</b>
          </slot>
        </div>
      </div>
    </div>
  </on-click-outside>
</template>

<script>
import OnClickOutside from '@/components/on-click-outside.vue'
import Popper from 'popper.js'

export default {
  name: 'BaseSelect',
  components: {
    OnClickOutside
  },
  props: ['value', 'options', 'filterFunction', 'disabled'],
  data() {
    return {
      isOpen: false,
      search: '',
      highlightedIndex: null,
      option:
        this.options.find(
          option =>
            this.value == (typeof option === 'object' ? option.value : option)
        ) || null
    }
  },
  beforeDestroy() {
    this.popper !== undefined && this.popper.destroy()
  },
  computed: {
    filteredOptions() {
      if (this.filterFunction !== undefined) {
        return this.filterFunction(this.search, this.options)
      }

      return this.options.filter(option => {
        option = typeof option === 'object' ? option.text : option

        return option.toLowerCase().startsWith(this.search.toLowerCase())
      })
    }
  },
  methods: {
    open() {
      if (!this.isOpen) {
        this.isOpen = true
        this.$nextTick(() => {
          this.setupPopper()
          this.$refs.search.focus()
          this.scrollToHighlighted()
        })
      } else {
        this.isOpen = false
      }
    },
    setupPopper() {
      if (this.popper === undefined) {
        this.popper = new Popper(this.$refs.button, this.$refs.dropdown, {
          placement: 'bottom',
          positionFixed: true,
          modifiers: {
            offset: {
              enabled: true,
              fn: data => {
                data.offsets.popper.left = data.offsets.reference.left
                data.offsets.popper.right = data.offsets.reference.right
                data.offsets.popper.width = data.styles.width = Math.round(
                  data.offsets.reference.width
                )
                return data
              },
              order: 840
            }
          }
        })
      } else {
        this.popper.scheduleUpdate()
      }
    },
    close() {
      if (!this.isOpen) {
        return
      }
      this.isOpen = false
      this.$refs.button.focus()
    },
    select(option, index) {
      this.$emit('input', typeof option === 'object' ? option.value : option)
      this.$emit('change', typeof option === 'object' ? option.value : option)
      this.search = ''
      this.highlightedIndex = index
      this.option = option
      this.close()
    },
    selectHighlighted() {
      this.select(this.filteredOptions[this.highlightedIndex])
    },
    scrollToHighlighted() {
      if (this.highlightedIndex === null) return

      this.$refs.options.children.length > 0 &&
        this.$refs.options.children[this.highlightedIndex].scrollIntoView({
          block: 'nearest'
        })
    },
    highlight(index) {
      this.highlightedIndex = index

      if (this.highlightedIndex < 0) {
        this.highlightedIndex = this.filteredOptions.length - 1
      }

      if (this.highlightedIndex > this.filteredOptions.length - 1) {
        this.highlightedIndex = 0
      }

      this.scrollToHighlighted()
    },
    highlightPrev() {
      this.highlight(this.highlightedIndex - 1)
    },
    highlightNext() {
      this.highlight(this.highlightedIndex + 1)
    },
    searchText() {
      this.$nextTick(() => {
        this.popper.scheduleUpdate()
      })
    }
  },
  watch: {
    value(val) {
      this.option =
        this.options.find(
          option => val == (typeof option === 'object' ? option.value : option)
        ) || null
    }
  }
}
</script>
