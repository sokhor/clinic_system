<template>
  <div>
    <div class="flex justify-between px-4 py-2">
      <h3 class="font-bold text-gray-800">Select Section</h3>
      <base-button flat @click="$emit('close')">
        <i class="fas fa-times"></i>
      </base-button>
    </div>
    <div class="p-4">
      <div class="flex flex-col items-center justify-center">
        <base-button
          class="w-full mt-3"
          color="primary"
          :waiting="saving"
          @click="generateQueue(section.id)"
          v-for="section in queueSections"
          :key="section.id"
        >
          {{ section.name }}
        </base-button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'QueueCreate',
  props: ['queueSections'],
  data() {
    return {
      saving: false
    }
  },
  methods: {
    async generateQueue(sectionId) {
      this.saving = true

      try {
        await this.$store.dispatch('queues/store', sectionId)
        this.$toasted.success('A new queue was generated')
      } catch (error) {
        this.$toasted.error(error.data.message)
      }

      this.saving = false
    }
  }
}
</script>
