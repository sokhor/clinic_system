<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        Patient Registration
      </h1>
    </div>
    <div class="flex -mx-4">
      <div class="w-3/4 px-4">
        <BaseCard class="p-4">
          <form>
            <div class="flex -mx-4">
              <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Full name
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.full_name"
                      type="text"
                      autofocus
                      @input="$v.form.full_name.$touch() || loadExistedPatients()"
                    />
                    <span class="block text-xs italic text-red" v-if="fullNameErrors.length > 0">
                      {{ fullNameErrors[0] }}
                    </span>
                  </div>
                </div>
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Other Name
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.full_name_2"
                      type="text"
                    />
                  </div>
                </div>
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Gender
                  </label>
                  <div class="w-3/5">
                    <select
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.gender"
                      type="text"
                      @input="$v.form.gender.$touch()"
                    >
                      <option value="">--Choose--</option>
                      <option value="M">Male</option>
                      <option value="F">Female</option>
                    </select>
                    <span class="block text-xs italic text-red" v-if="genderErrors.length > 0">
                      {{ genderErrors[0] }}
                    </span>
                  </div>
                </div>
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Date of Birth
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.dob"
                      type="text"
                    />
                  </div>
                </div>
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Nationality
                  </label>
                  <div class="w-3/5">
                    <select
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.nationality_code"
                      type="text"
                      @input="$v.form.nationality_code.$touch()"
                    >
                      <option value="">--Choose--</option>
                      <option value="KH">Cambodian</option>
                    </select>
                    <span class="block text-xs italic text-red" v-if="nationalityCodeErrors.length > 0">
                      {{ nationalityCodeErrors[0] }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="w-1/2 p-4">
                <div class="text-center">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-32 h-32 fill-current stroke-current text-grey-dark">
                    <circle cx="16" cy="7.5" r="7.4"/>
                    <path d="M16,18C7.7,18,1,24.3,1,32h30C31,24.3,24.3,18,16,18z"/>
                  </svg>
                </div>
              </div>
            </div>
            <h3 class="text-grey-dark font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">Contact</h3>
            <div class="flex -mx-4">
              <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Phone
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.phone"
                      type="text"
                      @input="$v.form.phone.$touch() || loadExistedPatients()"
                    />
                    <span class="block text-xs italic text-red" v-if="phoneErrors.length > 0">
                      {{ phoneErrors[0] }}
                    </span>
                  </div>
                </div>
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Email
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.email"
                      type="email"
                      @input="loadExistedPatients()"
                    />
                  </div>
                </div>
              </div>
              <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Address
                  </label>
                  <div class="w-3/5">
                    <textarea
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.address"
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>
            <h3 class="text-grey-dark font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">Identity</h3>
            <div class="flex -mx-4">
              <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Identity Type
                  </label>
                  <div class="w-3/5">
                    <select
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.identity_type"
                      @input="$v.form.identity_type.$touch()"
                    >
                      <option value="">--Choose--</option>
                      <option value="1">National ID</option>
                      <option value="2">Passport</option>
                      <option value="3">Driving License</option>
                    </select>
                    <span class="block text-xs italic text-red" v-if="identityTypeErrors.length > 0">
                      {{ identityTypeErrors[0] }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Identity No
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.identity_no"
                      type="text"
                      @input="$v.form.identity_no.$touch() || loadExistedPatients()"
                    />
                    <span class="block text-xs italic text-red" v-if="identityNoErrors.length > 0">
                      {{ identityNoErrors[0] }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <h3 class="text-grey-dark font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">Other</h3>
            <div class="flex -mx-4">
              <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Type
                  </label>
                  <div class="w-3/5">
                    <select
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.type"
                      @input="$v.form.type.$touch()"
                    >
                      <option value="">--Choose--</option>
                      <option value="1">Consulting</option>
                      <option value="2">Para-clinic</option>
                    </select>
                    <span class="block text-xs italic text-red" v-if="typeErrors.length > 0">
                      {{ typeErrors[0] }}
                    </span>
                  </div>
                </div>
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Referal
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.referal_id"
                      type="text"
                    />
                    <a href="#" class="block text-xs no-underline hover:underline mt-1" @click.prevent="addNewReferal">
                      <i class="fas fa-plus"></i> Add new
                    </a>
                  </div>
                </div>
              </div>
              <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Assign To
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.assigned_id"
                      type="text"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="flex items-center mt-4">
              <div class="flex-grow">
                <base-checkbox v-model="print_name_card">
                  Print name card
                </base-checkbox>
              </div>
              <div>
                <base-button flat color="primary" class="mr-5" @click="clearSelect">
                  Clear
                </base-button>
                <base-button outline class="mr-5" color="primary" :waiting="saving" @click="save">
                  Register
                </base-button>
                <base-button color="primary" :waiting="savingAndNew" @click="saveAndNew">
                  Register & New
                </base-button>
              </div>
            </div>
          </form>
        </BaseCard>
      </div>
      <div class="w-1/4 px-4">
        <h4 class="text-grey-darkest mb-2">Suggested Patients</h4>
        <BaseCard v-show="patients.length">
          <div class="p-4 border-b" v-for="patient in patients">
            <div class="flex">
              <img :src="patient.photo" v-if="patient.photo">
                <BaseUserIcon class="h-16 w-16 rounded-full" v-else/>
              <div class="ml-2">
                <span class="text-grey-darkest mb-2 text-lg font-semibold">{{ patient.full_name }}</span>
                <span class="font-normal ml-2">({{ patient.age }})</span>
                <p class="text-grey">{{ patient.code }}</p>
              </div>
            </div>
            <div class="mt-2 flex">
              <div class="flex-grow">
                <span class="block text-grey-darker">
                  <i class="fas fa-phone inline-block w-5"></i> {{ patient.phone}}
                </span>
                <span class="block text-grey-darker">
                  <i class="far fa-id-card inline-block w-5"></i> {{ patient.identity_no }}
                  <BaseBadge
                    :color="identityColor(patient.identity_type)"
                  >
                    {{ patient.identity_type_text }}
                  </BaseBadge>
                </span>
              </div>
              <div class="self-end">
                <BaseButton flat sm color="primary" @click="select(patient)">
                  <i class="fas fa-share"></i> Re-visit
                </BaseButton>
              </div>
            </div>
          </div>
        </BaseCard>
        <p class="flex items-center justify-center" v-show="patients.length === 0">
          <span class="fas fa-spinner spinning" v-show="patientLoading"></span>
          <span v-show="!patientLoading">No existed patients</span>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { required } from 'vuelidate/lib/validators'
import { debounce } from 'lodash'

export default {
  name: 'PatientCreate',
  data() {
    return {
      form: {
        id: '',
        full_name: '',
        full_name_2: '',
        dob: '',
        gender: '',
        nationality_code: '',
        phone: '',
        email: '',
        address: '',
        identity_type: '',
        identity_no: '',
        referal_id: '',
        assigned_id: '',
        type: '',
        photo: null
      },
      saving: false,
      savingAndNew: false,
      patientLoading: false,
      patients: [],
      print_name_card: false
    }
  },
  validations: {
    form: {
      full_name: { required },
      gender: { required },
      nationality_code: { required },
      phone: { required },
      identity_type: { required },
      identity_no: { required },
      type: { required }
    }
  },
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
    },
    fullNameErrors() {
      const errors = []
      if (!this.$v.form.full_name.$dirty) return errors
      !this.$v.form.full_name.required && errors.push('Required')
      return errors
    },
    genderErrors() {
      const errors = []
      if (!this.$v.form.gender.$dirty) return errors
      !this.$v.form.gender.required && errors.push('Required')
      return errors
    },
    nationalityCodeErrors() {
      const errors = []
      if (!this.$v.form.nationality_code.$dirty) return errors
      !this.$v.form.nationality_code.required && errors.push('Required')
      return errors
    },
    phoneErrors() {
      const errors = []
      if (!this.$v.form.phone.$dirty) return errors
      !this.$v.form.phone.required && errors.push('Required')
      return errors
    },
    identityTypeErrors() {
      const errors = []
      if (!this.$v.form.identity_type.$dirty) return errors
      !this.$v.form.identity_type.required && errors.push('Required')
      return errors
    },
    identityNoErrors() {
      const errors = []
      if (!this.$v.form.identity_no.$dirty) return errors
      !this.$v.form.identity_no.required && errors.push('Required')
      return errors
    },
    typeErrors() {
      const errors = []
      if (!this.$v.form.type.$dirty) return errors
      !this.$v.form.type.required && errors.push('Required')
      return errors
    }
  },
  methods: {
    async save(addNew = false) {
      this.$v.$touch()
      if (this.$v.$error) {
        throw 'Validation failed'
      }

      this.saving = true
      try {
        await this.$store.dispatch('patients/store', this.form)
        this.$toasted.success('Patient registered successfully')
        this.$router.push('/visits')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.saving = false
    },
    async saveAndNew() {
      this.$v.$touch()
      if (this.$v.$error) {
        throw 'Validation failed'
      }

      this.savingAndNew = true
      try {
        await this.$store.dispatch('patients/store', this.form)
        this.$toasted.success('Patient registered successfully')
        this.clearSelect()
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.savingAndNew = false
    },
    select(patient) {
      this.form.id = patient.id
      this.form.full_name = patient.full_name
      this.form.full_name_2 = patient.full_name_2
      this.form.dob = patient.dob
      this.form.gender = patient.gender
      this.form.nationality_code = patient.nationality_code
      this.form.phone = patient.phone
      this.form.email = patient.email
      this.form.address = patient.address
      this.form.identity_type = patient.identity_type
      this.form.identity_no = patient.identity_no
      this.form.referal_id = patient.referal_id
    },
    clearSelect() {
      this.form.id = ''
      this.form.full_name = ''
      this.form.full_name_2 = ''
      this.form.dob = ''
      this.form.gender = ''
      this.form.nationality_code = ''
      this.form.phone = ''
      this.form.email = ''
      this.form.address = ''
      this.form.identity_type = ''
      this.form.identity_no = ''
      this.form.referal_id = ''

      this.$v.form.$reset()
    },
    loadExistedPatients: debounce(function() {
      if (
        this.form.full_name.trim() === '' &&
        this.form.phone.trim() === '' &&
        this.form.email.trim() === '' &&
        this.form.identity_no.trim() === ''
      )
        return (this.patients = [])

      this.patients = []
      this.patientLoading = true
      this.$store
        .dispatch('patients/list', {
          filter: {
            full_name: this.form.full_name
            // phone: this.form.phone,
            // email: this.form.email,
            // identity_no: this.form.identity_no
          },
          per_page: 'all'
        })
        .then(response => {
          this.patients = response.data
          this.patientLoading = false
        })
    }, 500),
    addNewReferal() {}
  }
}
</script>
