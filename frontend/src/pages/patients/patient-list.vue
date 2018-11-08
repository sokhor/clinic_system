<template>
  <BaseCard class="h-full">
    <div
      class="w-full h-full flex justify-center items-center cursor-pointer bg-white p-4"
      v-if="patients.length === 0"
    >
      <p class="text-center leading-loose">
        <i class=" block fab fa-accessible-icon text-5xl mb-2"></i>
        <BaseButton color="primary" class="capitalize" @click="registerNew">Register a new patient</BaseButton>
      </p>
    </div>
    <div
      v-for="(patient, index) in patients"
      :key="patient.id"
      class="w-full flex cursor-pointer group hover:bg-grey-lightest"
      :class="{'border-b': index < patients.length - 1}"
    >
      <div class="p-4 flex items-center">
        <!-- <div class="h-16 w-16 bg-cover rounded-full text-center overflow-hidden" style="background-image: url('https://pbs.twimg.com/profile_images/885868801232961537/b1F6H4KC_400x400.jpg')">
        </div> -->
        <svg class="h-16 w-16 rounded-full fill-current text-grey-dark" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><circle cx="16" cy="7.5" r="7.4"></circle><path d="M16,18C7.7,18,1,24.3,1,32h30C31,24.3,24.3,18,16,18z"></path></svg>
      </div>
      <div class="p-4 flex flex-col justify-between flex-grow leading-normal">
        <div class="mb-2">
          <div class="font-bold text-lg">{{ patient.name_en }}</div>
          <div class="font-semibold mb-4">#{{ patient.id }}</div>
          <div class="text-sm flex">
            <p class="text-grey-darker flex-1">
              <i class="far fa-id-badge inline-block w-4 h-4"></i> {{ patient.identity_no }}
              <BaseBadge
                :color="identityColor(patient.identity_type)"
                class="italic"
              >
                {{ patient.identity_type_text }}
              </BaseBadge>
            </p>
            <p class="text-grey-darker flex-1">
              <i class="fas fa-mobile-alt inline-block w-4 h-4"></i> {{ patient.phone }}
            </p>
            <p class="text-grey-darker flex-1">
              <i class="inline-block w-4 h-4" :class="[genderIcon(patient.gender)]"></i> {{ gender(patient.gender) }}{{ patient.age ? `, ${patient.age} yrs`: '' }}
            </p>
          </div>
        </div>
      </div>
      <div class="p-4 flex items-center justify-end">
        <BaseButton sm color="primary" @click="selectPatient(patient)">
          Choose
        </BaseButton>
      </div>
    </div>
  </BaseCard>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'

export default {
  name: 'Patients',
  computed: {
    ...mapState('patients', { patients: 'resources' }),
    ...mapGetters(['gender']),
    genderIcon: () => gender => {
      if (gender === 'M') {
        return 'fas fa-mars'
      } else if (gender === 'F') {
        return 'fas fa-venus'
      }
    },
    gender: () => gender => {
      if (gender === 'M') {
        return 'Male'
      } else if (gender === 'F') {
        return 'Female'
      }
    },
    identityColor: () => identityType => {
      switch (identityType) {
        case 1:
          return 'green'
        case 2:
          return 'red'
        case 3:
          return 'blue'
      }
    }
  },
  methods: {
    ...mapActions('patients', { fetchPatients: 'list' }),
    selectPatient(patient) {
      this.$emit('selected-patient', patient)
    },
    registerNew() {
      this.$emit('register-new-patient')
    }
  }
}
</script>
