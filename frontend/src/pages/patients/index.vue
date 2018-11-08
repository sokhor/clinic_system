<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Registration</h1>
    </div>
    <div class="flex -mx-2">
      <div class="w-1/5 p-2">
        <SearchVisitedPatient />
      </div>
      <div class="w-4/5 p-2">
        <component
            :is="patient ? 'RegistrationForm' : 'PatientList'"
            @selected-patient="selectPatient"
            @register-new-patient="patient = {}"
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
      patient: null
    }
  },
  methods: {
    selectPatient(patient) {
      this.patient = patient
    },
    cancelForm() {
      this.patient = null
    }
  }
}
</script>
