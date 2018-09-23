<template>
  <on-click-outside :do="close">
    <div>
      <div ref="button" @click="open">
        <slot />
      </div>
      <div
        class="absolute bg-white p-3 shadow rounded"
        v-show="isOpen"
        ref="dropdown"
      >
        <slot name="dropdown-items" />
      </div>
    </div>
  </on-click-outside>
</template>

<script>
import Popper from 'popper.js'
import OnClickOutside from '@/components/on-click-outside.vue'

export default {
  name: 'BaseDropDown',
  components: { OnClickOutside },
  data() {
    return {
      popper: null,
      isOpen: false
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
      })
    },
    close() {
      if (!this.isOpen) {
        return
      }
      this.isOpen = false
    },
    setupPopper() {
      if (this.popper === null) {
        this.popper = new Popper(this.$refs.button, this.$refs.dropdown, {
          placement: 'bottom',
          modifiers: {
            preventOverflow: {
              boundariesElement: document.querySelector('body')
            },
          }
        })
      } else {
        this.popper.scheduleUpdate()
      }
    }
  }
}
</script>
