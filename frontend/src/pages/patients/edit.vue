<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-gray-900 text-xl font-bold">
        <router-link
          class="text-blue hover:text-blue-light mr-2"
          to="/patients"
        >
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / Edit Patient
      </h1>
    </div>
    <BaseCard>
      <form @submit.prevent="save">
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Name KH
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.name_kh"
              type="text"
              @input="$v.form.name_kh.$touch()"
            />
            <span
              class="block text-xs italic text-red"
              v-if="nameKhErrors.length > 0"
            >
              {{ nameKhErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Name EN
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.name_en"
              type="text"
              @input="$v.form.name_en.$touch()"
            />
            <span
              class="block text-xs italic text-red"
              v-if="nameEnErrors.length > 0"
            >
              {{ nameEnErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Date of Birth
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.dob"
              type="text"
            />
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Gender
          </label>
          <div class="w-2/5">
            <select
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.gender"
              type="text"
              @input="$v.form.gender.$touch()"
            >
              <option value="">--Choose--</option>
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
            <span
              class="block text-xs italic text-red"
              v-if="genderErrors.length > 0"
            >
              {{ genderErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Nationality
          </label>
          <div class="w-2/5">
            <select
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.nationality_code"
              type="text"
              @input="$v.form.nationality_code.$touch()"
            >
              <option value="">--Choose--</option>
              <option value="KH">Cambodian</option>
            </select>
            <span
              class="block text-xs italic text-red"
              v-if="nationalityCodeErrors.length > 0"
            >
              {{ nationalityCodeErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Phone
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.phone"
              type="text"
              @input="$v.form.phone.$touch()"
            />
            <span
              class="block text-xs italic text-red"
              v-if="phoneErrors.length > 0"
            >
              {{ phoneErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Email
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.email"
              type="email"
            />
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Address
          </label>
          <div class="w-2/5">
            <textarea
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.address"
            ></textarea>
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Identity Type
          </label>
          <div class="w-2/5">
            <select
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.identity_type"
              @input="$v.form.identity_type.$touch()"
            >
              <option value="">--Choose--</option>
              <option value="1">National ID</option>
              <option value="2">Passport</option>
              <option value="3">Driving License</option>
            </select>
            <span
              class="block text-xs italic text-red"
              v-if="identityTypeErrors.length > 0"
            >
              {{ identityTypeErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Identity No
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.identity_no"
              type="text"
              @input="$v.form.identity_no.$touch()"
            />
            <span
              class="block text-xs italic text-red"
              v-if="identityNoErrors.length > 0"
            >
              {{ identityNoErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-start p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Referal
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.referal"
              type="text"
            />
          </div>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button color="primary" :waiting="saving" type="submit">
            Update
          </base-button>
        </div>
      </form>
    </BaseCard>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'PatientEdit',
  props: ['patient'],
  data() {
    return {
      form: {
        id: this.patient.id,
        name_kh: this.patient.name_kh,
        name_en: this.patient.name_en,
        dob: this.patient.dob,
        gender: this.patient.gender,
        nationality_code: this.patient.nationality_code,
        phone: this.patient.phone,
        email: this.patient.email,
        address: this.patient.address,
        identity_type: this.patient.identity_type,
        identity_no: this.patient.identity_no,
        referal: this.patient.referal
      },
      saving: false
    }
  },
  validations: {
    form: {
      name_kh: { required },
      name_en: { required },
      gender: { required },
      nationality_code: { required },
      phone: { required },
      identity_type: { required },
      identity_no: { required }
    }
  },
  computed: {
    nameKhErrors() {
      const errors = []
      if (!this.$v.form.name_kh.$dirty) return errors
      !this.$v.form.name_kh.required && errors.push('Required')
      return errors
    },
    nameEnErrors() {
      const errors = []
      if (!this.$v.form.name_en.$dirty) return errors
      !this.$v.form.name_en.required && errors.push('Required')
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
        await this.$store.dispatch('patients/update', this.form)
        this.$toasted.success('Patient updated successfully')
        this.$router.push('/patients')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.saving = false
    }
  }
}
</script>
