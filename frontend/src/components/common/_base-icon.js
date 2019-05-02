import camelCase from 'lodash/camelCase'

export default {
  props: {
    source: {
      type: String,
      default: 'font-awesome'
    },
    name: {
      type: String,
      required: true
    }
  },
  computed: {
    customIconClass() {
      return this.$style[camelCase('icon-custom-' + this.name)]
    }
  },
  render() {
    return (
      <span
        {...{
          class:
            this.source === 'font-awesome' ? this.name : this.customIconClass
        }}
        aria-hidden="true"
      />
    )
  }
}
