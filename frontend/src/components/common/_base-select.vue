<style lang="scss">
.search-select {
  @apply relative;
  // position: relative;
}
.search-select-input {
  appearance: none;
  text-align: left;
  cursor: pointer;
  user-select: none;
  display: block;
  width: 100%;
  height: 34px;
  padding: 6px 12px;
  font-size: 12px;
  line-height: 1.42857143;
  color: #555;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 0;
  box-shadow: none;
  border-color: #d2d6de;
  white-space: nowrap;
  display: flex;
  align-items: center;

  &:focus {
    border-color: #3c8dbc;
  }
}
.search-select-placeholder,
.search-select-text {
  flex-grow: 1;
}
.search-select__arrow {
  transition: all 200ms ease-in-out;

  &::before {
    display: block;
    color: #999;
    border-style: solid;
    border-width: 5px 5px 0;
    border-color: #999 transparent transparent;
    content: '';
  }

  &__open {
    transform: rotate(180deg);
  }
}
.search-select-dropdown {
  margin-top: 0.25rem;
  margin-bottom: 0.25rem;
  position: absolute;
  right: 0;
  left: 0;
  background-color: #fff;
  padding: 0.5rem;
  border-radius: 0.25rem;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
  z-index: 50;
  border: solid 1px #d2d6de;
}
.search-select-search {
  display: block;
  margin-bottom: 0.5rem;
  width: 100%;
  padding: 0.5rem 0.75rem;
  background-color: #ededed;
  border: 1px solid #ccc;

  // &:focus {
  //   border-color: #3c8dbc;
  // }
}
.search-select-options {
  list-style: none;
  padding: 0;
  position: relative;
  overflow-y: auto;
  max-height: 14rem;
}
.search-select-option {
  padding: 0.5rem 0.75rem;
  cursor: pointer;
  border-radius: 0.25rem;
  user-select: none;

  &:hover {
    background-color: #279add;
    color: #fff;
  }

  &.is-active,
  &.is-active:hover {
    // background-color: #3490dc;
  }
}
</style>

<template>
  <on-click-outside :do="close">
    <div class="search-select" :class="{ 'is-active': isOpen }">
      <button
        ref="button"
        @click="open"
        type="button"
        class="search-select-input"
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
            @click="select(option)"
            :class="{ 'is-active': i === highlightedIndex }"
          >
            {{ typeof option === 'object' ? option.text : option }}
          </li>
        </ul>
        <div v-show="filteredOptions.length === 0" class="search-select-empty">
          <slot name="no-result" :search="search"
            >No results found for "{{ search }}"</slot
          >
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
  props: ['value', 'options', 'filterFunction'],
  data() {
    return {
      isOpen: false,
      search: '',
      highlightedIndex: 0,
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

        return `${option}`.toLowerCase().startsWith(this.search.toLowerCase())
      })
    }
  },
  methods: {
    open() {
      if (this.isOpen) {
        return
      }
      this.isOpen = true
      this.$nextTick(() => {
        this.setupPopper()
        this.$refs.search.focus()
        this.scrollToHighlighted()
      })
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
    select(option) {
      this.$emit('input', typeof option === 'object' ? option.value : option)
      this.$emit('change', typeof option === 'object' ? option.value : option)
      this.search = ''
      this.highlightedIndex = 0
      this.option = option
      this.close()
    },
    selectHighlighted() {
      this.select(this.filteredOptions[this.highlightedIndex])
    },
    scrollToHighlighted() {
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
