<template>
  <div ref="simple-scrollbar">
    <div class="simplebar-wrapper">
      <div class="simplebar-height-auto-observer-wrapper">
        <div class="simplebar-height-auto-observer" />
      </div>
      <div class="simplebar-mask">
        <div class="simplebar-offset">
          <div class="simplebar-content">
            <slot></slot>
          </div>
        </div>
      </div>
      <div class="simplebar-placeholder" />
    </div>
    <div class="simplebar-track simplebar-horizontal">
      <div class="simplebar-scrollbar" />
    </div>
    <div class="simplebar-track simplebar-vertical">
      <div class="simplebar-scrollbar" />
    </div>
  </div>
</template>

<script>
import SimpleBar from 'simplebar'

export default {
  name: 'SimplebScrollbar',
  data() {
    return {
      scrollbar: null
    }
  },
  mounted() {
    this.scrollbar = new SimpleBar(this.$refs['simple-scrollbar'])
  }
}
</script>
