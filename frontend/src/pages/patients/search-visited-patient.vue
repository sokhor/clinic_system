<template>
  <BaseCard>
    <h3 class="text-grey-darker font-semibold text-base px-4 py-2 bg-white-grey-light">Visited patient</h3>
    <form @submit.prevent="lookUp" class="p-4">
      <div>
        <div class="mb-4">
          <input
            class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
            v-model="form.id"
            type="text"
            autofocus
            placeholder="Patient Code"
          />
        </div>
      </div>
      <div>
        <div class="mb-4">
          <input
            class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
            v-model="form.full_name"
            type="text"
            placeholder="Full Name"
          />
        </div>
      </div>
      <div>
        <div class="mb-4">
          <input
            class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
            v-model="form.phone"
            type="text"
            placeholder="Phone Number"
          />
        </div>
      </div>
      <div>
        <div class="mb-4">
          <input
            class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
            v-model="form.identity_no"
            type="text"
            placeholder="Identity"
          />
        </div>
      </div>
      <div class="flex items-center justify-start">
        <BaseButton
          color="accent"
          :waiting="loading"
          type="submit"
          class="flex-1"
        >
          Search
        </BaseButton>
      </div>
    </form>
  </BaseCard>
</template>

<script>
import { mapState } from 'vuex'
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'PatientRegistrationForm',
  data() {
    return {
      form: {
        id: '',
        full_name: '',
        phone: '',
        identity_no: ''
      },
      loading: false
    }
  },
  methods: {
    lookUp() {
      this.loading = true

      this.$store
        .dispatch('patients/list', {
          filter: {
            full_name: this.form.full_name,
            phone: this.form.phone,
            identity_no: this.form.identity_no
          }
        })
        .then(() => (this.loading = false))
    }
  }
}
</script>
