<template>
  <div class="w-full h-full flex flex-col items-center justify-center">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-xs" @submit.prevent="postLogin">
      <alert type="danger" v-if="invalidCredential !== ''" class="mb-4">{{ invalidCredential }}</alert>
      <div class="mb-4">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
          Username
        </label>
        <input
          v-model="username"
          class="form-input shadow"
          id="username"
          type="text"
          @input="$v.username.$touch()"
        />
        <span class="form-helper-block block-error" v-if="usernameErrors.length > 0">
          {{ usernameErrors[0] }}
        </span>
      </div>
      <div class="mb-6">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input
          v-model="password"
          class="form-input shadow"
          type="password"
          @input="$v.password.$touch()"
        />
        <span class="form-helper-block block-error" v-if="passwordErrors.length > 0">
          {{ passwordErrors[0] }}
        </span>
      </div>
      <div class="flex items-center justify-between">
        <button class="btn btn-primary" type="submit">
          <waiting class="mr-2" v-if="loggingIn"></waiting> Sign In
        </button>
      </div>
    </form>
    <p class="text-center text-grey text-xs">
      ©2018 Acme Corp. All rights reserved.
    </p>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import httpClient from '../http-client'
import Alert from '../components/common/alert.vue'
import Waiting from '../components/common/waiting.vue'

export default {
  name: 'Login',
  components: {
    Alert,
    Waiting
  },
  data() {
    return {
      username: '',
      password: '',
      invalidCredential: '',
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

      httpClient
        .post('api/login', {
          username: this.username,
          password: this.password
        })
        .then(response => {
          this.loggingIn = false
          this.$store.commit('SET_AUTHENTICATION', response.data)
          this.$router.push('/')
        })
        .catch(error => {
          this.loggingIn = false
          this.invalidCredential = error.response.data.invalid_credentials
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
