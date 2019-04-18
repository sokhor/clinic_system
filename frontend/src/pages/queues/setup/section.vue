<template>
  <section>
    <div class="flex justify-between">
      <h3>{{ section.name }}</h3>
      <div>
        <base-button
          flat
          color="primary"
          class="mr-3"
          v-tooltip="'Edit section'"
          @click="editSection"
        >
          <i class="fas fa-pencil-alt"></i>
        </base-button>
        <base-button
          flat
          color="danger"
          v-tooltip="'Delete section'"
          @click="deleteSection"
        >
          <i class="fas fa-trash" v-show="!deleting"></i>
          <base-waiting v-show="deleting" />
        </base-button>
      </div>
    </div>
    <hr class="border-b border-gray-500" />
    <div class="flex flex-wrap -mx-2">
      <div
        v-for="queueCounter in section.counters"
        :key="queueCounter.id"
        class="p-2"
      >
        <queue-counter :counter="queueCounter" :key="queueCounter.id" />
      </div>
      <div class="p-2">
        <base-button
          flat
          class="w-32 h-32 flex justify-center items-center border border-dashed border-gray-500 text-2xl"
          @click="addNewCounter"
        >
          <i class="fas fa-plus"></i>
        </base-button>
      </div>
    </div>
  </section>
</template>

<script>
import QueueCounter from './counter'
import CounterNew from './counter-new'
import SectionEdit from './section-edit'

export default {
  name: 'QueueSection',
  components: { QueueCounter, CounterNew, SectionEdit },
  props: ['section'],
  data() {
    return {
      deleting: false
    }
  },
  methods: {
    addNewCounter() {
      this.$modal.show(
        CounterNew,
        {
          section: this.section
        },
        {
          height: 'auto',
          clickToClose: false
        }
      )
    },
    editSection() {
      this.$modal.show(
        SectionEdit,
        {
          section: this.section
        },
        {
          height: 'auto',
          clickToClose: false
        }
      )
    },
    async deleteSection() {
      this.deleting = true

      try {
        let response = await this.$store.dispatch(
          'queues/deleteSection',
          this.section
        )
        this.$toasted.success(response.message)
      } catch (error) {
        this.$toasted.error(error)
      }

      this.deleting = false
    }
  }
}
</script>
