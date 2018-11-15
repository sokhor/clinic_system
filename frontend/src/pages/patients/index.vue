<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Registration</h1>
      <BaseButton color="primary" @click="registerNew">Register Patient</BaseButton>
    </div>
    <div class="flex -mx-2">
      <div class="w-1/5 p-2">
        <SearchVisitedPatient />
      </div>
      <div class="w-4/5 p-2">
        <component
            :is="patient ? 'RegistrationForm' : 'PatientList'"
            :loading-patient="loadingPatient"
            @selected-patient="selectPatient"
            :patient="patient"
            @cancel-form="cancelForm"
          />
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import SearchVisitedPatient from './search-visited-patient.vue'
import PatientList from './patient-list.vue'
import RegistrationForm from './registration-form.vue'

export default {
  name: 'Patients',
  components: { SearchVisitedPatient, PatientList, RegistrationForm },
  data() {
    return {
      patient: null,
      loadingPatient: true
    }
  },
  created() {
    this.listPatients()
  },
  methods: {
    selectPatient(patient) {
      this.patient = patient
    },
    cancelForm() {
      this.patient = null
    },
    registerNew() {
      this.patient = {}
    },
    listPatients() {
      this.loadingPatient = true

      this.$store
        .dispatch('patients/list')
        .then(() => (this.loadingPatient = false))
    }
  }
}
</script>
