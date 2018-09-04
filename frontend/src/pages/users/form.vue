<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">Create User</h1>
    </div>
    <div class="w-full bg-white shadow rounded overflow-hidden">
      <form @submit.prevent="save">
        <div class="flex items-center p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Username
          </label>
          <input
            class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-2/5"
            v-model="form.username"
            type="text"
            @input="$v.form.username.$touch()"
          />
          <span class="form-helper-block block-error" v-if="usernameErrors.length > 0">
            {{ usernameErrors[0] }}
          </span>
        </div>
        <div class="flex items-center p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Password
          </label>
          <input
            class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-2/5"
            v-model="form.password"
            type="text"
            @input="$v.form.password.$touch()"
          />
          <span class="form-helper-block block-error" v-if="passwordErrors.length > 0">
            {{ passwordErrors[0] }}
          </span>
        </div>
        <div class="flex items-center p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Password Again
          </label>
          <input
            class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-2/5"
            v-model="form.password_confirmation"
            type="text"
            @input="$v.form.password_confirmation.$touch()"
          />
          <span class="form-helper-block block-error" v-if="passwordConfirmationErrors.length > 0">
            {{ passwordConfirmationErrors[0] }}
          </span>
        </div>
        <div class="flex items-center p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Email
          </label>
          <input
            class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-2/5"
            v-model="form.email"
            type="email"
          />
        </div>
        <div class="flex items-center p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5"></label>
          <!-- <input
            v-model="form.active"
            type="checkbox"
          /> Active -->
          <base-checkbox v-model="form.active" class="w-2/5">Active</base-checkbox>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button color="primary">Create</base-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'CreateUser',
  data() {
    return {
      form: {
        username: '',
        password: '',
        password_confirmation: '',
        email: '',
        active: false
      }
    }
  },
  validations: {
    form: {
      username: { required },
      password: { required },
      password_confirmation: { required }
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
      !this.$v.form.password_confirmation.required && errors.push('Required')
      return errors
    }
  },
  methods: {
    save() {}
  }
}
</script>
