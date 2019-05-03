<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between mb-6">
      <base-title>
        <router-link class="text-blue-500 hover:text-blue-300" to="/roles"
          ><i class="fas fa-arrow-left"></i
        ></router-link>
        / Edit Role
      </base-title>
      <base-button color="danger" @click="destroy(role)" :waiting="deleting">
        <i class="fas fa-trash" v-if="!deleting"></i>
      </base-button>
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
            Save Change
          </base-button>
        </div>
      </form>
    </base-card>
    <div class="w-full flex flex-row items-center justify-between pb-2 mt-6">
      <h1 class="inline text-gray-700 text-lg font-bold">
        Permissions
      </h1>
    </div>
    <permissions @input="setAbilities" :abilitiesProp="form.abilities" />
  </div>
</template>

<script>
import { Errors } from 'form-backend-validation'
import Permissions from './permissions.vue'
import httpClient from '@/http-client'

export default {
  name: 'RoleEdit',
  async beforeRouteEnter(to, from, next) {
    if (to.params.role === undefined) {
      let response = await httpClient.get(
        `/api/roles/${to.params.id}`,
        {},
        { showProgressBar: true }
      )
      to.params.role = response.data.data
    }
    next()
  },
  components: { Permissions },
  props: {
    role: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        id: this.role.id,
        role_name: '',
        abilities: []
      },
      saving: false,
      deleting: false,
      errorMessage: '',
      errors: new Errors()
    }
  },
  created() {
    this.form.role_name = this.role.title
    this.form.abilities = this.role.abilities
  },
  methods: {
    async save() {
      this.errorMessage = ''
      this.errors.clear()

      this.saving = true

      try {
        let response = await this.$store.dispatch('role/update', this.form)
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
    async destroy(role) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      this.deleting = true
      try {
        let response = await this.$store.dispatch('role/destroy', role)
        this.$toasted.success(response.message)
        this.$router.push('/roles')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.deleting = false
    },
    setAbilities(abilities) {
      this.form.abilities = abilities
    }
  }
}
</script>
