<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between items-end mb-3">
      <h1 class="inline text-gray-900 text-xl font-bold">Queue</h1>
      <base-button color="accent" @click="addNewQueue">Generate</base-button>
    </div>
    <div class="flex flex-wrap -mx-2">
      <div class="w-1/6 h-48 px-2 py-2" v-for="queue in queues" :key="queue.id">
        <base-card
          class="flex items-center justify-center w-full h-full cursor-pointer"
        >
          <span class="text-2xl font-semibold">{{ queue.ticket }}</span>
        </base-card>
      </div>
    </div>
  </div>
</template>

<script>
import apiQueueSection from '@/api/queues/sections'
import QueueCreate from './queue-create.vue'

let queueSections = []

export default {
  name: 'Queues',
  components: { QueueCreate },
  beforeRouteEnter(to, from, next) {
    apiQueueSection.list().then(response => {
      queueSections = response.data

      next()
    })
  },
  data() {
    return {
      queues: []
    }
  },
  created() {
    this.fetch()
  },
  methods: {
    fetch() {
      this.$store.dispatch('queues/list').then(response => {
        this.queues = response.data
      })
    },
    addNewQueue() {
      this.$modal.show(
        QueueCreate,
        {
          queueSections: queueSections.filter(qs => qs.counters.length > 0)
        },
        {
          height: 'auto',
          width: '300px',
          clickToClose: false
        }
      )
    }
  }
}
</script>
