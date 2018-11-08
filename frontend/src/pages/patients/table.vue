<template>
  <BaseCard>
    <BaseTable>
      <BaseThead>
        <BaseTh>ID</BaseTh>
        <BaseTh>Name KH</BaseTh>
        <BaseTh>Name EN</BaseTh>
        <BaseTh>Gender</BaseTh>
        <BaseTh>Date of Birth</BaseTh>
        <BaseTh>Phone</BaseTh>
        <BaseTh>Visited Date</BaseTh>
        <BaseTh class="w-1"></BaseTh>
      </BaseThead>
      <BaseTbody>
        <BaseTr v-for="patient in patients" :key="patient.id">
          <BaseTd>{{ patient.id }}</BaseTd>
          <BaseTd>{{ patient.name_kh }}</BaseTd>
          <BaseTd>{{ patient.name_en }}</BaseTd>
          <BaseTd>{{ gender(patient.gender) }}</BaseTd>
          <BaseTd>{{ patient.dob }}</BaseTd>
          <BaseTd>{{ patient.phone }}</BaseTd>
          <BaseTd>{{ patient.last_visited_at }}</BaseTd>
          <BaseTd class="flex">
            <BaseButton
              class="mr-2"
              flat
              color="primary"
              title="Edit"
              @click="edit(patient)"
            >
              <i class="fas fa-edit"></i>
            </BaseButton>
            <BaseButton
              flat
              color="danger"
              title="Delete"
              @click="destroy(patient)"
              :waiting="patient._deleting"
            >
              <i class="fas fa-trash" v-show="!patient._deleting"></i>
            </BaseButton>
          </BaseTd>
        </BaseTr>
      </BaseTbody>
    </BaseTable>
  </BaseCard>
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
