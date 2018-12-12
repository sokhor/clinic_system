<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Patients</h1>
      <BaseButton color="primary" @click="$router.push('/patients/create')">Register</BaseButton>
    </div>
    <BaseCard>
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
      <BaseTable>
        <BaseThead>
          <BaseTh>Code</BaseTh>
          <BaseTh>Name</BaseTh>
          <BaseTh>Gender</BaseTh>
          <BaseTh>Date Of Birth</BaseTh>
          <BaseTh>Phone</BaseTh>
          <BaseTh>Identity</BaseTh>
          <BaseTh class="w-1"></BaseTh>
        </BaseThead>
        <BaseTbody>
          <BaseTr v-for="patient in patients">
            <BaseTd>{{ patient.code }}</BaseTd>
            <BaseTd>
              <div class="flex items-center">
                <img :src="patient.photo" v-if="patient.photo">
                <BaseUserIcon class="h-8 w-8 rounded-full mr-2" v-else/>
                <span>{{ patient.full_name }}</span>
              </div>
            </BaseTd>
            <BaseTd>{{ patient.gender }}</BaseTd>
            <BaseTd>
              <span>{{ patient.dob}}</span>
              <BaseBadge
                color="blue"
                class="ml-2"
              >
                {{ patient.age }}
              </BaseBadge>
            </BaseTd>
            <BaseTd>{{ patient.phone }}</BaseTd>
            <BaseTd>
              {{ patient.identity_no }}
              <BaseBadge
                :color="identityColor(patient.identity_type)"
                class="ml-2"
              >
                {{ patient.identity_type_text }}
              </BaseBadge>
            </BaseTd>
            <BaseTd class="w-1">
              <div class="flex">
                <BaseButton
                  flat
                  color="primary"
                  title="Revisit"
                >
                  <i class="fas fa-share"></i>
                </BaseButton>
                <BaseButton
                  flat
                  color="primary"
                  title="View"
                  class="ml-4"
                  @click="$router.push(`/patients/${patient.id}`)"
                >
                  <i class="fas fa-eye"></i>
                </BaseButton>
                <BaseButton
                  flat
                  color="primary"
                  title="Edit"
                  class="ml-4"
                >
                  <i class="fas fa-edit"></i>
                </BaseButton>
              </div>
            </BaseTd>
          </BaseTr>
        </BaseTbody>
      </BaseTable>
    </BaseCard>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import { debounce } from 'lodash'

export default {
  name: 'Patients',
  data() {
    return {
      patient: null,
      loadingPatient: true,
      search: ''
    }
  },
  computed: {
    ...mapState('patients', { patients: 'resources' }),
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
  created() {
    this.listPatients()
  },
  methods: {
    registerNew() {
      this.patient = {}
    },
    listPatients() {
      this.loadingPatient = true

      this.$store
        .dispatch('patients/list')
        .then(() => (this.loadingPatient = false))
    }
  },
  watch: {
    search: debounce(function(search) {
      this.loadingPatient = true

      this.$store
        .dispatch('patients/list', {
          filter: {
            full_name: search
            // phone: search,
            // identity_no: search,
            // code: search,
            // email: search
          }
        })
        .then(() => (this.loadingPatient = false))
    }, 500)
  }
}
</script>
