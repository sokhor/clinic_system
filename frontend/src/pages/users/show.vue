<template>
  <div class="w-full">
    <div class="w-full flex flex-row items-end justify-between mb-6">
      <base-title>
        <router-link class="text-blue-500 hover:text-blue-400" to="/users">
          <i class="fas fa-arrow-left"></i>
        </router-link>
        / User Detail
      </base-title>
      <div>
        <base-button color="primary" @click="edit(user)" class="mr-2">
          <i class="fas fa-edit"></i>
        </base-button>
        <base-button
          color="danger"
          @click="destroy(user)"
          :waiting="user._deleting"
        >
          <i class="fas fa-trash" v-if="!user._deleting"></i>
        </base-button>
      </div>
    </div>
    <base-card>
      <div class="flex items-baseline p-4">
        <base-label class="w-1/5">
          Username
        </base-label>
        <span class="w-2/5">
          {{ user.username }}
        </span>
      </div>
      <div class="flex items-baseline p-4">
        <base-label class="w-1/5">
          Email
        </base-label>
        <span class="w-2/5">
          {{ user.email }}
        </span>
      </div>
      <div class="flex items-baseline p-4">
        <base-label class="w-1/5">
          Active
        </base-label>
        <span class="w-2/5">
          <div
            class="w-3 h-3 bg-green-500 rounded-full border-2 border-green-300"
            v-if="user.active"
          ></div>
          <div
            class="w-3 h-3 bg-red-500 rounded-full border-2 border-red-300"
            v-else
          ></div>
        </span>
      </div>
    </base-card>
    <div class="w-full flex flex-row items-end justify-between mb-6 mt-10">
      <base-title>Roles</base-title>
      <base-button color="primary" @click="attachRole(user)">
        Attach Role
      </base-button>
    </div>
    <base-card>
      <user-roles :roles="user.roles" />
    </base-card>
  </div>
</template>

<script>
import httpClient from '@/http-client'
import UserRoles from './user-roles.vue'
import AttachRole from './attach-role.vue'

export default {
  name: 'UserShow',
  async beforeRouteEnter(to, from, next) {
    if (to.params.user === undefined) {
      let response = await httpClient.get(
        `/api/users/${to.params.id}`,
        {},
        { showProgressBar: true }
      )
      to.params.user = response.data.data
    }
    next()
  },
  components: { UserRoles, AttachRole },
  props: {
    user: {
      type: Object,
      default: null
    }
  },
  methods: {
    edit(user) {
      this.$router.push({
        name: 'users-edit',
        params: { id: user.id, user: user }
      })
    },
    async destroy(user) {
      if (!(await this.$confirmDelete('Are you sure to delete?'))) {
        return
      }

      user._deleting = true
      try {
        await this.$store.dispatch('users/deleteUser', user)
        this.$router.push('/users')
      } catch (e) {}
      user._deleting = false
    },
    attachRole(user) {
      this.$modal.show(
        AttachRole,
        {
          user: this.user
        },
        {
          width: 300,
          height: 'auto'
        }
      )
    }
  }
}
</script>
