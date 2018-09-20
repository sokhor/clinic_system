<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/users"><i class="fas fa-arrow-left"></i></router-link> / Create User
      </h1>
    </div>
    <BaseCard>
      <form @submit.prevent="save">
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Username
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.username"
              type="text"
              @input="$v.form.username.$touch()"
            />
            <span class="block text-xs italic text-red" v-if="usernameErrors.length > 0">
              {{ usernameErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Password
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.password"
              type="password"
              @input="$v.form.password.$touch()"
            />
            <span class="block text-xs italic text-red" v-if="passwordErrors.length > 0">
              {{ passwordErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Password Again
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.password_confirmation"
              type="password"
              @input="$v.form.password_confirmation.$touch()"
            />
            <span class="block text-xs italic text-red" v-if="passwordConfirmationErrors.length > 0">
              {{ passwordConfirmationErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Email
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.email"
              type="email"
            />
            <span class="block text-xs italic text-red" v-if="emailErrors.length > 0">
              {{ emailErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5"></label>
          <BaseCheckbox v-model="form.active">Active</BaseCheckbox>
        </div>
        <div class="flex items-center justify-end p-4">
          <BaseButton color="primary" :waiting="saving" type="submit">Create</BaseButton>
        </div>
      </form>
    </BaseCard>
  </div>
</template>

<script>
import { required, requiredIf, email, sameAs } from 'vuelidate/lib/validators'

export default {
  name: 'UserCreate',
  props: {
    user: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        username: '',
        password: '',
        password_confirmation: '',
        email: '',
        active: true
      },
      saving: false
    }
  },
  validations: {
    form: {
      username: { required },
      password: {
        required: requiredIf(function() {
          return !this.isEditForm
        })
      },
      password_confirmation: { sameAsPassword: sameAs('password') },
      email: { email }
    }
  },
  computed: {
    usernameErrors() {
      const errors = []
      if (!this.$v.form.username.$dirty) return errors
      !this.$v.form.username.required && errors.push('Required')
      return errors
    },
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
    },
    emailErrors() {
      const errors = []
      if (!this.$v.form.email.$dirty) return errors
      !this.$v.form.email.email && errors.push('Invalid email')
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
        await this.$store.dispatch('users/createUser', this.form)
        this.$router.push('/users')
      } catch (e) {}
      this.saving = false
    }
  }
}
</script>
