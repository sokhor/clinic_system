import Popper from 'popper.js'
import OnClickOutside from '@/components/on-click-outside.vue'

export default {
  name: 'BaseDropDown',
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
            }
          }
        })
      } else {
        this.popper.scheduleUpdate()
      }
    }
  },
  render() {
    return (
      <OnClickOutside do={this.close}>
        <div>
          <div ref="button" vOn:click={this.open}>
            {this.$slots.default}
          </div>
          <div
            class="absolute bg-white p-3 shadow rounded"
            v-show={this.isOpen}
            ref="dropdown"
          >
            {this.$slots['dropdown-items']}
          </div>
        </div>
      </OnClickOutside>
    )
  }
}
