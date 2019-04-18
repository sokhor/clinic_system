<script>
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
    // Gets a CSS module class, e.g. iconCustomLogo
    customIconClass() {
      return this.$style[camelCase('icon-custom-' + this.name)]
    }
  }
}
</script>

<template>
  <span
    v-if="source === 'font-awesome'"
    class="fas"
    :class="name"
    aria-hidden="true"
  ></span>
  <span v-else-if="source === 'custom'" :class="customIconClass" />
</template>
