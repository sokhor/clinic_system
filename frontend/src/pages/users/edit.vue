<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between mb-6">
      <base-title>
        <router-link class="text-blue-500 hover:text-blue-400" to="/users">
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / Edit User
      </base-title>
      <base-button
        color="danger"
        @click="destroy"
        :waiting="{ state: deleting, hideText: true }"
      >
        <i class="fas fa-trash"></i>
      </base-button>
    </div>
    <base-card>
      <form>
        <div class="flex items-baseline p-4">
          <base-label class="w-1/5 required">
            Username
          </base-label>
          <div class="w-2/5">
            <base-input v-model="form.username" disabled />
            <base-validation-text v-if="errors.has('username')">
              {{ errors.first('username') }}
            </base-validation-text>
          </div>
        </div>
        <div class="flex items-baseline p-4">
          <base-label class="w-1/5 required">
            Password
          </base-label>
          <div class="w-2/5">
            <base-input type="password" v-model="form.password" />
            <base-validation-text v-if="errors.has('password')">
              {{ errors.first('password') }}
            </base-validation-text>
          </div>
        </div>
        <div class="flex items-baseline p-4">
          <base-label class="w-1/5 required">
            Password Again
          </base-label>
          <div class="w-2/5">
            <base-input type="password" v-model="form.password_confirmation" />
            <base-validation-text v-if="errors.has('password_confirmation')">
              {{ errors.first('password_confirmation') }}
            </base-validation-text>
          </div>
        </div>
        <div class="flex items-baseline p-4">
          <base-label class="w-1/5">
            Email
          </base-label>
          <div class="w-2/5">
            <base-input v-model="form.email" />
            <base-validation-text v-if="errors.has('email')">
              {{ errors.first('email') }}
            </base-validation-text>
          </div>
        </div>
        <div class="flex items-baseline p-4">
          <base-label class="w-1/5"></base-label>
          <base-checkbox v-model="form.active">Active</base-checkbox>
        </div>
        <div class="flex items-center justify-end p-4">
          <base-button
            class="mr-1"
            color="primary"
            :waiting="saving"
            @click="save"
          >
            Save Change
          </base-button>
        </div>
      </form>
    </base-card>
  </div>
</template>

<script>
import { Errors } from 'form-backend-validation'

export default {
  name: 'UserEdit',
  props: {
    userProp: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        username: '',
        email: '',
        active: true
      },
      saving: false,
      deleting: false,
      errors: new Errors()
    }
  },
  created() {
    for (let key in this.form) {
      this.form[key] = this.userProp[key]
    }
  },
  methods: {
    async save() {
      this.errors.clear()

      this.saving = true

      try {
        let response = await this.$store.dispatch('user/editUser', {
          id: this.userProp.id,
          ...this.form
        })
        this.$toasted.success(response.message)
        this.$router.push('/users')
      } catch (error) {
        if (error.errors !== undefined) {
          this.errors = new Errors(error.errors)
        }

        this.$toasted.error(error.message)
      }
      this.saving = false
    },
    async destroy() {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      this.deleting = true
      try {
        let response = await this.$store.dispatch(
          'user/deleteUser',
          this.userProp
        )
        this.$toasted.success(response.message)
        this.$router.push('/users')
      } catch (error) {
        this.$toasted.error(error.message)
      }
      this.deleting = false
    }
  }
}
</script>
