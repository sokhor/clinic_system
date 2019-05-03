<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pb-6">
      <base-title>
        <router-link class="text-blue-500 hover:text-blue-300" to="/roles"
          ><i class="fas fa-arrow-left"></i
        ></router-link>
        / Create Role
      </base-title>
    </div>
    <base-card>
      <form>
        <div class="flex items-baseline p-4">
          <base-label class="w-1/5 required">
            Role name
          </base-label>
          <div class="w-2/5">
            <base-input v-model="form.role_name" />
            <base-validation-text v-if="errors.has('role_name')">
              {{ errors.first('role_name') }}
            </base-validation-text>
          </div>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button color="primary" :waiting="saving" @click="save">
            Create
          </base-button>
        </div>
      </form>
    </base-card>
    <div
      class="w-full flex flex-row items-center justify-between pb-2 mt-6"
    >
      <h1 class="inline text-gray-700 text-lg font-bold">
        Permissions
      </h1>
    </div>
    <permissions @input="setAbilities" />
  </div>
</template>

<script>
import { Errors } from 'form-backend-validation'
import Permissions from './permissions.vue'

export default {
  name: 'RoleCreate',
  components: { Permissions },
  data() {
    return {
      form: {
        role_name: '',
        abilities: []
      },
      saving: false,
      errorMessage: '',
      errors: new Errors()
    }
  },
  methods: {
    async save() {
      this.errorMessage = ''
      this.errors.clear()

      this.saving = true

      try {
        let response = await this.$store.dispatch('role/store', this.form)
        this.$toasted.success(response.message)
        this.$router.push('/roles')
      } catch (error) {
        if (error.errors !== undefined) {
          this.errors = new Errors(error.errors)
        }

        this.$toasted.error(error.message)
      }
      this.saving = false
    },
    setAbilities(abilities) {
      this.form.abilities = abilities
    }
  }
}
</script>
