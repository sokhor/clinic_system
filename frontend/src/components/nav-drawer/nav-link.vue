<template>
  <div v-if="isExternalLink">
    <a
      :href="url"
      :class="classList"
      class="group block no-underline px-4 py-3 text-white font-hairline hover:text-white hover:bg-blue-500"
    >
      <span>
        <i
          :class="icon"
          class="inline-block w-6 text-blue-200 opacity-50 group-hover:text-white group-hover:opacity-100"
        ></i>
        {{ name }}
      </span>
      <base-badge v-if="badge && badge.text" :variant="badge.variant">{{
        badge.text
      }}</base-badge>
    </a>
  </div>
  <div v-else>
    <router-link
      :to="url"
      :class="classList"
      class="flex justify-between group block no-underline px-4 py-2 text-white font-hairline hover:text-white hover:bg-blue-500"
    >
      <span>
        <i
          :class="icon"
          class="inline-block w-6 text-blue-200 opacity-50 group-hover:text-white group-hover:opacity-100"
        ></i>
        {{ name }}
      </span>
      <base-badge v-if="badge && badge.text" :color="badge.color">{{
        badge.text
      }}</base-badge>
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'nav-link',
  props: {
    name: {
      type: String,
      default: ''
    },
    url: {
      type: String,
      default: ''
    },
    icon: {
      type: String,
      default: ''
    },
    badge: {
      type: Object,
      default: () => {}
    },
    variant: {
      type: String,
      default: ''
    },
    classes: {
      type: String,
      default: ''
    }
  },
  computed: {
    classList() {
      return ['nav-link', this.linkVariant, ...this.itemClasses]
    },
    linkVariant() {
      return this.variant ? `nav-link-${this.variant}` : ''
    },
    itemClasses() {
      return this.classes ? this.classes.split(' ') : []
    },
    isExternalLink() {
      if (this.url.substring(0, 4) === 'http') {
        return true
      } else {
        return false
      }
    }
  }
}
</script>
