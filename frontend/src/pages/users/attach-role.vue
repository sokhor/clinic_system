<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <a href="#" class="text-blue hover:text-blue-light" @click.prevent="goUserDetails">
          <i class="fas fa-arrow-left"></i>
        </a> / Attach Role
      </h1>
    </div>
    <BaseCard>
      <form @submit.prevent="save">
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Role
          </label>
          <div class="w-2/5">
            <select
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.selectedRole"
              @input="$v.form.selectedRole.$touch()"
            >
              <option value="">--Choose Roles--</option>
              <option v-for="role in roles" :key="role.id" :value="role.id">
                {{ role.title }}
              </option>
            </select>
            <span class="block text-xs italic text-red" v-if="selectedRoleErrors.length > 0">
              {{ selectedRoleErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button color="primary" :waiting="saving" type="submit">Attach</base-button>
        </div>
      </form>
    </BaseCard>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'
import httpClient from '@/http-client'

export default {
  name: 'AttachRole',
  props: {
    user: {
      type: Object,
      default: null
    },
    roles: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      form: {
        selectedRole: ''
      },
      saving: false
    }
  },
  validations: {
    form: {
      selectedRole: { required }
    }
  },
  computed: {
    selectedRoleErrors() {
      const errors = []
      if (!this.$v.form.selectedRole.$dirty) return errors
      !this.$v.form.selectedRole.required && errors.push('Required')
      return errors
    }
  },
  methods: {
    async save() {
      this.$v.$touch()
      if (this.$v.$error) {
        throw 'Validation failed'
      }

      this.saving = true
      try {
        await this.$store.dispatch('users/attachRoles', {
          user: this.user,
          roles: [this.form.selectedRole]
        })

        this.goUserDetails()
      } catch (e) {}
      this.saving = false
    },
    goUserDetails() {
      this.$router.push({ name: 'users-show' })
    }
  }
}
</script>
