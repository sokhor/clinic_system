<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Patient Visit</h1>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-th>Visit ID</base-th>
          <base-th>Visited At</base-th>
          <base-th>Patient Code</base-th>
          <base-th>Patient Name</base-th>
          <base-th>Age</base-th>
          <base-th>Gender</base-th>
          <base-th>Status</base-th>
          <base-th>Type</base-th>
          <base-th></base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="visit in visits" :key="visit.id">
            <base-td>{{ visit.id }}</base-td>
            <base-td>{{ visit.created_at }}</base-td>
            <base-td>{{ visit.patient.code }}</base-td>
            <base-td>{{ visit.patient.full_name }}</base-td>
            <base-td>{{ visit.patient.age }} yrs</base-td>
            <base-td>{{ visit.patient.gender }}</base-td>
            <base-td>{{ visit.status_text}}</base-td>
            <base-td>{{ visit.type_text }}</base-td>
            <base-td class="flex w-1">
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="View"
                @click="view(visit)"
              >
                <i class="fas fa-eye"></i>
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

export default {
  name: 'Visits',
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
