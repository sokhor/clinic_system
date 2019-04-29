<template>
  <div class="w-full h-screen flex flex-col items-center justify-center">
    <form
      class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-xs"
      @submit.prevent="postLogin"
    >
      <BaseAlert type="danger" v-if="message !== ''" class="mb-4">{{
        message
      }}</BaseAlert>
      <div class="mb-4">
        <BaseLabel class="mb-2">Username</BaseLabel>
        <BaseInput v-model="username" @input="$v.username.$touch()" />
        <span
          class="block text-xs italic text-red-500"
          v-if="usernameErrors.length > 0"
        >
          {{ usernameErrors[0] }}
        </span>
      </div>
      <div class="mb-6">
        <BaseLabel class="bmb-2">Password</BaseLabel>
        <BaseInput
          v-model="password"
          type="password"
          @input="$v.password.$touch()"
        />
        <span
          class="block text-xs italic text-red-500"
          v-if="passwordErrors.length > 0"
        >
          {{ passwordErrors[0] }}
        </span>
      </div>
      <div class="flex items-center justify-between">
        <base-button color="primary" :waiting="loggingIn" type="submit"
          >Sign In</base-button
        >
      </div>
    </form>
    <p class="text-center text-grey text-xs">
      ©2019 Prasetpheap. All rights reserved.
    </p>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'Login',
  data() {
    return {
      username: '',
      password: '',
      message: '',
      loggingIn: false
    }
  },
  validations: {
    username: { required },
    password: { required }
  },
  computed: {
    usernameErrors() {
      const errors = []
      if (!this.$v.username.$dirty) return errors
      !this.$v.username.required && errors.push('Required')
      return errors
    },
    passwordErrors() {
      const errors = []
      if (!this.$v.password.$dirty) return errors
      !this.$v.password.required && errors.push('Required')
      return errors
    }
  },
  methods: {
    postLogin() {
      this.validateInput()

      this.loggingIn = true

      this.$store
        .dispatch('auth/logIn', {
          username: this.username,
          password: this.password
        })
        .then(() => {
          this.loggingIn = false
          this.$router.push('/')
        })
        .catch(error => {
          this.loggingIn = false
          this.message = error.response.data.message
        })
    },
    validateInput() {
      this.$v.$touch()

      if (this.$v.$error) {
        throw 'Validation failed'
      }
    }
  }
}
</script>
