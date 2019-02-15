<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between h-16 mb-3">
      <h1 class="inline text-grey-darkest text-xl font-bold">Queue</h1>
      <base-button color="primary" @click="generateQueue" :waiting="saving" :disabled="saving">Generate</base-button>
    </div>
    <div class="flex -mx-4">
      <div class="w-2/6 px-4">
        <base-card>
          <ul class="list-reset">
            <li class="p-4 text-center" :class="{'border-b': index < queues.length - 1}" v-for="(queue, index) in queues">
              <span class="text-2xl font-semibold">{{ queue.ticket }}</span>
            </li>
          </ul>
        </base-card>
      </div>
    </div>
  </div>
</template>

<script>
import apiQueue from '@/api/queues'

export default {
  name: 'QueueList',
  data() {
    return {
      queues: [],
      saving: false
    }
  },
  created() {
    this.fetch()
  },
  methods: {
    async generateQueue() {
      this.saving = true

      try {
        let response = await apiQueue.store('queue/generate')
        this.queues.push(response.data)
        this.$toasted.success('A new queue was generated')
      } catch (error) {
        this.$toasted.error(error.data.message)
      }

      this.saving = false
    },
    fetch() {
      apiQueue.list().then(response => {
        this.queues = response.data
      })
    }
  }
}
</script>
