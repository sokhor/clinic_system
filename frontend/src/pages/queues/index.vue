<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Queue</h1>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-th>Queue No</base-th>
          <base-th>Patient Name</base-th>
          <base-th>Patient Code</base-th>
          <base-th>Age</base-th>
          <base-th>Gender</base-th>
          <base-th>Status</base-th>
          <base-th>duration</base-th>
          <base-th class="w-1"></base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="queue in queues" :key="queue.id">
            <base-td>{{ queue.queue_no }}</base-td>
            <base-td>{{ queue.patient.full_name }}</base-td>
            <base-td>{{ queue.patient.code }}</base-td>
            <base-td>{{ queue.patient.age }} yrs</base-td>
            <base-td>{{ queue.patient.gender }}</base-td>
            <base-td>{{ queue.status_text }}</base-td>
            <base-td>{{ fromNow(queue.created_at) }}</base-td>
            <base-td class="flex">
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="Edit"
                @click="edit(queue)"
              >
                <i class="fas fa-edit"></i>
              </base-button>
              <base-button
                flat
                color="danger"
                title="Delete"
                @click="destroy(queue)"
                :waiting="queue._deleting"
              >
                <i class="fas fa-trash" v-show="!queue._deleting"></i>
              </base-button>
            </base-td>
          </base-tr>
        </base-tbody>
      </base-table>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import moment from 'moment'

export default {
  name: 'Queues',
  computed: {
    ...mapState('queues', { queues: 'resources' }),
    fromNow: () => date => {
      return moment(date).fromNow()
    }
  },
  created() {
    this.fetchQueues()
  },
  methods: {
    ...mapActions('queues', { fetchQueues: 'list' }),
    edit(patient) {
      this.$router.push({
        name: 'queues-edit',
        params: { id: queue.id, queue }
      })
    },
    view(patient) {
      this.$router.push({
        name: 'queues-show',
        params: { id: queue.id, queueProp: patient }
      })
    },
    async destroy(queue) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      patient._deleting = true
      try {
        await this.$store.dispatch('queues/destroy', queue)
        this.$toasted.success('Queue deleted successfully')
        this.fetchQueues()
      } catch (error) {
        this.$toasted.error(error.message)
      }
      patient._deleting = false
    }
  }
}
</script>
