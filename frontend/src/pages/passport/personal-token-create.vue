<template>
  <div>
    <div
      class="w-full flex flex-row items-center justify-between p-3 mb-3 border-b border-white-grey"
    >
      <h4 class="inline text-gray-900 text-base font-bold">
        Create Personal Token
      </h4>
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
          <span
            class="block text-xs italic text-red"
            v-if="nameErrors.length > 0"
          >
            {{ nameErrors[0] }}
          </span>
        </div>
      </div>
      <div class="flex items-center justify-end p-4">
        <base-button color="primary" :waiting="saving" type="submit">
          Create
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
  name: 'PersonalTokenCreate',
  data() {
    return {
      form: {
        name: '',
        scopes: []
      },
      saving: false,
      isSuccess: null,
      alertMessage: '',
      errors: []
    }
  },
  validations: {
    form: {
      name: { required }
    }
  },
  computed: {
    nameErrors() {
      const errors = []
      if (!this.$v.form.name.$dirty) return errors
      !this.$v.form.name.required && errors.push('Required')
      return errors
    }
  },
  methods: {
    ...mapActions('passport', ['createPersonalToken']),
    async save() {
      this.$v.$touch()
      if (this.$v.$error) {
        throw 'Validation failed'
      }

      this.saving = true
      try {
        await this.createPersonalToken(this.form)

        this.form.name = ''
        this.form.redirect = ''
        this.$v.$reset()

        this.isSuccess = true
        this.alertMessage = 'A new personal token has created successfully'
        this.errors = []
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
