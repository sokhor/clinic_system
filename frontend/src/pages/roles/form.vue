<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-center justify-between pt-4 pb-6">
      <h1 class="inline text-grey-darkest text-xl font-bold">
        <router-link class="text-blue hover:text-blue-light" to="/roles"><i class="fas fa-arrow-left"></i></router-link> / {{ isEditForm ? 'Edit Role' : 'Create Role' }}
      </h1>
    </div>
    <BaseCard>
      <form @submit.prevent="save">
        <div class="flex items-baseline p-4 border-b border-white-grey">
          <label class="block text-grey-darker text-sm font-bold w-1/5">
            Role name
          </label>
          <div class="w-2/5">
            <input
              class="appearance-none border rounded py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline w-full"
              v-model="form.role_name"
              type="text"
              @input="$v.form.role_name.$touch()"
            />
            <span class="block text-xs italic text-red" v-if="roleNameErrors.length > 0">
              {{ roleNameErrors[0] }}
            </span>
          </div>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button color="primary" :waiting="saving" type="submit">
            {{ isEditForm ? 'Save Change' : 'Create' }}
          </base-button>
        </div>
      </form>
    </BaseCard>
  </div>
</template>

<script>
import { required } from 'vuelidate/lib/validators'

export default {
  name: 'RoleForm',
  props: {
    role: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        role_name: ''
      },
      saving: false
    }
  },
  validations: {
    form: {
      role_name: { required }
    }
  },
  computed: {
    roleNameErrors() {
      const errors = []
      if (!this.$v.form.role_name.$dirty) return errors
      !this.$v.form.role_name.required && errors.push('Required')
      return errors
    },
    isEditForm() {
      return this.role !== null
    }
  },
  created() {
    if (this.isEditForm) {
      this.form.role_name = this.role.title
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
        if (this.isEditForm) {
          await this.$store.dispatch(
            'roles/updateRole',
            Object.assign(this.form, { id: this.role.id })
          )

          this.$router.push('/roles')
        } else {
          await this.$store.dispatch('roles/createRole', this.form)
        }
      } catch (e) {}
      this.saving = false
    }
  }
}
</script>
