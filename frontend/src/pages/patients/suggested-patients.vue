<template>
  <div>
    <base-card v-show="patients.length">
      <div class="p-4 border-b" v-for="patient in patients" :key="patient.id">
        <div class="flex">
          <img :src="patient.photo" v-if="patient.photo" />
          <base-user-icon class="h-16 w-16 rounded-full" v-else />
          <div class="ml-2">
            <span class="text-gray-600 mb-2 text-lg font-semibold">
              {{ patient.full_name }}
            </span>
            <span class="font-normal ml-2">({{ patient.age }})</span>
            <p class="text-gray-500">{{ patient.code }}</p>
          </div>
        </div>
        <div class="mt-2 flex">
          <div class="flex-grow">
            <span class="block text-gray-700">
              <i class="fas fa-phone inline-block w-5"></i>
              {{ patient.phone }}
            </span>
            <span class="block text-gray-700">
              <i class="far fa-id-card inline-block w-5"></i>
              {{ patient.identity_no }}
              <base-badge :color="identityColor(patient.identity_type)">
                {{ patient.identity_type_text }}
              </base-badge>
            </span>
          </div>
          <div class="self-end">
            <base-button flat sm color="primary" @click="select(patient)">
              <i class="fas fa-share"></i> Re-visit
            </base-button>
          </div>
        </div>
      </div>
    </base-card>
    <p class="flex items-center justify-center" v-show="patients.length === 0">
      <span class="fas fa-spinner spinning" v-show="patientLoading"></span>
      <span v-show="!patientLoading">No existed patients</span>
    </p>
  </div>
</template>

<script>
export default {
  name: 'suggested-patients',
  props: ['patients', 'patientLoading'],
  computed: {
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
  }
}
</script>
