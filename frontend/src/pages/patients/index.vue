<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Patient</h1>
      <base-button color="accent" @click="$router.push('/patients/create')">Create</base-button>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <base-table>
        <base-thead>
          <base-th>Name KH</base-th>
          <base-th>Name EN</base-th>
          <base-th>Gender</base-th>
          <base-th>Date of Birth</base-th>
          <base-th>Phone</base-th>
          <base-th class="w-1"></base-th>
        </base-thead>
        <base-tbody>
          <base-tr v-for="patient in patients" :key="patient.id">
            <base-td>{{ patient.name_kh }}</base-td>
            <base-td>{{ patient.name_en }}</base-td>
            <base-td>{{ gender(patient.gender) }}</base-td>
            <base-td>{{ patient.dob }}</base-td>
            <base-td>{{ patient.phone }}</base-td>
            <base-td class="flex">
              <base-button
                class="mr-2"
                flat
                color="primary"
                title="Edit"
                @click="edit(patient)"
              >
                <i class="fas fa-edit"></i>
              </base-button>
              <base-button
                flat
                color="danger"
                title="Delete"
                @click="destroy(patient)"
                :waiting="patient._deleting"
              >
                <i class="fas fa-trash" v-show="!patient._deleting"></i>
              </base-button>
            </base-td>
          </base-tr>
        </base-tbody>
      </base-table>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'

export default {
  name: 'Patients',
  computed: {
    ...mapState('patients', { patients: 'resources' }),
    ...mapGetters(['gender'])
  },
  created() {
    this.fetchPatients()
  },
  methods: {
    ...mapActions('patients', { fetchPatients: 'list' }),
    edit(patient) {
      this.$router.push({
        name: 'patients-edit',
        params: { id: patient.id, patient }
      })
    },
    view(patient) {
      this.$router.push({
        name: 'patients-show',
        params: { id: patient.id, patientProp: patient }
      })
    },
    async destroy(patient) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      patient._deleting = true
      try {
        await this.$store.dispatch('patients/destroy', patient)
        this.$toasted.success('Patient deleted successfully')
        this.fetchPatients()
      } catch (error) {
        this.$toasted.error(error.message)
      }
      patient._deleting = false
    }
  }
}
</script>
