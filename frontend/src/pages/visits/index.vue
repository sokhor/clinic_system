<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between items-end mb-3">
      <h1 class="inline text-gray-900 text-xl font-bold">Visit</h1>
    </div>
    <base-card>
      <div class="p-4 flex">
        <input
          type="text"
          class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-64"
          v-model="search"
          placeholder="Search..."
        />
        <div class="flex-auto"></div>
        <BaseButton outline sm>
          <i class="fas fa-filter"></i>
        </BaseButton>
      </div>
      <base-table :columns="columns" :records="visits">
        <template slot-scope="{ record }">
          <td>{{ record.id }}</td>
          <td>{{ record.patient.code }}</td>
          <td>{{ record.patient.full_name }}</td>
          <td>{{ record.progress_text }}</td>
          <td>{{ record.ipd ? 'IPD' : 'OPD' }}</td>
          <td>{{ record.duration }}</td>
        </template>
      </base-table>
    </base-card>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'Visits',
  data() {
    return {
      columns: [
        'Visit ID',
        'Patient Code',
        'Patient Name',
        'Progress',
        'IPD/OP',
        'Duration'
      ],
      search: ''
    }
  },
  computed: {
    ...mapState('visits', { visits: 'resources' })
  },
  created() {
    this.fetchVisits()
  },
  methods: {
    ...mapActions('visits', { fetchVisits: 'list' }),
    view(visit) {
      this.$router.push(`/visits/${visit.id}`)
    }
  }
}
</script>
