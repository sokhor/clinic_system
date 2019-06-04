<template>
  <div class="perpage">
    <span>Show</span>
    <select
      class="form-input mr-2 ml-2"
      @change="onChangeSelected"
      :value="value"
    >
      <option>15</option>
      <option>30</option>
      <option>50</option>
      <option>100</option>
    </select>
    <span>entries</span>
  </div>
</template>

<script>
export default {
  name: 'PerPage',
  props: ['value'],
  methods: {
    onChangeSelected($event) {
      this.$emit('change', parseInt($event.target.value))
    }
  }
}
</script>
