<template>
  <base-card
    class="relative w-32 h-32 flex justify-center items-center cursor-pointer"
  >
    <p class="absolute text-center">
      <span class="block text-grey-light text-sm">Counter</span>
      <span>{{ counter.label }}</span>
    </p>
    <div class="absolute pin group">
      <div class="absolute pin group-hover:bg-blue-dark opacity-25"></div>
      <div
        class="absolute pin hidden group-hover:flex group-hover:items-center group-hover:justify-center text-2xl"
      >
        <base-button
          flat
          color="primary"
          class="mr-3"
          v-tooltip="'Edit section'"
          @click="editCounter"
        >
          <i class="fas fa-pencil-alt"></i>
        </base-button>
        <base-button
          flat
          color="danger"
          v-tooltip="'Delete section'"
          @click="deleteCounter"
        >
          <i class="fas fa-trash" v-show="!deleting"></i>
          <base-waiting v-show="deleting" />
        </base-button>
      </div>
    </div>
  </base-card>
</template>

<script>
import CounterEdit from './counter-edit'

export default {
  name: 'QueueCounter',
  components: { CounterEdit },
  props: ['counter'],
  data() {
    return {
      deleting: false
    }
  },
  methods: {
    editCounter() {
      this.$modal.show(
        CounterEdit,
        {
          counter: this.counter
        },
        {
          height: 'auto',
          clickToClose: false
        }
      )
    },
    async deleteCounter() {
      this.deleting = true

      try {
        let response = await this.$store.dispatch(
          'queues/deleteCounter',
          this.counter
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
