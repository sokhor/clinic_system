<template>
  <form class="p-4">
    <div class="mb-4">
      <base-label class="mb-2">
        Subject <span class="text-red">*</span>
      </base-label>
      <base-input v-model="form.subject" @input="$v.form.subject.$touch()" />
      <span
        class="block text-xs italic text-red"
        v-if="subjectErrors.length > 0"
      >
        {{ subjectErrors[0] }}
      </span>
    </div>
    <div class="mb-4 flex -mx-2">
      <div class="w-1/2 px-2">
        <base-label class="mb-2">
          Patient <span class="text-red">*</span>
        </base-label>
        <base-select
          v-model="form.patient_id"
          :options="patients.map(d => ({ value: d.id, text: d.full_name }))"
          :filter-function="filterPatient"
          @input="$v.form.patient_id.$touch()"
        ></base-select>
        <span
          class="block text-xs italic text-red"
          v-if="patientIdErrors.length > 0"
        >
          {{ patientIdErrors[0] }}
        </span>
      </div>
      <div class="w-1/2 px-2">
        <base-label class="mb-2">
          Doctor <span class="text-red">*</span>
        </base-label>
        <base-select
          v-model="form.doctor_id"
          :options="doctors.map(d => ({ value: d.id, text: d.full_name }))"
          :filter-function="filterDoctor"
          @input="$v.form.doctor_id.$touch()"
        ></base-select>
        <span
          class="block text-xs italic text-red"
          v-if="doctorIdErrors.length > 0"
        >
          {{ doctorIdErrors[0] }}
        </span>
      </div>
    </div>
    <div class="mb-4">
      <base-label class="mb-2">
        Appointment Time <span class="text-red">*</span>
      </base-label>
      <base-input
        v-model="form.appointed_at"
        placeholder="DD-MM-YYYY HH:mm:ss"
        @input="$v.form.appointed_at.$touch()"
      />
      <span
        class="block text-xs italic text-red"
        v-if="appointedAtErrors.length > 0"
      >
        {{ appointedAtErrors[0] }}
      </span>
    </div>
    <div class="mb-4">
      <base-label class="mb-2">Comment</base-label>
      <base-textarea v-model="form.comment" rows="5" />
    </div>
    <div class="flex items-center justify-end">
      <base-button color="primary" :waiting="saving" @click="updateEvent"
        >Save change</base-button
      >
    </div>
  </form>
</template>

<script>
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'NewAppointment',
  props: ['value', 'doctors', 'patients'],
  data() {
    return {
      form: {
        id: this.value.id,
        patient_id: this.value.patient_id,
        subject: this.value.subject,
        appointed_at: this.value.appointed_at,
        doctor_id: this.value.doctor_id,
        comment: this.value.comment,
        status: this.value.status
      },
      saving: false
    }
  },
  validations: {
    form: {
      patient_id: { required },
      subject: { required },
      appointed_at: { required },
      doctor_id: { required }
    }
  },
  computed: {
    patientIdErrors() {
      const errors = []
      if (!this.$v.form.patient_id.$dirty) return errors
      !this.$v.form.patient_id.required && errors.push('Required')
      return errors
    },
    subjectErrors() {
      const errors = []
      if (!this.$v.form.subject.$dirty) return errors
      !this.$v.form.subject.required && errors.push('Required')
      return errors
    },
    appointedAtErrors() {
      const errors = []
      if (!this.$v.form.appointed_at.$dirty) return errors
      !this.$v.form.appointed_at.required && errors.push('Required')
      return errors
    },
    doctorIdErrors() {
      const errors = []
      if (!this.$v.form.doctor_id.$dirty) return errors
      !this.$v.form.doctor_id.required && errors.push('Required')
      return errors
    }
  },
  methods: {
    async updateEvent() {
      this.$v.$touch()
      if (this.$v.$error) {
        throw 'Validation failed'
      }

      this.saving = true
      try {
        await this.$store.dispatch('appointments/update', this.form)
        this.$toasted.success('Appointment updated')
        this.saving = false
        this.$emit('appointment-updated')
      } catch (error) {
        this.$toasted.error(error.message)
      }
    },
    filterDoctor(search, options) {
      return options.filter(option => {
        option = typeof option === 'object' ? option.text : option

        return option.toLowerCase().includes(search.toLowerCase())
      })
    },
    filterPatient(search, options) {
      return options.filter(option => {
        option = typeof option === 'object' ? option.text : option

        return option.toLowerCase().includes(search.toLowerCase())
      })
    }
  }
}
</script>
