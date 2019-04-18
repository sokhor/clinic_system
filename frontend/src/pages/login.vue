<template>
  <div class="w-full h-screen flex flex-col items-center justify-center">
    <form
      class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-xs"
      @submit.prevent="postLogin"
    >
      <alert type="danger" v-if="message !== ''" class="mb-4">{{
        message
      }}</alert>
      <div class="mb-4">
        <label
          class="block text-gray-800 text-sm font-bold mb-2"
          for="username"
        >
          Username
        </label>
        <input
          v-model="username"
          class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline shadow w-full"
          id="username"
          type="text"
          @input="$v.username.$touch()"
        />
        <span
          class="block text-xs italic text-red"
          v-if="usernameErrors.length > 0"
        >
          {{ usernameErrors[0] }}
        </span>
      </div>
      <div class="mb-6">
        <label
          class="block text-gray-800 text-sm font-bold mb-2"
          for="password"
        >
          Password
        </label>
        <input
          v-model="password"
          class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline shadow w-full"
          type="password"
          @input="$v.password.$touch()"
        />
        <span
          class="block text-xs italic text-red"
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
import Alert from '../components/alert.vue'

export default {
  name: 'Login',
  components: {
    Alert
  },
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
