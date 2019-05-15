<template>
  <base-card class="p-4">
    <form>
      <div class="mb-4">
        <base-label class="mb-2 required">Role</base-label>
        <base-select
          v-model="form.selectedRole"
          :options="roles.map(role => ({ value: role.id, text: role.title }))"
        />
        <base-validation-text v-if="errors.has('roles')">
          {{ errors.first('roles') }}
        </base-validation-text>
      </div>
      <div class="flex items-center justify-end">
        <base-button color="primary" :waiting="saving" @click="save">
          Attach
        </base-button>
      </div>
    </form>
  </base-card>
</template>

<script>
import { Errors } from 'form-backend-validation'

export default {
  name: 'AttachRole',
  props: {
    user: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        selectedRole: ''
      },
      roles: [],
      saving: false,
      errors: new Errors()
    }
  },
  beforeMount() {
    this.$store.dispatch('role/get', { perPage: -1 }).then(response => {
      this.roles = response.data
    })
  },
  methods: {
    async save() {
      this.errors.clear()

      this.saving = true
      try {
        let response = await this.$store.dispatch('user/attachRoles', {
          id: this.user.id,
          roles: [this.form.selectedRole]
        })

        this.$toasted.success(response.message)
        this.$emit('close')
      } catch (error) {
        if (error.errors !== undefined) {
          this.errors = new Errors(error.errors)
        }

        this.$toasted.error(error.message)
      }
      this.saving = false
    }
  }
}
</script>
