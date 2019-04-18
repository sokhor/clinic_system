<template>
  <div>
    <div
      class="w-full flex flex-row items-center justify-between p-3 mb-3 border-b border-white-grey"
    >
      <h4 class="inline text-gray-900 text-base font-bold">Edit Client</h4>
      <base-button flat @click="$emit('close')"
        ><i class="fas fa-times"></i
      ></base-button>
    </div>
    <base-alert type="success" class="mx-4" v-if="isSuccess === true">
      <p>{{ alertMessage }}</p>
    </base-alert>
    <base-alert type="danger" class="mx-4" v-if="isSuccess === false">
      <ul class="list-reset">
        <li v-for="error in errors">
          {{ error }}
        </li>
      </ul>
    </base-alert>
    <form @submit.prevent="save">
      <div class="flex items-baseline p-4">
        <label class="block text-gray-800 text-sm font-bold w-1/5">
          Name
        </label>
        <div class="w-4/5">
          <input
            class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
            v-model="form.name"
            type="text"
            @input="$v.form.name.$touch()"
          />
          <span class="block text-xs italic"
            >Something your users will recognize and trust.</span
          >
          <span
            class="block text-xs italic text-red"
            v-if="nameErrors.length > 0"
          >
            {{ nameErrors[0] }}
          </span>
        </div>
      </div>
      <div class="flex items-baseline p-4">
        <label class="block text-gray-800 text-sm font-bold w-1/5">
          Redirect URL
        </label>
        <div class="w-4/5">
          <input
            class="appearance-none border rounded py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline w-full"
            v-model="form.redirect"
            type="text"
            @input="$v.form.redirect.$touch()"
          />
          <span class="block text-xs italic"
            >Your application's authorization callback URL.</span
          >
          <span
            class="block text-xs italic text-red"
            v-if="redirectErrors.length > 0"
          >
            {{ redirectErrors[0] }}
          </span>
        </div>
      </div>
      <div class="flex items-center justify-end p-4">
        <base-button color="primary" :waiting="saving" type="submit">
          {{ form.id === null ? 'Create' : 'Save Change' }}
        </base-button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
import { required, url } from 'vuelidate/lib/validators'
import { flatten, toArray } from 'lodash'

export default {
  name: 'ClientForm',
  props: ['client'],
  data() {
    return {
      form: {
        id: null,
        name: '',
        redirect: ''
      },
      saving: false,
      isSuccess: null,
      alertMessage: '',
      errors: []
    }
  },
  validations: {
    form: {
      name: { required },
      redirect: { required, url }
    }
  },
  computed: {
    nameErrors() {
      const errors = []
      if (!this.$v.form.name.$dirty) return errors
      !this.$v.form.name.required && errors.push('Required')
      return errors
    },
    redirectErrors() {
      const errors = []
      if (!this.$v.form.redirect.$dirty) return errors
      !this.$v.form.redirect.required && errors.push('Required')
      !this.$v.form.redirect.url && errors.push('URL format is invalid')
      return errors
    }
  },
  created() {
    this.form.id = this.client.id
    this.form.name = this.client.name
    this.form.redirect = this.client.redirect
  },
  methods: {
    ...mapActions('passport', ['updateClient']),
    async save() {
      this.$v.$touch()
      if (this.$v.$error) {
        throw 'Validation failed'
      }

      this.saving = true
      try {
        await this.updateClient(this.form)

        this.form.name = ''
        this.form.redirect = ''
        this.$v.$reset()

        this.isSuccess = true
        this.alertMessage = 'Client has updated successfully'
        this.errors = []
        this.$emit('close')
      } catch (data) {
        this.isSuccess = false
        this.alertMessage = 'Whoops! Something went wrong!'

        if (typeof data === 'object') {
          this.errors = _.flatten(_.toArray(data.errors))
        } else {
          this.errors = ['Something went wrong. Please try again.']
        }
      }
      this.saving = false
    }
  }
}
</script>
