<template>
  <BaseCard>
    <form @submit.prevent="save" class="p-4">
      <div class="flex -mx-4">
        <div class="w-2/5 p-4">
          <div class="flex items-start mb-3">
            <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
              Full name
            </label>
            <div class="w-3/5">
              <input
                class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                v-model="form.full_name"
                type="text"
                @input="$v.form.full_name.$touch()"
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
                v-model="form.full_name_optional"
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
        </div>
        <div class="w-2/5 p-4">
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
      </div>
      <h3 class="text-grey font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">Contact</h3>
      <div class="flex -mx-4">
        <div class="w-2/5 p-4">
          <div class="flex items-start mb-3">
            <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
              Phone
            </label>
            <div class="w-3/5">
              <input
                class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                v-model="form.phone"
                type="text"
                @input="$v.form.phone.$touch()"
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
              />
            </div>
          </div>
        </div>
        <div class="w-2/5 p-4">
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
      <h3 class="text-grey font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">Identity</h3>
      <div class="flex -mx-4">
        <div class="w-2/5 p-4">
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
        <div class="w-2/5 p-4">
          <div class="flex items-start mb-3">
            <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
              Identity No
            </label>
            <div class="w-3/5">
              <input
                class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                v-model="form.identity_no"
                type="text"
                @input="$v.form.identity_no.$touch()"
              />
              <span class="block text-xs italic text-red" v-if="identityNoErrors.length > 0">
                {{ identityNoErrors[0] }}
              </span>
            </div>
          </div>
        </div>
      </div>
      <h3 class="text-grey font-semibold py-2 mb-2 border-b border-grey-light text-xs uppercase">Other</h3>
      <div class="flex -mx-4">
        <div class="w-2/5 p-4">
          <div class="flex items-start mb-3">
            <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
              Referal
            </label>
            <div class="w-3/5">
              <input
                class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                v-model="form.referal"
                type="text"
              />
            </div>
          </div>
        </div>
        <div class="w-2/5 p-4">
          <div class="flex items-start mb-3">
            <label class="block text-grey-darker text-sm font-bold w-2/5 text-right pr-6">
              Assign To
            </label>
            <div class="w-3/5">
              <input
                class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
                v-model="form.referal"
                type="text"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-end mt-4">
        <base-button flat color="primary" class="mr-5" @click="cancel">
          Cancel
        </base-button>
        <base-button color="primary" :waiting="saving" type="submit">
          Register
        </base-button>
      </div>
    </form>
  </BaseCard>
</template>

<script>
import { mapState } from 'vuex'
import { required } from 'vuelidate/lib/validators'
import { isEmpty } from 'lodash'

export default {
  name: 'PatientForm',
  props: ['patient'],
  data() {
    return {
      form: {
        id: '',
        full_name: '',
        full_name_optional: '',
        dob: '',
        gender: '',
        nationality_code: '',
        phone: '',
        email: '',
        address: '',
        identity_type: '',
        identity_no: '',
        referal: ''
      },
      saving: false
    }
  },
  validations: {
    form: {
      full_name: { required },
      gender: { required },
      nationality_code: { required },
      phone: { required },
      identity_type: { required },
      identity_no: { required }
    }
  },
  computed: {
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
    }
  },
  methods: {
    async save() {
      this.$v.$touch()
      if (this.$v.$error) {
        throw 'Validation failed'
      }

      this.saving = true
      try {
        if (isEmpty(this.patient)) {
          await this.$store.dispatch('patients/store', this.form)
        } else {
          await this.$store.dispatch('patients/update', this.form)
        }
        this.$toasted.success('Patient registered successfully')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.saving = false
    },
    cancel() {
      this.$emit('cancel-form')
    }
  },
  watch: {
    patient: {
      handler(patient) {
        if (isEmpty(patient)) return
        ;(this.form.id = patient.id),
          (this.form.full_name = patient.full_name),
          (this.form.full_name_optional = patient.full_name_optional),
          (this.form.dob = patient.dob),
          (this.form.gender = patient.gender),
          (this.form.nationality_code = patient.nationality_code),
          (this.form.phone = patient.phone),
          (this.form.email = patient.email),
          (this.form.address = patient.address),
          (this.form.identity_type = patient.identity_type),
          (this.form.identity_no = patient.identity_no),
          (this.form.referal = patient.referal)
      },
      immediate: true,
      deep: true
    }
  }
}
</script>
