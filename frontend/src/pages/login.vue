<template>
  <div class="w-full h-screen flex flex-col items-center justify-center">
    <form
      class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-sm"
      @submit.prevent="postLogin"
    >
      <BaseAlert type="danger" class="mb-4" v-if="errorMessage !== ''">{{
        errorMessage
      }}</BaseAlert>
      <div class="mb-4">
        <BaseLabel class="mb-2">Username</BaseLabel>
        <BaseInput v-model="username" />
        <span
          class="block text-xs italic text-red-500"
          v-if="errors.has('username')"
        >
          {{ errors.first('username') }}
        </span>
      </div>
      <div class="mb-6">
        <BaseLabel class="mb-2">Password</BaseLabel>
        <BaseInput v-model="password" type="password" />
        <span
          class="block text-xs italic text-red-500"
          v-if="errors.has('username')"
        >
          {{ errors.first('username') }}
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
import { Errors } from 'form-backend-validation'

export default {
  name: 'Login',
  data() {
    return {
      username: '',
      password: '',
      loggingIn: false,
      errorMessage: '',
      errors: new Errors()
    }
  },
  methods: {
    postLogin() {
      this.errors.clear()

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

          if (error.errors !== undefined) this.errors = new Errors(error.errors)
          else this.errorMessage = error.message
        })
    }
  }
}
</script>
