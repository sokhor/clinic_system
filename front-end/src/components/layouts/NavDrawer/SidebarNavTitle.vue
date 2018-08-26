<template>
  <li class="px-4 py-3 text-xs text-silver font-bold uppercase" :class="classList">
    <template v-if="wrapper && wrapper.element">
      <component v-bind:is="wrapper.element" v-bind="wrapper.attributes">
        {{name}}
      </component>
    </template>
    <template v-else>
      {{name}}
    </template>
  </li>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      default: ""
    },
    classes: {
      type: String,
      default: ""
    },
    wrapper: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    classList() {
      return ["nav-title", ...this.itemClasses];
    },
    itemClasses() {
      return this.classes ? this.classes.split(" ") : "";
    }
  }
};
</script>
