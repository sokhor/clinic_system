<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-gray-900 text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/users"
          ><i class="fas fa-arrow-left"></i
        ></router-link>
        / User Reset Password
      </h1>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <form @submit.prevent="save">
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Username
          </label>
          <span class="w-2/5">{{ user.username }}</span>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Password
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.password"
              type="password"
              @input="$v.form.password.$touch()"
            />
            <span
              class="block text-xs italic text-red"
              v-if="passwordErrors.length > 0"
            >
              {{ passwordErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-gray-800 text-sm font-bold w-1/5">
            Password Again
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.password_confirmation"
              type="password"
              @input="$v.form.password_confirmation.$touch()"
            />
            <span
              class="block text-xs italic text-red"
              v-if="passwordConfirmationErrors.length > 0"
            >
              {{ passwordConfirmationErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button color="primary" :waiting="saving" type="submit"
            >Reset</base-button
          >
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { required, requiredIf, email, sameAs } from 'vuelidate/lib/validators'

export default {
  name: 'UserForm',
  props: {
    user: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        password: '',
        password_confirmation: ''
      },
      saving: false
    }
  },
  validations: {
    form: {
      password: { required },
      password_confirmation: { sameAsPassword: sameAs('password') }
    }
  },
  computed: {
    passwordErrors() {
      const errors = []
      if (!this.$v.form.password.$dirty) return errors
      !this.$v.form.password.required && errors.push('Required')
      return errors
    },
    passwordConfirmationErrors() {
      const errors = []
      if (!this.$v.form.password_confirmation.$dirty) return errors
      !this.$v.form.password_confirmation.sameAsPassword &&
        errors.push('Password mismatch')
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
        await this.$store.dispatch(
          'users/resetUserPassword',
          Object.assign(this.form, { id: this.user.id })
        )
        this.$router.push('/users')
        this.$toasted.success('Password reset successfully')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.saving = false
    }
  }
}
</script>
