<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between h-16 mb-3">
      <h1 class="inline text-grey-darkest text-xl font-bold">Queue</h1>
      <base-button color="accent" @click="addNewQueue">Generate</base-button>
    </div>
    <div class="flex -mx-4">
      <div class="w-2/6 px-4">
        <base-card>
          <ul class="list-reset">
            <li 
              class="p-4 text-center"
              :class="{'border-b': index < queues.length - 1}"
              v-for="(queue, index) in queues"
              :key="queue.id"
            >
              <span class="text-2xl font-semibold">{{ queue.ticket }}</span>
            </li>
          </ul>
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
          queueSections: queueSections
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
