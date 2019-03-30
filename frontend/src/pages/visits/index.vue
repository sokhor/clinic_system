<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between items-end mb-3">
      <h1 class="inline text-grey-darkest text-xl font-bold">Visit</h1>
    </div>
    <base-card>
      <div class="p-4 flex">
        <input
          type="text"
          class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-64"
          v-model="search"
          placeholder="Search..."
        />
        <div class="flex-auto"></div>
        <BaseButton outline sm>
          <i class="fas fa-filter"></i>
        </BaseButton>
      </div>
      <base-table>
        <base-thead>
          <base-th>Visit ID</base-th>
          <base-th>Patient Code</base-th>
          <base-th>Patient Name</base-th>
          <base-th>Progress</base-th>
          <base-th>IPD/OPD</base-th>
          <base-th>Duration</base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="visit in visits" :key="visit.id">
            <base-td>{{ visit.id }}</base-td>
            <base-td>{{ visit.patient.code }}</base-td>
            <base-td>{{ visit.patient.full_name }}</base-td>
            <base-td>{{ visit.progress_text}}</base-td>
            <base-td>{{ visit.ipd ? 'IPD' : 'OPD' }}</base-td>
            <base-td>{{ visit.duration }}</base-td>
          </base-tr>
        </base-tbody>
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
