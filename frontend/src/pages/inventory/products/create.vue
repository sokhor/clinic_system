<template>
  <div class="w-full">
    <!-- <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/roles"><i class="fas fa-arrow-left"></i></router-link> / Create Product
      </h1>
    </div>
    <div class="flex -mx-4">
      <div>
        <BaseCard class="p-4">
          <form>
            <div class="flex -mx-4">
              <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Product Name
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.product_name"
                      type="text"
                      autofocus
                      @input="$v.form.product_name.$touch()"
                    />
                    <span class="block text-xs italic text-red" v-if="productNameErrors.length > 0">
                      {{ productNameErrors[0] }}
                    </span>
                  </div>
                </div>
                <div class="w-1/2 p-4">
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Product Code
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.product_code"
                      type="text"
                      autofocus
                      @input="$v.form.product_code.$touch()"
                    />
                    <span class="block text-xs italic text-red" v-if="productCodeErrors.length > 0">
                      {{ productCodeErrors[0] }}
                    </span>
                  </div>
                </div>
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Brand Name
                  </label>
                  <div class="w-3/5">
                    <input
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.brand_name"
                      type="text"
                      autofocus
                      @input="$v.form.brand_name.$touch()"
                    />
                    <span class="block text-xs italic text-red" v-if="brandNameErrors.length > 0">
                      {{ brandNameErrors[0] }}
                    </span>
                  </div>
                </div>
                <div class="flex items-start mb-3">
                  <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
                    Category
                  </label>
                  <div class="w-3/5">
                    <select
                      class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                      v-model="form.category_id"
                      type="text"
                      @input="$v.form.category_id.$touch()"
                    >
                      <option value="">--Choose--</option>
                      <option value="1">Antibiotic</option>
                      <option value="2">Gastro-enterology</option>
                    </select>
                    <span class="block text-xs italic text-red" v-if="nationalityCodeErrors.length > 0">
                      {{ nationalityCodeErrors[0] }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex items-center mt-4">
              <div>
                <base-button outline class="mr-5" color="primary" :waiting="saving" @click="save">
                  Create
                </base-button>
                <base-button color="primary" :waiting="savingAndNew" @click="saveAndNew">
                  Create &amp; New
                </base-button>
              </div>
            </div>
          </form>
        </BaseCard>
      </div>
    </div> -->
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
